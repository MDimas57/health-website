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
                ->default(auth()->id()),

            Select::make('category_id')
                ->relationship('category', 'name')
                ->default(fn() => auth()->user()->category_id)
                ->disabled()
                ->dehydrated()
                ->required(),

            TextInput::make('title')
                ->required(),

            RichEditor::make('content')
                ->required()
                ->columnSpanFull(),

            Toggle::make('is_active')
                ->default(true),

        ]);
    }
}
