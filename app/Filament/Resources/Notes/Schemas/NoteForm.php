<?php

namespace App\Filament\Resources\Notes\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Toggle;

class NoteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Hidden::make('user_id')
                ->default(fn () => auth()->id()),

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
                ->maxLength(192),

            RichEditor::make('content')
                ->required()
                ->columnSpanFull(),

            Toggle::make('is_active')
                ->label('Aktif')
                ->default(true),

        ]);
    }
}