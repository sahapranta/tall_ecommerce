<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'active',
        'group',
        'verified'
    ];

    protected $casts = [
        'verified' => 'boolean',
        'active' => 'boolean',
    ];
}
