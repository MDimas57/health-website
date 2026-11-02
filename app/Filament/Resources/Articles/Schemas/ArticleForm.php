<?php

namespace App\Filament\Resources\Articles\Schemas;

use App\Filament\Forms\Components\TableEditor;
use Filament\Actions\Action;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\RichEditor\ToolbarButtonGroup;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
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

    /**
     * Warna header per jenis blok.
     */
    protected const BLOCK_COLORS = [
        'paragraph'  => '#0ea5e9', // biru langit
        'image'      => '#22c55e', // hijau
        'link'       => '#8b5cf6', // ungu
        'table'      => '#f59e0b', // oranye
        'chart'      => '#ec4899', // pink
        'demography' => '#14b8a6', // tosca
    ];

    /**
     * CSS pewarnaan header blok (ditempel di deskripsi section agar satu file).
     */
    protected static function blockStyles(): HtmlString
    {
        $css = '.fi-fo-builder-item-header:has([class*="blk-"]){border-left:5px solid var(--blk);'
            . 'background:color-mix(in srgb,var(--blk) 14%,transparent);}'
            . '.fi-fo-builder-item-header .blk{color:var(--blk);font-weight:600;}';

        foreach (self::BLOCK_COLORS as $key => $color) {
            $css .= ".fi-fo-builder-item-header:has(.blk-{$key}){--blk:{$color};}";
        }

        return new HtmlString('<style>' . $css . '</style>');
    }

    /**
     * Label blok saat dilipat: "Jenis — ringkasan singkat", berwarna sesuai jenis blok.
     */
    protected static function blockLabel(string $key, string $type, mixed $detail = null, int $limit = 45): HtmlString
    {
        $detail = self::plainText($detail);

        $text = $detail !== ''
            ? $type . ' — ' . Str::limit($detail, $limit)
            : $type . ' (belum diisi)';

        return new HtmlString('<span class="blk blk-' . $key . '">' . e($text) . '</span>');
    }

    /**
     * Ambil teks polos dari string HTML atau dari array JSON TipTap (RichEditor Filament v4).
     */
    protected static function plainText(mixed $value): string
    {
        if (is_string($value)) {
            return trim(html_entity_decode(strip_tags($value)));
        }

        if (! is_array($value)) {
            return '';
        }

        $parts = [];

        $walk = function (array $node) use (&$walk, &$parts): void {
            if (isset($node['text']) && is_string($node['text'])) {
                $parts[] = $node['text'];
            }

            foreach ($node['content'] ?? [] as $child) {
                if (is_array($child)) {
                    $walk($child);
                }
            }
        };

        $walk($value);

        return trim(preg_replace('/\s+/', ' ', implode(' ', $parts)));
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
                    ->collapsible()
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
                    ->description(new HtmlString(self::blockStyles()->toHtml() . self::small('Susun artikel dari beberapa blok. Klik "Tambah Isi Artikel", pilih jenis blok, lalu isi kontennya. Ubah urutan dengan tombol panah naik/turun atau seret ikon panah.')->toHtml()))
                    ->icon(Heroicon::DocumentText)
                    ->columnSpanFull()
                    ->schema([

                        Builder::make('content_blocks')
                            ->hiddenLabel()

                            // --- Tombol tambah blok (di bawah daftar) ---
                            ->addActionLabel('Tambah Isi Artikel')
                            ->addAction(fn (Action $action) => $action
                                ->icon(Heroicon::PlusCircle)
                                ->button()
                                ->color('primary')
                                ->size(Size::Large)
                            )

                            // --- Tombol sisip blok di antara dua blok (tanpa harus tambah lalu geser) ---
                            ->addBetweenAction(fn (Action $action) => $action
                                ->label('Sisipkan blok di sini')
                                ->icon(Heroicon::Plus)
                            )

                            // --- Pemilih jenis blok ---
                            ->blockPickerColumns(3)
                            ->blockPickerWidth('2xl')

                            // --- Navigasi: nomor urut, lipat, pindah naik/turun ---
                            ->blockNumbers()
                            ->collapsible()
                            ->collapsed()
                            ->persistCollapsed()
                            ->reorderableWithButtons()
                            ->cloneable()

                            // --- Konfirmasi sebelum hapus supaya tidak terhapus tidak sengaja ---
                            ->deleteAction(fn (Action $action) => $action->requiresConfirmation())

                            ->helperText(self::small('Tips: gunakan tombol "Lipat semua" / "Buka semua" di kanan atas daftar. Blok yang dilipat menampilkan nomor, ikon, dan ringkasan isinya.'))
                            ->blocks([

                                /* ---------- Paragraf ---------- */
                                Builder\Block::make('paragraph')
                                    ->label(fn (?array $state): HtmlString => self::blockLabel('paragraph', 'Paragraf', $state['text'] ?? null, 60))
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

                                /* ---------- Gambar ---------- */
                                Builder\Block::make('image')
                                    ->label(fn (?array $state): HtmlString => self::blockLabel('image', 'Gambar', $state['title'] ?? null))
                                    ->icon(Heroicon::Photo)
                                    ->columns(2)
                                    ->schema([
                                        FileUpload::make('image')
                                            ->label('Pilih Gambar')
                                            ->image()
                                            ->disk('public')
                                            ->directory('articles')
                                            ->imagePreviewHeight('150')
                                            ->required(),

                                        TextInput::make('title')
                                            ->label('Keterangan Gambar')
                                            ->placeholder('Contoh: Contoh menu gizi seimbang'),
                                    ]),

                                /* ---------- Link ---------- */
                                Builder\Block::make('link')
                                    ->label(fn (?array $state): HtmlString => self::blockLabel('link', 'Link', $state['title'] ?? null))
                                    ->icon(Heroicon::Link)
                                    ->columns(2)
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

                                /* ---------- Tabel ---------- */
                                Builder\Block::make('table')
                                    ->label(fn (?array $state): HtmlString => self::blockLabel('table', 'Tabel', $state['title'] ?? null))
                                    ->icon(Heroicon::TableCells)
                                    ->schema([
                                        TextInput::make('title')
                                            ->label('Judul Tabel')
                                            ->placeholder('Contoh: Kebutuhan kalori harian')
                                            ->required(),

                                        TableEditor::make('data')
                                            ->columnSpanFull(),
                                    ]),

                                /* ---------- Grafik ---------- */
                                Builder\Block::make('chart')
                                    ->label(fn (?array $state): HtmlString => self::blockLabel('chart', 'Grafik', $state['title'] ?? null))
                                    ->icon(Heroicon::ChartBar)
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('title')
                                            ->label('Judul Grafik')
                                            ->placeholder('Contoh: Prevalensi Stunting Balita per Tahun')
                                            ->required()
                                            ->columnSpanFull(),

                                        Select::make('chart_type')
                                            ->label('Jenis Grafik')
                                            ->options([
                                                'bar'            => 'Diagram Batang – membandingkan antar kategori (mis. cakupan imunisasi per wilayah)',
                                                'horizontal_bar' => 'Batang Horizontal – kategori dengan nama panjang (mis. 10 penyakit terbanyak)',
                                                'line'           => 'Grafik Garis – tren dari waktu ke waktu (mis. kasus DBD per bulan)',
                                                'pie'            => 'Diagram Lingkaran – proporsi dari keseluruhan (mis. status gizi balita)',
                                                'doughnut'       => 'Diagram Donat – proporsi dengan tampilan lebih ringan',
                                                'radar'          => 'Diagram Radar – membandingkan banyak indikator sekaligus',
                                            ])
                                            ->default('bar')
                                            ->required(),

                                        TextInput::make('unit')
                                            ->label('Satuan')
                                            ->placeholder('Contoh: %, orang, per 1.000 kelahiran hidup'),

                                        // Mode tabel: baris data jadi ringkas, tidak memanjang ke bawah
                                        Repeater::make('data')
                                            ->label('Data Grafik')
                                            ->helperText(self::small('Untuk grafik garis, urutkan data dari yang paling lama ke terbaru.'))
                                            ->table([
                                                TableColumn::make('Label')->markAsRequired(),
                                                TableColumn::make('Nilai')->markAsRequired(),
                                            ])
                                            ->compact()
                                            ->schema([
                                                TextInput::make('label')
                                                    ->placeholder('Contoh: 2023 / Kota A / Stunting')
                                                    ->required(),

                                                TextInput::make('value')
                                                    ->numeric()
                                                    ->required(),
                                            ])
                                            ->minItems(2)
                                            ->defaultItems(3)
                                            ->addActionLabel('Tambah Data')
                                            ->reorderable()
                                            ->columnSpanFull(),

                                        TextInput::make('source')
                                            ->label('Sumber Data')
                                            ->placeholder('Contoh: Survei Status Gizi Indonesia (SSGI) 2022')
                                            ->columnSpanFull(),

                                        Textarea::make('description')
                                            ->label('Keterangan / Interpretasi (opsional)')
                                            ->rows(2)
                                            ->columnSpanFull(),
                                    ]),

                                /* ---------- Demografi ---------- */
                                Builder\Block::make('demography')
                                    ->label(fn (?array $state): HtmlString => self::blockLabel(
                                        'demography',
                                        'Demografi',
                                        trim(($state['area'] ?? '') . ' ' . ($state['year'] ?? '')) ?: ($state['title'] ?? null)
                                    ))
                                    ->icon(Heroicon::UserGroup)
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('title')
                                            ->label('Judul')
                                            ->placeholder('Contoh: Piramida Penduduk Kota Bandar Lampung')
                                            ->required()
                                            ->columnSpanFull(),

                                        TextInput::make('area')
                                            ->label('Wilayah')
                                            ->placeholder('Contoh: Kota Bandar Lampung')
                                            ->required(),

                                        TextInput::make('year')
                                            ->label('Tahun Data')
                                            ->numeric()
                                            ->minValue(1900)
                                            ->maxValue((int) date('Y'))
                                            ->required(),

                                        Select::make('unit')
                                            ->label('Satuan Data')
                                            ->options([
                                                'jiwa'   => 'Jumlah jiwa',
                                                'persen' => 'Persen (%) dari total penduduk',
                                            ])
                                            ->default('jiwa')
                                            ->required()
                                            ->columnSpanFull(),

                                        // 16 baris kelompok umur dibuat mode tabel agar tidak sepanjang halaman
                                        Repeater::make('data')
                                            ->label('Penduduk menurut Kelompok Umur dan Jenis Kelamin')
                                            ->helperText(self::small('Kelompok umur sudah terisi otomatis. Cukup isi angka laki-laki dan perempuan pada tiap baris.'))
                                            ->table([
                                                TableColumn::make('Kelompok Umur'),
                                                TableColumn::make('Laki-laki')->markAsRequired(),
                                                TableColumn::make('Perempuan')->markAsRequired(),
                                            ])
                                            ->compact()
                                            ->schema([
                                                TextInput::make('age_group')
                                                    ->disabled()
                                                    ->dehydrated(),

                                                TextInput::make('male')
                                                    ->numeric()
                                                    ->minValue(0)
                                                    ->required(),

                                                TextInput::make('female')
                                                    ->numeric()
                                                    ->minValue(0)
                                                    ->required(),
                                            ])
                                            ->default(collect([
                                                '0-4', '5-9', '10-14', '15-19', '20-24', '25-29', '30-34', '35-39',
                                                '40-44', '45-49', '50-54', '55-59', '60-64', '65-69', '70-74', '75+',
                                            ])->map(fn (string $group) => [
                                                'age_group' => $group,
                                                'male'      => null,
                                                'female'    => null,
                                            ])->all())
                                            ->addable(false)
                                            ->deletable(false)
                                            ->reorderable(false)
                                            ->columnSpanFull(),

                                        TextInput::make('source')
                                            ->label('Sumber Data')
                                            ->placeholder('Contoh: BPS, Sensus Penduduk 2020')
                                            ->columnSpanFull(),

                                        Textarea::make('description')
                                            ->label('Keterangan / Interpretasi (opsional)')
                                            ->rows(2)
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
                    ->collapsible()
                    ->schema([

                        Select::make('status')
                            ->options([
                                'draft'     => 'Draft (belum tampil di website)',
                                'published' => 'Published (tampil di website)',
                                'archived'  => 'Archived (disembunyikan)',
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