<?php

//

namespace App\Http\Controllers\PrometheusMetrics;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis as LaravelRedis;
use Prometheus\CollectorRegistry;
use Prometheus\Exception\MetricsRegistrationException;
use Prometheus\RenderTextFormat;
use Prometheus\Storage\Redis as PrometheusRedis;
use RuntimeException;

class PrometheusMetricsController extends Controller
{
    public function __construct(private PrometheusRedis $redisStorage)  // PrometheusRedis anywhere through dependency injection. Registered in AppServiceProvider.php
    {}

    public function index()
    {
        // Version 1. Prometheus Redis adapter config, for local only
        /*
        $storage = new PrometheusRedis([
            'host' => 'redis',  // container name
            'port' => 6379,
            'timeout' => 0.1,
            'read_timeout' => 10,
            'persistent_connections' => false,
        ]);
        // dd (config('database.redis.redis_url')) ;
        */
        // End Version 1. Prometheus Redis adapter config, for local only

        // Version 2. Prometheus Redis adapter config, for local and production. Working
        // set up Redis for both local and production
        /*
        if (app()->environment('production')) {
            $redisUrl = config('database.redis.redis_url'); // $redisUrl = env('REDIS_URL');

            if (! $redisUrl) {
                throw new RuntimeException('REDIS_URL is not configured.');
            }

            $parsed = parse_url($redisUrl);

            $storage = new PrometheusRedis([
                'host' => $parsed['host'],
                'port' => $parsed['port'] ?? 6379,
                'timeout' => 0.1,
                'read_timeout' => 10,
                'persistent_connections' => false,
            ]);
        } else {
            // localhost
            $storage = new PrometheusRedis([
                'host' => 'redis',
                'port' => 6379,
                'timeout' => 0.1,
                'read_timeout' => 10,
                'persistent_connections' => false,
            ]);
        }
        */
        // end set up Redis for both local and production
        // End Version 2. Prometheus Redis adapter config, for local and production. Working

        // Version 3. Prometheus Redis adapter config via Singleton. For local and production
        // $storage = app(PrometheusRedis::class); //working, when you need it somewhere without dependency injection in constructor
        $storage = $this->redisStorage; // when have dependency injection in constructor only
        // End Version 3. Prometheus Redis adapter config via Singleton. For local and production

        $registry = new CollectorRegistry($storage);

        // Metrics: Define or retrieve
        try {
            $connectedClients = $registry->registerGauge('redis', 'connected_clients', 'Number of client connections');
        } catch (MetricsRegistrationException $e) {
            $connectedClients = $registry->getGauge('redis', 'connected_clients');
        }

        try {
            $usedMemory = $registry->registerGauge('redis', 'used_memory_bytes', 'Memory used by Redis in bytes');
        } catch (MetricsRegistrationException $e) {
            $usedMemory = $registry->getGauge('redis', 'used_memory_bytes');
        }

        // Track total commands processed directly from Redis.
        // Redis already maintains this as a monotonically increasing value.
        /*
        try {
            $totalCommandsProcessed = $registry->registerCounter('redis', 'total_commands_processed', 'Total number of Redis commands processed');
        } catch (MetricsRegistrationException $e) {
            $totalCommandsProcessed = $registry->getCounter('redis', 'total_commands_processed');
        }
        */
        // change suggested by AI
        try {
            $totalCommandsProcessed = $registry->registerGauge(
                'redis',
                'total_commands_processed',
                'Total number of Redis commands processed'
            );
        } catch (MetricsRegistrationException $e) {
            $totalCommandsProcessed = $registry->getGauge(
                'redis',
                'total_commands_processed'
            );
        }

        $totalCommandsProcessed->set(
            $info['total_commands_processed'] ?? 0
        );

        // Get Redis INFO
        try {
            $info = LaravelRedis::info();  // redis_version, used_memory, connected_clients, etc
        } catch (\Exception $e) {
            Log::error('Failed to fetch Redis INFO: '.$e->getMessage());

            return response('Redis error', 500);
        }

        // Set metric values
        $connectedClients->set($info['connected_clients'] ?? 0);
        $usedMemory->set($info['used_memory'] ?? 0);

        // Track total commands processed
        /*
        static $lastCommandsProcessed = 0;
        $current = $info['total_commands_processed'] ?? 0;
        $delta = max(0, $current - $lastCommandsProcessed);
        $totalCommandsProcessed->incBy($delta);
        $lastCommandsProcessed = $current;
        */

        // Render metrics
        $renderer = new RenderTextFormat;
        $metrics = $renderer->render($registry->getMetricFamilySamples());

        return response($metrics, 200)->header('Content-Type', RenderTextFormat::MIME_TYPE);
    }
}
