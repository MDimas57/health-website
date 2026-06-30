<?php

namespace App\Filament\Resources\CategoryBanners\Pages;

use App\Filament\Resources\CategoryBanners\CategoryBannerResource;
use Filament\Resources\Pages\EditRecord;

class EditCategoryBanner extends EditRecord
{
    protected static string $resource = CategoryBannerResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Contributor tidak boleh mengubah kategori
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