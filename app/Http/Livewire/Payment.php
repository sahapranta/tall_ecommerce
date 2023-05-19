<?php

namespace App\Http\Livewire;

use App\Models\Transaction;
use Livewire\Component;

class Payment extends Component
{
    public $transaction;

    public function mount($code)
    {
        $transaction = Transaction::firstWhere('code', $code);

        if ($transaction && is_null($transaction->status)) {
            $transaction->load('user', 'order');
            $this->transaction = $transaction;
        } else {
            redirect(route('checkout.success'));
        }
    }

    public function status($status)
    {
        if ($this->transaction) {
            $this->transaction->update(['status' => $status]);
        }
    }

    public function render()
    {
        return view('livewire.payment')
            ->layout('layouts.base');
    }
}
