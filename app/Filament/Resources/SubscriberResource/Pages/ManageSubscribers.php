<?php

namespace App\Filament\Resources\SubscriberResource\Pages;

use App\Filament\Resources\SubscriberResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageSubscribers extends ManageRecords
{
    protected static string $resource = SubscriberResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()->modalWidth('md'),
        ];
    }
}
