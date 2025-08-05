<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderItemResource\Pages;
use App\Models\OrderItem;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables; //
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrderItemResource extends Resource
{
    protected static ?string $model = OrderItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Shop';  // Grouping navigation items

    protected static ?int $navigationSort = 3;  // order to appear in panels

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(fn ($record) => static::getUrl(name: 'view', parameters: ['record' => $record]))

             // Columns
            ->columns([
                //
                TextColumn::make('id')->sortable(),
                TextColumn::make('product_name')->sortable()->label('customer'),
            ])
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
                // Infolists\Components\TextEntry::make('product_name')->label('ProductName'),
                Infolists\Components\TextEntry::make('product_name')->url(fn ($record) => ProductResource::getUrl('view', ['record' => $record->id])) // or 'view' if using view page
                    ->openUrlInNewTab()->color('primary'),
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
            'index' => Pages\ListOrderItems::route('/'),
            'create' => Pages\CreateOrderItem::route('/create'),
            'edit' => Pages\EditOrderItem::route('/{record}/edit'),
            'view' => Pages\ViewOrderItem::route('/{record}'), // view one owner page
        ];
    }
}
