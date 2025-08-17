<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PrometheusAuth
{
    public function handle(Request $request, Closure $next)
    {
        $username = 'prometheus';
        $password = 'secret123';

        if (
            $request->getUser() !== env('BASIC_AUTH_USERNAME') ||
            $request->getPassword() !== env('BASIC_AUTH_PASSWORD')

        ) {
            return response('Unauthorized', 401)->header('WWW-Authenticate', 'Basic');
        }

        return $next($request);
    }
}
