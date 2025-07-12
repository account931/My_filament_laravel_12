<?php

namespace App\Http\Controllers\TestController;

use App\Http\Controllers\Controller;
use App\Models\Owner;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\View\View;

// to place controller in subfolder
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
            'data' => $value,
            'resourceName' => $resourceName,
        ]);
    }

    /**
     * test view for open from filament action
     */
    public function testFilamentOwner(Request $request): View
    {
        $ownerOneRecord = $request->query('post'); // owner record from filament //gets id only

        $value = $request->query('value'); // just my test input // or $request->input('value')
        $value = $value ?? 'sorry, no value was passed from filament';

        // $response = Http::get('http://localhost/api/owners/' . $ownerOneRecord);
        // $client      = new Client();
        // $response = $client->get('http://localhost/api/owners/' . $ownerOneRecord);

        // $generatedData = $response->getBody()->getContents();
        // dd($generatedData);

        $generatedData = Owner::where('id', $ownerOneRecord)
            ->with(['venues', 'venues.equipments']) // add your relationships here
            ->first();
        // dd($generatedData);

        return view('test-controller.test-filament-owner', [
            'data' => $value,
            'ownerRecord' => $ownerOneRecord,
            'generatedData' => $ownerOneRecord ? $generatedData : null,
        ]);
    }
}
