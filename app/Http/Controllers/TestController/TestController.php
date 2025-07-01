<?php

namespace App\Http\Controllers\TestController;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Http\Controllers\Controller; //to place controller in subfolder

class TestController extends Controller
{
    /**
     * test view for open from filament action
     */
    public function testFilament(Request $request): View
    {
        $resourceName = $request->query('post'); // owner record from filament

        $value = $request->query('value'); // just my test input // or $request->input('value')
        $value = $value ?? 'sorry, no value was passed from filament';

        return view('test-controller.test-filament', [
            'data'        => $value,
            'resourceName' => $resourceName,
        ]);
    }

    
}
