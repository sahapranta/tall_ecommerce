<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Forms\Components\TextInput::make('firstname')
                    ->maxLength(191),
                Forms\Components\TextInput::make('lastname')
                    ->maxLength(191),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->maxLength(191),
                Forms\Components\DatePicker::make('dob'),
                Forms\Components\TextInput::make('sex')
                    ->maxLength(191),
                Forms\Components\DateTimePicker::make('last_visited_at'),
                Forms\Components\TextInput::make('last_visited_from')
                    ->maxLength(45),
                Forms\Components\TextInput::make('stripe_id')
                    ->maxLength(191),
                Forms\Components\TextInput::make('card_holder_name')
                    ->maxLength(255),
                Forms\Components\TextInput::make('card_brand')
                    ->maxLength(191),
                Forms\Components\TextInput::make('card_last_four')
                    ->maxLength(191),
                Forms\Components\Toggle::make('active')
                    ->required(),
                Forms\Components\TextInput::make('info'),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('firstname'),
                Tables\Columns\TextColumn::make('lastname'),
                Tables\Columns\TextColumn::make('phone'),
                Tables\Columns\TextColumn::make('dob')
                    ->date(),
                Tables\Columns\TextColumn::make('sex'),
                Tables\Columns\TextColumn::make('last_visited_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('last_visited_from'),
                Tables\Columns\TextColumn::make('stripe_id'),
                Tables\Columns\TextColumn::make('card_holder_name'),
                Tables\Columns\TextColumn::make('card_brand'),
                Tables\Columns\TextColumn::make('card_last_four'),
                Tables\Columns\IconColumn::make('active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('info'),
                Tables\Columns\TextColumn::make('user_id'),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\AddressRelationManager::class,
            RelationManagers\OrdersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'view' => Pages\ViewCustomer::route('/{record}'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
