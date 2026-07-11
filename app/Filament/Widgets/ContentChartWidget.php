<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use App\Models\Poster;
use App\Models\Video;
use App\Models\Document;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class ContentChartWidget extends ChartWidget
{
    protected ?string $heading = 'Statistik Upload Konten';

    protected ?string $description = '30 Hari Terakhir';

    protected static ?int $sort = 4;

    protected function getData(): array
    {
        $labels = [];

        $articles = [];
        $posters = [];
        $videos = [];
        $documents = [];

        for ($i = 29; $i >= 0; $i--) {

            $date = Carbon::now()->subDays($i);

            $labels[] = $date->format('d M');

            $articles[] = Article::whereDate('created_at', $date)->count();

            $posters[] = Poster::whereDate('created_at', $date)->count();

            $videos[] = Video::whereDate('created_at', $date)->count();

            $documents[] = Document::whereDate('created_at', $date)->count();
        }

        return [

            'datasets' => [

                [
                    'label' => 'Artikel',
                    'data' => $articles,
                    'borderColor' => '#10B981',
                    'backgroundColor' => 'rgba(16,185,129,.15)',
                    'tension' => .4,
                ],

                [
                    'label' => 'Poster',
                    'data' => $posters,
                    'borderColor' => '#F59E0B',
                    'backgroundColor' => 'rgba(245,158,11,.15)',
                    'tension' => .4,
                ],

                [
                    'label' => 'Video',
                    'data' => $videos,
                    'borderColor' => '#3B82F6',
                    'backgroundColor' => 'rgba(59,130,246,.15)',
                    'tension' => .4,
                ],

                [
                    'label' => 'Dokumen',
                    'data' => $documents,
                    'borderColor' => '#8B5CF6',
                    'backgroundColor' => 'rgba(139,92,246,.15)',
                    'tension' => .4,
                ],

            ],

            'labels' => $labels,

        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
    protected function getOptions(): array
{
    return [

        'plugins' => [

            'legend' => [

                'position' => 'bottom',

            ],

        ],

        'elements' => [

            'line' => [

                'borderWidth' => 3,

            ],

            'point' => [

                'radius' => 4,

                'hoverRadius' => 7,

            ],

        ],

        'scales' => [

            'y' => [

                'beginAtZero' => true,

            ],

        ],

    ];
}

    public static function canView(): bool
    {
        return auth()->user()?->hasRole('super_admin');
    }
}