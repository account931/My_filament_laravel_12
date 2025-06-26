<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Tables\Columns\TextColumn; //use to create custom method for TextInput
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
        //Add my custom Filament TextColumn method, can use as ->myCustomDisplay()
         TextColumn::macro('myCustomDisplay', function () {
            return $this->formatStateUsing(function ($state) {
                //$state = preg_replace('/[^a-z0-9]+/i', ' ', $state);
                //$state = ucwords(strtolower($state));
                //$state = str_replace(' ', '', $state);
                //return lcfirst($state);
                return $state .  ' (cstm)' ;
           });
        });
        //End Add my custom Filament TextColumn method, can use as ->myCustomDisplay()
    }
}
