{{-- resources/views/livewire/poster-search.blade.php --}}

<div>

    {{-- TOOLBAR --}}
    <div class="flex flex-col lg:flex-row gap-4 justify-between items-center mb-10">

        {{-- SEARCH --}}
        <div class="relative w-full lg:w-1/2">

            <input
                type="text"
                wire:model.live.debounce.500ms="q"
                placeholder="Cari poster kesehatan..."
                class="w-full pl-12 pr-4 py-3 rounded-2xl border border-slate-200
                       focus:ring-2 focus:ring-orange-500 focus:border-orange-500
                       shadow-sm bg-white"
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
            class="px-5 py-3 rounded-2xl border border-slate-200
                   bg-white shadow-sm"
        >

            <option value="latest">Poster Terbaru</option>
            <option value="oldest">Poster Terlama</option>
            <option value="popular">Paling Populer</option>

        </select>

    </div>



    {{-- CATEGORY --}}
    <div class="flex flex-wrap gap-3 mb-10">

        <button
            wire:click="$set('category', null)"
            class="px-5 py-2 rounded-full text-sm transition
            {{ !$category
                ? 'bg-orange-500 text-white shadow-lg shadow-orange-200'
                : 'bg-white border border-slate-200 text-slate-600 hover:bg-orange-50'
            }}"
        >
            Semua
        </button>

        @foreach($categories as $cat)

            <button
                wire:click="$set('category', {{ $cat->id }})"
                class="px-5 py-2 rounded-full text-sm transition
                {{ $category == $cat->id
                    ? 'bg-orange-500 text-white shadow-lg shadow-orange-200'
                    : 'bg-white border border-slate-200 text-slate-600 hover:bg-orange-50'
                }}"
            >

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

            Memuat poster...

        </div>

    </div>



    {{-- GRID --}}
    <div wire:loading.remove
         class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">

        @forelse($posters as $poster)

            <div
                x-data="{ open: false }"
                class="group"
            >

                {{-- CARD --}}
                <div
                    class="bg-white rounded-3xl overflow-hidden
                           border border-slate-100 shadow-sm
                           hover:shadow-2xl hover:-translate-y-1
                           transition duration-300"
                >

                    {{-- THUMBNAIL --}}
                    <div class="relative h-[520px] overflow-hidden">

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
                        <div
                            class="absolute inset-0
                                   bg-gradient-to-t
                                   from-black/90
                                   via-black/20
                                   to-transparent"
                        ></div>


                        {{-- CATEGORY --}}
                        <div class="absolute top-4 left-4">

                            <span
                                class="bg-orange-500/90 backdrop-blur
                                       text-white text-xs
                                       px-3 py-1 rounded-full"
                            >

                                {{ $poster->category->name ?? 'Kesehatan' }}

                            </span>

                        </div>


                       {{-- PREVIEW --}}
                        <div
                            class="absolute inset-0
                                flex items-center justify-center"
                        >

                            <button
                                @click="open = true"
                                class="opacity-0 group-hover:opacity-100
                                    scale-75 group-hover:scale-100
                                    transition duration-300

                                    px-6 py-4 rounded-2xl
                                    bg-white text-slate-900
                                    font-semibold text-sm

                                    shadow-2xl
                                    flex items-center gap-2"
                            >
                                Lihat Poster
                            </button>

                        </div>



                        {{-- CONTENT --}}
                        <div
                            class="absolute bottom-0 left-0 right-0
                                   p-6 text-white"
                        >

                            {{-- META --}}
                            <div
                                class="flex flex-wrap items-center
                                       gap-3 text-xs text-white/80 mb-3"
                            >

                                <span>
                                    {{ $poster->user->name ?? 'Admin' }}
                                </span>

                                <span>•</span>

                                <span>
                                    {{ $poster->published_at?->format('d M Y') }}
                                </span>

                                <span>•</span>

                                <span>
                                    👁 {{ number_format($poster->views ?? 0) }}
                                </span>

                            </div>


                            {{-- TITLE --}}
                            <h3
                                class="text-2xl font-bold
                                       leading-snug line-clamp-2"
                            >

                                {{ $poster->title }}

                            </h3>


                            {{-- DESCRIPTION --}}
                            <p
                                class="text-white/80 text-sm
                                       mt-3 line-clamp-3
                                       leading-relaxed"
                            >

                                {{ Str::limit(strip_tags($poster->description), 120) }}

                            </p>
                            {{-- ACTION --}}
                            <div class="mt-4">

                                <a
                                    href="{{ route('posters.show', $poster->slug) }}"
                                    class="inline-flex items-center gap-2
                                        bg-orange-500 hover:bg-orange-600
                                        text-white text-sm font-semibold
                                        px-4 py-2 rounded-xl transition"
                                >
                                    Detail Poster
                                    →
                                </a>

                            </div>

                        </div>

                    </div>

                </div>



                {{-- MODAL --}}
                <div
                    x-show="open"
                    x-transition
                    x-cloak
                    class="fixed inset-0 z-[9999]
                           bg-black/95
                           flex items-center justify-center
                           p-4"
                >

                    {{-- CLOSE --}}
                    <button
                        @click="open = false"
                        class="absolute top-6 right-6
                               w-12 h-12 rounded-full
                               bg-white/10 backdrop-blur-md
                               text-white text-2xl
                               hover:bg-white/20 transition"
                    >
                        ✕
                    </button>


                    {{-- IMAGE --}}
                    <img
                        src="{{ $poster->poster_file
                            ? (Str::startsWith($poster->poster_file, 'http')
                                ? $poster->poster_file
                                : Storage::url($poster->poster_file))
                            : 'https://via.placeholder.com/600x900' }}"
                        class="max-w-full max-h-[92vh]
                               rounded-2xl shadow-2xl"
                    >

                </div>

            </div>

        @empty

            <div class="col-span-full">

                <div
                    class="bg-white border border-dashed
                           border-slate-300 rounded-3xl
                           p-14 text-center"
                >

                    <div class="text-7xl mb-6">
                        🖼️
                    </div>

                    <h3
                        class="text-2xl font-bold
                               text-slate-700 mb-2"
                    >
                        Poster tidak ditemukan
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

        {{ $posters->links() }}

    </div>

</div>