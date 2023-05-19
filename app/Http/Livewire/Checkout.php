<?php

namespace App\Http\Livewire;

use App\Models\User;

use App\Models\Order;
use App\Models\Address;
use Livewire\Component;
use App\Models\Customer;
use Illuminate\Support\Str;
use Facades\App\Helpers\SKU;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Facades\Cart as CartService;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Facades\App\Services\CouponService;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Contracts\Auth\PasswordBroker;

class Checkout extends Component
{
    public $total;
    public $content;
    public $promo;

    public $currency;
    public $coupon;
    public $couponApplied = false;
    public $discount;

    public $registration = true;
    public $email;
    public $address1;
    public $address2;
    public $city;
    public $country;
    public $phone;
    public $firstname;
    public $lastname;
    public $state;
    public $postcode;
    public $delivery_method = 'standard';
    public $payment_method = 'stripe';
    public $grand_total = 0;

    protected $newUserCreated = false;
    protected $sendingResetLinkStatus;


    public $addresses;
    public $selected_address;
    public $add_new_address = true;


    public $transaction;
    public $new_order_number;
    public $tracking_id;
    public $paymentIntentCreated = false;

    public $delivery_charge = [
        'standard' => 5,
        'express' => 16,
        'store_pickup' => 0,
    ];

    public $taxrate = 27;
    public $taxable = 0;

    protected $listeners = ['addToCart' => 'updateCart', 'couponCleared', 'couponApplyEvent'];

    public function updateDeliveryMethod($method)
    {
        if ($this->delivery_method !== $method) {
            $this->delivery_method = $method;
        }
    }

    public function updateCart()
    {
        $this->total =  CartService::total();
        $this->content = CartService::content();
        $this->adjustGrandTotal();
    }

