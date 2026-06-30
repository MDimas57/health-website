<?php

namespace App\Filament\Resources\CategoryBanners\Pages;

use App\Filament\Resources\CategoryBanners\CategoryBannerResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCategoryBanner extends CreateRecord
{
    protected static string $resource = CategoryBannerResource::class;

   protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Simpan user yang membuat banner
        $data['user_id'] = auth()->id();

        // Contributor otomatis menggunakan kategorinya sendiri
        if (auth()->user()->hasRole('contributor')) {
            $data['category_id'] = auth()->user()->category_id;
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}