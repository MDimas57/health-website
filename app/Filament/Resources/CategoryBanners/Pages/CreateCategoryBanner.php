<?php

namespace App\Filament\Resources\CategoryBanners\Pages;

use App\Filament\Resources\CategoryBanners\CategoryBannerResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCategoryBanner extends CreateRecord
{
    protected static string $resource = CategoryBannerResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['category_id'] = auth()->user()->category_id;
        $data['user_id'] = auth()->id();

        return $data;
    }
}
