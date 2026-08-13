<?php

// Scout + Algolia

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

    public function index(?Product $product = null)
    {
        if ($product) {
            // Product was selected.
            // Record BigQuery event here.

            return view('scout.index', [
                'product' => $product,
            ]);
        }

        // No product selected — just show the search form.
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
