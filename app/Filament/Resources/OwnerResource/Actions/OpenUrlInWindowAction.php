<?php

// action used in App\Filament\Resources\OwnerResource, was moved here to separate folder to make code cleaner

namespace App\Filament\Resources\OwnerResource\Actions;

use Filament\Forms\Components\Select;
use Illuminate\Support\Collection;
use Filament\Tables\Actions\Action;        //header actions
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;  //flash message

class OpenUrlInWindowAction
{
    public static function make(): Action
    {
         return Action::make('openUrl')
                ->label('OpenUrl')
                ->icon('heroicon-o-document-plus')
                ->color('success') //Sets the button color
                //->form([Forms\Components\Hidden::make('api_response'),])
                //->action(function ($record) {   
                    //Notification::make()->title('Good' )->send();  //send flash message
               //})
               ->url(fn (/*Owner $record*/): string => route('test-filament', [/*'post' => $record,*/ 'value' =>  'arrived from filament' ]))
                //->url(fn (Owner $record): string => route('posts.edit', ['post' => $record]))
               //->url(fn ($record) => $record->website_url)
               //->url('https://filamentphp.com/docs')
               ->openUrlInNewTab(); // Optional: open in new tab;
    }
}
