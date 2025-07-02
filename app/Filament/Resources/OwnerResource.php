<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OwnerResource\Pages;
use App\Filament\RelationManagers;
use App\Models\Owner;
use Filament\Forms;
use Filament\Forms\Form;    //edit form
use Filament\Forms\Components\FileUpload; //Form upload
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;  //table textcolumn
use Filament\Tables\Columns\ImageColumn; //table image
use Filament\Tables\Columns\BooleanColumn; //table boolean
use Filament\Tables\Columns\BadgeColumn;   //table 
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
use Filament\Infolists\Components\ImageEntry;//infolist image
use App\Filament\Components\Infolists\SoftDeletedBadge; //infolist, my custom component
use App\Filament\Components\Infolists\BooleanEntry; //infolist, my custom component


use Filament\Tables\Filters\SelectFilter;   
use Filament\Tables\Actions\Action;        //Header actions
use Illuminate\Support\Facades\Http;       // Laravel HTTP client
use App\Enums\ConfirmedEnum;               //Enum
use App\Enums\LocationEnum;                //Enum
use Filament\Navigation\NavigationItem;    //navigation settings


class OwnerResource extends Resource
{
    protected static ?string $model = Owner::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 1;  //order to appear in panels

    protected static ?string $navigationGroup = 'Section Main';  //Grouping navigation items


    //public $apiResponse = ['title' => 'Ndfdfdfdo data received'];   //for ajax

    //Fn to hide resource panel, show for specific role only
    public static function shouldRegisterNavigation(): bool
    {
        //return auth()->user()?->hasRole('admin');
        return auth()->user()?->hasAnyRole(['admin', 'user']);
    }


