<?php

namespace App\Filament\Resources\Documents\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Group;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Forms\Components\RichEditor\ToolbarButtonGroup;
class DocumentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns([
                'default' => 1,
                'lg' => 3, // Membagi form menjadi 3 kolom grid utama
            ])
            ->components([

                // ==========================================
                // KONTEN UTAMA (KIRI - SPAN 2)
                // ==========================================
                Group::make()
                    ->schema([
                        Section::make('Informasi Utama')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Judul Dokumen')
                                    ->placeholder('Masukkan judul dokumen...')
                                    ->required()
                                    ->maxLength(255),

                                RichEditor::make('text')
                                    ->label('Deskripsi Dokumen')
                                    ->toolbarButtons([
                                        ['bold', 'italic', 'underline', 'strike','link'],
                                        [ToolbarButtonGroup::make('Heading', ['h1', 'h2', 'h3'])->icon('fi-o-heading')],
                                        [ToolbarButtonGroup::make('Alignment', ['alignStart', 'alignCenter', 'alignEnd', 'alignJustify'])],
                                        ['blockquote', 'codeBlock', 'bulletList', 'orderedList'],
                                        ['undo', 'redo'],
                                    ])
                                    ->columnSpanFull(),
                            ]),

                        Section::make('Berkas Dokumen')
                            ->description('Unggah berkas dokumen (PDF, Word, atau PowerPoint).')
                            ->schema([
                                FileUpload::make('document_file')
                                    ->label('Unggah File')
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
                                    ->live()
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        if (! $state) {
                                            $set('file_size', null);
                                            return;
                                        }

                                        $filePath = is_array($state) ? reset($state) : $state;
                                        $path = storage_path('app/public/' . $filePath);

                                        if (file_exists($path)) {
                                            $set('file_size', filesize($path));
                                        }
                                    }),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),

                // ==========================================
                // SIDEBAR METADATA (KANAN - SPAN 1)
                // ==========================================
                Group::make()
                    ->schema([
                        Section::make('Atribut & Status')
                            ->schema([
                                Select::make('category_id')
                                    ->label('Kategori')
                                    ->relationship('category', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->default(fn () => auth()->user()?->category_id)
                                    ->disabled(fn () => auth()->user()?->hasRole('contributor'))
                                    ->dehydrated(),

                                Select::make('status')
                                    ->label('Status')
                                    ->options([
                                        'draft' => 'Draft',
                                        'published' => 'Published',
                                        'archived' => 'Archived',
                                    ])
                                    ->default('draft')
                                    ->native(false)
                                    ->required(),

                                Toggle::make('is_featured')
                                    ->label('Dokumen Unggulan')
                                    ->helperText('Tampilkan dokumen ini sebagai unggulan di halaman depan.')
                                    ->inline(false),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),

            ]);
    }
}