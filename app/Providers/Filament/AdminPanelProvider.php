<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Filament\Widgets\WelcomeWidget;
use App\Filament\Widgets\AdminStatsOverview;
use App\Filament\Widgets\ContributorStatsOverview;
// use App\Filament\Widgets\ArticleChart;
// use App\Filament\Widgets\LatestArticles;
// use App\Filament\Widgets\LatestPosters;
// use App\Filament\Widgets\LatestVideos;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()

            ->id('admin')

            ->path('admin')
            ->viteTheme('resources/css/filament/admin/theme.css')

            ->login()

            ->colors([
                'primary' => Color::Teal,
            ])

            // Auto discover resource
            ->discoverResources(
                in: app_path('Filament/Resources'),
                for: 'App\\Filament\\Resources'
            )

            // Auto discover pages
            ->discoverPages(
                in: app_path('Filament/Pages'),
                for: 'App\\Filament\\Pages'
            )

            // Dashboard
            ->pages([
                Dashboard::class,
            ])

            // Auto discover widgets
            ->discoverWidgets(
                in: app_path('Filament/Widgets'),
                for: 'App\\Filament\\Widgets'
            )

            // Widget dashboard
            ->widgets([

                WelcomeWidget::class,

                AdminStatsOverview::class,

                ContributorStatsOverview::class,

                // ArticleChart::class,

                // LatestArticles::class,

                // LatestPosters::class,

                // LatestVideos::class,

            ])
            // Navigation Group
            ->navigationGroups([
                'Konten',
                'Master Data',
                'Pengaturan',
            ])

            // Middleware
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])

            // Auth Middleware
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}