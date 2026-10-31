<?php

namespace App\Filament\Resources\Articles\Pages;

use App\Filament\Resources\Articles\ArticleResource;
use Filament\Resources\Pages\CreateRecord;

class CreateArticle extends CreateRecord
{
    protected static string $resource = ArticleResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Contributor otomatis menggunakan kategorinya sendiri
        if (auth()->user()->hasRole('contributor')) {
            $data['category_id'] = auth()->user()->category_id;
        }

        // Simpan user pembuat artikel
        $data['user_id'] = auth()->id();

        // Isi tanggal publish jika langsung dipublish
        if ($data['status'] === 'published') {
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

            switch ($block['type']) {

                case 'paragraph':
                    $content .= ($block['data']['text'] ?? '') . PHP_EOL . PHP_EOL;
                    break;

            }

        }

        return trim($content);
    }
}