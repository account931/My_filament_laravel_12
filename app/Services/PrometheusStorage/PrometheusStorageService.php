<?php

// Service to configure Redis connection for Prometheus both for local(local Docker container) and production(Render Redis cloud which uses REDIS_URL)

namespace App\Services\PrometheusStorage;

use Prometheus\Storage\Redis as PrometheusRedis;
use RuntimeException;

class PrometheusStorageService
{
    public function make(): PrometheusRedis
    {
        if (app()->environment('production')) {
            return $this->production();
        }

        return $this->local();
    }

    private function production(): PrometheusRedis
    {
        $redisUrl = config('database.redis.redis_url');

        if (! $redisUrl) {
            throw new RuntimeException('REDIS_URL is not configured.');
        }

        $parsed = parse_url($redisUrl);

        return new PrometheusRedis([
            'host' => $parsed['host'],
            'port' => $parsed['port'] ?? 6379,
            'timeout' => 0.1,
            'read_timeout' => 10,
            'persistent_connections' => false,
        ]);
    }

    private function local(): PrometheusRedis
    {
        return new PrometheusRedis([
            'host' => 'redis',
            'port' => 6379,
            'timeout' => 0.1,
            'read_timeout' => 10,
            'persistent_connections' => false,
        ]);
    }
}
