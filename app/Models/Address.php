<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'zip_code',
        'country',
        'phone',
        'latitude',
        'longitude',
        'customer_id',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function getFullAddressAttribute()
    {
        $addressParts = [
            $this->address_line_1,
            $this->address_line_2,
            $this->city,
            $this->state,
            $this->zip_code,
            $this->country,
        ];

        $addressString = implode(', ', array_filter($addressParts));

        return $addressString;
    }
}
