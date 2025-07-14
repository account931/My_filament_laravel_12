<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VenueResource\Pages;
use App\Filament\RelationManagers;
use App\Models\Venue;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;  //table column
use Filament\Tables\Columns\BooleanColumn; //table boolean
use Filament\Infolists;                      //infolist 
use Filament\Infolists\Infolist;             //infolist
use Filament\Infolists\Components\TextEntry; //infolist entry
use App\Filament\Components\Infolists\SoftDeletedBadge; //infolist, my custom component
use App\Filament\Components\Infolists\BooleanEntry; //infolist, my custom component
use Dotswan\MapPicker\Fields\Map;                       // Form for Dotswan/filament-map-picker
use Dotswan\MapPicker\Infolists\MapEntry;   //infolist for MapEntry Dotswan/filament-map-picker


class VenueResource extends Resource
{
    protected static ?string $model = Venue::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-right-circle';

    protected static ?string $navigationGroup = 'Section Main';  //Grouping navigation items

    protected static ?int $navigationSort = 2;  //order to appear in panels

    //Fn to hide resource panel, show for specific role only
    public static function shouldRegisterNavigation(): bool
    {
        //return auth()->user()?->hasRole('admin');
        return auth()->user()?->hasAnyRole(['admin', 'user']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\TextInput::make('venue_name')->label('Venue Name')->required()->maxLength(255),

                //Dotswan/filament-map-picker
                Map::make('location')->label('Location')->columnSpanFull()
                // Basic Configuration
                ->defaultLocation(latitude: 40.4168, longitude: -3.7038)
                ->draggable(true)
                ->clickable(true) // click to move marker
                ->zoom(15)->minZoom(0)->maxZoom(28)
                ->tilesUrl("https://tile.openstreetmap.de/{z}/{x}/{y}.png")
                ->detectRetina(true)
                // Controls
                ->showFullscreenControl(true)
                ->showZoomControl(true)
                // Location Features
                ->liveLocation(true, true, 5000),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table

            //to force open viewOne on click instead of edit 
            ->recordUrl(fn ($record) => static::getUrl(name: 'view', parameters: ['record' => $record]))

            //columns-----------------------------------------
            ->columns([
                TextColumn::make('venue_name')->searchable()->sortable(),
                TextColumn::make('address')->searchable()->sortable(),
                BooleanColumn::make('active')->sortable(),
                TextColumn::make('location')->searchable()->sortable(),
                TextColumn::make('created_at')->searchable()->sortable(),
                //
            ])
            //end columns-----------------------------------------


            //
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

    public static function infolist(Infolist $infolist): Infolist
    {
    return $infolist
        ->schema([
            Infolists\Components\TextEntry::make('venue_name')->getStateUsing(fn ($record) => $record->getAttributes()['venue_name'] ?? null), //bypassing an Eloquent accessor)
            Infolists\Components\TextEntry::make('location'),
            //Infolists\Components\TextEntry::make('active'),
            BooleanEntry::make('active'), //my custom, only visible if soft deleted
            Infolists\Components\TextEntry::make('created_at'),

            //Dotswan/filament-map-picker
            MapEntry::make('location')->label('Location Map')
                ->state(fn ($record) => [
                    'lat' => $record->location['lat'] ?? null,
                    'lng' => $record->location['lng'] ?? null,  //fix as in L6 we stored as lat/lon, but package wants lat/lng
                ])
                ->defaultLocation(latitude: 40.4168, longitude: -3.7038)
                ->draggable(false)->showMarker()->zoom(7)
                ->tilesUrl("https://tile.openstreetmap.de/{z}/{x}/{y}.png")
                ->detectRetina(true)->markerColor("#22c55eff"),

        ]);
     }

    public static function getRelations(): array
    {
        return [
            //
            RelationManagers\EquipmentsRelationManager::class,
            RelationManagers\AuditsRelationManager::class, //Laravel audit


        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListVenues::route('/'),
            'create' => Pages\CreateVenue::route('/create'),
            'view'   => Pages\ViewVenue::route('/{record}'), // view one owner page
            'edit'   => Pages\EditVenue::route('/{record}/edit'),
        ];
    }
}
