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
            // Cek apakah field image berubah / ada file baru yang diunggah
            if ($banner->isDirty('image')) {
                $originalPath = $banner->image;

                if ($originalPath && Storage::disk('public')->exists($originalPath)) {
                    $fullPath = Storage::disk('public')->path($originalPath);
                    
                    // Pastikan file bukan sudah berformat webp
                    $extension = pathinfo($fullPath, PATHINFO_EXTENSION);
                    if (strtolower($extension) !== 'webp') {
                        $imageResource = null;
                        
                        // Buat resource gambar berdasarkan ekstensi aslinya
                        if (in_array(strtolower($extension), ['jpg', 'jpeg'])) {
                            $imageResource = @imagecreatefromjpeg($fullPath);
                        } elseif (strtolower($extension) === 'png') {
                            $imageResource = @imagecreatefrompng($fullPath);
                        } elseif (strtolower($extension) === 'gif') {
                            $imageResource = @imagecreatefromgif($fullPath);
                        }

                        if ($imageResource) {
                            // Tentukan path baru dengan ekstensi .webp
                            $newPath = preg_replace('/\.[^.]+$/', '.webp', $originalPath);
                            $newFullPath = Storage::disk('public')->path($newPath);

                            // Simpan gambar ke format webp dengan kualitas 80
                            imagewebp($imageResource, $newFullPath, 80);
                            imagedestroy($imageResource);

                            // Hapus file lama yang aslinya (jpg/png/gif)
                            Storage::disk('public')->delete($originalPath);

                            // Update nilai path di database menjadi .webp
                            $banner->image = $newPath;
                        }
                    }
                }
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}