<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Althinect\FilamentSpatieRolesPermissions\FilamentSpatieRolesPermissionsPlugin; //filament-spatie-roles-permissions  GUI plugin
use Filament\Navigation\NavigationItem;  //my custom link
use App\Filament\Widgets\MyCustomWidget;  //my custom widget
use App\Filament\Widgets\MyCustomWidget2;  //my custom widget

class Admin1PanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            
            //my custom link to go back to laravel
            ->navigationItems([
                NavigationItem::make('Go back to Laravel')
                    ->url('/dashboard') // or route('your.route.name')
                    ->icon('heroicon-o-link')
                    //->openUrlInNewTab(), // optional
            ])
            // end my custom link

            ->default()
            ->id('1')
            ->path('admin')  //!!!!!
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
                MyCustomWidget::class,  //my custom widget without view
                MyCustomWidget2::class,  //my custom widget with view

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
            //add filament-spatie-roles-permissions  GUI plugin
            ->plugin(FilamentSpatieRolesPermissionsPlugin::make())

            //Ordering navigation groups
            ->navigationGroups([
               'Section Main',
               'User section',
               'Settings',
            ]);
    }
}
