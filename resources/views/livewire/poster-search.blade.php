{{-- resources/views/livewire/poster-search.blade.php --}}
<div>

    {{-- TOOLBAR (Responsif: Stack vertikal di mobile, horizontal di desktop) --}}
    <div class="flex flex-col sm:flex-row gap-4 justify-between items-stretch sm:items-center mb-8">

        {{-- SEARCH --}}
        <div class="relative w-full sm:max-w-md md:w-1/2">

            <input
                type="text"
                wire:model.live.debounce.500ms="q"
                placeholder="Cari poster kesehatan..."
                class="w-full pl-12 pr-4 py-3 rounded-2xl border border-slate-200
                       focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                       shadow-sm bg-white text-slate-800 text-sm md:text-base transition"
            >

            {{-- ICON --}}
            <svg class="w-5 h-5 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>

        </div>

        {{-- SORT --}}
        <select
            wire:model.live="sort"
            class="w-full sm:w-auto px-5 py-3 rounded-2xl border border-slate-200
                   bg-white shadow-sm text-slate-700 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
        >
            <option value="latest">Poster Terbaru</option>
            <option value="oldest">Poster Terlama</option>
            <option value="popular">Paling Populer</option>
        </select>

    </div>

    {{-- CATEGORY (Responsif: Horizontal scrollable di mobile agar hemat tempat) --}}
    <div class="w-full overflow-x-auto no-scrollbar -mx-4 px-4 sm:mx-0 sm:px-0 mb-8">
        <div class="flex flex-nowrap sm:flex-wrap gap-2.5 pb-2 sm:pb-0">

            <button
                wire:click="$set('category', null)"
                class="whitespace-nowrap px-5 py-2 rounded-full text-xs md:text-sm font-semibold transition shrink-0
                {{ !$category
                    ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-100'
                    : 'bg-white border border-slate-200 text-slate-600 hover:bg-indigo-50'
                }}"
            >
                Semua
            </button>

            @foreach($categories as $cat)

                <button
                    wire:click="$set('category', {{ $cat->id }})"
                    class="whitespace-nowrap px-5 py-2 rounded-full text-xs md:text-sm font-semibold transition shrink-0
                    {{ $category == $cat->id
                        ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-100'
                        : 'bg-white border border-slate-200 text-slate-600 hover:bg-indigo-50'
                    }}"
                >
                    {{ $cat->name }}
                </button>

            @endforeach

        </div>
    </div>

    {{-- LOADING (Menggunakan warna biru tema medis) --}}
    <div wire:loading.flex
         class="justify-center items-center py-20 w-full">

        <div class="flex items-center gap-3 text-slate-500 font-medium">

            <svg class="animate-spin h-5 w-5 text-blue-600"
                 xmlns="http://www.w3.org/2000/svg"
                 fill="none"
                 viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
            </svg>

            Memuat poster...

        </div>

    </div>

    {{-- GRID (Responsif: 1 kolom di mobile, 2 di tablet, 3 di desktop) --}}
    <div wire:loading.remove
         class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8 items-stretch">

        @forelse($posters as $poster)

            <div
                x-data="{ open: false }"
                class="group h-full flex flex-col"
            >

                {{-- CARD --}}
                <div
                    class="bg-white rounded-3xl overflow-hidden
                           border border-slate-100 shadow-sm
                           hover:shadow-2xl hover:-translate-y-1.5
                           transition duration-300 h-full flex flex-col"
                >

                    {{-- THUMBNAIL (Ketinggian adaptif agar proporsional di layar handphone) --}}
                    <div class="relative h-[400px] sm:h-[480px] md:h-[520px] overflow-hidden shrink-0 w-full">

                        <img
                            src="{{ $poster->poster_file
                                ? (Str::startsWith($poster->poster_file, 'http')
                                    ? $poster->poster_file
                                    : Storage::url($poster->poster_file))
                                : 'https://via.placeholder.com/600x900' }}"
                            alt="{{ $poster->title }}"
                            class="w-full h-full object-cover
                                   group-hover:scale-105
                                   transition duration-700"
                        >

                        {{-- OVERLAY --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black/95 via-black/30 to-transparent"></div>

                        {{-- CATEGORY BADGE (Menggunakan Aksen Biru Medis) --}}
                        <div class="absolute top-4 left-4">
                            <span class="bg-blue-600/90 backdrop-blur text-white text-[11px] font-bold px-3 py-1 rounded-full shadow-sm">
                                {{ $poster->category->name ?? 'Kesehatan' }}
                            </span>
                        </div>

                        {{-- PREVIEW BUTTON (Optimasi: Selalu muncul di mobile, hover di desktop) --}}
                        <div class="absolute inset-0 flex items-center justify-center p-4">
                            <button
                                @click="open = true"
                                class="lg:opacity-0 lg:group-hover:opacity-100
                                       lg:scale-75 lg:group-hover:scale-100
                                       transition duration-300
                                       px-5 py-3 rounded-xl
                                       bg-white/95 backdrop-blur text-slate-900
                                       font-bold text-xs md:text-sm shadow-2xl
                                       flex items-center gap-2"
                            >
                                🔍 Lihat Poster
                            </button>
                        </div>

                        {{-- CONTENT LAYOVER --}}
                        <div class="absolute bottom-0 left-0 right-0 p-5 md:p-6 text-white flex flex-col justify-end">

                            {{-- META --}}
                            <div class="flex flex-wrap items-center gap-x-2 gap-y-1 text-[11px] md:text-xs text-white/80 mb-2.5">
                                <span class="font-semibold truncate max-w-[100px]">
                                    {{ $poster->user->name ?? 'Admin' }}
                                </span>
                                <span>•</span>
                                <span>
                                    {{ $poster->published_at?->format('d M Y') }}
                                </span>
                                <span>•</span>
                                <span class="whitespace-nowrap">
                                    {{ number_format($poster->views ?? 0) }} views
                                </span>
                            </div>

                            {{-- TITLE --}}
                            <h3 class="text-xl md:text-2xl font-bold leading-snug line-clamp-2 mb-4">
                                {{ $poster->title }}
                            </h3>

                            {{-- ACTION (Menggunakan warna Merah Kontras sesuai palet) --}}
                            <div>
                                <a
                                    href="{{ route('posters.show', $poster->slug) }}"
                                    class="inline-flex items-center gap-2
                                           bg-red-600 hover:bg-red-700
                                           text-white text-xs md:text-sm font-bold
                                           px-4 py-2.5 rounded-xl transition shadow-md w-full sm:w-auto justify-center"
                                >
                                    Detail Poster →
                                </a>
                            </div>

                        </div>

                    </div>

                </div>

                {{-- MODAL PREVIEW (Responsif & Fit Screen Mobile) --}}
                <div
                    x-show="open"
                    x-transition
                    x-cloak
                    class="fixed inset-0 z-[9999] bg-black/95 flex items-center justify-center p-4"
                >
                    {{-- CLOSE BUTTON --}}
                    <button
                        @click="open = false"
                        class="absolute top-4 right-4 md:top-6 md:right-6
                               w-10 h-10 md:w-12 md:h-12 rounded-full
                               bg-white/10 backdrop-blur-md
                               text-white text-xl md:text-2xl
                               hover:bg-white/20 transition flex items-center justify-center"
                    >
                        ✕
                    </button>

                    {{-- IMAGE INSIDE MODAL --}}
                    <img
                        src="{{ $poster->poster_file
                            ? (Str::startsWith($poster->poster_file, 'http')
                                ? $poster->poster_file
                                : Storage::url($poster->poster_file))
                            : 'https://via.placeholder.com/600x900' }}"
                        class="max-w-full max-h-[85vh] md:max-h-[92vh] rounded-xl shadow-2xl object-contain"
                    >
                </div>

            </div>

        @empty

            <div class="col-span-full">
                <div class="bg-white border border-dashed border-slate-300 rounded-3xl p-8 md:p-14 text-center">
                    <div class="text-5xl md:text-7xl mb-4 md:mb-6">🖼️</div>
                    <h3 class="text-xl md:text-2xl font-bold text-slate-700 mb-1">
                        Poster tidak ditemukan
                    </h3>
                    <p class="text-slate-500 text-xs md:text-sm">
                        Coba gunakan kata kunci lain atau ubah kategori.
                    </p>
                </div>
            </div>

        @endforelse

    </div>

    {{-- PAGINATION --}}
    <div class="mt-10 md:mt-14">
        {{ $posters->links() }}
    </div>

</div>