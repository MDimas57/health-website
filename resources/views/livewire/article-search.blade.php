<div>
    
    {{-- TOOLBAR (Responsif: Stack vertikal di mobile, row horizontal di desktop) --}}
    <div class="flex flex-col sm:flex-row gap-4 justify-between items-stretch sm:items-center mb-8">

        {{-- SEARCH --}}
        <div class="relative w-full sm:max-w-md md:w-1/2">

            <input type="text"
                   wire:model.live.debounce.500ms="q"
                   placeholder="Cari artikel kesehatan..."
                   class="w-full pl-12 pr-4 py-3 rounded-2xl border border-slate-200
                          focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                          shadow-sm bg-white text-slate-800 text-sm md:text-base transition">

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
        <select wire:model.live="sort"
                class="w-full sm:w-auto px-4 py-3 rounded-2xl border border-slate-200 bg-white text-slate-700 text-sm shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">

            <option value="latest">Artikel Terbaru</option>
            <option value="oldest">Artikel Terlama</option>
            <option value="popular">Paling Populer</option>

        </select>

    </div>

    {{-- CATEGORY (Responsif: Menggunakan scroll horizontal di mobile agar hemat ruang) --}}
    <div class="w-full overflow-x-auto no-scrollbar -mx-4 px-4 sm:mx-0 sm:px-0 mb-8">
        <div class="flex flex-nowrap sm:flex-wrap gap-2.5 pb-2 sm:pb-0">

            <button wire:click="$set('category', null)"
                    class="whitespace-nowrap px-5 py-2 rounded-full text-xs md:text-sm font-semibold transition shrink-0
                    {{ !$category
                        ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-100'
                        : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                Semua
            </button>

            @foreach($categories as $cat)

                <button wire:click="$set('category', {{ $cat->id }})"
                        class="whitespace-nowrap px-5 py-2 rounded-full text-xs md:text-sm font-semibold transition shrink-0
                        {{ $category == $cat->id
                            ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-100'
                            : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">

                    {{ $cat->name }}

                </button>

            @endforeach

        </div>
    </div>

    {{-- LOADING --}}
    <div wire:loading.flex
         class="justify-center items-center py-20 w-full">

        <div class="flex items-center gap-3 text-slate-500 font-medium">

            <svg class="animate-spin h-5 w-5 text-blue-600"
                 xmlns="http://www.w3.org/2000/svg"
                 fill="none"
                 viewBox="0 0 24 24">

                <circle class="opacity-25"
                        cx="12"
                        cy="12"
                        r="10"
                        stroke="currentColor"
                        stroke-width="4">
                </circle>

                <path class="opacity-75"
                      fill="currentColor"
                      d="M4 12a8 8 0 018-8v8z">
                </path>

            </svg>

            Memuat artikel...

        </div>

    </div>

    {{-- GRID SYSTEM (Responsif: 1 kolom di mobile, 2 di tablet, 3 di desktop) --}}
    <div wire:loading.remove
         class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8 items-stretch">

        @forelse($articles as $article)

            @php
                $words = str_word_count(strip_tags($article->content));
                $readingTime = ceil($words / 200);
            @endphp

            <div class="h-full flex">
                <a href="{{ route('articles.show', $article->slug) }}"
                   class="group w-full bg-white rounded-3xl overflow-hidden
                          border border-slate-100 shadow-sm
                          hover:shadow-2xl hover:-translate-y-1.5
                          transition duration-300 flex flex-col justify-between h-full">

                    {{-- THUMBNAIL (Aspek Rasio yang aman di mobile) --}}
                    <div class="relative h-48 sm:h-56 md:h-60 overflow-hidden shrink-0 w-full">

                        <img
                            src="{{ $article->thumbnail
                                ? (Str::startsWith($article->thumbnail, 'http')
                                    ? $article->thumbnail
                                    : Storage::url($article->thumbnail))
                                : 'https://via.placeholder.com/600x400' }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition duration-500"
                            alt="{{ $article->title }}"
                        >

                        {{-- OVERLAY --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent"></div>

                        {{-- CATEGORY BADGE --}}
                        <div class="absolute top-4 left-4">
                            <span class="bg-blue-600/90 backdrop-blur text-white
                                         text-[11px] font-bold px-3 py-1 rounded-full shadow-sm">
                                {{ $article->category->name ?? 'Umum' }}
                            </span>
                        </div>

                    </div>

                    {{-- CONTENT --}}
                    <div class="p-5 md:p-6 flex flex-col flex-grow justify-between bg-white">

                        <div>
                            {{-- META --}}
                            <div class="flex flex-wrap items-center gap-x-2 gap-y-1 text-[11px] md:text-xs text-slate-400 mb-3">

                                <span class="font-semibold text-slate-600 truncate max-w-[100px]">
                                    {{ $article->user->name ?? 'Admin' }}
                                </span>

                                <span>•</span>

                                <span>
                                    {{ $article->published_at?->format('d M Y') }}
                                </span>

                                <span>•</span>

                                <span class="whitespace-nowrap">
                                    ⏱ {{ $readingTime }} min
                                </span>

                            </div>

                            {{-- TITLE --}}
                            <h3 class="text-lg md:text-xl font-bold text-slate-800
                                       group-hover:text-indigo-600
                                       line-clamp-2 transition duration-300 leading-snug">
                                {{ $article->title }}
                            </h3>

                            {{-- DESCRIPTION --}}
                            <p class="text-slate-500 text-xs md:text-sm mt-2.5 line-clamp-3 leading-relaxed">
                                {{ Str::limit(html_entity_decode(strip_tags($article->content), ENT_QUOTES, 'UTF-8'), 120) }}
                            </p>
                        </div>

                        {{-- BUTTON / ACTION --}}
                        <div class="mt-6 pt-4 border-t border-slate-50 flex items-center justify-between shrink-0 w-full">

                            <span class="text-red-600 font-bold text-xs md:text-sm group-hover:text-red-700 transition">
                                Baca Selengkapnya
                            </span>

                            <svg class="w-4 h-4 md:w-5 md:h-5 text-red-600 group-hover:translate-x-1.5 transition duration-300"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2.5"
                                      d="M9 5l7 7-7 7"/>
                            </svg>

                        </div>

                    </div>

                </a>
            </div>

        @empty

            <div class="col-span-full">
                <div class="bg-white border border-dashed border-slate-200 rounded-3xl p-8 md:p-14 text-center">
                    <h3 class="text-lg md:text-xl font-bold text-slate-700 mb-1">
                        Artikel tidak ditemukan
                    </h3>
                    <p class="text-slate-400 text-xs md:text-sm">
                        Coba gunakan kata kunci lain atau ubah kategori.
                    </p>
                </div>
            </div>

        @endforelse

    </div>

    {{-- PAGINATION --}}
    <div class="mt-10 md:mt-14">
        {{ $articles->links() }}
    </div>

</div>