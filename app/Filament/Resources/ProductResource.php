<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Illuminate\Support\Str;
use RalphJSmit\Filament\SEO\SEO;

use Filament\Facades\Filament;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-template';
    protected static ?string $navigationGroup = 'Shop';

    public static function form(Form $form): Form
    {
        Filament::registerRenderHook(
            'styles.end',
            fn () => "<style>
                .grid-style .filepond--item {
                    width: calc(16.667% - 0.75em);
                    margin: 5px !important;
                }
                .filepond--item-panel{
                    padding: 15px !important;
                }
            </style>",
        );

        return $form
            ->schema([
                Forms\Components\Group::make()->schema([
                    Forms\Components\Card::make()->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->lazy()
                            ->afterStateUpdated(
                                fn (string $context, $state, callable $set) =>
                                $context === 'create' ? $set('slug', Str::slug($state)) : null
                            ),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->reactive()
                            ->maxLength(255)
                            ->unique(self::$model, 'slug', ignoreRecord: true),

                        Forms\Components\RichEditor::make('description')
                            // ->extraAttributes(['style' => 'height: 300px;'])
                            ->maxLength(65535)
                            ->disableToolbarButtons([
                                'attachFiles',
                                'codeBlock',
                            ])->columnSpan(2),
                    ])->columns(2),
                    Forms\Components\Card::make()->schema([
                        SpatieMediaLibraryFileUpload::make('Featured')
                            ->collection('featured')
                            ->image()
                            ->imagePreviewHeight('250')
                            ->imageResizeMode('cover')
                            ->panelLayout('integrated')
                            ->preserveFilenames()
                            ->responsiveImages()
                    ]),
                    Forms\Components\Card::make()->schema([
                        SpatieMediaLibraryFileUpload::make('Images')
                            ->collection('products')
                            ->extraAttributes(['class' => 'grid-style'])
                            ->image()
                            ->multiple()
                            ->preserveFilenames()
                            ->responsiveImages()
                    ]),
                ])->columnSpan(9),
                Forms\Components\Group::make()->schema([
                    Forms\Components\Card::make()->schema([
                        Forms\Components\Select::make('category_id')
                            // ->relationship('category', 'name', fn (Builder $query) => $query->whereNotNull('parent_id'))
                            ->relationship('category', 'name')
                            ->required(),
                        Forms\Components\Select::make('status')
                            ->required()
                            ->default('draft')
                            ->options(
                                \App\Enums\ProductStatusEnum::values()
                            ),
                        Forms\Components\Toggle::make('active')
                            ->default(true)
                            ->required(),
                        Forms\Components\Toggle::make('has_special_offer')
                            ->reactive()
                            ->default(false),
                        Forms\Components\Select::make('offer_type')
                            ->default('amount')
                            ->hidden(fn (callable $get) => $get('has_special_offer') !== true)
                            ->options([
                                'amount' => 'Amount',
                                'percent' => 'Percent',
                            ]),
                        Forms\Components\TextInput::make('offer_value')
                            ->hidden(fn (callable $get) => $get('has_special_offer') !== true)
                            ->numeric()
                    ]),
                    Forms\Components\Card::make()
                        ->schema([
                            Forms\Components\Placeholder::make('SEO')
                                ->label('SEO Meta Data'),
                            SEO::make(['title', 'description'])
                        ]),
                ])->columnSpan(3),
            ])->columns([
                'sm' => 12,
                'lg' => null,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('Image')
                    ->conversion('thumb')
                    ->collection('featured'),
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\IconColumn::make('active')
                    ->boolean(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors(['success' => 'published', 'warning' => 'draft']),
                Tables\Columns\TextColumn::make('sale_count'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
            ])->defaultSort('id', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\VariantOptionsRelationManager::class,
            RelationManagers\VariantsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
