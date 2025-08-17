<?php

// for Prometheus metrcis, middleware to count how many times a page is visited, registered in bootstrap.app
// should output at /meterics => app_visits_total{method="GET",path="dashboard"} 1

// Middleware runs on every request
// Increments a Prometheus counter with labels method and path
// Metrics appear in /metrics automatically because you use Redis storage shared by Prometheus client

namespace App\Http\Middleware\Prometheus_metrcis;

use Closure;
use Prometheus\CollectorRegistry;
use Prometheus\Storage\Redis as PrometheusRedis;

class CountVisits
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

        // Register or get the counter metric for visits
        try {
            $counter = $registry->registerCounter(
                'app',
                'visits_total',
                'Total number of visits',
                ['method', 'path']
            );
        } catch (\Prometheus\Exception\MetricsRegistrationException $e) {
            $counter = $registry->getCounter('app', 'visits_total');
        }

        // Increment counter with labels for HTTP method and path
        $counter->inc([$request->method(), $request->path()]);

        return $response;
    }
}
