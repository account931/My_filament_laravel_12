<?php

namespace App\Providers;

use Filament\Tables\Columns\TextColumn;
// use to create custom method for TextInput
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
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

    }
}
