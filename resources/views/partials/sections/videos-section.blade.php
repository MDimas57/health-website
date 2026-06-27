<div class="mt-24">

{{-- HEADER --}}
<div class="mb-10 lg:mb-12">

    <div class="text-center lg:text-left">

        {{-- BADGE --}}
        <div
            class="inline-flex items-center gap-2
                   px-4 py-2 rounded-full
                   bg-emerald-50 border border-emerald-100
                   text-emerald-700 text-xs sm:text-sm font-semibold
                   mb-4">

            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>

            Video Pembelajaran

        </div>

        {{-- TITLE --}}
        <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl
                   font-bold leading-tight text-slate-800">

            Video Edukasi

            <span class="text-emerald-600">
                Kesehatan
            </span>

        </h2>

        {{-- DESC --}}
        <p
            class="mt-4 text-sm sm:text-base
                   text-slate-500 leading-relaxed
                   max-w-2xl
                   mx-auto lg:mx-0">

            Kumpulan video edukasi kesehatan terbaru dengan pembahasan
            menarik dan mudah dipahami untuk meningkatkan kesadaran hidup sehat.

        </p>

    </div>

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

 {{-- MOBILE SLIDER --}}
<div class="md:hidden">

    <div
        class="flex gap-5 overflow-x-auto snap-x snap-mandatory
               scrollbar-hide pb-3">

        @foreach($videos as $video)

            <div
                class="snap-center shrink-0 w-[88%] sm:w-[70%]">

                <div
                    class="rounded-[28px]
                           overflow-hidden
                           bg-white
                           border border-slate-200">

                    @include('partials.cards.video-card', [
                        'video' => $video
                    ])

                </div>

            </div>

        @endforeach

    </div>

</div>

{{-- DESKTOP GRID --}}
<div class="hidden md:grid md:grid-cols-2 xl:grid-cols-3 gap-7">

    @foreach($videos as $video)

        <div class="group relative">

            {{-- Glow --}}
            <div
                class="absolute -inset-1
                       rounded-[30px]
                       blur-xl
                       opacity-0
                       transition
                       duration-500
                       bg-gradient-to-r
                       from-emerald-500/0
                       via-emerald-500/10
                       to-cyan-500/0
                       group-hover:opacity-100">
            </div>

            <div
                class="relative
                       h-full
                       rounded-[28px]
                       overflow-hidden
                       bg-white
                       border border-slate-200
                       hover:border-emerald-200
                       hover:-translate-y-2
                       transition-all
                       duration-500">

                @include('partials.cards.video-card', [
                    'video' => $video
                ])

            </div>

        </div>

    @endforeach

</div>


    @endif
    {{-- BUTTON --}}
<div class="flex justify-center mt-10">

    <a href="{{ route('videos.index') }}"
       class="inline-flex items-center gap-3
                       px-8 py-4 rounded-2xl
                       bg-emerald-600
                       text-white font-semibold
                       hover:bg-emerald-700
                       transition">

        Lihat Semua Video

         <svg
                    class="w-5 h-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 5l7 7-7 7"
                    />

        </svg>

    </a>

</div>

</div>