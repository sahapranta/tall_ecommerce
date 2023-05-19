<?php

namespace App\Http\Livewire;

use Livewire\Component;

class StripeConfirm extends Component
{
    public $transaction_id;

    public function mount($transaction)
    {
        $this->transaction_id = $transaction;
    }

    public function render()
    {
        $transaction = Transaction::find($this->transaction_id);

        if ($transaction->status == 'succeeded') {
            $this->redirect(route('checkout.success'));
        }

        return view('livewire.stripe-confirm');
    }
}
