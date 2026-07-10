<?php

namespace App\Filament\Resources\Documents\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Toggle;
class DocumentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Informasi Dokumen')
                    ->schema([

                        Grid::make(2)
                            ->schema([

                                Select::make('category_id')
                                    ->label('Kategori')
                                    ->relationship('category', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->default(fn () => auth()->user()->category_id)
                                    ->disabled(fn () => auth()->user()->hasRole('contributor'))
                                    ->dehydrated(),

                                Select::make('status')
                                    ->label('Status')
                                    ->options([
                                        'draft' => 'Draft',
                                        'published' => 'Published',
                                        'archived' => 'Archived',
                                    ])
                                    ->default('draft')
                                    ->required(),

                            ]),

                        TextInput::make('title')
                            ->label('Judul Dokumen')
                            ->required()
                            ->maxLength(255),

                        RichEditor::make('description')
                            ->label('Deskripsi')
                            ->columnSpanFull(),

                    ]),

                Section::make('Upload File')
                    ->schema([

                        Grid::make(1)
                            ->schema([

                                FileUpload::make('document_file')
                                    ->label('Dokumen')
                                    ->disk('public')
                                    ->directory('documents')
                                    ->acceptedFileTypes([
                                        'application/pdf',
                                        'application/msword',
                                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                        'application/vnd.ms-powerpoint',
                                        'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                                    ])
                                    ->downloadable()
                                    ->openable()
                                    ->previewable(false)
                                    ->required()
                                    ->afterStateUpdated(function ($state, callable $set) {

                                        if (!$state) {
                                            return;
                                        }

                                        $path = storage_path('app/public/' . $state);

                                        if (file_exists($path)) {
                                            $set('file_size', filesize($path));
                                        }
                                    }),

                            ]),

                    ]),

                Section::make('Publikasi')
                    ->schema([

                        Grid::make(1)
                            ->schema([

                                Toggle::make('is_featured')
                                    ->label('Dokumen Unggulan'),

                            ]),

                    ]),

            ]);
    }
}