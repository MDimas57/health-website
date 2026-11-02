<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Str;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ColorPicker;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

             TextInput::make('name')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Set $set, ?string $state) {$set('slug', Str::slug($state ?? ''));
                    }),

                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true),


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

 
               ColorPicker::make('color')
                    ->required()
                    ->default('#3B82F6'),


                Textarea::make('description')
                    ->columnSpanFull(),

            ]);
    }
}