<div class="mt-24">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-5 mb-10">

        <div>

            {{-- BADGE --}}
            <div class="inline-flex items-center gap-2
                        px-4 py-2 rounded-full
                        bg-emerald-50 border border-emerald-100
                        text-emerald-700 text-xs font-semibold
                        mb-4">

                <div class="w-2 h-2 rounded-full bg-emerald-500"></div>

                Video Pembelajaran

            </div>

            {{-- TITLE --}}
            <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 tracking-tight">

                Video Edukasi
                <span class="text-emerald-600">
                    Kesehatan
                </span>

            </h2>

            {{-- DESC --}}
            <p class="text-slate-500 mt-3 max-w-2xl leading-relaxed text-sm sm:text-base">

                Kumpulan video edukasi kesehatan terbaru dengan pembahasan
                menarik dan mudah dipahami untuk meningkatkan kesadaran hidup sehat.

            </p>

        </div>

        {{-- BUTTON --}}
        <a href="{{ route('videos.index') }}"
           class="group inline-flex items-center justify-center
                  gap-2 px-5 py-3 rounded-2xl
                  bg-slate-900 text-white
                  hover:bg-emerald-600
                  transition-all duration-300
                  font-semibold text-sm sm:text-base
                  w-full sm:w-auto">

            Lihat Semua

            <span class="transition-transform duration-300
                         group-hover:translate-x-1">

                →

            </span>

        </a>

    </div>

    {{-- EMPTY --}}
    @if($videos->isEmpty())

        <div class="rounded-[30px]
                    border border-slate-200
                    bg-gradient-to-br from-slate-50 to-white
                    p-12 text-center">

            <div class="w-20 h-20 rounded-full
                        bg-slate-100
                        flex items-center justify-center
                        mx-auto mb-5">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-10 h-10 text-slate-400"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="1.5"
                          d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14m-6 4h4a2 2 0 002-2V8a2 2 0 00-2-2H9a2 2 0 00-2 2v8a2 2 0 002 2zm-4 0h.01"/>

                </svg>

            </div>

            <h3 class="text-xl font-bold text-slate-800 mb-2">
                Belum Ada Video
            </h3>

            <p class="text-slate-500">
                Video edukasi kesehatan akan segera ditambahkan.
            </p>

        </div>

    @else

        {{-- GRID --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-7">

            @foreach ($videos as $video)

                <div class="group relative">

                    {{-- GLOW --}}
                    <div class="absolute -inset-1
                                bg-gradient-to-r
                                from-emerald-500/0
                                via-emerald-500/10
                                to-cyan-500/0
                                rounded-[30px]
                                blur-xl opacity-0
                                group-hover:opacity-100
                                transition duration-500">
                    </div>

                    {{-- CARD --}}
                    <div class="relative h-full
                                rounded-[28px]
                                overflow-hidden
                                bg-white border border-slate-200
                                hover:border-emerald-200
                                hover:-translate-y-2
                                transition-all duration-500">

                        @include('partials.cards.video-card', [
                            'video' => $video
                        ])

                    </div>

                </div>

            @endforeach

        </div>

    @endif

</div>