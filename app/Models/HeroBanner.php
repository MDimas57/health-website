<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class HeroBanner extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'button_text',
        'button_link',
        'image',
        'is_active',
        'sort_order',
        'user_id',
    ];

    protected static function booted()
    {
        static::saving(function ($banner) {
            if ($banner->isDirty('image') && $banner->image) {
                $banner->image = self::convertToWebpIfNeeded($banner->image);
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}