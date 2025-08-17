<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

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
        $middleware->append(\App\Http\Middleware\Prometheus_metrcis\CountVisits::class);           // Prometheus metrics, how many times a page is visited
        $middleware->append(\App\Http\Middleware\Prometheus_metrcis\TrackRequestDuration::class); // Prometheus metrics, measure how long requests take
        $middleware->append(\App\Http\Middleware\Prometheus_metrcis\CountHttpStatusCodes::class); // Prometheus metrics, counts 200/400/500 responses
        $middleware->append(\App\Http\Middleware\Prometheus_metrcis\CountExceptions::class);      // Prometheus metrics, tracks exceptions thrown during requests
        // End Prometheus metrics

        // ✅ Route middleware (only applied to specific routes when declared)
        $middleware->alias([
            'prometheus.auth' => \App\Http\Middleware\PrometheusAuth::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
