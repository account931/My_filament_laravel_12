<?php

// my Permission model that extends Spatie\Permission\Models\Permission, so can customize it as wish
// need to update config/permission.php then :
// 'models' => [
// 'role' => App\Models\Role::class,
// 'permission' => App\Models\Permission::class,

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    // Add your custom logic or properties here
}
