<?php

namespace App\Filament\Resources\CategoryBanners\Pages;

use App\Filament\Resources\CategoryBanners\CategoryBannerResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCategoryBanners extends ListRecords
{
    protected static string $resource = CategoryBannerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
