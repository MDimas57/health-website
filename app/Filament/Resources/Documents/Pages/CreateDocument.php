<?php

namespace App\Filament\Resources\Documents\Pages;

use App\Filament\Resources\Documents\DocumentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDocument extends CreateRecord
{
    protected static string $resource = DocumentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        if (auth()->user()->hasRole('contributor')) {
            $data['category_id'] = auth()->user()->category_id;
        };

        if ($data['status'] === 'published') {
            $data['published_at'] = now();
        }

        return $data;
    }
     protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}