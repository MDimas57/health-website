<?php

namespace App\Filament\Resources\CategoryBanners\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Hidden;


class CategoryBannerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Select::make('category_id')
                ->relationship('category', 'name')
                ->required()
                ->default(fn () => auth()->user()->category_id)
                ->disabled(fn () => ! auth()->user()->hasRole('super_admin')),

            TextInput::make('title')
                ->required(),

            Textarea::make('subtitle'),

            FileUpload::make('image')
                ->image()
                ->imageEditor()
                ->disk('public')
                ->directory('category-banners')
                ->visibility('public')
                ->maxSize(5120)
                ->required(),

            Toggle::make('is_active')
                ->default(true),

        ]);
    }
}