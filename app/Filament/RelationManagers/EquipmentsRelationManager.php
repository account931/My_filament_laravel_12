<?php

namespace App\Filament\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EquipmentResource;


class EquipmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'equipments';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('trademark_name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('owner_id')
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                //make possible to open trademark_name itself by click    
                Tables\Columns\TextColumn::make('trademark_name')->url(fn ($record) => EquipmentResource::getUrl('view', ['record' => $record->id])) // or 'view' if using view page
                         ->openUrlInNewTab()->color('primary'),
                Tables\Columns\TextColumn::make('model_name'),
                Tables\Columns\TextColumn::make('description'),
                //HasMany venues count 
                //Tables\Columns\TextColumn::make('equipments_count')->label('Equipments count')->counts('equipments'), // Automatically eager loads and counts the relation
            ])

            // Filters--------------------------
            ->filters([
                //
            ])
            // End Filters--------------------------

            // Head actions-------------------------
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            // End Head actions-------------------------

            // actions-------------------------
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
             // end actions-------------------------


            // Bulck actions------------------------- 
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]); // End Bulck actions------------------------- 
    }
}
