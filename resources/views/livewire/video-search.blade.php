<div>

    {{-- TOOLBAR --}}
    <div class="flex flex-col lg:flex-row gap-4 justify-between items-center mb-10">

        {{-- SEARCH --}}
        <div class="relative w-full lg:w-1/2">

            <input
                type="text"
                wire:model.live.debounce.500ms="q"
                placeholder="Cari video kesehatan..."
                class="w-full pl-12 pr-4 py-3 rounded-2xl border border-slate-200
                       focus:ring-2 focus:ring-red-500 focus:border-red-500
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

            <option value="latest">Video Terbaru</option>
            <option value="oldest">Video Terlama</option>
            <option value="popular">Paling Populer</option>

        </select>

    </div>



    {{-- CATEGORY --}}
    <div class="flex flex-wrap gap-3 mb-10">

        <button
            wire:click="$set('category', null)"
            class="px-5 py-2 rounded-full text-sm transition
            {{ !$category
                ? 'bg-red-500 text-white shadow-lg shadow-red-200'
                : 'bg-white border border-slate-200 text-slate-600 hover:bg-red-50'
            }}"
        >
            Semua
        </button>

        @foreach($categories as $cat)

            <button
                wire:click="$set('category', {{ $cat->id }})"
                class="px-5 py-2 rounded-full text-sm transition
                {{ $category == $cat->id
                    ? 'bg-red-500 text-white shadow-lg shadow-red-200'
                    : 'bg-white border border-slate-200 text-slate-600 hover:bg-red-50'
                }}"
            >

                {{ $cat->name }}

            </button>

        @endforeach

    </div>



    {{-- GRID --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">

        @forelse($videos as $video)

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
                    <div class="relative h-[260px] overflow-hidden">

                        <img
                            src="https://img.youtube.com/vi/{{ \Illuminate\Support\Str::afterLast($video->youtube_url, '=') }}/hqdefault.jpg"
                            class="w-full h-full object-cover
                                   group-hover:scale-110
                                   transition duration-700"
                        >

                        {{-- OVERLAY --}}
                        <div
                            class="absolute inset-0
                                   bg-gradient-to-t
                                   from-black/80
                                   via-black/20
                                   to-transparent"
                        ></div>



                        {{-- PLAY BUTTON --}}
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
                                       transition"
                            >

                                <svg class="w-8 h-8 text-white ml-1"
                                     fill="currentColor"
                                     viewBox="0 0 24 24">

                                    <path d="M8 5v14l11-7z"/>

                                </svg>

                            </div>

                        </button>



                        {{-- CATEGORY --}}
                        <div class="absolute top-4 left-4">

                            <span
                                class="bg-red-500/90 backdrop-blur
                                       text-white text-xs
                                       px-3 py-1 rounded-full"
                            >

                                 {{ $video->category->name ?? 'Video' }}

                            </span>

                        </div>



                        {{-- CONTENT --}}
                        <div
                            class="absolute bottom-0 left-0 right-0
                                   p-5 text-white"
                        >

                            <h3
                                class="text-xl font-bold
                                       line-clamp-2"
                            >

                                {{ $video->title }}

                            </h3>

                        </div>

                    </div>

                    {{-- CONTENT --}}
                    <div class="p-6">

                        {{-- META --}}
                        <div
                            class="flex flex-wrap items-center
                                   gap-3 text-xs text-slate-500 mb-4"
                        >

                            <span>
                                {{ $video->user->name ?? 'Admin' }}
                            </span>

                            <span>•</span>

                            <span>
                                {{ $video->published_at?->format('d M Y') }}
                            </span>

                            <span>•</span>

                            <span>
                                👁 {{ number_format($video->views ?? 0) }}
                            </span>

                        </div>



                       {{-- DESCRIPTION --}}
<p
    class="text-slate-500 text-sm
           leading-relaxed line-clamp-3 mb-5"
>
    {{ Str::limit(strip_tags($video->description), 120) }}
</p>

{{-- ACTION --}}
<div class="flex items-center justify-between">

    <a
        href="{{ route('videos.show', $video->slug) }}"
        class="inline-flex items-center gap-2
               px-4 py-2 rounded-xl
               bg-red-500 text-white
               hover:bg-red-600
               transition text-sm font-semibold"
    >
        Lihat Detail

        <svg class="w-4 h-4"
             fill="none"
             stroke="currentColor"
             viewBox="0 0 24 24">
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M9 5l7 7-7 7"
            />
        </svg>
    </a>

    <span class="text-xs text-slate-400">
        👁 {{ number_format($video->views ?? 0) }}
    </span>

</div>

                    </div>

                </div>



                        {{-- MODAL --}}
                    <template x-if="open">

                        <div
                            x-transition
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



                            {{-- VIDEO --}}
                            <div
                                class="w-full max-w-5xl
                                    aspect-video rounded-3xl
                                    overflow-hidden shadow-2xl"
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
                           border-slate-300 rounded-3xl
                           p-14 text-center"
                >

                    <div class="text-7xl mb-6">
                        🎥
                    </div>

                    <h3
                        class="text-2xl font-bold
                               text-slate-700 mb-2"
                    >
                        Video tidak ditemukan
                    </h3>

                    <p class="text-slate-500">
                        Belum ada video kesehatan yang dipublikasikan.
                    </p>

                </div>

            </div>

        @endforelse

    </div>



    {{-- PAGINATION --}}
    <div class="mt-14">

        {{ $videos->links() }}

    </div>

</div>