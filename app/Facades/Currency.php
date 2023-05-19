<?php

namespace App\Facades;

use App\Services\CurrencyService;
use Illuminate\Support\Facades\Facade;

class Currency extends Facade
{

    protected static function getFacadeAccessor()
    {
        return CurrencyService::class;
    }
}
