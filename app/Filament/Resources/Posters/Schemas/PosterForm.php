<?php

namespace App\Filament\Resources\Posters\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;

class PosterForm
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

                FileUpload::make('poster_file')
                    ->label('Poster')
                    ->image()
                    ->disk('public')
                    ->directory('posters')
                    ->required()
                    ->imagePreviewHeight('250')
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
                    ->label('Poster Unggulan'),

            ]);
    }
}