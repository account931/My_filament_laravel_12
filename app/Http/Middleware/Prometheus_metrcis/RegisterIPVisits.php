<?php

// for Prometheus metrcis, middleware to register/count IP visits, registered in bootstrap/app.php
// should output at /meterics => laravel_requests_by_ip_total{ip="172.18.0.1"} 3

// Middleware runs on every request
// Increments a Prometheus counter with labels method and path
// Metrics appear in /metrics automatically because you use Redis storage shared by Prometheus client

namespace App\Http\Middleware\Prometheus_metrcis;

use Closure;
use Prometheus\CollectorRegistry;
use Prometheus\Storage\Redis;
use Prometheus\Storage\Redis as PrometheusRedis;

class RegisterIPVisits
{
    protected $registry;

    protected $exceptionCounter;

    // PrometheusRedis anywhere through dependency injection. Registered in AppServiceProvider.php
    public function __construct(private PrometheusRedis $redisStorage) {}

    public function handle($request, Closure $next)
    {
        // Setup Prometheus Redis storage, works for local host only
        /*
        $storage = new PrometheusRedis([
            'host' => env('REDIS_HOST', 'redis'),
            'port' => env('REDIS_PORT', 6379),
            'database' => 10,
            'timeout' => 0.1,
            'read_timeout' => 10,
            'persistent_connections' => false,
        ]);
        */

        // Setup Prometheus Redis storage via Service, works for local and production Render
        $storage = $this->redisStorage; // should have dependency injection in constructor

        $this->registry = new CollectorRegistry($storage);

        // Register the counter once
        try {
            $this->registry->registerCounter(
                'laravel',
                'requests_by_ip_total',
                'Total requests grouped by IP',
                ['ip']
            );
        } catch (\Prometheus\Exception\MetricAlreadyRegisteredException $e) {
            // ignore – already registered
        }

        // Fetch the counter
        $counter = $this->registry->getCounter(
            'laravel',
            'requests_by_ip_total'
        );

        // Increment with label
        $counter->inc([$request->ip()]);

        return $next($request);
    }
}
