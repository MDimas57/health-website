<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Category;
use Illuminate\Support\Facades\View;
use App\Models\Post;
use App\Observers\CategoryObserver;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
    
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Category::observe(CategoryObserver::class);
        View::composer('layouts.public', function ($view) {
        $view->with('navCategories', Category::orderBy('name')->get());
         });
        View::composer('partials.navbar', function ($view) {
            $view->with('navCategories', Category::orderBy('name')->get());
        });

        // Atau kalau pakai component:
        View::composer('components.layout.navbar', function ($view) {
            $view->with('navCategories', Category::orderBy('name')->get());
        });
        View::composer('*', function ($view) {

        $footerRecentPosts = Post::published()
            ->latest('published_at')
            ->take(4)
            ->get();

        $view->with('footerRecentPosts', $footerRecentPosts);
    });
    }
}
