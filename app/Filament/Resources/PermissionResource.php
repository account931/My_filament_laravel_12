<?php

// here we override package althinect/filament-spatie-roles-permissions

namespace App\Filament\Resources;

use Althinect\FilamentSpatieRolesPermissions\Resources\PermissionResource as BasePermissionResource;

class PermissionResource extends BasePermissionResource
{
    // FALSE for next line: Auto Discovery works.
    // SINCE IT IS OVERRIDEN RESOURCE YOU NEED TO manual make model/policy registration in  AuthServiceProvider.php  =>  protected $policies = [Permission::class => PermissionPolicy::class,];
    // protected static ?string $model = \App\Models\Permission::class; //

    protected static ?string $slug = 'permissions';
}
