<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Article;
use App\Models\Poster;
use App\Models\Video;
use App\Models\CategoryBanner;

class CategoryController extends Controller
{
    public function show(string $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $banner = CategoryBanner::where('category_id', $category->id)
            ->where('is_active', true)
            ->latest()
            ->first();

        $articles = Article::with('category')
            ->where('category_id', $category->id)
            ->published()
            ->latest('published_at')
            ->take(6)
            ->get();

        $posters = Poster::with('category')
            ->where('category_id', $category->id)
            ->published()
            ->latest('published_at')
            ->take(6)
            ->get();

        $videos = Video::with('category')
            ->where('category_id', $category->id)
            ->published()
            ->latest('published_at')
            ->take(6)
            ->get();

        return view(
            'public.categories.show',
            compact(
                'category',
                'banner',
                'articles',
                'posters',
                'videos'
            )
        );
    }
}