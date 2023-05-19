<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCategories extends ListRecords
{
    use ListRecords\Concerns\Translatable;
    protected static string $resource = CategoryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\CreateAction::make(),
        ];
    }
}
