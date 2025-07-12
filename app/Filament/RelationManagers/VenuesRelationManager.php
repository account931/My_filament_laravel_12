<?php

namespace App\Filament\RelationManagers;

use App\Filament\Resources\VenueResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class VenuesRelationManager extends RelationManager
{
    protected static string $relationship = 'venues';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('owner_id')
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
                // make possible to open venue itself by click
                Tables\Columns\TextColumn::make('venue_name')->url(fn ($record) => VenueResource::getUrl('view', ['record' => $record->id])) // or 'view' if using view page
                    ->openUrlInNewTab()->color('primary'),
                Tables\Columns\TextColumn::make('address'),
                Tables\Columns\TextColumn::make('address'),
                // HasMany venues count
                Tables\Columns\TextColumn::make('equipments_count')->label('Equipments count')->counts('equipments'), // Automatically eager loads and counts the relation
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
