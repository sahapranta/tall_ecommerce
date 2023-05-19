<?php

namespace App\Http\Livewire;

use App\Facades\Currency as CurrencyService;
use Livewire\Component;
use Filament\Notifications\Notification;

class CurrencySwitcher extends Component
{
    public $activeCurrency = null;
    public $supported = [];

    public function changeActiveCurrency($code)
    {
        $currencies = CurrencyService::getSupported();
        $currency = $currencies->firstWhere("code", $code);
        CurrencyService::setActive($currency);

        $this->activeCurrency = $currency->code;
        $this->updateSupported($currencies);
        $this->emit('currencyUpdated');
        Notification::make()
            ->title("Currency Changed to {$currency->name}")
            ->success()
            ->send();
        /**
         * @todo
         * implement partial refresh
         */
        return redirect()->to(url()->previous());
    }

    public function mount()
    {
        $this->activeCurrency = CurrencyService::getActive()->code;
        $this->updateSupported();
    }

    public function updateSupported($currencies = null)
    {
        $currencies = $currencies ?: CurrencyService::getSupported();
        $this->supported = $currencies
            ->flatMap(fn ($c) => $c->code !== $this->activeCurrency ? [$c->code => $c->sign] : [])
            ->toArray();
    }

    public function render()
    {
        return view('livewire.currency-switcher');
    }
}
