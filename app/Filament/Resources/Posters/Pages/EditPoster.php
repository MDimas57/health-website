<?php

namespace App\Filament\Resources\Posters\Pages;

use App\Filament\Resources\Posters\PosterResource;
use Filament\Resources\Pages\EditRecord;

class EditPoster extends EditRecord
{
    protected static string $resource = PosterResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Contributor tidak boleh mengubah kategori
        if (auth()->user()->hasRole('contributor')) {
            $data['category_id'] = auth()->user()->category_id;
        }

        // Jika status berubah menjadi published dan belum memiliki tanggal publish
        if (
            $data['status'] === 'published' &&
            $this->record->published_at === null
        ) {
            $data['published_at'] = now();
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}