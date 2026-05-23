<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('slug')
                    ->required()
                    ->maxLength(255),


                FileUpload::make('image')
                    ->label('Gambar Kategori')
                    ->image()
                    ->directory('categories')
                    ->disk('public')
                    ->visibility('public')
                    ->preserveFilenames()
                    ->imagePreviewHeight('200')
                    ->loadingIndicatorPosition('left')
                    ->panelAspectRatio('16:9')
                    ->panelLayout('integrated')
                    ->removeUploadedFileButtonPosition('right')
                    ->uploadButtonPosition('left')
                    ->uploadProgressIndicatorPosition('left'),

 
                TextInput::make('color')
                    ->required()
                    ->default('#3B82F6'),


                Textarea::make('description')
                    ->columnSpanFull(),

            ]);
    }
}