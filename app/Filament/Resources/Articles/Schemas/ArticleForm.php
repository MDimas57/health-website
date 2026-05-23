<?php

namespace App\Filament\Resources\Articles\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DateTimePicker;

class ArticleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('title')
                    ->required()
                    ->maxLength(255),

                FileUpload::make('thumbnail')
                    ->image()
                    ->disk('public')
                    ->directory('articles')
                    ->imagePreviewHeight('200')
                    ->columnSpanFull(),

                RichEditor::make('content')
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
                    ->label('Artikel Unggulan'),

            ]);
    }
}