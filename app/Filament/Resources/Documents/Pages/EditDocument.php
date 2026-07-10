<?php

namespace App\Filament\Resources\Documents\Pages;

use App\Filament\Resources\Documents\DocumentResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditDocument extends EditRecord
{
    protected static string $resource = DocumentResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (
            $data['status'] === 'published'
            && blank($this->record->published_at)
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
