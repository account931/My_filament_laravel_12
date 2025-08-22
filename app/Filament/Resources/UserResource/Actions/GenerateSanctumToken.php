<?php

// action used in App\Filament\Resources\UserResource, was moved here to separate folder to make code cleaner

namespace App\Filament\Resources\UserResource\Actions;

// Telegram service to send messages
use Carbon\Carbon;
use Filament\Actions\Action; // flash message // to place controller in subfolder
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;

class GenerateSanctumToken
{
    public static function make(): Action
    {
        return Action::make('generateToken')
            ->label('Generate Sanctum API Token')
            ->form([
                TextInput::make('token_name')
                    ->label('Token Name')
                    ->placeholder('Enter a name for the token')
                    ->required(),

                Select::make('expiry')
                    ->label('Expiry')
                    ->options([
                        '1 week' => '1 Week',
                        '2 weeks' => '2 Weeks',
                        '1 month' => '1 Month',
                        '3 months' => '3 Months',
                        '6 months' => '6 Months',
                        '1 year' => '1 Year',
                    ])
                    ->default('1 month') // Default option
                    ->required(),

                TextInput::make('generated_token')
                    ->label('Generated Token')
                    ->disabled() // Disable so it can't be edited
                    ->placeholder('Your token will appear here once generated'),
            ])
            ->modalHeading('Generate API Token')
            ->modalButton('Generate Token')
            ->action(function (array $data) {

                $user = auth()->user(); // or any specific user instance
                $tokenName = $data['token_name'];
                $expiryPeriod = $data['expiry'];

                // Parse expiry period and calculate the expiration date
                $expiryDate = Carbon::now();

                switch ($expiryPeriod) {
                    case '1 week':
                        $expiryDate->addWeek();
                        break;
                    case '2 weeks':
                        $expiryDate->addWeeks(2);
                        break;
                    case '1 month':
                        $expiryDate->addMonth();
                        break;
                    case '3 months':
                        $expiryDate->addMonths(3);
                        break;
                    case '6 months':
                        $expiryDate->addMonths(6);
                        break;
                    case '1 year':
                        $expiryDate->addYear();
                        break;
                }

                // Create token with the name and associated expiration
                $token = $user->createToken($tokenName, ['*']);
                $plainToken = $token->plainTextToken;

                if ($token) {

                    // Display the generated token directly in the form
                    // $this->form->fill(['generated_token' => $plainToken]);

                    Notification::make()
                         // ->title($plainToken)
                        ->body('Copy your token, you will never see it again  <sub><b> '. $plainToken .'</b></sub>')       // explode() is used as $token comes as "id|token", but saved to db as "token" only,  check here: https://www.codepunker.com/tools/string-converter
                        // <sub> is a fix to see all token symbols, othrewise text does not fit the screen
                        ->persistent()              // prevent auto-closing the notification
                        ->icon('heroicon-o-document-text')
                        ->success()->send(); 

                   

                    // Optionally, you can save this token expiry in a database
                    // $user->tokens()->create(['name' => $tokenName, 'expires_at' => $expiryDate]);

                    // If you want to add custom expiry logic, implement it here

                    // $this->dontCloseModal();

                } else {
                    Notification::make()->title('Token was not created')->persistent()->danger()->body('Something failed ')->send();
                }

            })
            ->requiresConfirmation()
            ->color('primary')
            ->modalHeading('Generate New Token')
            ->modalDescription('Specify the token name and expiry time.');
    }
}
