<?php

// My widget for Two top viewed products
// Call your Laravel endpoint from the Filament widget (AJAX). Sanctum protected route
// Filament widgets cannot use Sanctum’s CSRF/session auth, as Sanctum can use CSRF + session auth — BUT ONLY IN A BROWSER.

namespace App\Filament\Widgets\BigQueryWidget;

use Filament\Widgets\ChartWidget;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Http;

class BigQueryLineAjaxChartWidget extends ChartWidget  // Widget
{
    public ?array $chartData = null;

    protected static ?string $heading = 'Working!!! BigQuery two top viewed products Chart via ajax, protected by Sanctum type 2 (BQ free tier ends)';

    protected int|string|array $columnSpan = 12; // full width

    protected function getColumns(): int
    {
        return 1; // forces all widgets to use full width and stack vertically
    }

    protected function getData(): array
    {
        if (! $this->chartData) {
            return [
                'labels' => [],
                'datasets' => [],
            ];
        }

        return [
            'labels' => collect($this->chartData)->pluck('product_id'), // $this->chartData['product_id']
            'datasets' => [
                [
                    'label' => 'Views',
                    'data' => collect($this->chartData)->pluck('total_views'), // $this->chartData['total_views'],
                ],
            ],
        ];
    }

    public function boot()
    {
        $this->loadData();
    }

    // Filament widgets cannot use Sanctum’s CSRF/session auth, as Sanctum can use CSRF + session auth — BUT ONLY IN A BROWSER.
    public function loadData()
    {
        $user = \App\Models\User::first();
        $token = $user->createToken('filament')->plainTextToken; //sanctum token
        $response = Http::withToken($token) /* Http::withToken(config('app.filament_api_token')) */ ->get('http://host.docker.internal:8000/api/bigquery/2topviewed');

        $this->chartData = $response->json();

        return;

        // route is Sanctum protected, type 2, via session, not access_token
        /*
        $csrfToken = csrf_token(); // XSRF token

        $response = Http::withHeaders([
        'X-XSRF-TOKEN' => $csrfToken,
    ])->withCookies([
        'laravel_session' => request()->cookie('laravel_session'),
        'XSRF-TOKEN'      => request()->cookie('XSRF-TOKEN'),
    ], '')
    ->get('http://host.docker.internal:8000/api/bigquery/2topviewed');

    $this->chartData = $response->json();
     return ;
    */

        // $this->chartData =  Http::get(route('api.bigquery.2topviewed'))->json();  //Http::get('/api/bigquery/2topviewed')->json();
        // $this->chartData = Http::get('http://host.docker.internal:8000/api/bigquery/2topviewed')->json(); //working

        $response = Http::get('http://host.docker.internal:8000/api/bigquery/2topviewed');

        // dd ($response->status());

        if ($response->status() === 401) {
            // Handle unauthorized case
            return 'Unauthorized request (401)';
            dd('Unauthorized request (401)');
        }

        $this->chartData = $response->json();

    }

    /*
     public function loadChartData()
     {
         $this->chartData = Http::get('/api/bigquery/2topviewed')->json();
     }
     */

    protected function getType(): string
    {
        return 'bar';  // line, pie, bar,
    }
}
