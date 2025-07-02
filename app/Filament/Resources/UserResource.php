<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
//use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;  //table input
use Filament\Infolists;                      //infolist 
use Filament\Infolists\Infolist;             //infolist
use Filament\Infolists\Components\TextEntry; //infolist entry
use App\Filament\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'User section';  //Grouping navigation items


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\TextInput::make('description')->label('description')->required()->maxLength(255),

                //add Spatie role permission
                Forms\Components\Select::make('roles')->multiple()->relationship('roles', 'name')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
             //to force open viewOne on click instead of edit 
            ->recordUrl(fn ($record) => static::getUrl(name: 'view', parameters: ['record' => $record]))
            
            //Columns-----------------------------------------
            ->columns([
                //
                TextColumn::make('id')->sortable(),
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('email')->searchable()->sortable(),
                TextColumn::make('description')->searchable()->sortable(),
                //HasMany audits count 
                TextColumn::make('audits_count')->label('Audits'), // counts Audits, must add getEloquentQuery() { return parent::getEloquentQuery()->withCount('audits');
                
            ])
            //End Columns-----------------------------------------



            // Filters--------------------------
            ->filters([
                //
            ])
            //End Filters--------------------------


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
            Infolists\Components\TextEntry::make('name')->getStateUsing(fn ($record) => $record->getAttributes()['name'] ?? null), //bypassing an Eloquent accessor)
            Infolists\Components\TextEntry::make('email'),
            Infolists\Components\TextEntry::make('description'),
            Infolists\Components\TextEntry::make('audits_count')->label('Audits'), // counts Audits, must add getEloquentQuery() { return parent::getEloquentQuery()->withCount('audits');
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
            'index'  => Pages\ListUsers::route('/'),
            'view'   => Pages\ViewUser::route('/{record}'), // view one user
            'create' => Pages\CreateUser::route('/create'),
            'edit'   => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    //Override the getEloquentQuery() method to add the audit count eager loading if u want use counting in table/infolist
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withCount('audits');
    }
}
