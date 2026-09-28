<?php

// List products from the database, 10 products per page.
// This is the important part of the agent.
// Gemini doesn't directly access your database.

namespace App\Ai_Gemini\Tools\ProductsTools;

use App\Models\Product;
use Prism\Prism\Facades\Tool;

class ListProducts
{
    public static function create()
    {
        return Tool::as('list_products')
            ->for('List products from the database, 10 products per page. Use the page parameter to navigate through the products. Optionally sort products by price ascending or descending.')
            ->withNumberParameter(
                'page',
                'The page number to retrieve. Page 1 returns products 1-10, page 2 returns products 11-20, etc.',
                false
            )
            ->withStringParameter(
                'price_sort',
                'Optional price sorting. Use "asc" for lowest price first or "desc" for highest price first. If omitted, products are sorted by ID.',
                false
            )
            ->using(function (int $page = 1, ?string $price_sort = null): string {

                $page = max(1, $page);

                $productsQuery = Product::query()
                    ->select([
                        'id',
                        'name',
                        'slug',
                        'description',
                        'sku',
                        'price',
                        'discount_price',
                        'stock',
                        'image',
                        'is_active',
                    ]);

                if (in_array($price_sort, ['asc', 'desc'], true)) {
                    $productsQuery->orderBy('price', $price_sort);
                } else {
                    $productsQuery->orderBy('id');
                }

                $products = $productsQuery->paginate(
                    10,
                    ['*'],
                    'page',
                    $page
                );

                return json_encode([
                    'current_page' => $products->currentPage(),
                    'per_page' => $products->perPage(),
                    'total' => $products->total(),
                    'last_page' => $products->lastPage(),
                    'has_more_pages' => $products->hasMorePages(),
                    'products' => $products->items(),
                ]);
            });
    }
}
