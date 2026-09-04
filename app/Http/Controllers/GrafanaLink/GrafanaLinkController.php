<?php

// j returnust external link to Grafana Cloud

namespace App\Http\Controllers\GrafanaLink;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class GrafanaLinkController extends Controller
{
    // use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        // $this->middleware('auth'); //logged users only
    }

    /**
     * renders views
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // using Policy. There 3 possible ways
        // $this->authorize('index', Owner::class); //must have, Policy check (403 if fails)

        // \Sentry\captureException($e);   you can fire an error manually to see if  Sentry picking errors
        return view('grafana-link.index');  // ->with(compact('apiRoutes'));

    }
}
