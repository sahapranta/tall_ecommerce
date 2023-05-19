<?php

namespace App\Http\Livewire\Shop;

use App\Models\Order;
use Livewire\Component;

class OrderSuccess extends Component
{
    public $order;


    public function mount($order)
    {
        $order = Order::with('items')->firstWhere('order_number', $order);
        if (!$order) {
            abort(404, 'Specified Order Not Found');
        }
        $this->order = $order;
    }

    public function render()
    {
        return view('livewire.shop.order-success')
            ->layout('layouts.base');
    }
}
