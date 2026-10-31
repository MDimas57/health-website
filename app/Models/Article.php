<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Article extends Model
{
    use HasFactory, HasSlug, SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | TABLE
    |--------------------------------------------------------------------------
    */

    protected $table = 'articles';

    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'content',
        'content_blocks',
        'thumbnail',
        'status',
        'published_at',
        'views',
        'is_featured',
    ];

    /*
    |--------------------------------------------------------------------------
    | CASTS
    |--------------------------------------------------------------------------
    */

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'content_blocks' => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | BOOTED (Webดิน Converter Otomatis)
    |--------------------------------------------------------------------------
    */

    protected static function booted()
    {
        static::saving(function ($article) {
            // 1. Konversi Thumbnail Utama ke WebP
            if ($article->thumbnail) {
                $article->thumbnail = self::convertToWebpIfNeeded($article->thumbnail);
            }

            // 2. Konversi Gambar di dalam Builder (content_blocks) ke WebP
            $blocks = $article->content_blocks;
            if (is_array($blocks)) {
                $updated = false;
                foreach ($blocks as &$block) {
                    if (isset($block['type']) && $block['type'] === 'image' && !empty($block['data']['image'])) {
                        $originalImage = $block['data']['image'];
                        $newImage = self::convertToWebpIfNeeded($originalImage);
                        if ($newImage !== $originalImage) {
                            $block['data']['image'] = $newImage;
                            $updated = true;
                        }
                    }
                }
                unset($block);

                if ($updated) {
                    $article->content_blocks = $blocks;
                }
            }
        });
    }

    /**
     * Helper privat untuk mengonversi gambar ke format WebP menggunakan GD Library
     */
   private static function convertToWebpIfNeeded(?string $originalPath): ?string
        {
            if (!$originalPath || !Storage::disk('public')->exists($originalPath)) {
                return $originalPath;
            }

            $fullPath = Storage::disk('public')->path($originalPath);
            $extLower = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));

            if ($extLower === 'webp' || !function_exists('imagewebp')) {
                return $originalPath;
            }

            $imageResource = match ($extLower) {
                'jpg', 'jpeg' => @imagecreatefromjpeg($fullPath),
                'png'         => @imagecreatefrompng($fullPath),
                'gif'         => @imagecreatefromgif($fullPath),
                default       => false,
            };

            if (!$imageResource) {
                return $originalPath;
            }

            // Penyebab error: PNG palette (indexed) harus diubah ke true color
            if (!imageistruecolor($imageResource)) {
                imagepalettetotruecolor($imageResource);
            }
            imagealphablending($imageResource, true);
            imagesavealpha($imageResource, true);

            $newPath = preg_replace('/\.[^.]+$/', '.webp', $originalPath);
            $newFullPath = Storage::disk('public')->path($newPath);

            $saved = @imagewebp($imageResource, $newFullPath, 80);
            imagedestroy($imageResource);

            // File asli hanya dihapus jika konversi berhasil
            if ($saved && file_exists($newFullPath) && $originalPath !== $newPath) {
                Storage::disk('public')->delete($originalPath);
                return $newPath;
            }

            return $originalPath;
        }

    /*
    |--------------------------------------------------------------------------
    | SLUG
    |--------------------------------------------------------------------------
    */

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeArchived($query)
    {
        return $query->where('status', 'archived');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail
            ? asset('storage/' . $this->thumbnail)
            : asset('images/default-thumbnail.jpg');
    }
}