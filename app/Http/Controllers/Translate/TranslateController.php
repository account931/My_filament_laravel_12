<?php

// translate

namespace App\Http\Controllers\Translate;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class TranslateController extends Controller
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

        return view('translate.index');  // ->with(compact('apiRoutes'));

    }

    /**
     * change language and redirects back
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeLanguage($lang)
    {   // dd($lang);

        // Allowed languages (security + safety)
        $availableLanguages = ['en', 'es', 'ar'];

        if (! in_array($lang, $availableLanguages)) {
            abort(400, 'Invalid language selected');

        }

        // Store language in session
        session()->put('locale', $lang);

        // Set locale for current request
        App::setLocale($lang);

        // Go back to previous page
        return redirect()->back();

    }
}
