<?php

// for Prometheus metrcis, measure how long requests take
// should output at /meterics => app_http_request_duration_seconds_bucket{method="GET",path="shop",status="200",le="0.75"} 2

// Middleware runs on every request
// Increments a Prometheus counter with labels method and path
// Metrics appear in /metrics automatically because you use Redis storage shared by Prometheus client

namespace App\Http\Middleware\Prometheus_metrcis;

// namespace App\Http\Middleware\PrometheusMetrics; //change to PSR 4

use Closure;
use Prometheus\CollectorRegistry;
use Prometheus\Storage\Redis as PrometheusRedis;

class TrackRequestDuration
{
    public function __construct(private PrometheusRedis $redisStorage)  // PrometheusRedis anywhere through dependency injection. Registered in AppServiceProvider.php
    {}

    public function handle($request, Closure $next)
    {
        $start = microtime(true);
        $response = $next($request);
        $duration = microtime(true) - $start;

        // Setup Prometheus Redis storage, works for local host only
        /*
        $storage = new PrometheusRedis([
            'host' => env('REDIS_HOST', 'redis'),
            'port' => env('REDIS_PORT', 6379),
            'database' => 10,
        ]);
        */

        // Setup Prometheus Redis storage via Service, works for local and production Render
        $storage = $this->redisStorage; // should have dependency injection in constructor

        $registry = new CollectorRegistry($storage);

        try {
            $histogram = $registry->registerHistogram(
                'app',
                'http_request_duration_seconds',
                'HTTP request duration in seconds',
                ['method', 'path', 'status']
            );
        } catch (\Prometheus\Exception\MetricsRegistrationException $e) {
            $histogram = $registry->getHistogram('app', 'http_request_duration_seconds');
        }

        $status = method_exists($response, 'getStatusCode') ? $response->getStatusCode() : 200; // Fix: as Filament started crashing

        $histogram->observe($duration, [$request->method(), $request->path(), $status /* $response->status() */]);

        return $response;
    }
}
