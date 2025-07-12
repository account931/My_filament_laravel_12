<?php

// One record

namespace App\Filament\Resources\AuditResource\Pages;

use App\Filament\Resources\AuditResource;
use Filament\Actions\Action;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;  // flash message
use Filament\Tables;

class ViewAudit extends ViewRecord
{
    protected static string $resource = AuditResource::class;

    // Set the title shown in the browser tab and page header
    public function getTitle(): string
    {
        return 'Audit Id: '.$this->record->id.',  Name : '.$this->record->auditable_type;
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
                ->url(fn () => AuditResource::getUrl('edit', ['record' => $this->record])),
            // end action
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
