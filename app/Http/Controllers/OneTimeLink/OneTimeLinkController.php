<?php

// generates one-time links for Scramble docs, uses middleweare 'CheckOneTimeToken' registered in /config/scramble.php. Also uses table 'one_time_links'
// one-time link middleware is active for  guest users only, logged user gets access alway

namespace App\Http\Controllers\OneTimeLink;

use App\Http\Controllers\Controller;
use App\Models\OneTimeLink;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

// usual email

class OneTimeLinkController extends Controller
{
    // use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        // $this->middleware('auth'); //logged users only
    }

    /**
     * renders views, form and response from generateLink
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // using Policy. There 3 possible ways
        // $this->authorize('index', Owner::class); //must have, Policy check (403 if fails)

        // gets all api routes for form dropdown, returns named route if available, otherwise just route
        $apiRoutes = collect(Route::getRoutes())
            ->filter(function ($route) {
                // Filter only routes with the 'api' middleware OR 'api/' prefix
                return in_array('api', $route->middleware())
                    || Str::startsWith($route->uri(), 'api');
            })
            ->map(function ($route) {
                $name = $route->getName();

                // dd($route->getName());
                return [
                    'route' => $name ?: $route->uri(),  // return named route if exists, otherwise uri
                    'uri' => $route->uri(),
                    'methods' => implode('|', $route->methods()),
                    'name' => $name,
                    'action' => $route->getActionName(),
                ];
            })
            ->filter(fn ($route) => ! Str::contains($route['uri'], '_debugbar')) // optional filter
            ->values();

        // end gets all api routes for form dropdown
        // dd($apiRoutes);
        return view('one-time-link.index')->with(compact('apiRoutes'));

    }

    /**
     * handles form, generates either one-time either signed links and redirects back
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function generateLink(Request $request)
    {

        // if it is form request from same method
        if ($request->has('category')) {// 'category' is present in the request (may be null)

            // generate simple route with one time token
            $token = Str::random(40);
            OneTimeLink::create(['token' => $token]);
            // $link = url('/docs/api/'.$token);     //generates /docs/api/$token
            // $link = url('/docs/api?token='.$token); // generates /docs/api?token=$token
            $simpleLink = url('/docs/api#/operations/'.Str::after($request->input('category'), 'api.').'?token='.$token); // generates /docs/api?token=$token. If route has api.'api.' removes it, if 'api/' stays
            // generate signed route\

        }

        session()->flash('success-link', [
            'simpleLink' => $simpleLink,
            'signedLink' => 'Link created successfully!',

        ]);

        return redirect()->route('onetime.link');

    }
}
