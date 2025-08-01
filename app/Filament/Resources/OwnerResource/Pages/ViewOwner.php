<?php

// One record

namespace App\Filament\Resources\OwnerResource\Pages;

use App\Filament\Resources\OwnerResource;
use App\Models\Owner;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;  // flash message
use Filament\Resources\Pages\ViewRecord;
use Filament\Tables;

class ViewOwner extends ViewRecord
{
    protected static string $resource = OwnerResource::class;

    // Set the title shown in the browser tab and page header
    public function getTitle(): string
    {
        return 'Owner Id: '.$this->record->id.',  '.$this->record->last_name;
    }

    // header action
    protected function getHeaderActions(): array
    {
        return [
            // action 1
            Action::make('callApi')
                ->label('Call API')
                ->icon('heroicon-o-cloud')
                ->color('info') // Sets the button color
                ->action(function () {
                    // Do something, like call an external API
                    // \Http::get('...');
                    // $this->notify('success', 'API called!');
                    Notification::make()->title('Fake API called successfully! Id '.$this->record->id)->success()->send();  // send flash message

                }),
            // end action 1
            // Tables\Actions\EditAction::make(),           //edit built-in action

            // action 2, Edit
            Action::make('edit')
                ->label('Edit')
                ->icon('heroicon-o-pencil')
                ->url(fn () => OwnerResource::getUrl('edit', ['record' => $this->record])),
            // end action 2

            // action 3, Delete
            DeleteAction::make(),
            // end action 3

            // action 4, Open in Blade one owner
            Action::make('edit')
                ->label('Open in Blade')
                ->color('success') // Sets the button color
                ->icon('heroicon-o-pencil')
                ->url(fn (Owner $record): string => route('test.filament.owner', ['post' => $record, 'value' => 'arrived from filament resource /owner/id']))
                ->openUrlInNewTab(), // Optional: open in new tab;
            // end action 4
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
