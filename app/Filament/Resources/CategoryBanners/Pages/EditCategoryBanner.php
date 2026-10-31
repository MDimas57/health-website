<?php

namespace App\Filament\Resources\CategoryBanners\Pages;

use App\Filament\Resources\CategoryBanners\CategoryBannerResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditCategoryBanner extends EditRecord
{
    protected static string $resource = CategoryBannerResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Contributor tidak boleh mengubah kategori
        if (auth()->user()->hasRole('contributor')) {
            $data['category_id'] = auth()->user()->category_id;
        }

        // Cek apakah ada file gambar yang tersimpan dan belum berformat webp
        if (!empty($data['image'])) {
            $originalPath = $data['image'];

            // Pastikan filenya ada di storage disk public
            if (Storage::disk('public')->exists($originalPath)) {
                $fullPath = Storage::disk('public')->path($originalPath);
                $extension = pathinfo($fullPath, PATHINFO_EXTENSION);

                // Jika ekstensinya belum webp, konversi sekarang
                if (strtolower($extension) !== 'webp') {
                    $imageResource = null;

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

                        // Simpan sebagai webp dengan kualitas 80
                        imagewebp($imageResource, $newFullPath, 80);
                        imagedestroy($imageResource);

                        // Hapus file lama yang berformat non-webp
                        Storage::disk('public')->delete($originalPath);

                        // Timpa data image yang akan disimpan ke database menjadi path .webp
                        $data['image'] = $newPath;
                    }
                }
            }
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}