<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'customer_id',
        'items_count',
        'taxrate',
        'taxable',
        'subtotal',
        'coupon_id',
        'discount',
        'shipping_weight',
        'shipping_charge',
        'total',
        'approved',
        'shipping_method',
        'billing_address',
        'shipping_address',
        'shipping_date',
        'delivery_date',
        'tracking_id',
        'payment_method',
        'payment_status',
        'currency',
        'message_to_customer',
    ];

    protected $casts = [
        'approved' => 'boolean',
    ];

    protected $dates = [
        'shipping_date',
        'delivery_date',
    ];

    public function user()
    {
        return $this->hasOneThrough(User::class, Customer::class, 'user_id', 'id', 'customer_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function getExpectedShippingAttribute()
    {
        return $this->shipping_date ?? $this->created_at->add($this->shipping_method === 'express' ? '+4 days' : '+7 days')->format('Y-m-d');
    }
}
