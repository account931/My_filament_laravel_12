<?php

// Basic auth for Prometeus endpont '/metrics'.
// Add to .env your any own created 'PROMETHEUS_METRICS_ENDPOINT_USERNAME', 'PROMETHEUS_METRICS_ENDPOINT_PASSWORD'. Just any, just .env vat must be the same as set in Prometeus auth

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PrometheusAuth
{
    public function handle(Request $request, Closure $next)
    {
        // $username = 'see env';
        // $password = 'see env'';

        if (
            $request->getUser() !== config('services.prometheus.username') ||   // env('PROMETHEUS_METRICS_ENDPOINT_USERNAME')
            $request->getPassword() !== config('services.prometheus.password')  // !== env('PROMETHEUS_METRICS_ENDPOINT_PASSWORD')

        ) {
            return response('Unauthorized', 401)->header('WWW-Authenticate', 'Basic');
        }

        return $next($request);
    }
}
