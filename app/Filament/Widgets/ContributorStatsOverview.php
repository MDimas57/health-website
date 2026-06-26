<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Article;
use App\Models\Poster;
use App\Models\Video;

class ContributorStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
    $user = auth()->user();

        return [

            Stat::make(
                'Artikel Saya',
                Article::where('user_id',$user->id)->count()
            ),

            Stat::make(
                'Poster Saya',
                Poster::where('user_id',$user->id)->count()
            ),

            Stat::make(
                'Video Saya',
                Video::where('user_id',$user->id)->count()
            ),

        ];
    }
    public static function canView(): bool
{
    return auth()->user()->hasRole('contributor');
}
protected static ?int $sort = 2;
}
