<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Article;
use App\Models\Poster;
use App\Models\Video;
use App\Models\Category;
use App\Models\User;

class AdminStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
{
    return [
        Stat::make('Artikel', Article::count()),
        Stat::make('Poster', Poster::count()),
        Stat::make('Video', Video::count()),
        Stat::make('Kategori', Category::count()),
        Stat::make('Contributor', User::role('contributor')->count()),
    ];
}
public static function canView(): bool
{
    return auth()->user()->hasRole('super_admin');
}
protected static ?int $sort = 2;
}
