<?php

// for Prometheus metrcis, middleware to count and time your database queries , registered in bootstrap.app
// should output at /meterics => app_db_queries_total 37
//                            app_db_query_duration_seconds_bucket{le="0.005"} 10

// Middleware runs on every request
// Increments a Prometheus counter with labels method and path
// Metrics appear in /metrics automatically because you use Redis storage shared by Prometheus client

namespace App\Http\Middleware\Prometheus_metrcis;

use Closure;
use DB;
use Prometheus\CollectorRegistry;
use Prometheus\Storage\Redis as PrometheusRedis;

class TrackDbQueries
{
    public function handle($request, Closure $next)
    {
        // Setup Prometheus Redis storage once
        $storage = new PrometheusRedis([
            'host' => env('REDIS_HOST', 'redis'),
            'port' => env('REDIS_PORT', 6379),
            'database' => 10,
            'timeout' => 0.1,
            'read_timeout' => 10,
            'persistent_connections' => false,
        ]);
        $registry = new CollectorRegistry($storage);

        // Register or get counters/histograms for DB queries
        try {
            $counter = $registry->registerCounter(
                'app',
                'db_queries_total',
                'Total number of database queries'
            );
        } catch (\Prometheus\Exception\MetricsRegistrationException $e) {
            $counter = $registry->getCounter('app', 'db_queries_total');
        }

        try {
            $histogram = $registry->registerHistogram(
                'app',
                'db_query_duration_seconds',
                'Duration of database queries in seconds'
            );
        } catch (\Prometheus\Exception\MetricsRegistrationException $e) {
            $histogram = $registry->getHistogram('app', 'db_query_duration_seconds');
        }

        // Track queries during this request
        DB::listen(function ($query) use ($counter, $histogram) {
            $counter->inc();

            // $query->time is in milliseconds, convert to seconds
            $durationSeconds = $query->time / 1000;
            $histogram->observe($durationSeconds);
        });

        return $next($request);
    }
}
