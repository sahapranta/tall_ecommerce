<?php

namespace App\Services;

use App\Models\Currency;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\Cache;
// use Illuminate\Support\Str;

class CurrencyService
{
    const KEY = 'currency';

    public function __construct(protected SessionManager $session)
    {
    }

    public function setActive(Currency $currency): void
    {
        $this->session->put(self::KEY, $currency);
    }

    public function getDefault()
    {
        return Currency::getDefault();
    }

    public function getSupported()
    {
        return Cache::rememberForever('supported_currencies', fn () => Currency::query()->supported()->get());
    }

    public function getActive()
    {
        return $this->session->has(self::KEY)
            ? $this->session->get(self::KEY)
            : $this->getDefault();
    }

    public function code()
    {
        $currency = $this->getActive();
        return $currency->code;
    }

    public function get($code = null)
    {
        return $this->getSupported()->firstWhere('code', $code ?? $this->code());
    }

    public function format($amount, $convert = true): string
    {
        return money($amount, $this->code(), $convert);
    }
}
