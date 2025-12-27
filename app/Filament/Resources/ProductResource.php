<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource; //
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Shop';  // Grouping navigation items

    protected static ?int $navigationSort = 2;  // order to appear in panels

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\TextInput::make('name')->label('Name')->required()->maxLength(255),
                Forms\Components\TextInput::make('description')->label('description')->required()->maxLength(255),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            // to force open viewOne on click instead of edit
            ->recordUrl(fn ($record) => static::getUrl(name: 'view', parameters: ['record' => $record]))

            // Columns-----------------------------------------
            ->columns([
                //
                TextColumn::make('name')->sortable()->label('name'),
                TextColumn::make('description')->sortable()->getStateUsing(fn ($record) => Str::limit($record->description, 20) ?? null),
                TextColumn::make('sku')->sortable(),
                TextColumn::make('price')->sortable(),
                TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            // End Columns-----------------------------------------

            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    // view one
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                // Infolists\Components\TextEntry::make('trademark_name')->getStateUsing(fn ($record) => $record->getAttributes()['trademark_name'] ?? null), // bypassing an Eloquent accessor)
                Infolists\Components\TextEntry::make('name')->label('Name'),
                Infolists\Components\TextEntry::make('slug'),
                Infolists\Components\TextEntry::make('description'),
                Infolists\Components\TextEntry::make('sku'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
            'view' => Pages\ViewProduct::route('/{record}'), // view one owner page
        ];
    }
}
