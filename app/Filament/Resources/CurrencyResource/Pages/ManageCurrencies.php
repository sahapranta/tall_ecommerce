<?php

namespace App\Filament\Resources\CurrencyResource\Pages;

use App\Filament\Resources\CurrencyResource;
use App\Models\Currency;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;
use Filament\Facades\Filament;
use Illuminate\Contracts\View\View;
use Filament\Notifications\Notification;

class ManageCurrencies extends ManageRecords
{

    protected static string $resource = CurrencyResource::class;

    protected function getActions(): array
    {
        if (Currency::whereDefault(1)->get()->isEmpty()) {
            Filament::registerRenderHook(
                'content.start',
                fn (): View => view('layouts.alert'),
            );
        }
        return [
            Actions\CreateAction::make()->modalWidth('md')
                ->after(function () {
                    if (Currency::whereDefault(1)->get()->isEmpty()) {
                        Notification::make()
                            ->danger()
                            ->title('There must be a default Currency')
                            ->send();
                    }
                }),
        ];
    }
}
