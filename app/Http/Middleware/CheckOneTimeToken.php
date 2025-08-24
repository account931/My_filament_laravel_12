<?php

// middleware is used for one time links for Scramble docs, registered in /config/scramble.php. Uses table 'one_time_links'

namespace App\Http\Middleware;

use App\Models\OneTimeLink;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckOneTimeToken
{
    public function handle($request, Closure $next)
    {
        // If user is logged in, always let him in (if Spatie permitts)
        if (Auth::check()) {
            if (! Auth::user()->can('view scramble docs')) {
                abort(404, 'You dont have permssion to view scramble docs');
            }

            return $next($request);
        }

        // $token = $request->route('token');   // if http://localhost:8000/docs/api/UxTZQNt
        $token = $request->query('token'); // if http://localhost:8000/docs/api?token=UxTZQNtyemA4Y2

        // dd($token);

        if (! $token) {
            abort(404, 'Token required.');
        }

        $link = OneTimeLink::where('token', $token)->first();

        if (! $link || $link->used) {
            abort(404, 'Invalid or used token.');
        }

        // Mark token as used
        $link->used = true;
        $link->save();

        return $next($request);
    }
}
