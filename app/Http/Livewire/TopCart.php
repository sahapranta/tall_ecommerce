<?php

namespace App\Http\Livewire;

use App\Facades\Cart;
use Livewire\Component;
use Filament\Notifications\Notification;

class TopCart extends Component
{
    public $cartCount = 0;
    protected $listeners = ['addToCart' => 'addProductToCart', 'cartChanged' => 'updateCount'];

    public function mount(): void
    {
        $this->updateCount();
    }

    public function updateCount()
    {
        $this->cartCount = Cart::totalQuantity();
    }

    public function addProductToCart($product)
    {
        Cart::add($product, 1);
        Notification::make()
            ->title('Product Successfully Added!')
            ->success()
            ->send();
        $this->updateCount();
    }

    public function render()
    {
        return view('livewire.top-cart');
    }
}
