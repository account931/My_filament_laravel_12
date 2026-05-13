<?php

//  Inertia example

namespace App\Http\Controllers\Inertia;

use App\Http\Controllers\Controller;
use App\Models\Owner;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // to place controller in subfolder
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Inertia\Inertia;

class InertiaController extends Controller
{
    // use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        // $this->middleware('auth'); //logged users only
    }

    /**
     *  Inertia
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // using Policy. There 3 possible ways
        // $this->authorize('index', Owner::class); //must have, Policy check (403 if fails)

        // return view('inertia.index'); // ->with(compact('name', 'owners'));

        // Inertia uses one root Blade file as the entry point, Default name = app, but we have changed it to resources/views/inertia/InertiaBladeMainRootView/app.blade.php in AppServiceProvider

        // dd(User::all());

        return Inertia::render('InertiaComponents/Users', [  // Users' is frontend component (Vue)
            // 'users' => User::all()                           //just get users only
            'users' => User::with(['supabase_storage_images', 'roles'])->get(),  // users with multiple relations
        ]);
        // ->withViewData(['layout' => 'layouts.app']);
    }
}
