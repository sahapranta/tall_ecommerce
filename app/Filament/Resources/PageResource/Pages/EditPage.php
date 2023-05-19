<?php

namespace App\Filament\Resources\PageResource\Pages;


use App\Filament\Resources\PageResource;
use Filament\Pages\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPage extends EditRecord
{
    public static function getResource(): string
    {
        return config('filament-pages.filament.resource', PageResource::class);
    }

    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
