<?php

// open route, does not require Passport(access token)

namespace App\Http\Controllers\VenuesStoreLocator;

use App\Http\Controllers\Controller;
use App\Models\Owner;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs; // to place controller in subfolder
use Illuminate\Foundation\Validation\ValidatesRequests;

class VenuesLocatorController extends Controller
{
    // use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        // $this->middleware('auth'); //logged users only
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // using Policy. There 3 possible ways
        // $this->authorize('index', Owner::class); //must have, Policy check (403 if fails)

        return view('venue-store-locator.index'); // ->with(compact('name', 'owners'));
    }
}
