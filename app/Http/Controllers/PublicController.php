<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Poster;
use App\Models\Video;
use App\Models\Category;

class PublicController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HOME
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $articles = Article::with('category')
            ->where('status', 'published')
            ->latest('published_at')
            ->take(6)
            ->get();

        $posters = Poster::with('category')
            ->where('status', 'published')
            ->latest('published_at')
            ->take(6)
            ->get();

        $videos = Video::with('category')
            ->where('status', 'published')
            ->latest('published_at')
            ->take(6)
            ->get();

        $categories = Category::latest()->get();

        return view('public.index', compact(
            'articles',
            'posters',
            'videos',
            'categories'
        ));

        
    }

    /*
    |--------------------------------------------------------------------------
    | ARTICLES - LIST PAGE
    |--------------------------------------------------------------------------
    */

   public function articles(Request $request)
{
    $categoryId = $request->category;
    $q = $request->q;
    $sort = $request->sort ?? 'latest';

    $articles = Article::with(['category', 'user'])
        ->where('status', 'published')

        ->when($q, function ($query) use ($q) {
            $query->where(function ($inner) use ($q) {
                $inner->where('title', 'like', "%{$q}%")
                      ->orWhere('content', 'like', "%{$q}%");
            });
        })

        ->when($categoryId, function ($query) use ($categoryId) {
            $query->where('category_id', $categoryId);
        })

        ->when($sort == 'popular', fn($q) => $q->orderByDesc('views'))
        ->when($sort == 'oldest', fn($q) => $q->oldest('published_at'), fn($q) => $q->latest('published_at'))

        ->paginate(9)
        ->withQueryString();

    $categories = Category::latest()->get();

    // 🔥 JIKA AJAX REQUEST → RETURN PARTIAL ONLY
    if ($request->ajax()) {
        return view('public.articles.partials.grid', compact('articles'))->render();
    }

    return view('public.articles.index', compact(
        'articles',
        'categories',
        'categoryId',
        'q',
        'sort'
    ));
}
                
    /*
    |--------------------------------------------------------------------------
    | ARTICLE DETAIL
    |--------------------------------------------------------------------------
    */

    public function articleShow($slug)
    {
        $article = Article::with('category')
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // RELATED ARTICLE (lebih relevan: berdasarkan kategori)
        $relatedArticles = Article::with('category')
            ->where('status', 'published')
            ->where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('public.articles.show', compact(
            'article',
            'relatedArticles'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | SEARCH
    |--------------------------------------------------------------------------
    */

    public function search(Request $request)
    {
        $q = $request->q;

        $articles = Article::with('category')
            ->where('status', 'published')
            ->where(function ($query) use ($q) {
                $query->where('title', 'like', "%{$q}%")
                      ->orWhere('content', 'like', "%{$q}%");
            })
            ->latest('published_at')
            ->paginate(12);

        $videos = Video::where('status', 'published')
            ->where('title', 'like', "%{$q}%")
            ->latest('published_at')
            ->paginate(12);

        $posters = Poster::where('status', 'published')
            ->where('title', 'like', "%{$q}%")
            ->latest('published_at')
            ->paginate(12);

        return view('public.search', compact(
            'q',
            'articles',
            'videos',
            'posters'
        ));
    }

    /*
|--------------------------------------------------------------------------
| POSTERS
|--------------------------------------------------------------------------
*/

public function posters()
{
    return view('public.posters.index');
}
    public function videos()
{
    return view('public.videos.index');
}
    
}
