<?php

// action used in App\Filament\Resources\OwnerResource, was moved here to separate folder to make code cleaner

namespace App\Filament\Resources\OwnerResource\Actions;

use Filament\Forms\Components\Select;
use Illuminate\Support\Collection;
use Filament\Tables\Actions\BulkAction;  //bulk actions
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;  //flash message

class MarkAsConfirmedBulkAction
{
    public static function make(): BulkAction
    {
        return BulkAction::make('markAsConfirmed')
            ->label('Mark as Confirmed-separate')
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
                ->icon('heroicon-o-check-circle');
    }
}
