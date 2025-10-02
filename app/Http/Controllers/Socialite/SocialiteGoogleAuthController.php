<?php

// Flow to login via Google using Socialite. To run go to http://localhost:8000/socialite/index#/
// Login and getting google_access_token, google_refresh_token and saving in DB for a logged user.

namespace App\Http\Controllers\Socialite;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class SocialiteGoogleAuthController extends Controller
{
    // use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        // $this->middleware('auth'); //logged users only
    }

    /**
     * Redirect the user to the Google OAuth authentication page.
     *
     * This method uses Laravel Socialite to initiate the Google login process.
     * It may also perform authorization via policy (commented out here).
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function googleLogin()
    {
        // using Policy. There 3 possible ways
        // $this->authorize('index', Owner::class); //must have, Policy check (403 if fails)

        return Socialite::driver('google')
            // necessary scopes for Google drive
            ->scopes([
                'https://www.googleapis.com/auth/drive.file',        // scopes/permissions to work with
                'https://www.googleapis.com/auth/userinfo.email',
                'https://www.googleapis.com/auth/userinfo.profile',
            ])
            // use below to force getting refresh_token, if not visiting first time ever
            /*
            ->with([
               'access_type' => 'offline',  //To force Google OAuth to return a refresh_token, otherwise returned on first login only
               'prompt' => 'consent',       //To force Google OAuth to return a refresh_token, otherwise returned on first login only
            ])
           */
            ->redirect();
    }

    /**
     * Handle the callback from Google OAuth login via Socialite.
     * Login and getting google_access_token, google_refresh_token and saving in DB for a logged user
     *
     * This method retrieves the authenticated user's information from Google using Socialite.
     * It stores the user object in the session, saves the OAuth access and refresh tokens
     * to the currently authenticated user (via Laravel's Auth), and then redirects the user.
     *
     * Notes:
     * - `stateless()` is used to avoid session state validation (useful for APIs or testing).
     * - The refresh token is only provided the first time or if `prompt=consent` is used.
     * - Assumes that the user is already authenticated in Laravel before OAuth.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function googleLoginCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // Store logged user in session
        Session::put('google_oauthed_user', $googleUser);
        // Session::put('google_oauth_user', $googleUser->email);

        $user = Auth::user(); // or find/create user using $googleUser->getEmail()

        // save google_access_token, google_refresh_token, etc to db table 'users'. Encrypt values, use Laravel's built-in encryption with app key
        $user->google_access_token = Crypt::encryptString($googleUser->token);  // Encrypt values
        $user->google_refresh_token = Crypt::encryptString($googleUser->refreshToken); // only provided first time or with prompt=consent
        $user->google_expires_at = Carbon::now('UTC')->addSeconds($googleUser->expiresIn); // fix for correct time //now()->addSeconds($googleUser->expiresIn);
        $user->save();
        // end save to db

        // dd ($googleUser); //google oauth token  //Use a Google Service Account if your app only needs access to your own Google Drive (when no logged user engaged
        return redirect()->route('socialite.start')->with('googleAccessToken', $googleUser);

    }

    /**
     * Logs out the user from a Socialite (Google OAuth) session.
     *
     * This method specifically removes the 'google_oauthed_user' session data used
     * to store the authenticated user's information retrieved via Google OAuth.
     *
     * Optionally, you can uncomment the `Auth::logout()`, `invalidate()`, and
     * `regenerateToken()` lines to perform a full logout including session invalidation
     * and CSRF token regeneration.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function socialiteLogout()
    {
        session()->forget('google_oauthed_user'); // Remove this session data

        // Auth::logout();       // Logs out the user from the session in case u want complete log out
        // request()->session()->invalidate();  // Invalidate session
        // request()->session()->regenerateToken(); // Regenerate CSRF token

        return redirect()->back();  // Redirect wherever you want
    }
}
