<?php

// This is the important part of the agent.
// Gemini doesn't directly access your database.

namespace App\Ai_Gemini\Tools;

use App\Models\User;
use Prism\Prism\Facades\Tool;

class CountUsers
{
    public static function create()
    {
        return Tool::as('count_users')
            ->for('Count the total number of users in the database.')
            ->using(function (): string {

                $count = User::query()->count();

                return json_encode([
                    'count' => $count,
                ]);
            });
    }
}
