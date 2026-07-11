<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use App\Models\Document;
use App\Models\Poster;
use App\Models\Video;
use App\Models\note;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ContributorStatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        $user = auth()->user();

        $articles = Article::where('user_id', $user->id)->count();
        $posters = Poster::where('user_id', $user->id)->count();
        $videos = Video::where('user_id', $user->id)->count();
        $documents = Document::where('user_id', $user->id)->count();
        $notes = $user->notes()->count();

        $total = $articles + $posters + $videos + $documents + $notes;

        return [

            Stat::make('Total Konten', $total)
                ->description('Semua konten yang telah dibuat')
                ->descriptionIcon('heroicon-m-squares-2x2')
                ->color('primary')
                ->chart([4, 6, 8, 12, 15, 18, $total]),

            Stat::make('Artikel', $articles)
                ->description('Artikel yang dipublikasikan')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('success')
                ->chart([1, 2, 3, 4, 5, 6, $articles]),

            Stat::make('Poster', $posters)
                ->description('Poster kesehatan')
                ->descriptionIcon('heroicon-m-photo')
                ->color('warning')
                ->chart([1, 1, 2, 3, 3, 4, $posters]),

            Stat::make('Video', $videos)
                ->description('Video edukasi')
                ->descriptionIcon('heroicon-m-video-camera')
                ->color('danger')
                ->chart([1, 2, 2, 3, 4, 5, $videos]),

            Stat::make('Dokumen', $documents)
                ->description('Dokumen yang diunggah')
                ->descriptionIcon('heroicon-m-folder')
                ->color('info')
                ->chart([0, 1, 1, 2, 2, 3, $documents]),
            Stat::make('Catatan', $notes)
                ->description('Catatan kesehatan')
                ->descriptionIcon('heroicon-m-pencil-square')
                ->color('gray')
                ->chart([0,1,1,2,3,4,$notes]),

        ];
    }

    public static function canView(): bool
    {
        return auth()->check() &&
            auth()->user()->hasRole('contributor');
    }
}