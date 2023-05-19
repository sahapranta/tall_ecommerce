<?php

namespace App\Models;

use App\Traits\HasActive;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, HasActive, SoftDeletes;

    protected $fillable = [
        'firstname',
        'lastname',
        'phone',
        'dob',
        'sex',
        'last_visited_at',
        'last_visited_from',
        'stripe_id',
        'card_holder_name',
        'card_brand',
        'card_last_four',
        'active',
        'info',
        'user_id'
    ];

    protected $casts = [
        'info' => 'array',
        'dob' => 'datetime',
        'last_visited_at' => 'datetime',
        'active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->hasMany(Address::class);
    }

    public function defaultAddress()
    {
        return $this->hasOne(Address::class)->ofMany('is_default');
    }

    public function getFullnameAttribute()
    {
        return trim($this->firstname . ' ' . $this->lastname);
    }
}
