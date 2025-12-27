<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\App;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Global middleware (applied to every request)
        // register middleware here
        // Prometheus metrics
        if (getenv('APP_ENV') !== 'testing') { // fix to prevent github action Pest tests from failing
            // if (!app()->environment('testing')) {//caused error Uncaught ReflectionException: Class "env" does not exist as is not safe to call inside bootstrap/app.php or before the app is fully
            $middleware->append(\App\Http\Middleware\Prometheus_metrcis\CountVisits::class);           // Prometheus metrics, how many times a page is visited
            $middleware->append(\App\Http\Middleware\Prometheus_metrcis\TrackRequestDuration::class);  // Prometheus metrics, measure how long requests take
            $middleware->append(\App\Http\Middleware\Prometheus_metrcis\CountHttpStatusCodes::class);  // Prometheus metrics, counts 200/400/500 responses
            $middleware->append(\App\Http\Middleware\Prometheus_metrcis\CountExceptions::class);       // Prometheus metrics, tracks exceptions thrown during request
            $middleware->append(\App\Http\Middleware\Prometheus_metrcis\RegisterIPVisits::class);      // Prometheus metrics, tracks IP visits
        }
        // End Prometheus metrics

        // ✅ Route middleware (only applied to specific routes when declared)
        $middleware->alias([
            'prometheus.auth' => \App\Http\Middleware\PrometheusAuth::class,
        ]);

        $middleware->alias([
            'auth.one_time_token' => \App\Http\Middleware\CheckOneTimeSignedToken::class,
            'force.json' => \App\Http\Middleware\ForceJsonResponse::class,   // force return json
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
