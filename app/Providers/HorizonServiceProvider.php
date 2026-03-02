<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Laravel\Horizon\Horizon;
use Laravel\Horizon\HorizonApplicationServiceProvider;

class HorizonServiceProvider extends HorizonApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        parent::boot();

        // Horizon::routeSmsNotificationsTo('15556667777');
        // Horizon::routeMailNotificationsTo('example@example.com');
        // Horizon::routeSlackNotificationsTo('slack-webhook-url', '#channel');
    }

    /**
     * Register the Horizon gate.
     *
     * This gate determines who can access Horizon in non-local environments.
     */
    protected function gate(): void
    {
        // allow users to view horizont on live production
        $allowed = explode(',', config('services.horizon.allowed_emails', ''));  // from env  //env('HORIZON_ALLOWED_EMAILS', '')

        Gate::define('viewHorizon', function ($user = null) use ($allowed) {
            return in_array(optional($user)->email, $allowed);
        });
    }
}
