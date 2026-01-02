<?php

namespace App\Providers;

use App\Models\Permission;
// use Spatie\Permission\Models\Permission;
use App\Policies\PermissionPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    // Map models to policies
    protected $policies = [
        // Permission::class => PermissionPolicy::class,  //no need, as auto-discovery works
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
