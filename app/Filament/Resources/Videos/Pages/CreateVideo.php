<?php

namespace App\Filament\Resources\Videos\Pages;

use App\Filament\Resources\Videos\VideoResource;
use Filament\Resources\Pages\CreateRecord;

class CreateVideo extends CreateRecord
{
    protected static string $resource = VideoResource::class;

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