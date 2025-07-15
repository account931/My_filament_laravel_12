<?php

// action used in App\Filament\Resources\OwnerResource, was moved here to separate folder to make code cleaner
// send real notification to Mialtrap.io and telegram channel
// send DB notification and emails to Owners, while similar page in pure Laravel /send-notification  sends to Users

namespace App\Filament\Resources\OwnerResource\Actions;

use App\Filament\Resources\OwnerResource;        // header actions
use App\Mail\WelcomeEmail;
use App\Models\Owner;
use App\Notifications\SendMyNotification;  // flash message
use App\Services\TelegramService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification; // to place controller in subfolder
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Mail;  // Telegram service to send messages

class SendMessage
{
    public static function make(): Action
    {
        $resourceName = class_basename(OwnerResource::class);

        return Action::make('openUrl')
            ->label('Send message')
            ->icon('heroicon-o-document-plus')
            ->color('info') // Sets the button color
            ->requiresConfirmation()
            ->form([
                Forms\Components\Select::make('selectedUser')
                    ->label('User')->required()
                    ->options(Owner::all()->pluck('last_name', 'id')->toArray())->multiple(),

                Forms\Components\Textarea::make('message')->label('Message')->placeholder('Enter your message here...')->required()->rows(4),   // number of visible row

                Forms\Components\Checkbox::make('confirm')->label('I confirm sending this message to Owners')->required(),
            ])

            ->action(function (array $data) {
                if (! $data['confirm']) {
                    Notification::make()->title('You must confirm before sending')->danger()->send();

                    return;
                }
                // Handle form submission
                // $this->selectedUser = $data['selectedUser'];

                // Example: Do something with $this->selectedUser
                // session()->flash('success', 'Selected user ID: ' . $this->selectedUser);

                // send emails to mailtrap, a bit modified, now send email not to Users as in L6, but to Owners------------------
                $owners = Owner::find($data['selectedUser']);

                foreach ($owners as $user) {

                    // Send notification with a message (goes both via DB & Email notifications, as it is specified in function via($notifiable) in App\Notifications\SendMyNotification)
                    $user->notify(new SendMyNotification($user, $data['message']));

                    // Mail Facade, Variant 1, send usual email via Mail facade (just to test)
                    // Mail::to($user->email)->send(new WelcomeEmail($user, $data['message']));

                    // Mail Facade, Variant 2, If you want u can queue the email instead of sending it immediately:
                    Mail::to($user->email)->queue(new WelcomeEmail($user, $data['message'].' (sent from Filament)')); // wont run unless u do => php artisan queue:work
                }
                // end send emails to mailtrap -----------------------------------

                // Send notification to Telegram via service
                $telegram = app(TelegramService::class);
                $telegram->send('The message was sent to Mailtrap via Filament. Selected Owners are: '.implode(', ', $data['selectedUser']).', form input is: '.$data['message']);

                // Filament flash message
                Notification::make()->title('Message was sent to Mailtrap. Selected Owners are: '.implode(', ', $data['selectedUser']).', form input is: '.$data['message'])
                    ->success()
                    ->send();
            });

    }
}
