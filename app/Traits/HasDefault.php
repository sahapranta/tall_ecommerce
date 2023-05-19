<?php

namespace App\Traits;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

/**
 * has Default in Database
 */
trait HasDefault
{
    // DB column name
    public static string $defaultKey = 'default';

    public function scopeDefault(Builder $query, $default = true)
    {
        return $query->firstWhere(static::$defaultKey, $default);
    }

    public static function getDefault()
    {
        $key = 'dynamic_' . Str::snake(self::class);

        return Cache::rememberForever($key, fn () => self::query()->default());
    }
}
