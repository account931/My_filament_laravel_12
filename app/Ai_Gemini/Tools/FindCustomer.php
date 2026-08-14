<?php

// This is the important part of the agent.
// Gemini doesn't directly access your database.

namespace App\Ai_Gemini\Tools;

use App\Models\User;
use Prism\Prism\Facades\Tool;

class FindCustomer
{
    public static function create()
    {
        return Tool::as('find_customer')
            ->for('Find customers by their name or email address.')
            ->withStringParameter(
                'query',
                'The customer name or email address to search for.'
            )
            ->using(function (string $query): string {

                $customers = User::query()
                    ->where('name', 'like', "%{$query}%")
                    ->orWhere('email', 'like', "%{$query}%")
                    ->limit(10)
                    ->get([
                        'id',
                        'name',
                        'email',
                        'created_at',
                    ]);

                if ($customers->isEmpty()) {
                    return json_encode([
                        'found' => false,
                        'message' => 'No customers found.',
                    ]);
                }

                return json_encode([
                    'found' => true,
                    'customers' => $customers->toArray(),
                ]);
            });
    }
}
