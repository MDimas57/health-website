<div>

    {{-- TOOLBAR (Perbaikan Mobile: Flex Stack dengan Gap Lebih Rapi) --}}
    <div class="flex flex-col sm:flex-row gap-4 justify-between items-center mb-8">

        {{-- SEARCH --}}
        <div class="relative w-full sm:w-1/2 lg:w-1/3">

            <input
                type="text"
                wire:model.live.debounce.500ms="q"
                placeholder="Cari video kesehatan..."
                class="w-full pl-11 pr-4 py-3 rounded-2xl border border-slate-200
                       focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                       shadow-sm bg-white text-sm transition"
            >

            {{-- ICON (Aksen Ungu saat fokus) --}}
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
            class="w-full sm:w-auto px-4 py-3 rounded-2xl border border-slate-200
                   bg-white shadow-sm text-sm text-slate-700 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none"
        >
            <option value="latest">Video Terbaru</option>
            <option value="oldest">Video Terlama</option>
            <option value="popular">Paling Populer</option>
        </select>

    </div>

    {{-- CATEGORY (Perbaikan Mobile: Auto-scroll horizontal jika kategori penuh agar tidak merusak layout) --}}
    <div class="w-full overflow-x-auto no-scrollbar -mx-4 px-4 sm:mx-0 sm:px-0 mb-8">
        <div class="flex flex-nowrap sm:flex-wrap gap-2.5 pb-2 sm:pb-0">
            <button
                wire:click="$set('category', null)"
                class="whitespace-nowrap px-5 py-2 rounded-full text-xs md:text-sm font-semibold transition shrink-0
                {{ !$category
                    ? 'bg-red-500 text-white shadow-lg shadow-red-200'
                    : 'bg-white border border-slate-200 text-slate-600 hover:bg-blue-50 hover:text-blue-600 hover:border-blue-200'
                }}"
            >
                Semua
            </button>

            @foreach($categories as $cat)
                <button
                    wire:click="$set('category', {{ $cat->id }})"
                    class="whitespace-nowrap px-5 py-2 rounded-full text-xs md:text-sm font-semibold transition shrink-0
                    {{ $category == $cat->id
                        ? 'bg-red-500 text-white shadow-lg shadow-red-200'
                        : 'bg-white border border-slate-200 text-slate-600 hover:bg-blue-50 hover:text-blue-600 hover:border-blue-200'
                    }}"
                >
                    {{ $cat->name }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- GRID (Perbaikan Mobile: Penggunaan Gap yang proporsional dari Mobile ke Desktop) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">

        @forelse($videos as $video)

            <div
                x-data="{ open: false }"
                class="group"
            >

                {{-- CARD --}}
                <div
                    class="bg-white rounded-[2rem] overflow-hidden
                           border border-slate-100 shadow-sm
                           hover:shadow-2xl hover:-translate-y-1
                           transition duration-300 flex flex-col h-full"
                >

                    {{-- THUMBNAIL (Rasio Tinggi Adaptif: Lebih pendek di mobile, ideal di desktop) --}}
                    <div class="relative h-[200px] sm:h-[220px] md:h-[240px] overflow-hidden bg-slate-900">

                        <img
                            src="https://img.youtube.com/vi/{{ $video->youtube_id }}/hqdefault.jpg"
                            alt="{{ $video->title }}"
                            class="w-full h-56 object-cover
                                group-hover:scale-105
                                transition duration-700"
                        >

                        {{-- OVERLAY --}}
                        <div
                            class="absolute inset-0
                                   bg-gradient-to-t
                                   from-slate-950/90
                                   via-slate-950/30
                                   to-transparent"
                        ></div>

                        {{-- PLAY BUTTON (Tetap Merah) --}}
                        <button
                            @click="open = true"
                            class="absolute inset-0
                                   flex items-center justify-center"
                        >
                            <div
                                class="w-14 h-14 rounded-full
                                       bg-red-500/90
                                       backdrop-blur-md
                                       flex items-center justify-center
                                       shadow-2xl
                                       group-hover:scale-110
                                       transition duration-300"
                            >
                                <svg class="w-7 h-7 text-white ml-1"
                                     fill="currentColor"
                                     viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                            </div>
                        </button>

                        {{-- BADGE CATEGORY (Tetap Merah) --}}
                        <div class="absolute top-4 left-4">
                            <span
                                class="bg-red-500 text-white text-[11px] font-bold tracking-wide
                                       px-3 py-1 rounded-full shadow-sm"
                            >
                                 {{ $video->category->name ?? 'Video' }}
                            </span>
                        </div>

                        {{-- TITLE OVERLAY --}}
                        <div
                            class="absolute bottom-0 left-0 right-0
                                   p-5 text-white"
                        >
                            <h3
                                class="text-base md:text-lg font-bold
                                       line-clamp-2 leading-snug group-hover:text-red-100 transition"
                            >
                                {{ $video->title }}
                            </h3>
                        </div>

                    </div>

                    {{-- CARD BODY (Menggunakan flex-1 agar tinggi tombol sebaris seimbang) --}}
                    <div class="p-5 md:p-6 flex flex-col flex-1 justify-between">

                        {{-- META --}}
                        <div
                            class="flex flex-wrap items-center
                                   gap-x-2 gap-y-1 text-xs text-slate-400 mb-3"
                        >
                            <span class="font-medium text-slate-600">
                                 {{ $video->user->name ?? 'Admin' }}
                            </span>
                            <span>•</span>
                            <span>
                                 {{ $video->published_at?->format('d M Y') }}
                            </span>
                        </div>

                        {{-- DESCRIPTION --}}
                        <p
                            class="text-slate-500 text-xs md:text-sm
                                   leading-relaxed line-clamp-2 md:line-clamp-3 mb-5"
                        >
                            {{ Str::limit(html_entity_decode(strip_tags($video->description), ENT_QUOTES, 'UTF-8'), 100) }}
                        </p>

                        {{-- ACTION --}}
                        <div class="flex items-center justify-between mt-auto pt-2 border-t border-slate-50">

                            {{-- BUTTON DETAIL (Tetap Merah) --}}
                            <a
                                href="{{ route('videos.show', $video->slug) }}"
                                class="inline-flex items-center gap-1.5
                                       px-4 py-2.5 rounded-xl
                                       bg-red-500 text-white
                                       hover:bg-red-600
                                       transition text-xs font-bold shadow-md shadow-red-100"
                            >
                                Lihat Detail
                                <svg class="w-3.5 h-3.5"
                                     fill="none"
                                     stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2.5"
                                          d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>

                            {{-- VIEWS (Aksen Biru Medis Lembut) --}}
                            <span class="inline-flex items-center gap-1 text-xs font-semibold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-lg">
                                {{ number_format($video->views ?? 0) }} views
                            </span>

                        </div>

                    </div>

                </div>

                {{-- MODAL VIDEO (Optimasi Mobile: Pading lebih rapat agar iframe tidak terpotong) --}}
                <template x-if="open">

                    <div
                        x-transition
                        class="fixed inset-0 z-[9999]
                               bg-slate-950/95 backdrop-blur-sm
                               flex items-center justify-center
                               p-3 sm:p-6"
                    >

                        {{-- CLOSE BUTTON (Ganti dengan ikon SVG agar serasi dengan tema Biru/Ungu) --}}
                        <button
                            @click="open = false"
                            class="absolute top-4 right-4 md:top-6 md:right-6
                                   w-10 h-10 md:w-12 md:h-12 rounded-full
                                   bg-white/10 text-white flex items-center justify-center
                                   hover:bg-indigo-600 transition duration-200"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>

                        {{-- VIDEO FRAME CONTAINER --}}
                        <div
                            class="w-full max-w-4xl
                                   aspect-video rounded-2xl md:rounded-[2rem]
                                   overflow-hidden shadow-2xl bg-black"
                        >
                            <iframe
                                src="https://www.youtube.com/embed/{{ \Illuminate\Support\Str::afterLast($video->youtube_url, '=') }}?autoplay=1"
                                class="w-full h-full"
                                allow="autoplay"
                                allowfullscreen
                            ></iframe>
                        </div>

                    </div>

                </template>

            </div>

        @empty

            <div class="col-span-full">

                <div
                    class="bg-white border border-dashed
                           border-slate-200 rounded-[2rem]
                           p-8 md:p-16 text-center shadow-sm"
                >
                    <div class="text-5xl md:text-6xl mb-4 text-indigo-500">
                        🎥
                    </div>

                    <h3
                        class="text-xl md:text-2xl font-bold
                               text-slate-800 mb-1"
                    >
                        Video tidak ditemukan
                    </h3>

                    <p class="text-slate-400 text-sm">
                        Belum ada video kesehatan yang dipublikasikan pada kategori ini.
                    </p>
                </div>

            </div>

        @endforelse

    </div>

    {{-- PAGINATION --}}
    <div class="mt-12">
        {{ $videos->links() }}
    </div>

</div>