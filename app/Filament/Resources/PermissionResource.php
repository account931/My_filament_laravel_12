<?php

// here we override package althinect/filament-spatie-roles-permissions

namespace App\Filament\Resources;

use Althinect\FilamentSpatieRolesPermissions\Resources\PermissionResource as BasePermissionResource;

class PermissionResource extends BasePermissionResource
{
    protected static ?string $slug = 'permissions';
}
