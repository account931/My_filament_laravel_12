<?php

// to change languages
// our controller sets the language only for the current request:After redirect, Laravel forgets it unless you apply it via middleware.

namespace App\Http\Middleware;

use Closure;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        if (session()->has('locale')) {
            app()->setLocale(session('locale'));
        }

        return $next($request);
    }
}
