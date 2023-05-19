<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CurrencyResource\Pages;
use App\Filament\Resources\CurrencyResource\RelationManagers;
use App\Models\Currency;
use Closure;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Validation\Rules\Unique;
use Filament\Notifications\Notification;

class CurrencyResource extends Resource
{
    protected static ?string $model = Currency::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationGroup = 'Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\TextInput::make('code')
                        ->required()
                        ->maxLength(5),
                    Forms\Components\TextInput::make('sign')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('decimal_places')
                        ->numeric()
                        ->default(2)
                        ->required(),
                    Forms\Components\Select::make('format')
                        ->options([
                            'start' => 'Start',
                            'end' => 'End',
                        ])
                        ->default('start')
                        ->required(),
                ]),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('exchange_rate')
                    ->required(),

                Forms\Components\Grid::make(1)->schema([
                    Forms\Components\Toggle::make('active')
                        ->required(),
                    Forms\Components\Toggle::make('default')
                        ->required()
                        ->unique(callback: function (Unique $rule) {
                            return $rule->where('default', 1);
                        })
                        ->rules(['boolean']),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return
            $table
            ->columns([
                Tables\Columns\TextColumn::make('code'),
                Tables\Columns\TextColumn::make('sign'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('exchange_rate'),
                Tables\Columns\IconColumn::make('active')
                    ->boolean(),
                Tables\Columns\IconColumn::make('default')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->modalWidth('md')
                    ->after(function () {
                        if (Currency::whereDefault(1)->get()->isEmpty()) {
                            Notification::make()
                                ->danger()
                                ->title('There must be a default Currency')
                                ->send();
                        }
                    }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCurrencies::route('/'),
        ];
    }
}
