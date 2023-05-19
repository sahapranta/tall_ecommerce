<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'choices',
        'currency',
        'coupon_id',
    ];

    protected $casts = [
        'choices' => 'array',
    ];

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->hasOneThrough(Customer::class, User::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function plus($variant_id)
    {
        $this->items()->firstWhere('variant_id', $variant_id)->increment('quantity');
    }

    public function minus($variant_id)
    {
        $this->items()->firstWhere('variant_id', $variant_id)->decrement('quantity');
    }
}
