<?php
// app/Filament/Resources/Consultations/Schemas/ConsultationForm.php

namespace App\Filament\Resources\Consultations\Schemas;

use App\Support\WebpConverter;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ConsultationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('topic')
                ->label('Topik Konsultasi')
                ->required(),

            TextInput::make('officer_name')
                ->label('Nama Petugas')
                ->required(),

            FileUpload::make('photo')
                ->label('Foto Petugas')
                ->helperText('Format JPG/PNG akan otomatis diubah menjadi WebP.')
                ->image()
                ->imageEditor()
                ->imageEditorAspectRatios(['1:1', '4:3'])
                ->maxSize(4096)
                ->disk('public')
                ->directory('consultations')
                ->visibility('public')
                ->columnSpanFull(),

            Textarea::make('bio')
                ->label('Biodata Petugas')
                ->rows(4)
                ->maxLength(500)
                ->columnSpanFull(),

            TextInput::make('phone')
                ->label('Nomor WhatsApp')
                ->tel()
                ->required()
                ->helperText('Contoh: 081234567890'),

            TextInput::make('sort_order')
                ->label('Urutan')
                ->numeric()
                ->default(0),

            Toggle::make('is_active')
                ->label('Aktif')
                ->default(true),
        ]);
    }
}