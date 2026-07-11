<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use App\Models\Category;
use App\Models\CategoryBanner;
use App\Models\Document;
use App\Models\Poster;
use App\Models\User;
use App\Models\Video;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        if (! auth()->user()->hasRole('super_admin')) {
            return [];
        }

        return [

            Stat::make('Artikel', Article::count())
                ->description('Total Artikel')
                ->descriptionIcon('heroicon-m-document-text')
                ->chart([7, 10, 8, 12, 15, 18, 20])
                ->color('success'),

            Stat::make('Poster', Poster::count())
                ->description('Total Poster')
                ->descriptionIcon('heroicon-m-photo')
                ->chart([3,5,8,7,10,12,15])
                ->color('warning'),

            Stat::make('Video', Video::count())
                ->description('Total Video')
                ->descriptionIcon('heroicon-m-play-circle')
                ->chart([1,3,4,6,8,10,11])
                ->color('info'),

            Stat::make('Dokumen', Document::count())
                ->description('Total Dokumen')
                ->descriptionIcon('heroicon-m-folder')
                ->chart([2,4,6,9,10,12,16])
                ->color('primary'),

            Stat::make('Kategori', Category::count())
                ->description('Kategori Kesehatan')
                ->descriptionIcon('heroicon-m-tag')
                ->color('gray'),

            Stat::make('Banner', CategoryBanner::count())
                ->description('Banner Hero')
                ->descriptionIcon('heroicon-m-photo')
                ->color('pink'),

            Stat::make(
                'Contributor',
                User::role('contributor')->count()
            )
                ->description('Pengguna Contributor')
                ->descriptionIcon('heroicon-m-users')
                ->color('warning'),

            Stat::make(
                'Total Download',
                number_format(Document::sum('download_count'))
            )
                ->description('Download Dokumen')
                ->descriptionIcon('heroicon-m-arrow-down-tray')
                ->color('success'),

        ];
    }

    protected function getColumns(): int
    {
        return 4;
    }
    protected static ?int $sort = 2;
}