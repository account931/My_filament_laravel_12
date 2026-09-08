<?php

namespace App\Providers;

use App\Services\PrometheusStorage\PrometheusStorageService;
// use to create custom method for TextInput
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Prometheus\Storage\Redis as PrometheusRedis;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // register PrometheusStorageService as a singleton, so Laravel can resolve PrometheusRedis anywhere through dependency injection.
        // call as $storage = $this->storage; //when have dependency injection in constructor only => construct(private PrometheusRedis $storage,)
        // Or $storage = app(PrometheusRedis::class); //when you need it somewhere without dependency injection in constructor
        $this->app->singleton(PrometheusRedis::class, function () {
            return app(PrometheusStorageService::class)->make();
        });
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // fix test
        /*
        if (App::environment('testing')) {
            // Prevent Vite from being loaded during tests
             Vite::useHotFile(public_path('fake-hot'));
        }
        */

        // Add my custom Filament TextColumn method, can use as ->myCustomDisplay()
        TextColumn::macro('myCustomDisplay', function () {
            return $this->formatStateUsing(function ($state) {
                // $state = preg_replace('/[^a-z0-9]+/i', ' ', $state);
                // $state = ucwords(strtolower($state));
                // $state = str_replace(' ', '', $state);
                // return lcfirst($state);
                return $state.' (formatStateUsing)';
            });
        });
        // End Add my custom Filament TextColumn method, can use as ->myCustomDisplay()

        // fix for Render.com, Force HTTPS in Laravel (important on Render)
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
        // End fix for Render.com

        // set inertia root blade view. Was trying to set it in App\Http/Middleware/HandleInertiaRequests.php but no effect
        Inertia::setRootView('inertia.InertiaBladeMainRootView.app'); // path is resources/views/inertia/InertiaBladeMainRootView/app.blade.php

    }
}
