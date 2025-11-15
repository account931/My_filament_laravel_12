<?php

// Internal api controller to make requests to BigQuery, used in Vue only

namespace App\Http\Controllers\Api\BigQueryApi;

// use App\Http\Controllers\Controller\Owner;
use App\Http\Controllers\Controller;
use App\Models\Owner;
use App\Models\Product; // Collection list
// base controller
use App\Services\BigQuery\BigQueryService;
// Resource of 1 record
// for in: validation
use Illuminate\Http\Request; // my custom Form validation via Request Class (to create new blog & images in tables {wpressimages_blog_post} & {wpressimage_imagesstock})

class BigQueryApiController extends Controller
{
    public function twoTopViwed(BigQueryService $bigQueryService)  // can handle GET params
    {

        // Getting 2 top most viewed-
        $topTwoViewed = $bigQueryService->getTopViewedProducts(2);  // returns product_id, total_views only

        // Since we need product names, not only ID - Collect product IDs, since we want to add product name to array
        $topTwoViewed = collect($topTwoViewed);
        $productIdsTab2 = $topTwoViewed->pluck('product_id')->unique();

        // Fetch products from your database to get names
        $productsTab2 = Product::whereIn('id', $productIdsTab2)->get()->keyBy('id');

        // Merge product details into BigQuery views, adding product name
        $topTwoViewed = $topTwoViewed->map(function ($view) use ($productsTab2) {
            // $view['product_id'] = $view['product_id'] . ' - ' . ($productsTab2[$view['product_id']] ?? null);
            $view['product_id'] = 'ID: '.$view['product_id'].', Name: '.($productsTab2[$view['product_id']]->name ?? null);

            return $view;
        });

        // return response()->json(Owner::all());
        return response()->json($topTwoViewed);

    }
}
