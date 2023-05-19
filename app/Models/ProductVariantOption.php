<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductVariantOption extends Pivot
{
    protected $table = 'product_variant_options';
    // protected $table = 'variant_option_variant';

    protected $fillable = [
        'variant_option_id',
        'variant_id',
        'value',
    ];

    public function variantOption()
    {
        return $this->belongsTo(VariantOption::class);
    }

    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }

    public $timestamps = false;
}
