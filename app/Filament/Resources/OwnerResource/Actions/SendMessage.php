<?php

// action used in App\Filament\Resources\OwnerResource, was moved here to separate folder to make code cleaner

namespace App\Filament\Resources\OwnerResource\Actions;

use Filament\Forms\Components\Select;
use Illuminate\Support\Collection;
use Filament\Tables\Actions\Action;        //header actions
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;  //flash message
use App\Models\Owner;
use App\Filament\Resources\OwnerResource;


class SendMessage
{
    public static function make(): Action
    {
        $resourceName = class_basename(OwnerResource::class); 

         return Action::make('openUrl')
                ->label('Send message')
                ->icon('heroicon-o-document-plus')
                ->color('info') //Sets the button color
                ->form([
                    Forms\Components\Select::make('selectedUser')
                        ->label('User')->required()
                        ->options(Owner::all()->pluck('last_name', 'id')->toArray())->multiple(),

                    Forms\Components\Textarea::make('message')->label('Message') ->placeholder('Enter your message here...')->required()->rows(4)   // number of visible row
                        
                ])
                ->action(function (array $data) {
                    // Handle form submission
                    //$this->selectedUser = $data['selectedUser'];

                    // Example: Do something with $this->selectedUser
                    //session()->flash('success', 'Selected user ID: ' . $this->selectedUser);
                    Notification::make()->title('selected Owners are: ' .implode(', ', $data['selectedUser'])    . ', form input is: ' . $data['message']  )
                                  ->success()
                                  ->send();
                });
             
    }
}
