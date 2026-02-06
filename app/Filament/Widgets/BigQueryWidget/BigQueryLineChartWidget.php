<?php

// My widget for Two top viewed product
// Fetch BigQuery data directly inside the Filament Chart

namespace App\Filament\Widgets\BigQueryWidget;

use App\Models\Product;
use App\Services\BigQuery\BigQueryService;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Widget;

class BigQueryLineChartWidget extends ChartWidget  // Widget
{
    protected static ?string $heading = 'BigQuery Two top viewed products Chart via direct fetch (BQ free tier ends) ';

    protected int|string|array $columnSpan = 12; // full width

    protected function getColumns(): int
    {
        return 1; // forces all widgets to use full width and stack vertically
    }

    protected function getData(): array
    {
        // Getting 2 top most viewed-
        $topTwoViewed = (new BigQueryService)->getTopViewedProducts(2);  // returns product_id, total_views only

        // Since we need product names, not only ID - Collect product IDs, since we want to add product name to array
        $topTwoViewed = collect($topTwoViewed);

        $productIdsTab2 = $topTwoViewed->pluck('product_id')->unique();

        // Fetch products from your database to get names
        $productsTab2 = Product::whereIn('id', $productIdsTab2)->get()->keyBy('id');

        // Merge product details into BigQuery views, adding product name
        $topTwoViewed = $topTwoViewed->map(function ($view) use ($productsTab2) {
            // $view['product_id'] = $view['product_id'] . ' - ' . ($productsTab2[$view['product_id']] ?? null);
            $view['product_id'] = 'ID: '.$view['product_id'].', Name: '.($productsTab2[$view['product_id']]->name ?? null);

            return $view;
        });

        // dd($topTwoViewed);

        return [
            'datasets' => [
                [
                    'label' => 'Views Count',
                    'data' => $topTwoViewed->pluck('total_views'),
                ],
            ],
            'labels' => $topTwoViewed->pluck('product_id'),
        ];
    }

    protected function getType(): string
    {
        return 'bar';  // line, pie, bar,
    }
}
