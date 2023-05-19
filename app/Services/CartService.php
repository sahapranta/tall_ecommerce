<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Variant;
use App\Models\CartItem;
use App\Models\Currency;
use Facades\App\Services\CouponService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Session\SessionManager;
use App\Facades\Currency as CurrencyService;

class CartService
{
    const MINIMUM_QUANTITY = 1;
    const KEY = 'shopping-cart';
    const COUPON_KEY = 'shopping-cart-coupon';
    const MERGE_KEY = 'shopping-cart-merged';

    public function __construct(
        protected SessionManager $session,
        protected $currency = null,
        protected $coupon = null,
        protected $discount = 0,
        public $cart = null,
    ) {
        $this->updateSessionFromDb();
        $this->updateCurrency();
    }

    protected function updateSessionFromDb()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user->load('cart', 'cart.items');
            $cart = $user->cart;
            $content = $this->getContent();
            $this->cart = $cart;

            if ($cart && $cart->coupon_id) {
                $this->coupon = CouponService::find($cart->coupon_id);
            }
            // if (!$this->cart && $content->isEmpty()) return;

            /**
             * @todo
             *  May be some optimization and
             *  automated through test needed
             */
            if ($cart && $cart->items) {
                $items = $cart->items;
                $cart->items->each(function ($item) use ($content) {
                    if ($content->has($item->variant_id) && $this->session->has(self::MERGE_KEY)) {
                        $existingItem = $content->get($item->variant_id);
                        $newQuantity = $item->quantity + $existingItem->quantity;
                        $item->increment('quantity', $existingItem->quantity);
                        $content->get($item->variant_id)->put('quantity', $newQuantity);
                        $this->session->put(self::MERGE_KEY, true);
                    } else {
                        $cartItem = $this->createCartItem($item->variant_id, $item->quantity);
                        $content->put($item->variant_id, $cartItem);
                    }
                });
                $newAdded = $content->except($items->pluck('variant_id')->toArray());
                $this->addBulkToCartItems($newAdded, $cart);

                $this->session->put(self::KEY, $content);
            } else if (!$content->isEmpty()) {
                $cart = $this->createCartInDB();
                $this->addBulkToCartItems($content, $cart);
                $coupon = $this->coupon();
                if ($coupon && CouponService::checkValidity($coupon)) {
                    $this->applyCoupon($coupon);
                }
            }
        }
    }

    protected function addBulkToCartItems($items, $cart = null)
    {
        $cart = $cart ?? $this->cart;
        if (!$cart) return;
        $data = [];
        foreach ($items as $item) {
            $data[] = new CartItem($item->only(['variant_id', 'price', 'quantity', 'options'])->toArray());
        }
        $cart->items()->saveMany($data);
    }

    public function getContent(): Collection
    {
        return $this->session->has(self::KEY)
            ? $this->session->get(self::KEY)
            : collect([]);
    }

    protected function createCartItem($variant_id, $quantity): Collection
    {
        $variant = Variant::with(['product', 'product.featuredImage', 'options'])->find($variant_id);

        $quantity = $this->checkMinimum(intval($quantity));
        $price = $variant->final_price;
        $options = $variant->attributes($variant->options);

        return collect([
            'variant_id' => $variant->id,
            'product_id' => $variant->product->id,
            'title' => $variant->product->title,
            'thumb' => $variant->product->thumb,
            'slug' => $variant->product->slug,
            'price' =>  $price,
            'stock' => $variant->stock,
            'quantity' => $quantity,
            'options' => $options
        ]);
    }

    protected function checkMinimum(int $quantity): int
    {
        return $quantity < self::MINIMUM_QUANTITY ? self::MINIMUM_QUANTITY : $quantity;
    }

    public function add($variant_id, $quantity): void
    {
        // if authenticated create cart
        if (is_null($this->cart) && Auth::check()) {
            $this->createCartInDB();
        }

        $content = $this->getContent();
        $cartItem = null;

        if ($content->has($variant_id)) {
            $item = $content->get($variant_id);
            $newQuantity = $item->get('quantity') + $quantity;
            if ($newQuantity <= $item->get('stock')) {
                $this->updateCartItem($variant_id);
                $content->get($variant_id)->put('quantity', $newQuantity);
            }
        } else {
            $cartItem = $this->createCartItem($variant_id, $quantity);
            // saving to db using CartItem model
            $this->addCartItemsInDB($variant_id,  $cartItem->get('price'), $quantity, $cartItem->get('options'));
            $content->put($variant_id, $cartItem);
        }

        $this->session->put(self::KEY, $content);
    }

    public function update(string $id, string $action): void
    {
        $content = $this->getContent();

        if ($content->has($id)) {
            $cartItem = $content->get($id);

            switch ($action) {
                case 'plus':
                    $this->updateCartItem($id);
                    $cartItem->put('quantity', $content->get($id)->get('quantity') + 1);
                    break;
                case 'minus':
                    $updatedQuantity = $content->get($id)->get('quantity') - 1;
                    if ($updatedQuantity > 0) {
                        $this->updateCartItem($id, 'minus');
                        $cartItem->put('quantity', $updatedQuantity);
                    }
                    break;
            }
            $content->put($id, $cartItem);

            $this->session->put(self::KEY, $content);
        }
    }

    public function remove(string $id): void
    {
        $content = $this->getContent();

        if ($content->has($id)) {
            $this->session->put(self::KEY, $content->except($id));
            $this->deleteCarItem($id);
        }
    }

    public function clear(): void
    {
        $this->session->forget(self::KEY);
        $this->session->forget(self::COUPON_KEY);
        $this->session->forget(self::MERGE_KEY);

        // delete cart from database if created
        if ($this->cart && $this->willBeDeletedFromDB()) {
            $this->cart->delete();
        }
    }

    protected function willBeDeletedFromDB()
    {
        // may be some configuration that
        // restrict the delete process rather
        // implement status checked out in cart table
        return true;
    }

    public function content(): Collection
    {
        return is_null($this->session->get(self::KEY)) ? collect([]) : $this->session->get(self::KEY);
    }

    public function total(): float
    {
        $content = $this->getContent();

        $total = $content->reduce(
            fn ($total, $item) =>
            $total += $item->get('price') * $item->get('quantity')
        );

        return $total ?: 0;
    }

    protected function calculate()
    {
        $total = $this->total();

        if ($this->coupon) {
            $this->discount = CouponService::getDiscount($this->coupon, $total);
        }

        return ['subtotal' => $total, 'discount' => $this->discount, 'total' => $total - $this->discount];
    }

    public function getDiscount()
    {
        $this->calculate();
        return $this->discount;
    }

    public function totalQuantity(): int
    {
        $content = $this->getContent();
        if ($content->isEmpty()) return 0;

        $total = $content->reduce(
            fn ($total, $item) =>
            $total += $item->get('quantity')
        );

        return $total;
    }

    public function getCurrency(): Currency
    {
        return $this->currency ?: Currency::getDefault();
    }

    public function setCurrency(Currency $currency): void
    {
        $this->currency = $currency;

        if ($this->cart && $this->cart->currency !== $currency->code) {
            $this->cart->update([
                'currency' => $currency->code,
            ]);
        }
    }

    public function updateCurrency()
    {
        $this->setCurrency(CurrencyService::getActive());
    }

    /**
     * cart model for saving items to db
     */
    protected function createCartInDB()
    {
        $cart = Cart::create([
            'user_id' => Auth::id(),
            'currency' => $this->getCurrency()->code
        ]);

        return $this->$cart = $cart;
    }

    protected function addCartItemsInDB(int $variant, $price, int $quantity, $options = null): void
    {
        if (!$this->cart) {
            return;
        }
        try {
            $this->cart->items()->create([
                'variant_id' => $variant,
                'price' => $price,
                'quantity' => $quantity,
                'options' => $options,
            ]);
        } catch (Exception $e) {
            Log::alert($e->getMessage());
        }
    }

    protected function updateCartItem($variant_id, $operation = 'plus')
    {
        if (!is_null($this->cart)) {
            $this->cart->{$operation}($variant_id);
        }
    }

    protected function deleteCarItem($id)
    {
        if (!is_null($this->cart)) {
            $this->cart->items()->firstWhere('variant_id', $id)->delete();
        }
    }

    // Applying coupon code
    public function applyCoupon(Coupon $coupon)
    {
        $this->coupon = $coupon;
        $this->calculate();
        $this->session->put(self::COUPON_KEY, $coupon);
        if ($this->cart && $this->cart->coupon_id !== $coupon->id) {
            $this->cart->update(['coupon_id' => $coupon->id]);
        }
    }

    public function clearCoupon()
    {
        if ($this->cart && $this->cart->coupon_id !== null) {
            $this->cart->update(['coupon_id' => null]);
        }
        $this->session->forget(self::COUPON_KEY);
        $this->coupon = null;
        $this->discount = 0;
    }

    public function coupon()
    {
        return $this->session->has(self::COUPON_KEY) ? $this->session->get(self::COUPON_KEY) : null;
    }
}
