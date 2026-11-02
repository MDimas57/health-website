<?php
// app/Models/Consultation.php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Consultation extends Model
{
    protected $fillable = [
        'topic',
        'officer_name',
        'photo',
        'bio',
        'phone',
        'is_active',
        'sort_order',
    ];

    protected $casts = ['is_active' => 'boolean'];

    protected $appends = ['photo_url'];

    protected static function booted()
    {
        static::saving(function ($consultation) {
            if ($consultation->isDirty('photo') && $consultation->photo) {
                $consultation->photo = self::convertToWebpIfNeeded($consultation->photo);
            }
        });

        // Hapus file foto saat data dihapus
        static::deleted(function ($consultation) {
            if ($consultation->photo) {
                Storage::disk('public')->delete($consultation->photo);
            }
        });
    }

    protected function photoUrl(): Attribute
    {
        return Attribute::get(fn () => $this->photo
            ? Storage::disk('public')->url($this->photo)
            : null);
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

        if (!imageistruecolor($imageResource)) {
            imagepalettetotruecolor($imageResource);
        }
        imagealphablending($imageResource, true);
        imagesavealpha($imageResource, true);

        // Batasi lebar maksimal 800px agar ringan
        if (imagesx($imageResource) > 800) {
            $scaled = imagescale($imageResource, 800);
            if ($scaled) {
                imagedestroy($imageResource);
                $imageResource = $scaled;
            }
        }

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
}