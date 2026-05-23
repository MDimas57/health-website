<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Select::make('type')
                    ->label('Jenis Konten')
                    ->options([
                        'article' => 'Artikel',
                        'poster' => 'Poster',
                        'video' => 'Video YouTube',
                    ])
                    ->required()
                    ->live(),

                TextInput::make('title')
                    ->label('Judul')
                    ->required()
                    ->maxLength(255),

                Select::make('category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Publish',
                        'archived' => 'Arsip',
                    ])
                    ->default('draft')
                    ->required(),

                // Artikel
                RichEditor::make('content')
                    ->label('Isi Artikel')
                    ->visible(fn ($get) => $get('type') === 'article')
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'underline',
                        'strike',
                        'bulletList',
                        'orderedList',
                        'h2',
                        'h3',
                        'blockquote',
                        'link',
                        'redo',
                        'undo',
                    ])
                    ->fileAttachmentsDisk('public')
                    ->fileAttachmentsDirectory('uploads/editor')
                    ->columnSpanFull(),

              // Poster
                FileUpload::make('poster_file')
                    ->label('Upload Poster')
                    ->image()
                    ->disk('public')
                    ->directory('posters')
                    ->imagePreviewHeight('250')
                    ->visible(fn ($get) => $get('type') === 'poster'),

                // Video
                TextInput::make('youtube_url')
                    ->label('Link YouTube')
                    ->url()
                    ->placeholder('https://youtube.com/watch?v=xxxx')
                    ->visible(fn ($get) => $get('type') === 'video'),

                // Thumbnail
                FileUpload::make('thumbnail')
                    ->label('Thumbnail')
                    ->image()
                    ->disk('public')
                    ->directory('thumbnails')
                    ->imagePreviewHeight('200'),
            ]);
    }
}