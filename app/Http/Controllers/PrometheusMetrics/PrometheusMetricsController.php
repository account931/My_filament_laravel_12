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

class PrometheusMetricsController extends Controller
{
    public function index()
    {
        // Prometheus Redis adapter config
        $storage = new PrometheusRedis([
            'host' => 'redis',  // container name
            'port' => 6379,
            'timeout' => 0.1,
            'read_timeout' => 10,
            'persistent_connections' => false,
        ]);

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

        try {
            $totalCommandsProcessed = $registry->registerCounter('redis', 'total_commands_processed', 'Total number of Redis commands processed');
        } catch (MetricsRegistrationException $e) {
            $totalCommandsProcessed = $registry->getCounter('redis', 'total_commands_processed');
        }

        // Get Redis INFO
        try {
            $info = LaravelRedis::info();
        } catch (\Exception $e) {
            Log::error('Failed to fetch Redis INFO: '.$e->getMessage());

            return response('Redis error', 500);
        }

        // Set metric values
        $connectedClients->set($info['connected_clients'] ?? 0);
        $usedMemory->set($info['used_memory'] ?? 0);

        // Track total commands processed
        static $lastCommandsProcessed = 0;
        $current = $info['total_commands_processed'] ?? 0;
        $delta = max(0, $current - $lastCommandsProcessed);
        $totalCommandsProcessed->incBy($delta);
        $lastCommandsProcessed = $current;

        // Render metrics
        $renderer = new RenderTextFormat;
        $metrics = $renderer->render($registry->getMetricFamilySamples());

        return response($metrics, 200)->header('Content-Type', RenderTextFormat::MIME_TYPE);
    }
}
