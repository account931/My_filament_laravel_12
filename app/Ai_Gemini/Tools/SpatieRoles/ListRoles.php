<?php

namespace App\Ai_Gemini\Tools\SpatieRoles;

use Prism\Prism\Facades\Tool;
use Spatie\Permission\Models\Role;

class ListRoles
{
    public static function create()
    {
        return Tool::as('list_roles')
            ->for('List all roles defined in the application.')
            ->using(function (): string {

                $roles = Role::query()
                    ->select([
                        'id',
                        'name',
                        'guard_name',
                    ])
                    ->orderBy('name')
                    ->get();

                return json_encode([
                    'total' => $roles->count(),
                    'roles' => $roles,
                ]);
            });
    }
}
