<?php

namespace App\Filament\Resources\PageResource\Pages;

use App\Filament\Resources\PageResource;
use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPages extends ListRecords
{
    public static function getResource(): string
    {
        return config('filament-pages.filament.resource', PageResource::class);
    }

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
