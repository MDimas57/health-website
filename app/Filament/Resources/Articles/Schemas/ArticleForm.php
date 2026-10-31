<?php

namespace App\Filament\Resources\Articles\Schemas;

use App\Filament\Forms\Components\TableEditor;
use Filament\Actions\Action;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\RichEditor\ToolbarButtonGroup;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Size;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class ArticleForm
{
    /**
     * Teks petunjuk dengan font lebih kecil.
     */
    protected static function small(string $text): HtmlString
    {
        return new HtmlString('<span style="font-size: 0.75rem; line-height: 1.25rem;">' . e($text) . '</span>');
    }

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                /* =========================
                   1. Informasi Dasar
                ========================= */
                Section::make('Informasi Artikel')
                    ->description(self::small('Isi judul, kategori, dan gambar sampul artikel.'))
                    ->icon(Heroicon::InformationCircle)
                    ->columns(2)
                    ->columnSpanFull()
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

                        TextInput::make('title')
                            ->label('Judul Artikel')
                            ->placeholder('Contoh: Panduan Gizi Seimbang untuk Keluarga')
                            ->required()
                            ->maxLength(255),

                        FileUpload::make('thumbnail')
                            ->label('Gambar Sampul (Thumbnail)')
                            ->helperText(self::small('Gambar yang tampil di daftar artikel. Disarankan rasio landscape.'))
                            ->image()
                            ->disk('public')
                            ->directory('articles')
                            ->imagePreviewHeight('200')
                            ->columnSpanFull(),
                    ]),

                /* =========================
                   2. Isi Artikel
                ========================= */
                Section::make('Isi Artikel')
                    ->description(self::small('Susun artikel dari beberapa blok. Klik tombol biru "Tambah Isi Artikel" di bawah, pilih jenis blok (paragraf, gambar, link, atau tabel), lalu isi kontennya. Urutan blok bisa diubah dengan menyeret ikon panah.'))
                    ->icon(Heroicon::DocumentText)
                    ->columnSpanFull()
                    ->schema([

                        Builder::make('content_blocks')
                            ->hiddenLabel()
                            ->addActionLabel('Tambah Isi Artikel')
                            ->addAction(fn (Action $action) => $action
                                ->icon(Heroicon::PlusCircle)
                                ->button()
                                ->color('primary')
                                ->size(Size::Large)
                            )
                            ->blockPickerColumns(2)
                            ->blockNumbers(false)
                            ->collapsible()
                            ->collapsed()
                            ->cloneable()
                            ->helperText(self::small('Tips: blok yang sudah diisi akan menampilkan pratinjau singkat saat dilipat. Klik blok untuk membuka dan mengedit.'))
                            ->blocks([

                                Builder\Block::make('paragraph')
                                    ->label(function (?array $state): string {
                                        $text = $state['text'] ?? null;

                                        return is_string($text) && filled(strip_tags($text))
                                            ? 'Paragraf: ' . Str::limit(strip_tags($text), 60)
                                            : 'Paragraf';
                                    })
                                    ->icon(Heroicon::Bars3BottomLeft)
                                    ->schema([
                                        RichEditor::make('text')
                                            ->label('Isi Paragraf')
                                            ->placeholder('Tulis isi paragraf di sini...')
                                            ->toolbarButtons([
                                                ['bold', 'italic', 'underline', 'strike', 'link'],
                                                [ToolbarButtonGroup::make('Heading', ['h1', 'h2', 'h3'])->icon('fi-o-heading')],
                                                [ToolbarButtonGroup::make('Alignment', ['alignStart', 'alignCenter', 'alignEnd', 'alignJustify'])],
                                                ['blockquote', 'codeBlock', 'bulletList', 'orderedList'],
                                                ['undo', 'redo'],
                                            ])
                                            ->required()
                                            ->columnSpanFull(),
                                    ]),

                                Builder\Block::make('image')
                                    ->label(fn (?array $state): string => filled($state['title'] ?? null)
                                        ? 'Gambar: ' . $state['title']
                                        : 'Gambar')
                                    ->icon(Heroicon::Photo)
                                    ->schema([
                                        FileUpload::make('image')
                                            ->label('Pilih Gambar')
                                            ->image()
                                            ->disk('public')
                                            ->directory('articles')
                                            ->required(),

                                        TextInput::make('title')
                                            ->label('Keterangan Gambar')
                                            ->placeholder('Contoh: Contoh menu gizi seimbang'),
                                    ]),

                                Builder\Block::make('link')
                                    ->label(fn (?array $state): string => filled($state['title'] ?? null)
                                        ? 'Link: ' . $state['title']
                                        : 'Link')
                                    ->icon(Heroicon::Link)
                                    ->schema([
                                        TextInput::make('title')
                                            ->label('Teks Link')
                                            ->placeholder('Contoh: Baca selengkapnya di Kemenkes')
                                            ->required(),

                                        TextInput::make('url')
                                            ->label('Alamat URL')
                                            ->placeholder('https://contoh.com')
                                            ->url()
                                            ->required(),
                                    ]),

                                Builder\Block::make('table')
                                    ->label(fn (?array $state): string => filled($state['title'] ?? null)
                                        ? 'Tabel: ' . $state['title']
                                        : 'Tabel')
                                    ->icon(Heroicon::TableCells)
                                    ->schema([
                                        TextInput::make('title')
                                            ->label('Judul Tabel')
                                            ->placeholder('Contoh: Kebutuhan kalori harian')
                                            ->required(),

                                        TableEditor::make('data')
                                            ->columnSpanFull(),
                                    ]),
                            ])
                            ->columnSpanFull(),
                    ]),

                /* =========================
                   3. Pengaturan Publikasi
                ========================= */
                Section::make('Pengaturan Publikasi')
                    ->description(self::small('Atur status dan tampilan artikel di website.'))
                    ->icon(Heroicon::Cog6Tooth)
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([

                        Select::make('status')
                            ->options([
                                'draft' => 'Draft (belum tampil di website)',
                                'published' => 'Published (tampil di website)',
                                'archived' => 'Archived (disembunyikan)',
                            ])
                            ->default('draft')
                            ->required(),

                        Toggle::make('is_featured')
                            ->label('Artikel Unggulan')
                            ->helperText('Aktifkan agar artikel tampil di bagian unggulan.'),
                    ]),

            ]);
    }
}