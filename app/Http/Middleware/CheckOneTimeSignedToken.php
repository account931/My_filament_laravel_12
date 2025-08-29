<?php

// middleware is used for signed one-time links for Scramble docs, middleware is registered in /config/scramble.php. Uses table 'one_time_links'
// auth users goes without any checking, guests are checked for signature/expiration//one-time token

namespace App\Http\Middleware;

use App\Models\OneTimeLink;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class CheckOneTimeSignedToken
{
    public function handle($request, Closure $next)
    {
        // check if user is logged in, if always let him in without token, signature or expiry token (if Spatie permitts)
        if (Auth::check()) {
            if (! Auth::user()->can('view scramble docs')) {
                abort(404, 'You dont have permssion to view scramble docs');
            }

            return $next($request);
        }

        // Check 1: check if link is signed (in other situation, can just apply middleware 'signed' in routes/web and this checking will be automatic)
        if (! URL::hasValidSignature(request())) {
            abort(404, 'Signature is corrupted or invalid.');
        }

        // Check 2: check if link is not expired
        $expires = request('expires');
        if ($expires < now()->timestamp) {
            abort(404, 'Link expired');
        }

        // Check 3: check one-time token if was already used or not
        // $token = $request->route('oneTimeToken');   // if http://localhost:8000/docs/api/UxTZQNt
        $oneTimeTokenCheck = $request->query('oneTimeToken'); // if http://localhost:8000/docs/api?token=UxTZQNtyemA4Y2

        // dd($oneTimeTokenCheck);

        if (! $oneTimeTokenCheck) {
            abort(404, 'Token required.');
        }

        $link = OneTimeLink::where('token', $oneTimeTokenCheck)->first();

        if (! $link || $link->used) {
            abort(404, 'Invalid or used one-time token.');
        }

        // Mark token as used
        $link->used = true;
        $link->save();
        // dd($link);

        return $next($request);
    }
}
