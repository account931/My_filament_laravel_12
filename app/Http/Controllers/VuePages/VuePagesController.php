<?php

// open route, does not require Passport(access token)

namespace App\Http\Controllers\VuePages;

use App\Http\Controllers\Controller;
use App\Models\Owner;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs; // to place controller in subfolder
use Illuminate\Foundation\Validation\ValidatesRequests;
// my custom Form validation via Request Class (to create new blog & images in tables {wpressimages_blog_post} & {wpressimage_imagesstock})
use Illuminate\Http\Request;

class VuePagesController extends Controller
{
    // use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        // $this->middleware('auth'); //logged users only
    }

    /**
     * Show start page with all owners list, open route, does not require Passport(access token)
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // using Policy. There 3 possible ways
        // $this->authorize('index', Owner::class); //must have, Policy check (403 if fails)

        return view('vue-pages.index'); // ->with(compact('name', 'owners'));
    }
}
