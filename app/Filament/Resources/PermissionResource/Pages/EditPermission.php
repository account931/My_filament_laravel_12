<?php

// here we override package althinect/filament-spatie-roles-permissions

namespace App\Filament\Resources\PermissionResource\Pages;

use Althinect\FilamentSpatieRolesPermissions\Resources\PermissionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPermission extends EditRecord
{
    protected static string $resource = PermissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->after(fn () => app(\Spatie\Permission\PermissionRegistrar::class)
                    ->forgetCachedPermissions()),
        ];
    }
}
