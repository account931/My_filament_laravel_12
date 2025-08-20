<?php

// One record

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions\Action;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;  // flash message
use Filament\Tables;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    // Set the title shown in the browser tab and page header
    public function getTitle(): string
    {
        return 'User Id: '.$this->record->id.',  Name : '.$this->record->name;
    }

    // header action
    protected function getHeaderActions(): array
    {
        return [

            // action 1
            Action::make('callApi')
                ->label('Call API')
                ->icon('heroicon-o-cloud')
                ->action(function () {
                    // Do something, like call an external API
                    // \Http::get('...');
                    // $this->notify('success', 'API called!');
                    Notification::make()->title('Fake API called successfully! Id '.$this->record->id)->success()->send();  // send flash message

                }),
            // end action 1
            // Tables\Actions\EditAction::make(),           //edit built-in action

            // action 2
            Action::make('edit')
                ->label('Edit')
                ->icon('heroicon-o-pencil')
                ->url(fn () => UserResource::getUrl('edit', ['record' => $this->record])),
            // end action 2

            // action 3
            \App\Filament\Resources\UserResource\Actions\GenerateSanctumToken::make(), // my header action 3 moved to separate folder
            // end action 3

        ];
    }

    // THIS IS NOT WORKING, WORKS FROM DEFINED IN  public static function infolist(Infolist $infolist): Infolist
    /*
    protected function getInfolistSchema(): array
    {
        dd('ViewOwner loaded', $this->record);
        return [
            TextEntry::make('last_name'),
            TextEntry::make('email'),
        ];
    }
    */
}
