<?php

//

namespace App\Http\Controllers\BigQuery;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\BigQuery\BigQueryService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
// usual email
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
        // getting data from BigQuery, it returns data, like product_id, user_id, so if want product_id details from DB, do next steps
        $views = $bigQueryService->getProductViewsBigQuery(20);
        // $views = collect($bigQueryService->getProductViewsBigQuery(20));

        // Collect product IDs
        $views = collect($views);
        $productIds = $views->pluck('product_id')->unique();

        // Fetch products from your database
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        // Merge product details into BigQuery views
        $views = $views->map(function ($view) use ($products) {
            $view['product'] = $products[$view['product_id']] ?? null;

            return $view;
        });

        return view('big-query.show-big-query-data', compact('views'));
    }
}
