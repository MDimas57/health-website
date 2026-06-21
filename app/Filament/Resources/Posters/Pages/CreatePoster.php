<?php

namespace App\Filament\Resources\Posters\Pages;

use App\Filament\Resources\Posters\PosterResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePoster extends CreateRecord
{
    protected static string $resource = PosterResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['category_id'] = auth()->user()->category_id;
        $data['user_id'] = auth()->id();

        if ($data['status'] === 'published') {
            $data['published_at'] = now();
        }

        return $data;
    }
}