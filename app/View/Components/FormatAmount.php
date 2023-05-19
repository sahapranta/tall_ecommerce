<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Str;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\IntlMoneyFormatter;
use Akaunting\Money\Currency;
use Akaunting\Money\Money;
use NumberFormatter;

class FormatAmount extends Component
{
    public $amount;
    public $currency;
    public $locale;

    public function __construct(int $amount, string $currency, string $locale = null)
    {
        $this->amount = $amount;
        $this->currency = $currency;
        $this->locale = $locale ?? app()->getLocale();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $money = new Money($this->amount, new Currency(Str::upper($this->currency)));

        $numberFormatter = new NumberFormatter($this->locale, NumberFormatter::CURRENCY);
        $moneyFormatter = new IntlMoneyFormatter($numberFormatter, new ISOCurrencies());

        return $moneyFormatter->format($money);
        // return view('components.format-amount');
    }
}
