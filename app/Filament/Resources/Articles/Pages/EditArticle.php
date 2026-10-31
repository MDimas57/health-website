<?php

namespace App\Filament\Resources\Articles\Pages;

use App\Filament\Resources\Articles\ArticleResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

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

        // Konversi Thumbnail Utama ke WebP jika ada
        if (!empty($data['thumbnail'])) {
            $data['thumbnail'] = $this->convertToWebpIfNeeded($data['thumbnail']);
        }

        // Konversi Gambar di dalam content_blocks Builder ke WebP jika ada
        if (!empty($data['content_blocks']) && is_array($data['content_blocks'])) {
            foreach ($data['content_blocks'] as &$block) {
                if (isset($block['type']) && $block['type'] === 'image' && !empty($block['data']['image'])) {
                    $block['data']['image'] = $this->convertToWebpIfNeeded($block['data']['image']);
                }
            }
            unset($block);
        }

        $data['content'] = $this->buildContentFromBlocks(
            $data['content_blocks'] ?? []
        );

        return $data;
    }

    /**
     * Helper privat untuk mengonversi file gambar ke format WebP
     */
    private function convertToWebpIfNeeded(?string $originalPath): ?string
    {
        if (!$originalPath || !Storage::disk('public')->exists($originalPath)) {
            return $originalPath;
        }

        $fullPath = Storage::disk('public')->path($originalPath);
        $extension = pathinfo($fullPath, PATHINFO_EXTENSION);

        // Jika sudah webp, abaikan
        if (strtolower($extension) === 'webp') {
            return $originalPath;
        }

        $imageResource = null;
        $extLower = strtolower($extension);

        if (in_array($extLower, ['jpg', 'jpeg'])) {
            $imageResource = @imagecreatefromjpeg($fullPath);
        } elseif ($extLower === 'png') {
            $imageResource = @imagecreatefrompng($fullPath);
        } elseif ($extLower === 'gif') {
            $imageResource = @imagecreatefromgif($fullPath);
        }

        if ($imageResource) {
            $newPath = preg_replace('/\.[^.]+$/', '.webp', $originalPath);
            $newFullPath = Storage::disk('public')->path($newPath);

            // Simpan ke webp dengan kualitas 80
            imagewebp($imageResource, $newFullPath, 80);
            imagedestroy($imageResource);

            // Hapus file lama non-webp
            if ($originalPath !== $newPath && Storage::disk('public')->exists($originalPath)) {
                Storage::disk('public')->delete($originalPath);
            }

            return $newPath;
        }

        return $originalPath;
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