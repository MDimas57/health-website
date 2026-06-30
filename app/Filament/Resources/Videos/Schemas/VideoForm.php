<?php

namespace App\Filament\Resources\Videos\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\RichEditor;

class VideoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

            Select::make('category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->default(fn () => auth()->user()->category_id)
                    ->disabled(fn () => auth()->user()->hasRole('contributor'))
                    ->dehydrated(),

                TextInput::make('title')
                    ->required()
                    ->maxLength(255),

                FileUpload::make('thumbnail')
                    ->image()
                    ->disk('public')
                    ->directory('videos')
                    ->required()
                    ->imagePreviewHeight('250')
                    ->columnSpanFull(),

                TextInput::make('youtube_url')
                    ->label('Youtube URL')
                    ->url()
                    ->required(),

                RichEditor::make('description')
                    ->required()
                    ->columnSpanFull(),
                Select::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'archived' => 'Archived',
                    ])
                    ->default('draft')
                    ->required(),

                Toggle::make('is_featured')
                    ->label('Video Unggulan'),

            ]);
    }
}