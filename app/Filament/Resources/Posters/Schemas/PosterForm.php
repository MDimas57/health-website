<?php

namespace App\Filament\Resources\Posters\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\RichEditor;

class PosterForm
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
                    ->label('Judul Poster')
                    ->required()
                    ->maxLength(255),

                RichEditor::make('description')
                    ->label('Deskripsi Poster')
                    ->placeholder('Masukkan deskripsi atau informasi mengenai poster...')
                    ->columnSpanFull(),

                FileUpload::make('poster_file')
                    ->label('Poster')
                    ->image()
                    ->disk('public')
                    ->directory('posters')
                    ->required()
                    ->imagePreviewHeight('250')
                    ->columnSpanFull(),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'archived' => 'Archived',
                    ])
                    ->default('draft')
                    ->required(),

                Toggle::make('is_featured')
                    ->label('Poster Unggulan'),

            ]);
    }
}