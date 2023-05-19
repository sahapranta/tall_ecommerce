<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;

class RelativeProducts extends Component
{
    public $products;

    public function mount(): void
    {
        $products = Product::with(['featuredImage', 'variant', 'variant.options'])->limit(4)->inRandomOrder()->get();
        $this->fill(['products' => $products]);
    }

    public function render()
    {
        return view('livewire.relative-products');
    }
}
