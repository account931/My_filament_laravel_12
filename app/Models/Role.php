<?php

// my Role model that extends Spatie\Permission\Models\Role, so can customize it as wish
// need to update config/permission.php then :
// 'models' => [
// 'role' => App\Models\Role::class,
// 'permission' => App\Models\Permission::class,

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    // Add your custom logic or properties here
}
