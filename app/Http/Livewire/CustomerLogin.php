<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CustomerLogin extends Component
{
    public function render()
    {
        return view('livewire.customer-login')->layout('layouts.guest');
    }
}
