<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Facades\Cart as CartService;
use App\Facades\Currency as CurrencyService;
use Facades\App\Services\CouponService;
use Filament\Notifications\Notification;


class Cart extends Component
{
    public $total;
    public $content;
    public $promo;
    public $currency;
    public $coupon;
    public $couponApplied = false;
    public $discount;

    protected $listeners = ['addToCart' => 'updateCart', 'currencyUpdated', 'couponCleared', 'couponApplyEvent'];

    protected $rules = [
        'promo' => 'required|alpha_num:ascii|min:6',
    ];

    protected function messages()
    {
        return ['promo' => __('validation.promo')];
    }

    public function currencyUpdated()
    {
        $currency = CurrencyService::getActive();
        $this->dispatchBrowserEvent('currencyUpdated', ['currency' => $currency->code]);
        $this->fill(['currency' => $currency]);
        CartService::updateCurrency();
    }

    public function updated($name)
    {
        if ($name === 'promo') {
            $this->validateOnly($name);
        }
    }

    public function mount(): void
    {
        $this->updateCart();
        $this->addCoupon(CartService::coupon());
    }

    public function render()
    {
        return view('livewire.cart');
    }

    public function updateCart()
    {
        $this->total = CartService::total();
        $this->content = CartService::content();
    }

    public function removeFromCart(string $id): void
    {
        CartService::remove($id);
        $this->updateCart();
        $this->emit('cartChanged');
    }

    public function updateCartItem(string $id, string $action): void
    {
        CartService::update($id, $action);
        $this->updateCart();
        $this->emit('cartChanged');
    }

    public function clearCoupon()
    {
        CartService::clearCoupon();
        $this->emit('couponCleared');
        // $this->fill(['couponApplied' => false, 'coupon' => null, 'discount' => 0, 'promo' => '']);
    }

    public function couponCleared()
    {
        $this->fill(['couponApplied' => false, 'coupon' => null, 'discount' => 0, 'promo' => '']);
    }

    public function applyPromo()
    {
        $this->validate();

        $coupon = CouponService::getCoupon($this->promo);

        if ($coupon) {
            CartService::applyCoupon($coupon);

            // Notification::make()
            //     ->title(__('cart.promo_applied'))
            //     ->success()
            //     ->send();
            $this->addCoupon($coupon);
            $this->emit('couponApplyEvent');
        } else {
            Notification::make()
                ->title(__('cart.promo_not_valid'))
                ->success()
                ->send();
        }
    }

    public function couponApplyEvent()
    {
        if (!$this->couponApplied) {
            $this->addCoupon(CartService::coupon());
        }
    }

    protected function addCoupon($coupon)
    {
        if ($coupon) {
            $this->fill(['discount' => CartService::getDiscount(), 'coupon' => $coupon, 'couponApplied' => true]);
        }
    }
}
