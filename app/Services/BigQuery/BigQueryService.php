<?php

// Service to log view product details to BigQuery
// use in controller as (new BigQueryService())->logProductView($product->id, auth()->id());

namespace App\Services\BigQuery;

use Google\Cloud\BigQuery\BigQueryClient;
use Google\Cloud\Core\Exception\GoogleException;

class BigQueryService
{
    protected $bigQuery;

    protected $dataset;

    protected $table;

    public function __construct()
    {
        $this->bigQuery = new BigQueryClient([
            'projectId' => env('BIGQUERY_PROJECT_ID'),
            'keyFilePath' => base_path(env('BIGQUERY_KEY_FILE')),
            // 'keyFilePath' => storage_path('app/' . env('BIGQUERY_KEY_FILE')),
        ]);

        $this->dataset = $this->bigQuery->dataset(env('BIGQUERY_DATASET'));
        $this->table = $this->dataset->table(env('BIGQUERY_TABLE'));
    }

    public function logProductView($productId, $userId = null)
    {
        try {
            $insertResponse = $this->table->insertRows([
                ['data' => [
                    'product_id' => $productId,
                    'user_id' => $userId,
                    'viewed_at' => now()->toDateTimeString(),
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->header('User-Agent'),
                ]],
            ]);

            if (! $insertResponse->isSuccessful()) {
                \Log::error('BigQuery insert failed', $insertResponse->failedRows());
            } else {
                // logger()->info('BigQuery insert succeeded');
            }
        } catch (GoogleException $e) {
            \Log::error('BigQuery error: '.$e->getMessage());
        }
    }

    public function getProductViewsBigQuery($limit = 10)
    {
        $query = sprintf(
            'SELECT * FROM `%s.%s.%s` ORDER BY viewed_at DESC LIMIT %d',
            env('BIGQUERY_PROJECT_ID'),
            env('BIGQUERY_DATASET'),
            env('BIGQUERY_TABLE'),
            $limit
        );

        $queryJob = $this->bigQuery->query($query);
        $results = $this->bigQuery->runQuery($queryJob);

        $data = [];
        foreach ($results as $row) {
            $data[] = (array) $row;
        }

        return $data;
    }
}
