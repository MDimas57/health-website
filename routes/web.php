<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/

Route::get('/', [PublicController::class, 'index'])
    ->name('home');


/*
|--------------------------------------------------------------------------
| ARTICLES
|--------------------------------------------------------------------------
*/

Route::get('/articles', [PublicController::class, 'articles'])
    ->name('articles.index');

Route::get('/articles/{slug}', [PublicController::class, 'articleShow'])
    ->name('articles.show');


/*
|--------------------------------------------------------------------------
| POSTERS
|--------------------------------------------------------------------------
*/

Route::get('/posters', [PublicController::class, 'posters'])
    ->name('posters.index');

Route::get('/posters/{slug}', [PublicController::class, 'posterShow'])
    ->name('posters.show');


/*
|--------------------------------------------------------------------------
| VIDEOS
|--------------------------------------------------------------------------
*/

Route::get('/videos', [PublicController::class, 'videos'])
    ->name('videos.index');

Route::get('/videos/{slug}', [PublicController::class, 'videoShow'])
    ->name('videos.show');


/*
|--------------------------------------------------------------------------
| CATEGORY
|--------------------------------------------------------------------------
*/

Route::get('/kategori/{slug}', [PublicController::class, 'category'])
    ->name('category.show');


/*
|--------------------------------------------------------------------------
| SEARCH
|--------------------------------------------------------------------------
*/

Route::get('/cari', [PublicController::class, 'search'])
    ->name('search');

Route::get('/articles/api', [PublicController::class, 'articlesApi']);

Route::get('/posters', [PublicController::class, 'posters'])
    ->name('posters.index');
Route::get('/videos', [PublicController::class, 'videos'])
    ->name('videos.index');