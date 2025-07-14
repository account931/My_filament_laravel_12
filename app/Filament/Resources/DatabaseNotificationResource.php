<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Owner;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DatabaseNotificationResource\Pages;
use App\Filament\Resources\DatabaseNotificationResource\RelationManagers;
use Illuminate\Notifications\DatabaseNotification;  //Laravel DB notification
use Filament\Infolists;
use Filament\Infolists\Infolist;

class DatabaseNotificationResource extends Resource
{
    protected static ?string $model = DatabaseNotification::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
            // to force open viewOne on click instead of edit
            ->recordUrl(fn ($record) => static::getUrl(name: 'view', parameters: ['record' => $record]))

            //Columns
            ->columns([
                //
                TextColumn::make('id')->sortable(),
                TextColumn::make('type')->label('Type'),
                TextColumn::make('notifiable_id'),  //owner

                //Display name who was notified, it can be user or owner, so add logic
                //TextColumn::make('notifiable.last_name')->searchable(),
                TextColumn::make('notifiable_name')->label('Owner or User name')  //owner name //DatabaseNotification model has a notifiable() morph relation
                    ->state(fn ($record) => $record->notifiable) // just to activate it, as notifiable_name doesn't exist in your model or database, and Filament may be ignoring the   
                    ->formatStateUsing(function ($record) {
                        //dd($record->notifiable_type, $record->notifiable);
                        $notifiable = $record->notifiable;

                        if (! $notifiable) {
                            return '-';
                        }

                        return match ($record->notifiable_type) {
                            'App\Models\Owner' => $notifiable->last_name,
                            'App\Models\User'  => $notifiable->name,
                            default =>  $notifiable->id,
                        };
                })
                ->color(fn ($state, $record) => match ($record->notifiable_type) {
                   'App\Models\Owner' => 'danger',
                   'App\Models\User'  => 'success',
                    default           => 'gray',
                }),

                TextColumn::make('notifiable_type'),
                TextColumn::make('data')->formatStateUsing(fn ($state) => json_encode($state)),
                TextColumn::make('created_at')->since()->sortable(),
            ])
            ->filters([
                //
                // Filter 1, based on Owner/User name
                SelectFilter::make('notifiable_id')->label('Owner Last Name')
                    //->options(fn () => DatabaseNotification::pluck('notifiable_id', 'id'))
                    //>relationship expects a BelongsTo, HasOne, or HasMany, not a morphTo.
                    //->relationship('notifiable', 'last_name') // 'notifiable' is the relationship, 'name' is the column to display
                    //->options(fn () => Owner::select('id', 'last_name')->get()->unique('last_name') ->pluck('last_name', 'id'))
                    ->options(function () {
                        // Step 1: Get distinct notifiable IDs from notifications
                        $notifiableIds = DatabaseNotification::where('notifiable_type', Owner::class)
                           ->pluck('notifiable_id')
                           ->unique();

                        // Step 2: Get owners with those IDs
                        return Owner::whereIn('id', $notifiableIds)
                            ->get()
                            ->unique('last_name') // Optional: only one entry per last name
                            ->pluck('last_name', 'id'); // [id => last_name]
                        })

                    ->query(function (Builder $query, array $data) {   //dd($data);
                        //if (isset($data['value'])) {     // wtf, it must be $data['confirmed']
                        if (filled($data['value'])) {
                            $query->where('notifiable_id', (int) $data['value']);
                        }
                    })
                    ->label('Select notified'),
                // end Filter 1 

                
                // Filter 2, based on notifiable_type
                SelectFilter::make('notifiable_type')->label('Notifiable Type')
                    ->options([
                        \App\Models\Owner::class => 'Owner',
                        \App\Models\User::class  => 'User',
                    ])
                     ->query(function ($query, array $data) {
                        if (filled($data['value'])) {
                            $query->where('notifiable_type', $data['value']);
                        }
                })
                // end Filter 2

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
                Infolists\Components\TextEntry::make('id'),
                Infolists\Components\TextEntry::make('type'),
                Infolists\Components\TextEntry::make('notifiable_id'),
                Infolists\Components\TextEntry::make('created_at'),

                //Display name who was notified, it can be user or owner, so add logic
                //TextColumn::make('notifiable.last_name')->searchable(),
                Infolists\Components\TextEntry::make('notifiable_name')->label('Owner or User Name')  //owner name //DatabaseNotification model has a notifiable() morph relation
                    ->state(fn ($record) => $record->notifiable) // just to activate it, as notifiable_name doesn't exist in your model or database, and Filament may be ignoring the   
                    ->formatStateUsing(function ($record) {
                        //dd($record->notifiable_type, $record->notifiable);
                        $notifiable = $record->notifiable;

                        if (! $notifiable) {
                            return '-';
                        }

                        return match ($record->notifiable_type) {
                            'App\Models\Owner' => $notifiable->last_name,
                            'App\Models\User'  => $notifiable->name,
                            default =>  $notifiable->id,
                        };
                })
                ->color(fn ($state, $record) => match ($record->notifiable_type) {
                   'App\Models\Owner' => 'danger',
                   'App\Models\User'  => 'success',
                    default           => 'gray',
                }),

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
            'index'  => Pages\ListDatabaseNotifications::route('/'),
            'create' => Pages\CreateDatabaseNotification::route('/create'),
            'edit'   => Pages\EditDatabaseNotification::route('/{record}/edit'),
            'view'   => Pages\ViewDBNotification::route('/{record}'), // view one user
        ];
    }

  
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
        ->with('notifiable'); // Eager load the relation
    }

    //disable creation/editing/deletion:
    public static function canCreate(): bool
    {
        return false;
    }
    
    public static function canEdit(Model $record): bool
    {
        return false;
    }
   
    public static function canDelete(Model $record): bool
    {
        return false;
    }
    
}
