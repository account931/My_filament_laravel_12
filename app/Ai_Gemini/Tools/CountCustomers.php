<?php

namespace App\Ai_Gemini\Tools;

use App\Models\User;
use Prism\Prism\Facades\Tool;

class CountCustomers
{
    public static function create()
    {
        return Tool::as('count_customers')
            ->for('Count the total number of customers in the database.')
            ->using(function (): string {

                $count = User::query()->count();

                return json_encode([
                    'count' => $count,
                ]);
            });
    }
}
