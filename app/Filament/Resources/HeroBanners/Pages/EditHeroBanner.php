<?php

namespace App\Filament\Resources\HeroBanners\Pages;

use App\Filament\Resources\HeroBanners\HeroBannerResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditHeroBanner extends EditRecord
{
    protected static string $resource = HeroBannerResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Cek apakah ada file gambar tersimpan dan belum webp
        if (!empty($data['image'])) {
            $originalPath = $data['image'];

            if (Storage::disk('public')->exists($originalPath)) {
                $fullPath = Storage::disk('public')->path($originalPath);
                $extension = pathinfo($fullPath, PATHINFO_EXTENSION);

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
                        $newPath = preg_replace('/\.[^.]+$/', '.webp', $originalPath);
                        $newFullPath = Storage::disk('public')->path($newPath);

                        imagewebp($imageResource, $newFullPath, 80);
                        imagedestroy($imageResource);

                        Storage::disk('public')->delete($originalPath);

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