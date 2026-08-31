<?php

// This is the important part of the agent.
// Gemini doesn't directly access your database.

namespace App\Ai_Gemini\Tools;

use App\Models\User;
use Prism\Prism\Facades\Tool;

class ListUsers
{
    public static function create()
    {

        return Tool::as('list_users')
            ->for('List users from the database with their roles, 10 users per page. Use the page parameter to navigate through the users.')
            ->withNumberParameter(
                'page',
                'The page number to retrieve. Page 1 returns users 1-10, page 2 returns users 11-20, etc.',
                false
            )
            ->using(function (int $page = 1): string {

                $page = max(1, $page);

                $users = User::query()
                    ->with('roles:id,name')
                    ->select([
                        'id',
                        'name',
                        'email',
                        'created_at',
                    ])
                    ->orderBy('id')
                    ->paginate(10, ['*'], 'page', $page);

                $data = $users->getCollection()->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'roles' => $user->roles->pluck('name')->values()->toArray(),
                        'created_at' => $user->created_at,
                    ];
                });

                return json_encode([
                    'current_page' => $users->currentPage(),
                    'per_page' => $users->perPage(),
                    'total' => $users->total(),
                    'last_page' => $users->lastPage(),
                    'has_more_pages' => $users->hasMorePages(),
                    'users' => $data,
                ]);
            });
    }

    /*
    return Tool::as('list_users')
        ->for('List users from the database, 10 users per page. Use the page parameter to navigate through the users.')
        ->withNumberParameter(
            'page',
            'The page number to retrieve. Page 1 returns users 1-10, page 2 returns users 11-20, etc.',
            false
        )
        ->using(function (int $page = 1): string {

            $page = max(1, $page);

            $users = User::query()
                ->select([
                    'id',
                    'name',
                    'email',
                    'created_at',
                ])
                ->orderBy('id')
                ->paginate(10, ['*'], 'page', $page);

            return json_encode([
                'current_page' => $users->currentPage(),
                'per_page' => $users->perPage(),
                'total' => $users->total(),
                'last_page' => $users->lastPage(),
                'has_more_pages' => $users->hasMorePages(),
                'users' => $users->items(),
            ]);
        });
    }
   */
}