    protected function rules()
    {
        $user = Auth::user();
        return  [
            'promo' => 'nullable|alpha_num:ascii|min:5',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user?->id),
            ],
            'firstname' => 'required|min:3|max:100',
            'lastname' => 'nullable|min:3|max:100',
            'address1' => 'required|string',
            'address2' => 'nullable|string',
            'city' => 'required|string',
            'country' => 'required|string',
            'phone' => [
                'required',
                Rule::unique('customers')->ignore($user?->customer?->id),
            ],
            'state' => 'nullable|string',
            'postcode' => 'nullable|string',
        ];
    }

    protected function messages()
    {
        return ['promo' => __('validation.promo')];
    }

    public function updated($name)
    {
        $this->resetValidation($name);

        if ($name === 'promo') {
            $this->validateOnly($name);
        }

        if ($name === 'delivery_method') {
            $this->adjustGrandTotal();
        }
    }

    public function adjustGrandTotal()
    {
        $grand_total = $this->total ?: 0;

        if ($this->discount > 0) {
            $grand_total -= $this->discount;
        }

        $grand_total += $this->delivery_charge[$this->delivery_method];
        $taxable = $grand_total * ($this->taxrate / 100);
        $grand_total += $taxable;

        $this->fill(['grand_total' => $grand_total, 'taxable' => $taxable]);
    }

    public function mount(): void
    {
        $this->updateCart();
        $this->addCoupon(CartService::coupon());
        $this->adjustGrandTotal();
        $this->currency = CartService::getCurrency();

        if (Auth::check()) {
            $user = Auth::user();

            $this->fill(['email' => $user->email]);

            $user->load('customer', 'customer.address');

            if ($user->customer->exists()) {
                $customer = $user->customer;
                $this->fill([
                    'firstname' => $customer->firstname,
                    'lastname' => $customer->lastname,
                    'phone' => $customer->phone,
                ]);
            }

            if (!$customer->address->isEmpty()) {
                $this->addresses = $customer->address;
                $this->add_new_address = false;
            }
        }
    }

    public function render()
    {
        return view('livewire.checkout')
            ->layout('layouts.base');
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
        $coupon = CouponService::getCoupon($this->promo);
        if ($coupon) {
            CartService::applyCoupon($coupon);
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

    public function submit()
    {
        $this->currency = CartService::getCurrency();
        DB::beginTransaction();

        try {
            if (Auth::check()) {
                $user = Auth::user();
            } else {
                $this->validateOnly('email');
                $user =  User::create(['name' => $this->firstname, 'email' => $this->email, 'password' => Str::password(10)]);
                $this->newUserCreated = true;
            }


            if ($user->customer()->exists()) {
                $customer = $user->customer;
            } else {
                $this->validateOnly('firstname');
                $this->validateOnly('lastname');
                $customer = Customer::create([
                    'user_id' => $user->id,
                    'firstname' => $this->firstname,
                    'lastname' => $this->lastname,
                    'phone' => $this->phone,
                ]);
            }

            // if customer wants to add new address
            if ($this->add_new_address) {
                $this->validateOnly('address_line_1');
                $this->validateOnly('city');
                $this->validateOnly('state');
                $this->validateOnly('country');
                $this->validateOnly('phone');
                $address =  Address::create([
                    'customer_id' => $customer->id,
                    'address_line_1' => $this->address1,
                    'address_line_2' => $this->address2,
                    'city' => $this->city,
                    'country' => $this->country,
                    'phone' => $this->phone,
                    'state' => $this->state,
                    'zip_code' => $this->postcode,
                ]);
                // if add_new_address is false and the selected address has value
            } else {
                $address = $this->selected_address
                    ? $this->addresses->firstWhere('id', $this->selected_address)
                    : $customer->defaultAddress;
            }


            $order = Order::create([
                'order_number'       => SKU::make('ORD'),
                'customer_id'        => $customer->id,
                'items_count'        => CartService::totalQuantity(),
                'taxrate'            => $this->taxrate,
                'subtotal'           => $this->total,
                'taxable'            => $this->taxable,
                'discount'           => $this->discount,
                'coupon_id'          => $this->coupon?->id,
                // 'shipping_weight'    => $this->shipping_weight,
                'shipping_charge'    => $this->delivery_charge[$this->delivery_method],
                'total'              => $this->grand_total,
                'shipping_method'    => $this->delivery_method,
                // 'billing_address' => $this->billing_address, // We assume that billing & shipping is same
                'shipping_address'   => $address->full_address,
                'payment_method'     => $this->payment_method,
                'currency'           => $this->currency->code,
                'tracking_id'        => Str::password(10, symbols: false),
            ]);

            $orderItems = [];

            foreach ($this->content as $value) {
                $orderItems[] = [
                    'variant_id' => $value['variant_id'],
                    'quantity'   => $value['quantity'],
                    'unit_price' => $value['price'],
                    'item_description' => $this->flattenOptionsArray($value['options']),
                ];
            }

            $order->items()->createMany($orderItems);

            $this->clearCheckout();

            if ($this->payment_method === 'stripe') {
                $this->createIntent($order);
            }

            Notification::make()
                ->title('Your Order is Confirmed.')
                ->success()
                ->send();

            $this->new_order_number = $order->order_number;
            $this->tracking_id = $order->tracking_id;
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::alert($th->getMessage(), [$th]);
        }

        DB::commit();

        if ($this->newUserCreated && $this->registration) {
            $this->sendReset($this->email);
        }

        if ($this->transaction) {
            return redirect(route('checkout.payment', ['code' => $this->transaction->code]));
        } else {
            $route = Auth::check()
                ? route('order.success', ['order' => $this->new_order_number])
                : route('order.confirmed', ['order' => $this->tracking_id]);
            return redirect($route);
        }
    }

    protected function clearCheckout()
    {
        CartService::clear();
        $this->fill(['total' => 0]);
    }

    protected function flattenOptionsArray($optionsArray): string
    {
        if (empty($optionsArray)) return '';
        $description = '';
        foreach ($optionsArray as $key => $value) {
            $description .= "{$key}: {$value}, ";
        }
        // Remove the trailing comma and space from the description
        $description = rtrim($description, ', ');
        return $description;
    }

    protected function broker(): PasswordBroker
    {
        return Password::broker(config('fortify.passwords'));
    }

    protected function sendReset($email)
    {
        $status = $this->broker()->sendResetLink(['email' => $email]);
        // "passwords.sent"
        $this->sendingResetLinkStatus = $status;
    }

    protected function full_checkout()
    {
        \Stripe\Stripe::setApiKey(config('extra.stripe_secret'));
        $lineItems = [];

        $this->currency = CartService::getCurrency();

        $this->content->each(function ($item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => $this->currency,
                    'product_data' => [
                        'name' => $item['name'],
                        // 'images' => [$item['thumb']]
                    ],
                    'tax_behavior' => 'exclusive',
                    'unit_amount' => $item['price'] * 100,
                ],
                'quantity' => $item['quantity'],
            ];
        });

        $shipping_options = [
            'shipping_rate_data' => [
                'fixed_amount' => ['amount' => 0, 'currency' => $this->currency],
                'display_name' => 'Free shipping',
                'tax_behavior' => 'exclusive',
                'tax_code' => 'txcd_92010001',
                'delivery_estimate' => [
                    'minimum' => ['unit' => 'business_day', 'value' => 5],
                    'maximum' => ['unit' => 'business_day', 'value' => 7],
                ],
            ],
        ];

        $session = \Stripe\Checkout\Session::create([
            'shipping_address_collection' => ['allowed_countries' => ['US', 'CA']],
            'shipping_options' => $shipping_options,
            'line_items' => $lineItems,
            'mode' => 'payment',
            'automatic_tax' => ['enabled' => true],
            'success_url' => route('checkout.success', [], true) . "?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' => route('checkout.cancel', [], true),
        ]);

        return $session;
    }

    protected function createIntent($order)
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $order->total * 100,
            'currency' => $order->currency,
            'automatic_payment_methods' => [
                'enabled' => true,
            ],
        ]);

        $transaction = Transaction::create([
            'order_id' => $order->id,
            'customer_id' => $order->customer_id,
            'code' => $paymentIntent->id,
            'client_secret' => $paymentIntent->client_secret,
            'amount' => $paymentIntent->amount,
            'currency' => $paymentIntent->currency,
        ]);

        $this->transaction = $transaction;

        $this->paymentIntentCreated = true;
    }
}
