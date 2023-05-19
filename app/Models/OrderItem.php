<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_description',
        'variant_id',
        'quantity',
        'unit_price',
        'order_id',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(Variant::class);
    }

    public function product(): HasOneThrough
    {
        return $this->hasOneThrough(Product::class, Variant::class, 'product_id', 'id', 'variant_id');
    }
}
