<?php

// action used in App\Filament\Resources\OwnerResource, was moved here to separate folder to make code cleaner

namespace App\Filament\Resources\OwnerResource\Actions;

use App\Filament\Resources\OwnerResource;        // header actions
use App\Models\Owner;
use Filament\Forms;
use Filament\Forms\Form;  // flash message
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;

class OpenUrlInWindowAction
{
    public static function make(): Action
    {
        $resourceName = class_basename(OwnerResource::class);

        return Action::make('openUrl')
            ->label('OpenUrl')
            ->icon('heroicon-o-document-plus')
            ->color('success') // Sets the button color
               // ->form([Forms\Components\Hidden::make('api_response'),])
               // ->action(function ($record) {
                   // Notification::make()->title('Good' )->send();  //send flash message
              // })
            ->url(fn (/* Owner $record */): string => route('test-filament', ['post' => $resourceName, 'value' => 'arrived from filament']))
               // ->url(fn (Owner $record): string => route('posts.edit', ['post' => $record]))
              // ->url(fn ($record) => $record->website_url)
              // ->url('https://filamentphp.com/docs')
            ->openUrlInNewTab(); // Optional: open in new tab;
    }
}
