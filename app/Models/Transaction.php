<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'customer_id',
        'code',
        'client_secret',
        'amount',
        'currency',
        'status',
        'result',
    ];

    protected $casts = [
        'result' => 'array'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {
        return $this->hasOneThrough(User::class, Customer::class, 'user_id', 'id', 'customer_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
