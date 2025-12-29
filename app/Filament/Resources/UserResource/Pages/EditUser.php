<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),

            // Create new user fix as this does not work =>  Actions\CreateAction::make(),
            Action::make('create')
                ->label('Create New User')
                ->url(UserResource::getUrl('create'))
                ->icon('heroicon-o-plus'),
        ];
    }
}
