<?php

namespace App\Http\Livewire;

use App\Models\Product;
use App\Models\Variant;
use Livewire\Component;

class ProductView extends Component
{
    public Product $product;
    public $color = '';
    public $size = '';
    public $variant;
    public $variant_id;
    public $variant_options;

    public function mount(Product $product)
    {
        $product->load(['category:id,name,slug', 'media', 'variant', 'variants', 'variants.options']);
        $this->product = $product;
        $this->variant = $product->variant;
        $this->variant_options = $product->allVariantOptions();
    }

    public function changeVariant($key, $value, $id)
    {
        $variantOptions = collect($this->variant_options);
        $otherKey = $key === 'color' ? 'size' : 'color';
        $variant = collect($variantOptions->get($otherKey, collect()))->firstWhere('variant_id', $id);
        $variantValue = $variant['value'] ?? 'disabled';
        $this->fill([$key => $value, 'variant_id' => $id, $otherKey => $variantValue]);
        $this->loadVariant($id);
    }

    public function loadVariant($id)
    {
        $variant = Variant::find($id);
        $this->fill(['variant' => $variant]);
    }

    public function render()
    {
        return view('livewire.product-view')->layout('layouts.base');
    }
}
