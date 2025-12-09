<?php

// for Prometheus metrcis, tracks exceptions thrown during requests, registered in bootstrap/app.php
// should output at /meterics => app_exceptions_total{exception="Illuminate\\Database\\QueryException"} 3
//                              app_exceptions_total{exception="Symfony\\Component\\HttpKernel\\Exception\\NotFoundHttpException"} 7

// Middleware runs on every request
// Increments a Prometheus counter with labels method and path
// Metrics appear in /metrics automatically because you use Redis storage shared by Prometheus client

namespace App\Http\Middleware\Prometheus_metrcis;

use Closure;
use Prometheus\CollectorRegistry;
use Prometheus\Storage\Redis as PrometheusRedis;
use Throwable;

class CountExceptions
{
    protected $registry;

    protected $exceptionCounter;

    public function __construct()
    {
        $storage = new PrometheusRedis([
            'host' => env('REDIS_HOST', 'redis'),
            'port' => env('REDIS_PORT', 6379),
            'database' => 10,
            'timeout' => 0.1,
            'read_timeout' => 10,
            'persistent_connections' => false,
        ]);

        $this->registry = new CollectorRegistry($storage);

        try {
            $this->exceptionCounter = $this->registry->registerCounter(
                'app',
                'exceptions_total',
                'Total number of exceptions thrown',
                ['exception']
            );
        } catch (\Prometheus\Exception\MetricsRegistrationException $e) {
            $this->exceptionCounter = $this->registry->getCounter('app', 'exceptions_total');
        }
    }

    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next)
    {
        try {
            return $next($request);
        } catch (Throwable $e) {
            // Increment counter with exception class as label
            $this->exceptionCounter->inc([get_class($e)]);

            // Re-throw the exception so Laravel can handle it as usual
            throw $e;
        }
    }
}
