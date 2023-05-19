<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use HasFactory;
    protected $fillable = [
        'sku',
        'product_id',
        'sale_price',
        'offer_price',
        'shipping_weight',
        'offer_start',
        'offer_end',
        'stock',
        'free_shipping',
        'is_default',
        'active',
        'dimension',
        'note',
    ];

    protected $casts = [
        'free_shipping' => 'boolean',
        'is_default' => 'boolean',
        'active' => 'boolean',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'offer_start',
        'offer_end',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function calculatePercentage($value1, $value2)
    {
        if (!is_numeric($value1) || !is_numeric($value2)) {
            return "N/A";
        }

        $percentage = ($value1 - $value2) / $value1 * 100;

        if (!is_finite($percentage)) {
            return "N/A";
        }

        return number_format($percentage) . "%";
    }

    public function getSavePercentAttribute()
    {
        return $this->calculatePercentage($this->sale_price, $this->final_price);
    }

    public function getFinalPriceAttribute()
    {
        $price = $this->sale_price;
        if ($this->product->has_special_offer) {
            if ($this->product->offer_type === 'percent') {
                $price = $price * ((100 - $this->product->offer_value) / 100);
            } else if ($this->product->offer_type === 'percent') {
                $price = $price - $this->product->offer_value;
            }
            return $price;
        }
        return $this->offer_price ?? $price;
    }


    public function options()
    {
        return $this->belongsToMany(VariantOption::class, 'product_variant_options')
            ->using(ProductVariantOption::class)
            ->withPivot('value');
    }

    /**
     *  it is identical to options but used for
     *  filament purpose
     */
    public function attribs()
    {
        return $this->hasMany(ProductVariantOption::class);
    }

    public function attributes($options): array
    {
        return $options ? $options->flatMap(fn ($o) => [$o->name => $o->pivot->value])->toArray() : [];
    }
}
