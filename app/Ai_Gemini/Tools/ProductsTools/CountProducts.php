<?php

// This is the important part of the agent.
// Gemini doesn't directly access your database.

namespace App\Ai_Gemini\Tools\ProductsTools;

use App\Models\Product;
use Prism\Prism\Facades\Tool;

class CountProducts
{
    public static function create()
    {
        return Tool::as('count_products')
            ->for('Count the total number of products in the database.')
            ->using(function (): string {

                $count = Product::query()->count();

                return json_encode([
                    'count' => $count,
                ]);
            });
    }
}
