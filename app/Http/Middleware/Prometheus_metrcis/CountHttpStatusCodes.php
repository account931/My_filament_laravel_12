<?php

// for Prometheus metrcis, middleware counts 200/400/500 responses, registered in bootstrap/app.php
// should output at /metrics => app_http_responses_total{status_code="200"}

// Middleware runs on every request
// Increments a Prometheus counter with labels method and path
// Metrics appear in /metrics automatically because you use Redis storage shared by Prometheus client

namespace App\Http\Middleware\Prometheus_metrcis;

use Closure;
use Prometheus\CollectorRegistry;
use Prometheus\Storage\Redis as PrometheusRedis;

class CountHttpStatusCodes
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // Setup Prometheus Redis storage
        $storage = new PrometheusRedis([
            'host' => env('REDIS_HOST', 'redis'),
            'port' => env('REDIS_PORT', 6379),
            'database' => 10,
            'timeout' => 0.1,
            'read_timeout' => 10,
            'persistent_connections' => false,
        ]);

        $registry = new CollectorRegistry($storage);

        // Register or get counter metric for HTTP status codes
        try {
            $counter = $registry->registerCounter(
                'app',
                'http_responses_total',
                'Count of HTTP responses by status code',
                ['status_code']
            );
        } catch (\Prometheus\Exception\MetricsRegistrationException $e) {
            $counter = $registry->getCounter('app', 'http_responses_total');
        }

        // Increment counter with status code label
        $statusCode = (string) $response->getStatusCode();
        $counter->inc([$statusCode]);

        return $response;
    }
}
