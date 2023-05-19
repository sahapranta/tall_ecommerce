<?php

namespace App\Models;

use App\Traits\HasActive;
use App\Traits\HasDefault;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory, HasDefault, HasActive;

    protected $fillable = [
        "code",
        "sign",
        "name",
        "exchange_rate",
        "format",
        "decimal_places",
        "active",
        "default",
    ];

    public function getFactorAttribute()
    {
        if ($this->decimal_places < 1) {
            return 1;
        }

        return sprintf("1%0{$this->decimal_places}d", 0);
    }

    // Simply testing

    public function format($amount, $space = '')
    {
        return $this->format === 'front' ?  "{$this->sign}{$space}{$amount}" : "{$amount}{$space}{$this->sign}";
    }

    public function scopeSupported($query)
    {
        $query->select(['code', 'sign', 'name', 'default', 'exchange_rate'])
            ->active();
    }
}
