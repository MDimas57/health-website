<?php

namespace App\Filament\Resources\HeroBanners\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;

class HeroBannerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('title')
                    ->label('Judul')
                    ->required()
                    ->maxLength(255),

                Textarea::make('subtitle')
                    ->label('Subtitle')
                    ->rows(4)
                    ->columnSpanFull(),

                TextInput::make('button_text')
                    ->label('Teks Tombol')
                    ->placeholder('Contoh : Baca Artikel'),

                TextInput::make('button_link')
                    ->label('Link Tombol')
                    ->placeholder('/articles'),

                FileUpload::make('image')
                    ->label('Banner')
                    ->image()
                    ->disk('public')
                    ->directory('hero-banners')
                    ->required()
                    ->imagePreviewHeight('250')
                    ->columnSpanFull(),

                TextInput::make('sort_order')
                    ->label('Urutan')
                    ->numeric()
                    ->default(0),

                Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),

            ]);
    }
}