<?php
//One record

namespace App\Filament\Resources\EquipmentResource\Pages;

use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\EquipmentResource;
use Filament\Infolists\Components\TextEntry;
use App\Models\Owner;
use Filament\Actions\Action;
use Filament\Notifications\Notification;  //flash message
use Filament\Tables;

class ViewEquipment extends ViewRecord
{
    protected static string $resource = EquipmentResource::class;


    // Set the title shown in the browser tab and page header
    public function getTitle(): string
    {
        return 'Equipment Id: ' . $this->record->id  . ',  ' . $this->record->trademark_name;
    }

    //header action
    protected function getHeaderActions(): array
    {
        return [
            //action 1
            Action::make('callApi')
                ->label('Call API')
                ->icon('heroicon-o-cloud')
                ->action(function () {
                    // Do something, like call an external API
                    // \Http::get('...');
                    //$this->notify('success', 'API called!');
                    Notification::make()->title('Fake API called successfully! Id ' . $this->record->id  )->success()->send();  //send flash message

                }),
            //end action 1
            //Tables\Actions\EditAction::make(),           //edit built-in action

            //action 2
            Action::make('edit')
                ->label('Edit')
                ->icon('heroicon-o-pencil')
                ->url(fn () => EquipmentResource::getUrl('edit', ['record' => $this->record])),
            //end action 2
        ];
    }

    //THIS IS NOT WORKING, WORKS FROM DEFINED IN  public static function infolist(Infolist $infolist): Infolist
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
