<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'type',
        'value',
        'min_amount',
        'max_amount',
        'starting_time',
        'ending_time',
        'active',
        'description',
    ];

    protected $dates = [
        'starting_time',
        'ending_time',
        'created_at',
        'updated_at'
    ];
}
