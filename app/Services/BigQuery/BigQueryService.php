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

    // Tab 1: getting Last 5 viewed products
    // get last viewed products, i,e last 5 or 10 by default
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

    /**
     * //Tab 2: Getting 2 top most viewed
     * Retrieves the top N most frequently viewed products from the BigQuery log.
     *
     * @param  int  $limit  The number of top products to retrieve (default is 2).
     * @return array An array of results, each containing 'product_id' and 'total_views'.
     */
    public function getTopViewedProducts($limit = 2)
    {
        // SQL to count product views, group by product, order by count, and limit the result.
        $query = sprintf(
            'SELECT product_id, COUNT(product_id) AS total_views FROM `%s.%s.%s` GROUP BY product_id ORDER BY total_views DESC LIMIT %d',
            env('BIGQUERY_PROJECT_ID'), // Your Google Cloud Project ID
            env('BIGQUERY_DATASET'),    // The BigQuery Dataset Name
            env('BIGQUERY_TABLE'),      // The BigQuery Table Name (e.g., 'product_views_log')
            $limit
        );

        // 1. Execute the query using your BigQuery client instance
        // Assuming $this->bigQuery is correctly set up to handle the query execution
        try {
            // Note: The bigQuery->query() and runQuery() syntax is based on your example,
            // but might vary slightly depending on the exact Google Cloud PHP library version used.
            $queryJob = $this->bigQuery->query($query);
            $results = $this->bigQuery->runQuery($queryJob);
        } catch (\Exception $e) {
            // Handle exceptions (e.g., table not found, authentication error)
            error_log('BigQuery Query failed: '.$e->getMessage());

            return [];
        }

        // 2. Process the results into a standard PHP array
        $data = [];
        foreach ($results as $row) {
            // Explicitly cast to array if the result object supports it,
            // or access properties directly if it's an object (e.g., $row->product_id)
            $data[] = (array) $row;
        }

        return $data;
    }
}
