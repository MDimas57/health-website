<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Article;
use App\Models\Poster;
use App\Models\Video;

class LatestContentSection extends Component
{
    public $featuredContent;
    public $featuredPosters;
    public $latestPosts;

    public function mount()
    {
        /*
        |--------------------------------------------------------------------------
        | ARTICLE + VIDEO
        |--------------------------------------------------------------------------
        */

        $articles = Article::with('category')
            ->where('status', 'published')
            ->get()
            ->map(function ($item) {
                $item->content_type = 'article';
                return $item;
            });

        $videos = Video::with('category')
            ->where('status', 'published')
            ->get()
            ->map(function ($item) {
                $item->content_type = 'video';
                return $item;
            });

        /*
        |--------------------------------------------------------------------------
        | ALL CONTENTS
        |--------------------------------------------------------------------------
        */

        $allContents = $articles
            ->merge($videos)
            ->sortByDesc(function ($item) {
                return $item->published_at;
            })
            ->values();

        /*
        |--------------------------------------------------------------------------
        | FEATURED CONTENT
        |--------------------------------------------------------------------------
        */

        $this->featuredContent = $allContents->first();

        /*
        |--------------------------------------------------------------------------
        | LATEST POSTS
        |--------------------------------------------------------------------------
        */

        $this->latestPosts = $allContents
            ->skip(1)
            ->take(3);

        /*
        |--------------------------------------------------------------------------
        | FEATURED POSTERS
        |--------------------------------------------------------------------------
        */

        $this->featuredPosters = Poster::with('category')
            ->where('status', 'published')
            ->latest('published_at')
            ->take(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.latest-content-section');
    }
}