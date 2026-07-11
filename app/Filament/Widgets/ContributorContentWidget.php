<?php

namespace App\Filament\Widgets;
use filament\Widgets\StatsOverviewWidget;
use filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use Filament\Widgets\Widget;

class ContributorContentWidget extends Widget
{
    protected string $view = 'filament.widgets.contributor-content-widget';

    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

    protected function getViewData(): array
    {
        $contributors = User::role('contributor')
            ->withCount([
                'articles',
                'posters',
                'videos',
                'documents',
                'notes'
            ])
            ->get()
            ->map(function ($user) {

                $user->total_content =
                    $user->articles_count +
                    $user->posters_count +
                    $user->videos_count +
                    $user->documents_count +
                    $user->notes_count;

                return $user;

            })
            ->sortByDesc('total_content');

        return compact('contributors');
    }

    public static function canView(): bool
    {
        return auth()->user()?->hasRole('super_admin');
    }
    
}