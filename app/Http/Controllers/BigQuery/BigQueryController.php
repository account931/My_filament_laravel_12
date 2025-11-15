<?php

//

namespace App\Http\Controllers\BigQuery;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Services\BigQuery\BigQueryService;
// usual email
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class BigQueryController extends Controller
{
    // use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        // $this->middleware('auth'); //logged users only
    }

    /**
     * Display a listing of active products for BigQuery tracking.
     *
     * This method retrieves a limited set of active products from the database
     * (for example, the most recent or featured ones) and passes them to the
     * BigQuery index view. A policy check can optionally be applied to ensure
     * the current user has permission to access this page.
     *
     * @return \Illuminate\View\View Returns the view containing the list of active products.
     */
    public function index()
    {
        // using Policy. There 3 possible ways
        // $this->authorize('index', Owner::class); //must have, Policy check (403 if fails)

        $products = Product::active()->take(4)->get();

        return view('big-query.index')->with(compact('products'));
    }

    /**
     * Show one product. By Implicit Route Model Binding. Log BigQuery here
     *
     * @param  \App\Models\Product  $product  The product model instance, automatically resolved by route-model binding.
     * @return \Illuminate\View\View The view that displays the details of the specified owner
     */
    public function show(Product $product)
    {
        // $equipment = Owner::where('id', $id)->firstOrFail();

        // Log the view in BigQuery
        (new BigQueryService)->logProductView($product->id, auth()->id());

        // or to avoid slowing down product page loads, you can dispatch it to a queue:
        /*
        dispatch(function () use ($product) {
    (new BigQueryService())->logProductView($product->id, auth()->id());
})->afterResponse();
*/

        return view('big-query.viewOne', compact('product'));
    }

    /**
     * Display a list of recent product views fetched from BigQuery.
     *
     * This method retrieves product view tracking data from Google BigQuery
     * using the BigQueryService and passes it to the corresponding Blade view
     * for display.
     *
     * @param  \App\Services\BigQueryService  $bigQueryService  The service responsible for communicating with BigQuery.
     * @return \Illuminate\View\View Returns the view containing the product view data table.
     */
    public function showBigQueryData(BigQueryService $bigQueryService)
    {
        // Tab 1: getting Last 5 viewed products-----------------------------
        // getting data from BigQuery, it returns data, like product_id, user_id, so if want product_id details from DB, do next steps
        $views = $bigQueryService->getProductViewsBigQuery(5);
        // $views = collect($bigQueryService->getProductViewsBigQuery(20));

        // Collect product IDs
        $views = collect($views);
        $productIds = $views->pluck('product_id')->unique();

        // Fetch products from your database to get names
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        // Merge product details into BigQuery views
        $views = $views->map(function ($view) use ($products) {
            $view['product'] = $products[$view['product_id']] ?? null;

            return $view;
        });

        // Collect users IDs
        $userIds = $views->pluck('user_id')->unique();

        // Fetch user names from your database to get users ames
        $users = User::whereIn('id', $userIds)->get()->keyBy('id');

        // Merge user details into BigQuery views
        $viewsLastFive = $views->map(function ($view) use ($users) {
            $view['user'] = $users[$view['user_id']] ?? null;

            return $view;
        });
        // End Tab 1: getting Last 5 viewed products

        // Tab 2: Getting 2 top most viewed--------------------------------------------------
        $topTwoViewed = $bigQueryService->getTopViewedProducts(2);  // BigQuery returns product_id, total_views only

        // Collect product IDs, since we want to add product name to array
        $topTwoViewed = collect($topTwoViewed);
        $productIdsTab2 = $topTwoViewed->pluck('product_id')->unique();

        // Fetch products from your database to get names
        $productsTab2 = Product::whereIn('id', $productIdsTab2)->get()->keyBy('id');

        // Merge product details into BigQuery views, adding product name
        $topTwoViewed = $topTwoViewed->map(function ($view) use ($productsTab2) {
            $view['product'] = $productsTab2[$view['product_id']] ?? null;

            return $view;
        });
        // End Tab 2: Getting 2 top most viewed

        // Tab 3: Chart JS, views count for 2 top viewd
        // uses Tab 2 results
        // $labels = $topTwoViewed->pluck('product.name'); // $topTwoViewedTab5->keys();  // Product names
        $labels = collect($topTwoViewed)->map(fn ($item) => 'ID: '.$item['product']['id'].' - '.$item['product']['name']); // create lable, like ID -Product name
        $values = $topTwoViewed->pluck('total_views');  // $topTwoViewedTab5->values(); // Product View counts
        // End ab 3: Chart JS

        // Tab 4: Vue Chart JS, makes api call itself to App\Http\Controllers\Api\BigQueryApi\BigQueryApiController

        return view('big-query.show-big-query-data', compact(
            'viewsLastFive',    // tab 1
            'topTwoViewed',     // tab 2
            'labels', 'values'  // tab 3
        ));
    }
}
