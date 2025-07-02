<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EquipmentResource\Pages;
//use App\Filament\Resources\EquipmentResource\RelationManagers;
use App\Models\Equipment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;  //table textcolumn
use Filament\Infolists;                      //infolist 
use Filament\Infolists\Infolist;             //infolist
use Filament\Infolists\Components\TextEntry; //infolist entry
use App\Filament\RelationManagers;

class EquipmentResource extends Resource
{
    protected static ?string $model = Equipment::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder-plus';

    protected static ?string $navigationGroup = 'Section Main';  //Grouping navigation items

    protected static ?int $navigationSort = 3;  //order to appear in panels



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\TextInput::make('trademark_name')->label('Venue Name')->required()->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            //to force open viewOne on click instead of edit 
            ->recordUrl(fn ($record) => static::getUrl(name: 'view', parameters: ['record' => $record]))

            ->columns([
                //colums ------
                TextColumn::make('id')->sortable(),
                TextColumn::make('trademark_name')->searchable()->sortable()->visible(fn () => auth()->user()?->can('view owners'))
                   ->getStateUsing(fn ($record) => $record->getAttributes()['trademark_name'] ?? null), //bypassing an Eloquent accessor)
                TextColumn::make('model_name')->searchable()->sortable(),
                TextColumn::make('description')->searchable()->sortable(),
                TextColumn::make('created_at')->searchable()->sortable(),
            ])
            //end //colums ------
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

    //view one , viewOwner does not matter?????
    public static function infolist(Infolist $infolist): Infolist
    {
    return $infolist
        ->schema([
            Infolists\Components\TextEntry::make('trademark_name')->getStateUsing(fn ($record) => $record->getAttributes()['trademark_name'] ?? null), //bypassing an Eloquent accessor)
            Infolists\Components\TextEntry::make('model_name'),
            Infolists\Components\TextEntry::make('description'),
            Infolists\Components\TextEntry::make('created_at'),

        ]);
     }

    public static function getRelations(): array
    {
        return [
            //
            RelationManagers\AuditsRelationManager::class, //Laravel audit

        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListEquipment::route('/'),
            'create' => Pages\CreateEquipment::route('/create'),
            'view'   => Pages\ViewEquipment::route('/{record}'), // view one owner page
            'edit'   => Pages\EditEquipment::route('/{record}/edit'),
        ];
    }
}
