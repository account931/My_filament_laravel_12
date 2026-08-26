<?php

// This is the important part of the agent.
// Gemini doesn't directly access your database.

namespace App\Ai_Gemini\Tools;

use App\Models\User;
use Prism\Prism\Facades\Tool;

class FindUser
{
    public static function create()
    {
        return Tool::as('find_user')
            ->for('Find users by their name or email address, optionally filtered by role.')
            ->withStringParameter(
                'query',
                'The user name or email address to search for.'
            )
            ->withStringParameter(
                'role',
                'Optional Spatie role name to filter by, for example "admin".'
            )
            ->using(function (string $query, string $role = ''): string {

                $users = User::query()
                    // ->where('name', 'like', "%{$query}%")
                    // ->orWhere('email', 'like', "%{$query}%")
                    ->with('roles') // add Spatie permissions relation and avoids the N+1 query problem
                    ->where(function ($q) use ($query) {
                        $q->where('name', 'like', "%{$query}%")
                            ->orWhere('email', 'like', "%{$query}%");
                    })

                    // filter by role
                    ->when($role !== '', function ($q) use ($role) {
                        $q->whereHas('roles', function ($q) use ($role) {
                            $q->where('name', $role);
                        });
                    })
                    /*
                     ->when($role, function ($q) use ($role) {
                         $q->whereHas('roles', function ($q) use ($role) {
                             $q->where('name', $role);
                         });
                     })
                     */
                    // end  filter by role
                    ->limit(10)
                    ->get([
                        'id',
                        'name',
                        'email',
                        'is_active',
                        'created_at',
                    ]);

                // map over to add add Spatie permissions relation. map  is for transforming the collection.
                $users = $users->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'is_active' => $user->is_active,
                        'created_at' => $user->created_at,
                        'role' => $user->roles->first()?->name,  // return first role only
                        // 'roles' => $user->roles->pluck('name')->values()  //If a user can have multiple roles and you want all of them:
                    ];
                });

                // debug and see in storage/logs/laravel.log
                \Log::debug('FindUser tool', ['query' => $query, 'role' => $role, 'users' => $users->toArray()]);

                // dd the reuslt but you wont see it in ajax
                // dd(['query' => $query, 'role' => $role, 'users' => $users->toArray(),]);

                if ($users->isEmpty()) {
                    return json_encode([
                        'found' => false,
                        'message' => 'No customers found.',
                    ]);
                }

                return json_encode([
                    'found' => true,
                    'users' => $users->toArray(),
                ]);
            });
    }
}
