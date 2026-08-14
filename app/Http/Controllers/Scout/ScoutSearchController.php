<?php

// Scout + Algolia search on Models/Product

namespace App\Http\Controllers\Scout;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ScoutSearchController extends Controller
{
    // use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        // $this->middleware('auth'); //logged users only
    }

    // Search box and display result at the same page
    public function index(?Product $product = null)
    {
        if ($product) {
            // Product was selected, e.g localhost:8000/scout/6. Get product details from local Db by implicit binding
            // Record BigQuery event here if needed.

            return view('scout.index', [
                'product' => $product,
            ]);
        }

        // No product selected — just show the search form. Search box is a Algolia InstantSearch's built-in widget with js in /resources/js/algolia_scout/algolia-search.js
        // It forms links like localhost:8000/scout/6. When you click it, the rest is handled by local Db by implicit binding, get product by id and display result, see if ($product) part
        return view('scout.index', [
            'product' => null,
        ]);
    }

    /*
    public function index()
    {
        return view('scout.index');
    }
    */

    // instead of manual search we use @algolia/autocomplete-js
    /*
    public function search(Request $request)
    {
        $query = $request->input('query');

        // Perform your Scout search here.
        // Example:
         $results = User::search($query)->get();

        return view('scout.index', [
            'query' => $query,
            'results' => $results ?? [],
        ]);
    }
    */
}
