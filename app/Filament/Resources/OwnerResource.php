<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OwnerResource\Pages;
use App\Filament\Resources\OwnerResource\RelationManagers;
use App\Models\Owner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\EditAction;   //edit icon
use Filament\Tables\Actions\DeleteAction; //delete icon
use Filament\Notifications\Notification;  //flash
use Filament\Tables\Filters\Filter;
use Filament\Tables\Actions\BulkAction;  //bulk actions
use Illuminate\Database\Eloquent\Collection;

class OwnerResource extends Resource
{
    protected static ?string $model = Owner::class;

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
            //columns-----------------------------------------
            ->columns([
                //
                TextColumn::make('id')->sortable(),
                TextColumn::make('first_name')->searchable()->sortable()
                   ->getStateUsing(fn ($record) => $record->getAttributes()['first_name'] ?? null), //bypassing an Eloquent accessor)

                //HasMany venues count 
                TextColumn::make('venues_count')->label('Venues')->counts('venues'), // Automatically eager loads and counts the relation
                
                //HasMany disaply venues name
                //TextColumn::make('venues')->getStateUsing(fn ($record) => $record->getAttributes()['first_name'] ?? null),
                /*TextColumn::make('venues.name')->label('Venues')
                     ->formatStateUsing(fn ($state, $record) => 
                         $record->venues->pluck('venue_name') //->join(', ')
                    )
                     ->wrap(),
                     */

                TextColumn::make('last_name')->searchable()->sortable(),
                TextColumn::make('email')->searchable()->sortable(),
                TextColumn::make('phone')->searchable(),
                BooleanColumn::make('confirmed')->sortable(),
                BadgeColumn::make('location')
                    ->colors(['primary' => 'UA','success' => 'EU',])
                    ->sortable(),
                 TextColumn::make('created_at')->dateTime()->sortable(),
                 TextColumn::make('updated_at')->dateTime()->sortable(),
                //
            ])

            // Filters--------------------------
            ->filters([
                // Date filter
                Filter::make('created_time')
                    ->form([
                        Forms\Components\DatePicker::make('start_time')->label('Start Time'),
                        Forms\Components\DatePicker::make('end_time')->label('End Time'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        if ($data['start_time']) {
                            $query->whereDate('created_at', '>=', $data['start_time']);
                        }
                        if ($data['end_time']) {
                            $query->whereDate('created_at', '<=', $data['end_time']);
                        }
                    })
                    ->label('Created Timee'),
                //End Date filter

                //filter 2...........
            ])
            // End Filters ---------------------



            //Row actions---------------------------
            ->actions([
                Tables\Actions\EditAction::make(),
                EditAction::make(),
                DeleteAction::make(),
                //custom actions-1
                Tables\Actions\Action::make('view')
                    ->label('Flash ID')
                    //->url(fn ($record) => route('your.route.name', $record))
                    //->openUrlInNewTab(),
                    ->action(function ($record, $livewire) {
                        // Flash the record ID into session
                        session()->flash('message', 'Record ID is: ' . $record->id);
                        Notification::make()->title('Record ID is: ' . $record->id)->send();  //send flash message

                        // Optionally, you can notify Livewire/Filament users with a notification:
                        //$livewire->notify('success', 'Record ID flashed: ' . $record->id);
                    })
                    ->requiresConfirmation() // optional, ask user to confirm before action
                    ->color('primary')
                    ->icon('heroicon-o-information-circle'),
                    //end custom actions-1

                //action 2.........
            ])
             //End Row actions---------------------------


            //Bulk actions------------------------------------------------------
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),  //delete bulk action
                    //my bulk-1
                    BulkAction::make('markAsConfirmed')
                        ->label('Mark as Confirmed')
                        ->action(fn (Collection $records) => 
                              Notification::make()->title('Record IDs are: ' . $records->pluck('id'))->send() //send flash message
                             //$records->each->update(['confirmed' => true] )
                        )
                        ->requiresConfirmation()
                        ->color('success')
                        ->icon('heroicon-o-check-circle'),
                    //end my bulk-1

                    //bulk action 2.........
                ]),
            ]);  //end all Bulk actions------------------------------------------------------
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
            'index' => Pages\ListOwners::route('/'),
            'create' => Pages\CreateOwner::route('/create'),
            'edit' => Pages\EditOwner::route('/{record}/edit'),
        ];
    }
}
