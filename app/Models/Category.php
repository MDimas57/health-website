<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
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
        'consultation_name',
        'consultation_phone',
    ];

    protected static function booted()
    {
        static::saving(function ($category) {
            if (!$category->image) {
                return;
            }

            // Foto diganti -> hapus file lama
            if ($category->isDirty('image')) {
                $old = $category->getOriginal('image');
                if ($old && $old !== $category->image) {
                    Storage::disk('public')->delete($old);
                }
            }

            // Foto baru ATAU foto lama (saat edit tanpa ganti foto) -> jadikan webp
            $category->image = self::convertToWebpIfNeeded($category->image);
        });

        static::deleting(function ($category) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
        });
    }

    /**
     * Konversi gambar ke WebP menggunakan GD.
     */
    private static function convertToWebpIfNeeded(?string $originalPath): ?string
    {
        if (!$originalPath || !Storage::disk('public')->exists($originalPath)) {
            return $originalPath;
        }

        $fullPath = Storage::disk('public')->path($originalPath);
        $extLower = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));

        // Sudah webp atau GD tidak mendukung webp
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

        // Perbaikan error "Palette image not supported by webp"
        if (!imageistruecolor($imageResource)) {
            imagepalettetotruecolor($imageResource);
        }
        imagealphablending($imageResource, true);
        imagesavealpha($imageResource, true);

        $newPath     = preg_replace('/\.[^.]+$/', '.webp', $originalPath);
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

    /**
     * Generate slug otomatis dari name
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

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

    public function banners()
    {
        return $this->hasMany(CategoryBanner::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}