<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 md:gap-8">

    @forelse($videos as $video)

        <article
            class="group
                   bg-white
                   rounded-[24px] md:rounded-[32px]
                   overflow-hidden
                   border border-slate-100
                   shadow-sm hover:shadow-xl hover:border-red-100/60
                   transition-all
                   duration-300
                   flex flex-col">

            {{-- Thumbnail --}}
            <a
                href="{{ route('videos.show', $video->slug) }}"
                class="block relative overflow-hidden aspect-[16/9] w-full bg-slate-900">

                <img
                    src="{{ $video->youtube_thumbnail }}"
                    alt="{{ $video->title }}"
                    class="w-full
                           h-full
                           object-cover
                           group-hover:scale-105
                           transition
                           duration-700">

                {{-- Overlay Gelap Lembut --}}
                <div
                    class="absolute inset-0
                           bg-gradient-to-t
                           from-slate-950/60
                           via-slate-950/10
                           to-transparent">
                </div>

                {{-- Badge Video Merah --}}
                <div class="absolute top-4 left-4">

                    <span
                        class="px-2.5 py-1
                               rounded-full
                               bg-red-600
                               text-white
                               text-[10px] sm:text-xs
                               font-bold
                               tracking-wider
                               shadow-sm">
                        VIDEO
                    </span>

                </div>

                {{-- Play Button Berskala Adaptif --}}
                <div
                    class="absolute inset-0
                           flex items-center justify-center">

                    <div
                        class="w-14 h-14 sm:w-16 sm:h-16 md:w-20 md:h-20
                               rounded-full
                               bg-white/95
                               backdrop-blur-sm
                               flex items-center justify-center
                               shadow-xl
                               group-hover:scale-110 group-hover:bg-red-600 group-hover:text-white
                               text-red-600
                               transition-all
                               duration-300">

                        <svg
                            class="w-6 h-6 sm:w-7 sm:h-7 md:w-9 md:h-9
                                   ml-0.5 sm:ml-1
                                   fill-currentColor"
                            viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z"/>
                        </svg>

                    </div>

                </div>

                {{-- Durasi --}}
                @if(!empty($video->duration))

                    <div
                        class="absolute
                               bottom-3
                               right-3
                               px-1.5 py-0.5
                               rounded-md
                               bg-slate-950/75
                               backdrop-blur-sm
                               text-white
                               text-[10px] sm:text-xs
                               font-medium">
                        {{ $video->duration }}
                    </div>

                @endif

            </a>

            {{-- Body --}}
            <div class="p-5 sm:p-6 flex-1 flex flex-col">

                {{-- Tanggal Rilis --}}
                <div
                    class="flex items-center
                           gap-2
                           text-xs sm:text-sm
                           text-slate-400
                           mb-3">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4 text-slate-400/80"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>

                    {{ $video->published_at?->format('d M Y') }}

                </div>

                {{-- Judul Video --}}
                <a href="{{ route('videos.show', $video->slug) }}" class="block group/title">

                    <h3
                        class="font-bold
                               text-lg sm:text-xl
                               text-slate-900
                               leading-snug
                               line-clamp-2
                               group-hover/title:text-red-600
                               group-hover:text-red-600
                               transition duration-200">
                        {{ $video->title }}
                    </h3>

                </a>

                {{-- Deskripsi Ringkas --}}
                <p
                    class="mt-3
                           text-slate-600
                           text-xs sm:text-sm
                           leading-relaxed
                           line-clamp-3
                           flex-1">
                    {{ Str::limit(strip_tags(html_entity_decode($video->description ?? 'Video edukasi kesehatan PortalSehat.')), 110) }}
                </p>

                {{-- Footer Info --}}
                <div
                    class="mt-5
                           pt-4
                           border-t
                           border-slate-100
                           flex
                           items-center
                           justify-between">

                    {{-- Jumlah Penayangan --}}
                    <div
                        class="flex
                               items-center
                               gap-1.5
                               text-xs sm:text-sm
                               text-slate-500">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="w-4 h-4 text-slate-400"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 0s-3 6-9 6-9-6-9-6 3-6 9-6 9 6 9 6z"/>
                        </svg>

                        <span>{{ number_format($video->views ?? 0) }} ditonton</span>

                    </div>

                    {{-- Link Tonton --}}
                    <a
                        href="{{ route('videos.show', $video->slug) }}"
                        class="inline-flex
                               items-center
                               gap-1.5
                               text-xs sm:text-sm
                               font-bold
                               text-red-600
                               hover:text-red-700
                               transition">

                        Tonton

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="w-3.5 h-3.5 transform group-hover:translate-x-0.5 transition-transform"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2.5"
                                d="M9 5l7 7-7 7"/>
                        </svg>

                    </a>

                </div>

            </div>

        </article>

    @empty

        {{-- State Kosong (Merah Netral) --}}
        <div class="col-span-full text-center py-16 md:py-24">

            <div class="inline-flex p-4 rounded-full bg-slate-50 border border-slate-100 mb-4">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-10 h-10 mx-auto text-slate-300"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.5"
                        d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 19h8a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>

            <h3 class="text-lg md:text-xl font-bold text-slate-800">Belum ada video</h3>
            <p class="mt-1.5 text-xs md:text-sm text-slate-500 max-w-sm mx-auto">
                Video edukasi interaktif akan segera dihadirkan dalam waktu dekat.
            </p>

        </div>

    @endforelse

</div>