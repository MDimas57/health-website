<?php

namespace App\Filament\Resources\Articles\Pages;

use App\Filament\Resources\Articles\ArticleResource;
use Filament\Resources\Pages\EditRecord;

class EditArticle extends EditRecord
{
    protected static string $resource = ArticleResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Contributor tidak boleh mengubah kategori
        if (auth()->user()->hasRole('contributor')) {
            $data['category_id'] = auth()->user()->category_id;
        }

        // Isi published_at jika artikel dipublish pertama kali
        if (
            $data['status'] === 'published' &&
            $this->record->published_at === null
        ) {
            $data['published_at'] = now();
        }

        $data['content'] = $this->buildContentFromBlocks(
            $data['content_blocks'] ?? []
        );

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    protected function buildContentFromBlocks(array $blocks): string
    {
        $content = '';

        foreach ($blocks as $block) {
            if (($block['type'] ?? null) === 'paragraph') {
                $content .= ($block['data']['text'] ?? '') . PHP_EOL . PHP_EOL;
            }
        }

        return trim($content);
    }
}