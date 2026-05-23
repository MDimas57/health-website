<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Post extends Model
{
    use HasSlug;

    protected $fillable = [
        'user_id', 'category_id', 'title', 'slug', 'type',
        'content', 'thumbnail', 'youtube_url', 'poster_file',
        'status', 'published_at', 'views',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Ambil YouTube embed ID dari URL
    public function getYoutubeIdAttribute(): ?string
    {
        if (!$this->youtube_url) return null;
        preg_match('/(?:v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $this->youtube_url, $m);
        return $m[1] ?? null;
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}