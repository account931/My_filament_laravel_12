<?php

// action used in App\Filament\Resources\OwnerResource, was moved here to separate folder to make code cleaner

namespace App\Filament\Resources\OwnerResource\Actions;

use App\Filament\Resources\OwnerResource;        // header actions
use App\Mail\WelcomeEmail;
use App\Models\Owner;
use App\Notifications\SendMyNotification;  // flash message
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action; // to place controller in subfolder
use Illuminate\Support\Facades\Mail;

class SendMessage
{
    public static function make(): Action
    {
        $resourceName = class_basename(OwnerResource::class);

        return Action::make('openUrl')
            ->label('Send message')
            ->icon('heroicon-o-document-plus')
            ->color('info') // Sets the button color
            ->form([
                Forms\Components\Select::make('selectedUser')
                    ->label('User')->required()
                    ->options(Owner::all()->pluck('last_name', 'id')->toArray())->multiple(),

                Forms\Components\Textarea::make('message')->label('Message')->placeholder('Enter your message here...')->required()->rows(4),   // number of visible row

            ])
            ->action(function (array $data) {
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

                    // Mail Facade, Variant 2, If you want to queue the email instead of sending it immediately:
                    Mail::to($user->email)->queue(new WelcomeEmail($user, $data['message']));
                }
                // end send emails to mailtrap -----------------------------------

                Notification::make()->title('Message was sent to Mailtrap.Selected Owners are: '.implode(', ', $data['selectedUser']).', form input is: '.$data['message'])
                    ->success()
                    ->send();
            });

    }
}
