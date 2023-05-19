<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariantOption extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'name'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variants()
    {
        return $this->hasManyThrough(Variant::class, Product::class);
    }

    public function options()
    {
        return $this->belongsToMany(Variant::class, 'product_variant_options')
            ->using(ProductVariantOption::class)
            ->withPivot('value');
    }

    public function attribs()
    {
        return $this->hasMany(ProductVariantOption::class);
    }
}
