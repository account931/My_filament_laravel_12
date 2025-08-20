<?php

namespace App\Providers\Filament;

use Althinect\FilamentSpatieRolesPermissions\FilamentSpatieRolesPermissionsPlugin;
use App\Filament\Widgets\MyCustomWidget;
use App\Filament\Widgets\MyCustomWidget2;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken; // filament-spatie-roles-permissions  GUI plugin
use Illuminate\Routing\Middleware\SubstituteBindings;  // my custom link
use Illuminate\Session\Middleware\StartSession;  // my custom widget
use Illuminate\View\Middleware\ShareErrorsFromSession;  // my custom widget

class Admin1PanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel

            // my custom link to go back to laravel
            ->navigationItems([
                NavigationItem::make('Go back to Laravel')
                    ->url('/dashboard') // or route('your.route.name')
                    ->icon('heroicon-o-link')
                    ->badge('Go Home'),
                // ->openUrlInNewTab(), // optional
            ])
            // end my custom link

            ->default()
            ->id('1')
            ->path('admin')  // !!!!!fix was here, got 404 on /admin
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets') // automatic widget discovery, even if comment MyCustomWidget
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
                MyCustomWidget::class,  // my custom widget without view
                MyCustomWidget2::class,  // my custom widget with view

            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            // add filament-spatie-roles-permissions  GUI plugin
            ->plugin(FilamentSpatieRolesPermissionsPlugin::make())

            // Ordering navigation groups
            ->navigationGroups([
                'Section Main',
                'User section',
                'Shop',
                'Settings',
            ]);
    }
}
