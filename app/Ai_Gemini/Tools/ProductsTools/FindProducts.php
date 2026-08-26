<?php

// Finds products
// This is the important part of the agent.
// Gemini doesn't directly access your database.

namespace App\Ai_Gemini\Tools\ProductsTools;

use App\Models\Product;
use Prism\Prism\Facades\Tool;

class FindProducts
{
    public static function create()
    {
        return Tool::as('find_product')
            ->for(
                'Find products by product name, SKU, or description. '.
                'Use this tool when the user asks to find, search for, or look up a product.'
            )
            ->withStringParameter(
                'query',
                'The product name, SKU, or search term to look for.'
            )
            ->using(function (string $query): string {

                $products = Product::query()
                    ->where(function ($q) use ($query) {
                        $q->where('name', 'like', "%{$query}%")
                            ->orWhere('sku', 'like', "%{$query}%")
                            ->orWhere('description', 'like', "%{$query}%");
                    })
                    ->limit(10)
                    ->get([
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
                    ])
                    ->map(function ($product) {
                        return [
                            'id' => $product->id,
                            'name' => $product->name,
                            'slug' => $product->slug,
                            'description' => $product->description,
                            'sku' => $product->sku,
                            'price' => $product->price,
                            'discount_price' => $product->discount_price,
                            'stock' => $product->stock,
                            'image' => $product->image,
                            'is_active' => $product->is_active,
                        ];
                    });

                if ($products->isEmpty()) {
                    return json_encode([
                        'found' => false,
                        'message' => 'No products found.',
                    ]);
                }

                return json_encode([
                    'found' => true,
                    'products' => $products->values()->toArray(),
                ]);
            });
    }
}
