<?php

// variant with custom view

namespace App\Filament\Widgets;

use App\Models\Owner;
use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Widget;

class MyCustomWidget2 extends StatsOverviewWidget  // Widget
{
    protected static string $view = 'filament.widgets.my-custom-widget';

    protected int|string|array $columnSpan = 2; // how wide it appears

    public int $totalUsers;

    public int $newUsers;

    public int $totalOwners;

    public Carbon $carbonDate;

    public function mount(): void
    {
        $this->totalUsers = User::count();
        $this->newUsers = User::where('created_at', '>=', now()->startOfWeek())->count();
        $this->totalOwners = Owner::count();
        $this->carbonDate = Carbon::now();
    }

    /*
    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::count())->color('success')->icon('heroicon-o-user-group'),
            Stat::make('New This Week', User::where('created_at', '>=', now()->startOfWeek())->count()),
            //Stat::make('Active Today', User::whereDate('last_login_at', Carbon::today())->count()),
        ];
    }
        */
}
