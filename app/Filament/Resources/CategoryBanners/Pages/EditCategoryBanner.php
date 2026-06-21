<?php

namespace App\Filament\Resources\CategoryBanners\Pages;

use App\Filament\Resources\CategoryBanners\CategoryBannerResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCategoryBanner extends EditRecord
{
    protected static string $resource = CategoryBannerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
