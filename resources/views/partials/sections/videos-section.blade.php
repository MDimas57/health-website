{{-- SECTION DENGAN FULL BACKGROUND MERAH YOUTUBE --}}
<section class="relative py-16 lg:py-24
                w-screen
                ml-[calc(50%-50vw)]
                overflow-hidden
                bg-[#FF0000]"> {{-- Menggunakan merah solid YouTube agar kontras dengan putih lebih menyala --}}

    {{-- GARIS HITAM DI PALING ATAS SECTION --}}
    <div class="absolute top-0 left-0 w-full h-[6px] bg-black z-20"></div>
    
    {{-- ELEMEN DEKORASI GELAP AGAR MERAH LEBIH ELEGAN & BERDIMENSI --}}
    <div class="absolute inset-0 bg-gradient-to-tr from-black/10 via-transparent to-white/10 z-0 pointer-events-none"></div>

    {{-- TEKSTUR DOTS --}}
    <div
        class="absolute inset-0 opacity-[0.08] z-0 pointer-events-none"
        style="background-image: radial-gradient(#ffffff 1.5px, transparent 1.5px); background-size: 24px 24px;"
    ></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 lg:px-8">
        
        {{-- HEADER --}}
        <div class="max-w-2xl mx-auto text-center mb-12 lg:mb-16">
            <span
                class="inline-flex items-center gap-2
                       px-4 py-2 rounded-full
                       bg-black/30 border border-white/20
                       text-white text-xs sm:text-sm font-medium backdrop-blur-sm shadow-inner"
            >
                Edukasi Digital Kesehatan
            </span>

            <h2 class="text-white text-3xl sm:text-4xl lg:text-5xl font-bold tracking-tight mt-3 filter drop-shadow-md">
                Video Edukasi
                <span class="text-black">
                    Terbaru
                </span>
            </h2>

            <p class="mt-3 text-white/95 max-w-2xl mx-auto leading-relaxed text-base lg:text-lg px-2">
                Kumpulan video edukasi kesehatan terbaru dengan pembahasan menarik 
                dan mudah dipahami untuk meningkatkan kesadaran hidup sehat.
            </p>
        </div>

        {{-- EMPTY STATE --}}
        @if($videos->isEmpty())

            <div class="rounded-[30px]
                        border border-white/20
                        bg-white/10 backdrop-blur-md
                        p-12 text-center">

                <div class="w-20 h-20 rounded-full
                            bg-white/20
                            flex items-center justify-center
                            mx-auto mb-5 border border-white/30">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-10 h-10 text-white"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="1.5"
                              d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14m-6 4h4a2 2 0 002-2V8a2 2 0 00-2-2H9a2 2 0 00-2 2v8a2 2 0 002 2zm-4 0h.01"/>

                    </svg>

                </div>

                <h3 class="text-xl font-bold text-white mb-2">
                    Belum Ada Video
                </h3>

                <p class="text-white/80">
                    Video edukasi kesehatan akan segera ditambahkan.
                </p>

            </div>

        @else

            {{-- MOBILE SLIDER --}}
            <div class="md:hidden">

                <div
                    class="flex gap-5 overflow-x-auto snap-x snap-mandatory
                           scrollbar-hide pb-5">

                    @foreach($videos as $video)

                        <div
                            class="snap-center shrink-0 w-[85%] sm:w-[70%]">

                            <div
                                class="rounded-[24px]
                                       overflow-hidden
                                       bg-white text-zinc-900
                                       border border-white/20
                                       shadow-xl">

                                {{-- PENTING: 'isDark' diubah menjadi false agar teks di dalam komponen card menjadi hitam/gelap --}}
                                @include('partials.cards.video-card', [
                                    'video' => $video,
                                    'isDark' => false
                                ])

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>

            {{-- DESKTOP GRID --}}
            <div class="hidden md:grid md:grid-cols-2 xl:grid-cols-3 gap-8">

                @foreach($videos as $video)

                    <div class="group relative">

                        {{-- Glow Effect (Bayangan halus saat di-hover agar pop-out di atas background merah) --}}
                        <div
                            class="absolute -inset-1
                                   rounded-[30px]
                                   blur-xl
                                   opacity-0
                                   transition
                                   duration-500
                                   bg-black/30
                                   group-hover:opacity-100">
                        </div>

                        {{-- Card Container (Sekarang menggunakan Putih Bersih & Teks Gelap) --}}
                        <div
                            class="relative
                                   h-full
                                   rounded-[24px]
                                   overflow-hidden
                                   bg-white text-zinc-900
                                   border border-transparent
                                   shadow-lg
                                   hover:shadow-[0_20px_40px_rgba(0,0,0,0.3)]
                                   hover:-translate-y-2
                                   transition-all
                                   duration-500">

                            {{-- PENTING: 'isDark' diubah menjadi false agar teks di dalam komponen card menjadi hitam/gelap --}}
                            @include('partials.cards.video-card', [
                                'video' => $video,
                                'isDark' => false
                            ])

                        </div>

                    </div>

                @endforeach

            </div>

        @endif

        {{-- BUTTON LIHAT SEMUA --}}
        <div class="flex justify-center mt-10 lg:mt-12">

            <a href="{{ route('videos.index') }}"
               class="group inline-flex items-center gap-2.5
                      px-8 py-4 rounded-2xl
                      bg-zinc-950 border border-zinc-800
                      text-white font-semibold text-sm tracking-wide
                      shadow-xl shadow-black/30
                      hover:bg-black
                      hover:scale-105
                      transition duration-300">

                Lihat Semua Video

                <svg
                    class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2.5"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M9 5l7 7-7 7"
                    />
                </svg>

            </a>

        </div>
    </div>

</section>