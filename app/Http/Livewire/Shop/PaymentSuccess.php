<?php

namespace App\Http\Livewire\Shop;

use App\Models\Transaction;
use Livewire\Component;

class PaymentSuccess extends Component
{
    public $payment_intent;
    public $redirect_status;
    public $payment_intent_client_secret;

    public $payload;
    public $order;

    protected $queryString = ['payment_intent', 'redirect_status', 'payment_intent_client_secret'];

    public function mount()
    {
        $this->fill(['payload' => ['id' => $this->payment_intent, 'status' => $this->redirect_status, 'client_secret' => $this->payment_intent_client_secret]]);

        if ($this->payment_intent) {
            $transaction = Transaction::with('order')->firstWhere('code', $this->payment_intent);
            $status = $this->redirect_status;
            if ($transaction && $status) {
                $transaction->update(['status' => $status]);
                $this->order = $transaction->order;

                if (empty(config('extra.stripe_webhook')) && $status === 'succeeded') {
                    $transaction->order->update(['payment_status' => 'paid']);
                }
            }
        }

        $this->reset($this->queryString);
    }

    public function render()
    {
        return view('livewire.shop.payment-success')
            ->layout('layouts.base');
    }
}
