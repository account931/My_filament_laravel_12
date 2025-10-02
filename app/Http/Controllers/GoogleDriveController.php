<?php

// NOT USED SO FAR, same functionality is implemented in App/Http/Controllers/Socialite/SocialiteGoogleAuthController. Just keep in case

namespace App\Http\Controllers;

use Google_Client;
use Google_Service_Drive;
use Illuminate\Http\Request;

class GoogleDriveController extends Controller
{
    public function redirectToGoogle()
    {
        $client = new Google_Client;
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(config('services.google.redirect'));
        $client->addScope(Google_Service_Drive::DRIVE);
        $client->setAccessType('offline'); // important for refresh token
        $client->setPrompt('consent');     // forces refresh token

        $authUrl = $client->createAuthUrl();

        return redirect()->away($authUrl);
    }

    public function handleGoogleCallback(Request $request)
    {
        $client = new Google_Client;
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(config('services.google.redirect'));

        $token = $client->fetchAccessTokenWithAuthCode($request->input('code'));

        if (isset($token['error'])) {
            return response()->json(['error' => $token['error_description']], 400);
        }

        // Save token in session, DB, or wherever you want
        session(['google_token' => $token]);

        return response()->json([
            'access_token' => $token['access_token'],
            'expires_in' => $token['expires_in'],
            'refresh_token' => $token['refresh_token'] ?? null,
        ]);
    }
}