    //Adding a badge to a navigation item
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }



    // Edit form -------------------------
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\TextInput::make('last_name')->label('Last Name')->required()->maxLength(255),
                Forms\Components\TextInput::make('first_name')->label('First Name')->required()->maxLength(255)
                      ->formatStateUsing(function ($state, $record) {  //bypassing an Eloquent accessor
                          return $record->getRawOriginal('first_name');
                }),
                //image, 'image' as DB column must be in model protected $fillable = [  
                FileUpload::make('image')->label('Upload Image')
                ->image() // Ensures only images can be uploaded
                ->disk('public') // uses storage/app/public
                ->directory('images') // saves to storage/app/public/images
                ->imagePreviewHeight('150') // Optional preview height
                ->maxSize(2048) // in KB (2MB max)
                ->required(),
                Forms\Components\TextInput::make('email')->label('Email')->required()->email() ->rules(['email']), // Laravel validation rule,
                Forms\Components\TextInput::make('phone')->label('phone')->required()->tel() // Sets input type="tel"
                     ->rules(['required', 'regex:/^[+]380[\d]{1,4}[0-9]+$/']), // $RegExp_Phone = '/^[+]380[\d]{1,4}[0-9]+$/'; 
               Forms\Components\Select::make('location')->label('location')->options( collect(LocationEnum::cases())
                  ->mapWithKeys(fn ($case) => [$case->value => $case->label()]) ->toArray())->required(),
            ]);
    }
    // End Edit form --------------------------






    public static function table(Table $table): Table
    {
        return $table
            //Columns-----------------------------------------
            ->columns([
                //
                TextColumn::make('id')->sortable(),
                TextColumn::make('first_name')->searchable()->sortable()->visible(fn () => auth()->user()?->can('view owners'))
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
                     
                TextColumn::make('last_name')->searchable()->sortable()->myCustomDisplay(), //my custom method, set in App/Providers/AppServiceProvider
                //image
                ImageColumn::make('image')->label('Profile Image')->disk('public') ->circular(),   // storage disk, if needed //storage/app/public  
                TextColumn::make('email')->searchable()->sortable(),
                TextColumn::make('phone')->searchable(),
                BooleanColumn::make('confirmed')->sortable(),
                BadgeColumn::make('location')
                    ->colors(['primary' => 'UA','success' => 'EU',])
                    ->sortable(),
                TextColumn::make('audits_count')->label('Audits'), // counts Audits, must add getEloquentQuery() { return parent::getEloquentQuery()->withCount('audits');

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

            //Header action 1 ---------
            Action::make('callApi')
                ->label('Call External APII')
                ->icon('heroicon-o-plus')
                //->form([Forms\Components\Hidden::make('api_response'),])
                ->action(function ($record, $livewire) {   //pass liveware is a must
                    // Your logic here
                    // Send a GET request to external API
                    //dd(route('api.owners.test', [], true));
                    //$response = Http::get('http://localhost/api/owners');
                   // $response = Http::get(route('api.owners.test'));
                   //$response = Http::get('http://127.0.0.1/api/owners');
                   //$response = Http::get('http://localhost:8000/api/owners');
                   //$response = Http::timeout(10)->get('http://laravel.test/api/owners');
                   //$response = Http::timeout(10)->get('http://localhost:8000/api/owners');
                   //$response = Http::timeout(10)->get('http://host.docker.internal:8000/api/owners');
                   //$response = Http::get('http://host.docker.internal/api/owners');
                   //$response = Http::get('my_filament_laravel_12-laravel.test-1');
                //my_filament_laravel_12-laravel.test-1
                
                   $response = Http::timeout(10)->get('https://jsonplaceholder.typicode.com/posts/1'); //test open api
                   
                   


                    if ($response->successful()) {
                        // Process response if needed
                        $data = $response->json();

                        // Optionally: use notifications to inform user
                        //\Filament\Facades\Filament::notify('success', 'API called successfully!');
                        Notification::make()->title('API called successfully! Title is: '  . $data['title'])->success()->send();  //send flash message
                        
                        // Store response in a property to pass into modal
                        // Store the API response data in Livewire property
                        $apiResponse = $response->json();
                        
                        //dd($livewire->apiResponse);
                    
                    } else {
                        Notification::make()->title('API failed!' )->send();  //send flash message
                        //\Filament\Facades\Filament::notify('danger', 'Failed to call API.');
                    }
                }) //end action
                //open modal with api response
                /*
                ->modalHeading('My API Response')
                ->modalSubmitAction(false)
                ->modalCancelActionLabel('Close')
                ->modalContent(function ($record, $livewire) {

                    $response = $apiResponse ?? ['title' => 'No data received'];

                    return view('filament.resource.user-resource.modals.api-response', [
                        'response' => $response,
                    ]);
                })*/
                ,
                // end open modal
                // End Header action 1-------

                // Header action 2 -------
                \App\Filament\Resources\OwnerResource\Actions\OpenUrlInWindowAction::make(), //my header action 2 moved to separate folder
                // End Header action 2-------

                // Header action 3 -------
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

                    \App\Filament\Resources\OwnerResource\Actions\MarkAsConfirmedBulkAction::make(), //my bulk action 1 moved to separate folder

                    //my bulk-2
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
                    //end my bulk-2

                    //bulk action 3.........
                ]),
            ]);  //end all Bulk actions------------------------------------------------------
    }

    //view one , viewOwner does not matter?????
    public static function infolist(Infolist $infolist): Infolist
    {
    return $infolist
        ->columns(3)
        ->schema([

            //group entries 1
            Infolists\Components\Section::make()
                    ->columnSpan(1)
                    ->schema([
                        ImageEntry::make('image')->label('Profile Image')->disk('public') ->circular(),   // storage disk, if needed
                        Infolists\Components\TextEntry::make('first_name')->getStateUsing(fn ($record) => $record->getAttributes()['first_name'] ?? null), //bypassing an Eloquent accessor)
                        Infolists\Components\TextEntry::make('last_name'),

                     ]),

            //group entries 2         
            Infolists\Components\Grid::make(1)
                ->columnSpan(1)
                ->schema([
                    Infolists\Components\Section::make()
                        ->schema([
                            Infolists\Components\TextEntry::make('soft deleted')->getStateUsing(fn ($record) => $record->trashed() 
                                     ? '<span style="color: white; background-color: red; padding: 0.2em 0.5em; border-radius: 0.25rem;"> Soft Deleted</span>'
                                     : '<span style="color: white; background-color: green; padding: 0.2em 0.5em; border-radius: 0.25rem;">   Not deleted</span>'
                                )->html(), // <-- Important to render HTML instead of escaping it
                            SoftDeletedBadge::make(), //my custom, only visible if soft deleted
                        ]),
            ]),
            // end group entries 2  



            //group entries 3        
            Infolists\Components\Section::make()
                ->columnSpan(1)
                ->schema([
                    Infolists\Components\TextEntry::make('email'),
                    Infolists\Components\TextEntry::make('phone'),
                    Infolists\Components\TextEntry::make('location'),
                    Infolists\Components\TextEntry::make('audits_count')->label('Audits'), // counts Audits, must add getEloquentQuery() { return parent::getEloquentQuery()->withCount('audits');

            ]),
            // end group entries 3  

            
            //group entries 4       
            Infolists\Components\Section::make()
                ->columnSpan(1)
                ->schema([
                    Infolists\Components\TextEntry::make('confirmed')->label('Confirmed')->formatStateUsing(fn ($state) => $state
                        ? '<span style="color: white; background-color: green; padding: 0.2em 0.5em; border-radius: 0.25rem;">Confirmed</span>'
                        : '<span style="color: white; background-color: red; padding: 0.2em 0.5em; border-radius: 0.25rem;">Not confirmed</span>')
                        ->html(),  // Important: allow HTML rendering

                    BooleanEntry::make('confirmed'), //my custom, only visible if soft deleted
            ]),
            // end group entries  4   


          
        ]);
     }

    //register relation manager
    public static function getRelations(): array
    {
        return [
            //
            RelationManagers\VenuesRelationManager::class, //venues relation
            RelationManagers\AuditsRelationManager::class, //Laravel audit


        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListOwners::route('/'),
            'create' => Pages\CreateOwner::route('/create'),
            'view'   => Pages\ViewOwner::route('/{record}'), // view one owner page
            'edit'   => Pages\EditOwner::route('/{record}/edit'),
        ];
    }

    //modify the query
    public static function getEloquentQuery(): Builder
    {
        // Get the default query
        $query = parent::getEloquentQuery();

        // Modify the query, for example:
        // - Filter only active records
        // - Exclude soft deleted
        // - Add where clauses or joins
        //return $query->where('status', 'active');
        return $query
            ->withTrashed()  // Include soft deleted records in the query
            ->withCount('audits'); //add the audit count eager loading if u want use counting in table/infolist
    }
}
