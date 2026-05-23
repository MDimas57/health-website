<div>
    

    {{-- TOOLBAR --}}
    <div class="flex flex-col lg:flex-row gap-4 justify-between items-center mb-10">

        {{-- SEARCH --}}
        <div class="relative w-full lg:w-1/2">

            <input type="text"
                   wire:model.live.debounce.500ms="q"
                   placeholder="Cari artikel kesehatan..."
                   class="w-full pl-12 pr-4 py-3 rounded-2xl border border-slate-200
                          focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500
                          shadow-sm bg-white">

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
                class="px-5 py-3 rounded-2xl border border-slate-200 bg-white shadow-sm">

            <option value="latest">Artikel Terbaru</option>
            <option value="oldest">Artikel Terlama</option>
            <option value="popular">Paling Populer</option>

        </select>

    </div>

    {{-- CATEGORY --}}
    <div class="flex flex-wrap gap-3 mb-10">

        <button wire:click="$set('category', null)"
                class="px-5 py-2 rounded-full text-sm transition
                {{ !$category
                    ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-200'
                    : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
            Semua
        </button>

        @foreach($categories as $cat)

            <button wire:click="$set('category', {{ $cat->id }})"
                    class="px-5 py-2 rounded-full text-sm transition
                    {{ $category == $cat->id
                        ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-200'
                        : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">

                {{ $cat->name }}

            </button>

        @endforeach

    </div>

    {{-- LOADING --}}
    <div wire:loading.flex
         class="justify-center items-center py-10">

        <div class="flex items-center gap-3 text-slate-500">

            <svg class="animate-spin h-5 w-5"
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

    {{-- GRID --}}
    <div wire:loading.remove
         class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">

        @forelse($articles as $article)

            @php
                $words = str_word_count(strip_tags($article->content));
                $readingTime = ceil($words / 200);
            @endphp

            <a href="{{ route('articles.show', $article->slug) }}"
               class="group bg-white rounded-3xl overflow-hidden
                      border border-slate-100 shadow-sm
                      hover:shadow-2xl hover:-translate-y-1
                      transition duration-300">

                {{-- THUMBNAIL --}}
                <div class="relative h-60 overflow-hidden">

                    <img
                        src="{{ $article->thumbnail
                            ? (Str::startsWith($article->thumbnail, 'http')
                                ? $article->thumbnail
                                : Storage::url($article->thumbnail))
                            : 'https://via.placeholder.com/600x400' }}"
                        class="w-full h-full object-cover group-hover:scale-110 transition duration-500"
                    >

                    {{-- OVERLAY --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-black/10 to-transparent"></div>

                    {{-- CATEGORY --}}
                    <div class="absolute top-4 left-4">

                        <span class="bg-emerald-600/90 backdrop-blur text-white
                                     text-xs px-3 py-1 rounded-full">

                            {{ $article->category->name ?? 'Umum' }}

                        </span>

                    </div>

                </div>

                {{-- CONTENT --}}
                <div class="p-6">

                    {{-- META --}}
                    <div class="flex items-center gap-3 text-xs text-slate-500 mb-3">

                        <span>
                            {{ $article->user->name ?? 'Admin' }}
                        </span>

                        <span>•</span>

                        <span>
                            {{ $article->published_at?->format('d M Y') }}
                        </span>

                        <span>•</span>

                        <span>
                            ⏱ {{ $readingTime }} min
                        </span>

                    </div>

                    {{-- TITLE --}}
                    <h3 class="text-xl font-bold text-slate-800
                               group-hover:text-emerald-600
                               line-clamp-2 transition">

                        {{ $article->title }}

                    </h3>

                    {{-- DESCRIPTION --}}
                    <p class="text-slate-500 text-sm mt-3 line-clamp-3 leading-relaxed">

                        {{ Str::limit(strip_tags($article->content), 140) }}

                    </p>

                    {{-- BUTTON --}}
                    <div class="mt-5 flex items-center justify-between">

                        <span class="text-emerald-600 font-medium text-sm">
                            Baca Selengkapnya
                        </span>

                        <svg class="w-5 h-5 text-emerald-600 group-hover:translate-x-1 transition"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M9 5l7 7-7 7"/>

                        </svg>

                    </div>

                </div>

            </a>

        @empty

            <div class="col-span-full">

                <div class="bg-white border border-dashed border-slate-300
                            rounded-3xl p-14 text-center">

                    <h3 class="text-xl font-bold text-slate-700 mb-2">
                        Artikel tidak ditemukan
                    </h3>

                    <p class="text-slate-500">
                        Coba gunakan kata kunci lain atau ubah kategori.
                    </p>

                </div>

            </div>

        @endforelse

    </div>

    {{-- PAGINATION --}}
    <div class="mt-14">
        {{ $articles->links() }}
    </div>

</div>