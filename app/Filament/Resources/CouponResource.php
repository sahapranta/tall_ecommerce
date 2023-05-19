<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CouponResource\Pages;
use App\Filament\Resources\CouponResource\RelationManagers;
use App\Models\Coupon;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CouponResource extends Resource
{
    protected static ?string $model = Coupon::class;

    protected static ?string $navigationIcon = 'heroicon-o-speakerphone';
    protected static ?string $navigationGroup = 'Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->maxLength(191)->required(),
                Forms\Components\TextInput::make('value')
                    ->numeric()->required(),
                Forms\Components\Select::make('type')
                    ->options([
                        'amount' => 'Amount', 'percent' => 'Percent'
                    ])
                    ->default('amount'),
                Forms\Components\TextInput::make('min_amount')
                    ->numeric()->mask(
                        fn (Forms\Components\TextInput\Mask $mask) =>
                        $mask->numeric()
                            ->decimalPlaces(2)
                            ->normalizeZeros()
                    ),
                Forms\Components\TextInput::make('max_amount')
                    ->numeric()->mask(
                        fn (Forms\Components\TextInput\Mask $mask) =>
                        $mask->numeric()
                            ->decimalPlaces(2)
                            ->normalizeZeros()
                    ),
                Forms\Components\DatePicker::make('starting_time'),
                Forms\Components\DatePicker::make('ending_time'),
                Forms\Components\Toggle::make('active')
                    ->inline(false)
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->maxLength(65000)->rows(1)->columnSpan(2),

            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')->weight('bold')->copyable()
                    ->copyMessage('Coupon code copied'),
                Tables\Columns\BadgeColumn::make('type')->enum([
                    'amount' => 'Amount', 'percent' => 'Percent'
                ])->colors([
                    'primary',
                    'success' => 'amount',
                    'danger' => 'Percent',
                ]),
                Tables\Columns\TextColumn::make('value'),
                Tables\Columns\TextColumn::make('amount')
                    ->formatStateUsing(fn ($state, $record) => "({$record['min_amount']} to {$record['max_amount']})")
                    ->size('sm'),
                // Tables\Columns\TextColumn::make('max_amount'),
                // Tables\Columns\TextColumn::make('starting_time')->date()->since(),
                Tables\Columns\TextColumn::make('ending_time')->date()->since(),
                Tables\Columns\ToggleColumn::make('active'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->modalWidth('md'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCoupons::route('/'),
        ];
    }
}
