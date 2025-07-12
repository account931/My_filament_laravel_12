<?php

// variant without custom view

namespace App\Filament\Widgets;

use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Widget;

class MyCustomWidget extends StatsOverviewWidget  // Widget
{
    // protected static string $view = 'filament.widgets.my-custom-widget';  //no view if dont neede it, like here

    protected int|string|array $columnSpan = 1; // how wide it appears

    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::count())->color('success')->icon('heroicon-o-user-group'),
            Stat::make('New Users This Week', User::where('created_at', '>=', now()->startOfWeek())->count()),
            // Stat::make('Active Today', User::whereDate('last_login_at', Carbon::today())->count()),
        ];
    }
}
