<?php

// NOT USED SO FAR!!! Tried but failed, so now any Vue uses API Token Authentication (Personal Access Tokens).
// Auth controller
// Sanctum via CSRF-based session authentication, (not API tokens). Sanctum issues cookies, not bearer tokens. ou must first get a CSRF cookie, then perform your logi

namespace App\Http\Controllers\Auth_Api\SanctumCSRFbasedSessionAuthentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CSRFbasedSessionAuthController extends Controller
{
    public function loginCSRF(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $request->session()->regenerate();  // Creates a new session ID to prevent session fixation attacks, Writes the old session and starts a new one.

        return response()->json(['message' => 'Logged in']);

    }

    public function logout(Request $request) {}
}
