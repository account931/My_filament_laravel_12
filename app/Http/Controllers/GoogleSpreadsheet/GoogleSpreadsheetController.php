<?php

//  Reads a specific Spreadsheet and display it in Blade
//  Before using it you should login via Socialite to get 'access_token' and 'refresh token' and go back to this app page.
// 'access_token' is used to grant access to Google, but when token is expired, we use 'refresh token' to get new 'access_token'. It is implemented in function getAccessToken(User $userModel) in App\Services\GoogleDriveSqlBackupService.php OR same function but in separate Service in App\Services\GoogleRefreshToken\GoogleRefreshTokenService.php

namespace App\Http\Controllers\GoogleSpreadsheet;

use App\Http\Controllers\Controller;
use App\Services\GoogleRefreshToken\GoogleRefreshTokenService;
use Google\Client;
use Google\Service\Sheets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt; // Service to get/generate Google 'access_token' using Google 'google_refresh_token'

class GoogleSpreadsheetController extends Controller
{
    // use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        // $this->middleware('auth'); //logged users only
    }

    // same page for /GET and /POST, /GET displays just a form button. On this button click we send /POST to same function, get spreadsheet content and display it. This way can see button and result on same page
    public function index(Request $request)
    {

        $values = [];

        // We Do NOT load/get Google Sheets content on normal /GET page load. Load Google Sheets content on /POST only
        if ($request->isMethod('post')) {

            $user = Auth::user();

            if ($user->google_user_email && $user->google_refresh_token) {  // if user has already performed Socialite login, got callback and saved 'google_user_email/google_refresh_token' fields to table 'users'

                $client = new Client;
                $client->setClientId(config('services.google.client_id'));
                $client->setClientSecret(config('services.google.client_secret'));

                // Read-only access to Google Sheets
                $client->addScope(Sheets::SPREADSHEETS_READONLY);

                // Variant 1. Working. Get a new 'access token' using the stored 'refresh token'.
                // get and decrypt 'google_refresh_token' from table 'users'
                $refreshToken = Crypt::decryptString(
                    $user->google_refresh_token
                );

                // dd(['encrypted' => $user->google_refresh_token,'decrypted' => Crypt::decryptString($user->google_refresh_token),]);

                // Get a new access token using the stored refresh token. Using the Google API PHP Client.
                // Can do the same with Laravel HTTP client in \Services\GoogleDriveSqlBackupService.php
                $accessToken = $client->fetchAccessTokenWithRefreshToken(
                    $refreshToken
                ); // returns ['access_token', 'expires_in', 'created' ]

                // dd($accessToken);

                if (isset($accessToken['error'])) {
                    abort(
                        500,
                        $accessToken['error_description']
                            ?? 'Unable to authenticate with Google.'
                    );
                }
                // End 1. Working Get a new 'access token' using the stored 'refresh token'.

                // Variant 2. Same as Var 1. Working. Get a new 'access token' using the stored 'refresh token' using Service.
                // $service = new GoogleRefreshTokenService;  // Service with core logic
                // $accessToken = $service->getAccessToken(Auth::user());  //NB: returns 'access_token' only
                // Variant 2. Working Get a new 'access token' using the stored 'refresh token' sing Service.

                $client->setAccessToken($accessToken);

                // Start reading Spreadsheet flow.............
                // Create Google Sheets service
                $service = new Sheets($client);

                // $spreadsheetId = config('services.google.sheet_id');
                $spreadsheetId = config('services.google.sheet_id');  // env('GOOGLE_SHEET_ID');
                // dd($spreadsheetId);

                // Read first visible sheet
                $range = 'A1:D100';

                $response = $service->spreadsheets_values->get(
                    $spreadsheetId,
                    $range
                );

                $values = $response->getValues() ?? [];
                // End reading Spreadsheet flow.............
            }
        }

        return view('google-spreadsheet.index', ['values' => $values]);

        // Var 2. Working. Loads spreadsheet data at once on page load
        /*
        $values = [];

        $user = Auth::user();

        if ($user->google_user_email && $user->google_refresh_token) {

            $client = new Client;

            $client->setClientId(config('services.google.client_id'));
            $client->setClientSecret(config('services.google.client_secret'));

            // Read-only access to Google Sheets
            $client->addScope(Sheets::SPREADSHEETS_READONLY);

            $refreshToken = Crypt::decryptString($user->google_refresh_token);

            // Get a new access token using the stored refresh token
            $token = $client->fetchAccessTokenWithRefreshToken(
                $refreshToken  // $user->google_refresh_token
            );


            if (isset($token['error'])) {
                abort(
                    500,
                    $token['error_description'] ?? 'Unable to authenticate with Google.'
                );
            }


            //if (isset($token['error'])) {dd($token);}

            $client->setAccessToken($token);

            // Create Google Sheets service
            $service = new Sheets($client);

            // $spreadsheetId = config('services.google.sheet_id');
            $spreadsheetId = config('services.google.sheet_id');  //env('GOOGLE_SHEET_ID');
            // dd  ($spreadsheetId);


            //dd(['sheet_id' => $spreadsheetId,'google_user' => $user->google_user_email,]);
















            $range = 'A1:D100';  //use first visible sheet
            //$range = 'Sheet1!A1:D100';  //name here is incorrect

            $response = $service->spreadsheets_values->get(
                $spreadsheetId,
                $range
            );

            $values = $response->getValues() ?? [];
        }

        return view('google-spreadsheet.index', [
            'values' => $values,
        ]);

        */
    }
}
