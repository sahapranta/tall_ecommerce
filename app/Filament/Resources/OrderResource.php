<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-list';
    protected static ?string $navigationGroup = 'Shop';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('order_number')
                    ->maxLength(191),
                Forms\Components\Select::make('customer_id')
                    ->relationship('customer', 'firstname')
                    ->required(),
                Forms\Components\TextInput::make('items_count')
                    ->required(),
                Forms\Components\TextInput::make('taxrate'),
                Forms\Components\TextInput::make('taxable'),
                Forms\Components\TextInput::make('subtotal')
                    ->required(),
                Forms\Components\TextInput::make('discount'),
                // Forms\Components\TextInput::make('shipping_weight'),
                Forms\Components\TextInput::make('shipping_charge'),
                Forms\Components\TextInput::make('total')
                    ->required(),
                Forms\Components\Toggle::make('approved'),
                Forms\Components\TextInput::make('shipping_method')
                    ->maxLength(191),
                // Forms\Components\Textarea::make('billing_address')
                //     ->maxLength(65535),
                Forms\Components\Textarea::make('shipping_address')
                    ->maxLength(65535),
                Forms\Components\DatePicker::make('shipping_date'),
                Forms\Components\DatePicker::make('delivery_date'),
                Forms\Components\TextInput::make('tracking_id')
                    ->maxLength(191),
                Forms\Components\TextInput::make('payment_status'),
                Forms\Components\TextInput::make('payment_method'),
                Forms\Components\TextInput::make('message_to_customer')
                    ->maxLength(191),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_number'),
                Tables\Columns\TextColumn::make('customer.firstname'),
                Tables\Columns\TextColumn::make('items_count'),
                // Tables\Columns\TextColumn::make('taxrate'),
                Tables\Columns\TextColumn::make('taxable'),
                Tables\Columns\TextColumn::make('subtotal'),
                Tables\Columns\TextColumn::make('discount'),
                // Tables\Columns\TextColumn::make('shipping_weight'),
                Tables\Columns\TextColumn::make('shipping_charge'),
                Tables\Columns\TextColumn::make('total'),
                Tables\Columns\IconColumn::make('approved')
                    ->boolean(),
                Tables\Columns\TextColumn::make('payment_status'),
                Tables\Columns\TextColumn::make('payment_method'),
                Tables\Columns\TextColumn::make('shipping_method'),
                // Tables\Columns\TextColumn::make('billing_address'),
                Tables\Columns\TextColumn::make('shipping_address'),
                Tables\Columns\TextColumn::make('shipping_date')
                    ->date(),
                // Tables\Columns\TextColumn::make('delivery_date')
                //     ->date(),
                // Tables\Columns\TextColumn::make('tracking_id'),

                // Tables\Columns\TextColumn::make('message_to_customer'),
                // Tables\Columns\TextColumn::make('deleted_at')
                //     ->dateTime(),
                // Tables\Columns\TextColumn::make('created_at')
                //     ->dateTime(),
                // Tables\Columns\TextColumn::make('updated_at')
                //     ->dateTime(),
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
            RelationManagers\OrderItemsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
