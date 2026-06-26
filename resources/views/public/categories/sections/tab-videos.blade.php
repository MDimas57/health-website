<div class="grid md:grid-cols-2 xl:grid-cols-3 gap-8">

    @forelse($videos as $video)

        <article
            class="group
                   bg-white
                   rounded-3xl
                   overflow-hidden
                   border border-slate-200
                   shadow-sm
                   hover:shadow-xl
                   transition-all
                   duration-300">

            {{-- Thumbnail --}}
            <a
                href="{{ route('videos.show',$video->slug) }}"
                class="relative block overflow-hidden">

                <img
                    src="{{ $video->youtube_thumbnail }}"
                    alt="{{ $video->title }}"
                    class="w-full
                           h-60
                           object-cover
                           group-hover:scale-105
                           transition
                           duration-700">

                {{-- Overlay --}}
                <div
                    class="absolute inset-0
                           bg-gradient-to-t
                           from-black/70
                           via-black/10
                           to-transparent">
                </div>

                {{-- Badge --}}
                <div class="absolute top-5 left-5">

                    <span
                        class="px-3 py-1.5
                               rounded-full
                               bg-red-600
                               text-white
                               text-xs
                               font-semibold">

                        VIDEO

                    </span>

                </div>

                {{-- Play Button --}}
                <div
                    class="absolute inset-0
                           flex items-center justify-center">

                    <div
                        class="w-20 h-20
                               rounded-full
                               bg-white/90
                               backdrop-blur
                               flex items-center justify-center
                               shadow-2xl
                               group-hover:scale-110
                               transition">

                        <svg
                            class="w-9 h-9
                                   text-red-600
                                   ml-1"
                            fill="currentColor"
                            viewBox="0 0 24 24">

                            <path d="M8 5v14l11-7z"/>

                        </svg>

                    </div>

                </div>

                {{-- Duration --}}
                @if(!empty($video->duration))

                    <div
                        class="absolute
                               bottom-4
                               right-4
                               px-2 py-1
                               rounded-lg
                               bg-black/70
                               text-white
                               text-xs">

                        {{ $video->duration }}

                    </div>

                @endif

            </a>

            {{-- Body --}}
            <div class="p-6">

                <div
                    class="flex items-center
                           gap-2
                           text-sm
                           text-slate-400
                           mb-3">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4"
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

                <a href="{{ route('videos.show',$video->slug) }}">

                    <h3
                        class="font-bold
                               text-xl
                               text-slate-900
                               leading-snug
                               line-clamp-2
                               group-hover:text-red-600
                               transition">

                        {{ $video->title }}

                    </h3>

                </a>

                <p
                    class="mt-4
                           text-slate-600
                           line-clamp-3
                           leading-7">

                    {{ Str::limit(strip_tags(html_entity_decode($video->description ?? 'Video edukasi kesehatan PortalSehat.')),130) }}

                </p>

                <div
                    class="mt-6
                           pt-5
                           border-t
                           border-slate-100
                           flex
                           items-center
                           justify-between">

                    <div
                        class="flex
                               items-center
                               gap-2
                               text-sm
                               text-slate-500">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="w-4 h-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 0s-3 6-9 6-9-6-9-6 3-6 9-6 9 6 9 6z"/>

                        </svg>

                        {{ number_format($video->views ?? 0) }}

                    </div>

                    <span
                        class="inline-flex
                               items-center
                               gap-2
                               text-red-600
                               font-semibold
                               text-sm">

                        Tonton

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="w-4 h-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 5l7 7-7 7"/>

                        </svg>

                    </span>

                </div>

            </div>

        </article>

    @empty

        <div class="col-span-full text-center py-20">

            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-16 h-16 mx-auto text-slate-300"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24">

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 19h8a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>

            </svg>

            <h3 class="mt-5 text-xl font-semibold text-slate-700">

                Belum ada video

            </h3>

            <p class="mt-2 text-slate-500">

                Video edukasi akan ditampilkan di sini.

            </p>

        </div>

    @endforelse

</div>