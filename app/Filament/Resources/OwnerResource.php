<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OwnerResource\Pages;
use App\Filament\Resources\OwnerResource\RelationManagers;
use App\Models\Owner;
use Filament\Forms;
use Filament\Forms\Form;    //edit form
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
use Filament\Notifications\Notification;  //flash message
use Filament\Tables\Filters\Filter;
use Filament\Tables\Actions\BulkAction;  //bulk actions
use Illuminate\Database\Eloquent\Collection;
use Filament\Infolists;                      //infolist 
use Filament\Infolists\Infolist;             //infolist
use Filament\Infolists\Components\TextEntry; //infolist entry
use Filament\Tables\Filters\SelectFilter;   
use Filament\Tables\Actions\Action;        //header actions
use Illuminate\Support\Facades\Http;       // Laravel HTTP client
use App\Enums\ConfirmedEnum;                  //Enum

class OwnerResource extends Resource
{
    protected static ?string $model = Owner::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // Edit form
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\TextInput::make('last_name')->label('Last Name')->required()->maxLength(255),
                Forms\Components\TextInput::make('first_name')->label('First Name')->required()->maxLength(255),

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
                TextColumn::make('venues.venue_name')->label('Venues(first 2)')
                     ->formatStateUsing(fn ($state, $record) => 
                         $record->venues->take(2)->pluck('venue_name')->join(', ')
                    )
                    ->wrap(),
                     

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

                //filter 2 (is confirmed)
                SelectFilter::make('confirmed')
                ->options([
                    ConfirmedEnum::Confirmed->value    => ConfirmedEnum::Confirmed->label(),     //'1'  => 'Confirmed',
                    ConfirmedEnum::NotConfirmed->value => ConfirmedEnum::NotConfirmed->label(),  //'0'   => 'Not Confirmed', 
                     
                ])
                ->query(function (Builder $query, array $data) {  //dd($data);
                    if (isset($data['value'])) {     //wtf, it must be $data['confirmed']
                        $query->where('confirmed', (int) $data['value']);
                    }
                })
                ->label('Confirmed Status'),
                //end filter 2 (is confirmed)

                //filter 3...........
                Filter::make('is_confirmed')->query(fn (Builder $query): Builder => $query->where('confirmed', true))
                //end filter 3...........

              //filter 4...........  
            ])
            // End Filters ---------------------





            // Header actions---------------------
            ->headerActions([
            Action::make('callApi')
                ->label('Call External APII')
                ->icon('heroicon-o-plus')
                ->action(function () {
                    // Your logic here
                    // Send a GET request to external API
                    //dd(route('api.owners.test', [], true));
                    //$response = Http::get('http://localhost/api/owners');
                   // $response = Http::get(route('api.owners.test'));
                   //$response = Http::get('http://127.0.0.1/api/owners');
                   //$response = Http::get('http://localhost/api/owners');
                   //$response = Http::timeout(10)->get('http://laravel.test/api/owners');
                   $response = Http::timeout(10)->get('http://localhost:8000/api/owners');





                    //$response = Http::get('http://host.docker.internal/api/owners');
                    //$response = Http::get('my_filament_laravel_12-laravel.test-1');
//my_filament_laravel_12-laravel.test-1

                    


                    if ($response->successful()) {
                        // Process response if needed
                        $data = $response->json();

                        // Optionally: use notifications to inform user
                        //\Filament\Facades\Filament::notify('success', 'API called successfully!');
                        Notification::make()->title('API called successfully!' )->send();  //send flash message

                    } else {
                        Notification::make()->title('API failed!' )->send();  //send flash message
                        //\Filament\Facades\Filament::notify('danger', 'Failed to call API.');
                    }
                }),
            ])
            // End Header actions---------------------




            //Row actions---------------------------
            ->actions([
                Tables\Actions\ViewAction::make(),           //view one row action
                Tables\Actions\EditAction::make(),           //edit built-in action
                //EditAction::make(),
                DeleteAction::make(),                        // delete built-in action

                //custom actions-1
                Tables\Actions\Action::make('flashId')
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
                    Tables\Actions\DeleteBulkAction::make(),  //delete built-in bulk action

                    \App\Filament\Resources\OwnerResource\Actions\MarkAsConfirmedBulkAction::make(), //my bulk action moved to separate folder

                    //my bulk-1
                    BulkAction::make('markAsConfirmed1')
                        ->label('Mark as Confirmed')
                        //add form
                        ->form([
                        Forms\Components\Select::make('status')
                            ->required()
                            ->options([
                                'active' => 'Active',
                                'inactive' => 'Inactive',
                            ]),
                        Forms\Components\TextInput::make('message')->required(),
                        ])
                        //end add form
                        ->action(function (Collection $records, array $data) {    // $records -> seelcted ids, $data - form input
                            //dd($data);
                            //send flash message      
                            Notification::make()->title('Record IDs are: ' . $records->pluck('id')  . ', form input is: ' . $data['message']   . ' ' .   $data['status'])
                                  ->success()
                                  ->send();
                             //$records->each->update(['confirmed' => true] )
                         })
                        ->requiresConfirmation()
                        ->color('success')
                        ->icon('heroicon-o-check-circle'),
                    //end my bulk-1

                    //bulk action 2.........
                ]),
            ]);  //end all Bulk actions------------------------------------------------------
    }

    //view one , viewOwner does not matter?????
    public static function infolist(Infolist $infolist): Infolist
    {
    return $infolist
        ->schema([
            Infolists\Components\TextEntry::make('first_name')->getStateUsing(fn ($record) => $record->getAttributes()['first_name'] ?? null), //bypassing an Eloquent accessor)
            Infolists\Components\TextEntry::make('last_name'),
            Infolists\Components\TextEntry::make('email'),
            Infolists\Components\TextEntry::make('phone'),
            Infolists\Components\TextEntry::make('location'),
            Infolists\Components\TextEntry::make('confirmed')
            
                ->columnSpanFull(),
        ]);
     }

    //register relation manager
    public static function getRelations(): array
    {
        return [
            //
            RelationManagers\VenuesRelationManager::class,

        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListOwners::route('/'),
            'create' => Pages\CreateOwner::route('/create'),
            'view'  => Pages\ViewOwner::route('/{record}'), // ✅ Must match ViewOwner.php exactly
            'edit'  => Pages\EditOwner::route('/{record}/edit'),
        ];
    }
}
