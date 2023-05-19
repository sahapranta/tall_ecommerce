<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use App\Models\VariantOption;
use Facades\App\Helpers\SKU;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VariantsRelationManager extends RelationManager
{
    protected static string $relationship = 'variants';

    protected static ?string $recordTitleAttribute = 'sku';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()->schema([
                    Forms\Components\TextInput::make('sku')
                        ->required()
                        ->default(
                            fn (RelationManager $livewire) =>
                            SKU::make($livewire->ownerRecord->title)
                        )
                        ->maxLength(255),
                    Forms\Components\TextInput::make('sale_price')->numeric()->required(),
                    Forms\Components\TextInput::make('offer_price')->numeric()->required(),
                    Forms\Components\TextInput::make('shipping_weight')->required(false),
                    Forms\Components\TextInput::make('stock')->numeric()->required(),
                    Forms\Components\TextInput::make('dimension'),
                    Forms\Components\Grid::make(3)->schema([
                        Forms\Components\Toggle::make('active')
                            ->default(true),
                        Forms\Components\Toggle::make('free_shipping')
                            ->default(false),
                        Forms\Components\Toggle::make('is_default')
                            ->default(false),
                    ]),
                ])->columns(2),
                Forms\Components\Group::make()->schema([
                    Forms\Components\Repeater::make('attribs')
                        ->label('Options')
                        ->hint('You can choose option only after create')
                        ->relationship('attribs')
                        ->schema([
                            Forms\Components\Select::make('variant_option_id')
                                ->label('name')
                                ->options(function (RelationManager $livewire): array {
                                    return $livewire->ownerRecord->variantOptions()
                                        ->pluck('name', 'id')
                                        ->toArray();
                                })
                                ->required(),
                            Forms\Components\Hidden::make('variant_id'),
                            Forms\Components\TextInput::make('value')->required()->hint('Must be unique'),
                        ])
                        ->minItems(1)
                        // ->maxItems(fn (RelationManager $livewire) => $livewire->ownerRecord->variantOptions()->count())
                        ->disableItemDeletion()
                        ->disableItemMovement()
                        ->columns(2),
                ])
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sku'),
                Tables\Columns\TextColumn::make('sale_price'),
                Tables\Columns\TextColumn::make('offer_price'),
                Tables\Columns\TextColumn::make('stock'),
                // Tables\Columns\TextColumn::make('shipping_weight'),
                Tables\Columns\IconColumn::make('active')
                    ->boolean(),
                Tables\Columns\IconColumn::make('free_shipping')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
