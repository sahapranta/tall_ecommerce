<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'variant_id',
        'price',
        'quantity',
        'options',
    ];

    protected $casts = [
        'options' => 'array',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }

    public function product()
    {
        return $this->hasOneThrough(Product::class, Variant::class);
    }
}
