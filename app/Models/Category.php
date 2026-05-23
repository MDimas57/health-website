<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Category extends Model
{
    use HasSlug;

      protected $fillable = [
        'name',
        'slug',
        'image',
        'color',
        'description',
    ];

    /**
     * Generate slug otomatis dari name
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    /**
     * Relasi ke posts
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function posters()
    {
        return $this->hasMany(Poster::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }
}