<?php

namespace App\Filament\Resources\Posters\Pages;

use App\Filament\Resources\Posters\PosterResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePoster extends CreateRecord
{
    protected static string $resource = PosterResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Contributor otomatis menggunakan kategorinya sendiri
        if (auth()->user()->hasRole('contributor')) {
            $data['category_id'] = auth()->user()->category_id;
        }

        // Simpan user yang membuat poster
        $data['user_id'] = auth()->id();

        if ($data['status'] === 'published') {
            $data['published_at'] = now();
        }

        return $data;
    }
    protected function getRedirectUrl(): string
    {
        return PosterResource::getUrl('index');
    }
}