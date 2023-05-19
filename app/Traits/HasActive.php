<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasActive
{
    public function scopeActive(Builder $query): void
    {
        $query->whereActive(true);
    }

    public function scopeInactive(Builder $query): void
    {
        $query->whereActive(false);
    }
}
