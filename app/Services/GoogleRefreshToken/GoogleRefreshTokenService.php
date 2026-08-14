<?php

// Service to get/generate Google 'access_token' using Google 'google_refresh_token' saved in DB table 'users' in 'google_refresh_token'
// it is a same function as used in App\Services\GoogleDriveSqlBackupService.php, just moved out to a single Service. For example this service is used/commented in Controllers\GoogleSpreadsheet\GoogleSpreadsheetController.php
// example of use in controller as (new GoogleRefreshTokenService())->getAccessToken(User $user);
// When you login via Socialite you get 'access_token' (which lives for 1 hour and used for access) + 'refresh_token' (which is long live and used to issue new access_token). So, 'access_token' and 'refresh_token' is unique for every user, while client_id, secret_id is common

namespace App\Services\GoogleRefreshToken;

use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

class GoogleRefreshTokenService
{
    public function __construct() {}

    /**
     * generate Google 'access_token' using Google 'google_refresh_token' saved in DB table 'users' in 'google_refresh_token'
     * 'google_refresh_token' is generate in other flow Controllers/Socialite/SocialiteGoogleAuthController
     */
    public function getAccessToken(User $userModel): string
    {
        // Hardcode token temporarily or load from file
        // return 'YOUR_OAUTH_ACCESS_TOKEN';
        // return env('GOOGLE_ACCESS_TOKEN');

        // GET google_refresh_token  FIRST! ------------------------

        // gets user
        $user = $userModel; // User::find($userID);

        // check if access_token is not expired to avoid unnecessary API calls
        if ($user->google_expires_at && now()->lessThan($user->google_expires_at)) {
            // Token is still valid
            return Crypt::decryptString($user->google_access_token); // decrypt value
        }

        // Get a new access token using the stored refresh token. Uses Laravel HTTP client.
        // Can do the same with Google API PHP Client =>  $token = $client->fetchAccessTokenWithRefreshToken($refreshToken);
        $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'client_id' => config('services.google.client_id'),
            'client_secret' => config('services.google.client_secret'),
            'refresh_token' => Crypt::decryptString($user->google_refresh_token),  // $refreshToken, decrypt, as we save it encrypted in DB
            'grant_type' => 'refresh_token',
        ]);

        if ($response->successful() && $response->json('access_token')) {
            $newAccessToken = $response->json()['access_token'];
            $expiresIn = $response->json()['expires_in'];

            // updates google_access_token, etc to db table 'users'
            $user->google_access_token = Crypt::encryptString($newAccessToken); // save encrypted
            $user->google_expires_at = now()->addSeconds($expiresIn);
            $user->save();

            return $newAccessToken;
            // end save to db

            // Optional: Save new access token to DB, session, etc.
        } else {
            // Handle failure
            throw new \Exception('Failed to refresh access token: '.$response->body());
        }
    }
}
