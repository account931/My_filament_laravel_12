<?php

// action used in App\Filament\Resources\OwnerResource, was moved here to separate folder to make code cleaner

namespace App\Filament\Resources\OrderResource\Actions;

use App\Enums\OrderStatusEnum;
use Filament\Forms;  // bulk actions
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\BulkAction;  // flash message
use Illuminate\Support\Collection;

class ChangeOrderStatusBulkAction
{
    public static function make(): BulkAction
    {
        return BulkAction::make('change status')
            ->label('Change Order status')
            // add form
            ->form([
                Forms\Components\Select::make('status')
                    ->required()
                    ->options(
                        collect(OrderStatusEnum::cases())
                            ->mapWithKeys(fn ($case) => [$case->value => ucfirst($case->name)])
                            ->toArray()
                        /*[
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                       ] */
                    ),
                // Forms\Components\TextInput::make('message')->required(),
            ])
            // end add form
            ->action(function (Collection $records, array $data) {    // $records -> seelcted ids, $data - form input
                // dd($data);
                $records->each->update(['status' => $data['status']]);  // update statsu of order

                // send flash message
                Notification::make()->title('Record IDs: '.$records->pluck('id').', were updated with status '.$data['status'])
                    ->success()
                    ->send();
                // $records->each->update(['confirmed' => true] )
            })
            ->requiresConfirmation()
            ->color('success')
            ->icon('heroicon-o-check-circle');
    }
}
