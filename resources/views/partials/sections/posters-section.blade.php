{{-- FULL BLEED POSTER SECTION --}}
<section
x-data="{
    open: false,
    index: 0,

    images: @js($posters->take(4)->map(fn($p) => [
        'image' => asset('storage/' . $p->poster_file),
        'title' => $p->title,
        'category' => $p->category?->name ?? 'Poster'
    ])),

    get current() {
        return this.images[this.index] || {}
    },

    openModal(i) {
        this.index = i
        this.open = true
        document.body.style.overflow = 'hidden'
    },

    closeModal() {
        this.open = false
        document.body.style.overflow = ''
    },

    next() {
        this.index = (this.index + 1) % this.images.length
    },

    prev() {
        this.index = (this.index - 1 + this.images.length) % this.images.length
    }
}"
class="relative py-16 lg:py-24
       w-screen
       ml-[calc(50%-50vw)]
       overflow-hidden
       bg-white"
style="isolation:isolate;"
>

    {{-- TRANSISI JEMBATAN WARNA --}}
    <div class="absolute top-0 left-0 right-0 h-24 lg:h-32 bg-gradient-to-b from-slate-900 to-white z-10 opacity-10"></div>

    {{-- TRANSISI GRADIENT BORDER --}}
    <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-blue-500 via-purple-500 to-red-500 opacity-40 z-20"></div>

    {{-- BACKGROUND DECORATION --}}
    <div class="absolute top-10 -left-32 w-[300px] h-[300px] lg:w-[500px] lg:h-[500px] bg-blue-200/40 rounded-full blur-3xl z-0"></div>
    <div class="absolute top-20 left-1/3 w-[250px] h-[250px] lg:w-[400px] lg:h-[400px] bg-purple-200/30 rounded-full blur-3xl z-0"></div>
    <div class="absolute bottom-0 -right-32 w-[300px] h-[300px] lg:w-[500px] lg:h-[500px] bg-rose-200/30 rounded-full blur-3xl z-0"></div>

    <div
        class="absolute inset-0 opacity-[0.07] z-0"
        style="background-image: radial-gradient(#6366f1 1.5px, transparent 1.5px); background-size: 24px 24px;"
    ></div>

    {{-- CONTENT --}}
    <div class="relative z-10 max-w-7xl mx-auto px-4 lg:px-8">
        
        {{-- HEADER POSTER --}}
        <div class="max-w-2xl mx-auto text-center mb-12 lg:mb-20">
            <span
                class="inline-flex items-center gap-2
                       px-4 py-2 rounded-full
                       bg-indigo-50
                       border border-indigo-100
                       text-indigo-700 text-xs sm:text-sm font-medium"
            >
                Edukasi Visual Kesehatan
            </span>

            <h2 class="text-slate-900 text-3xl sm:text-4xl lg:text-5xl font-bold tracking-tight mt-3">
                Poster Kesehatan
                <span class="text-indigo-600">
                    Terbaru
                </span>
            </h2>

            <p class="mt-3 text-slate-600 max-w-2xl mx-auto leading-relaxed text-base lg:text-lg px-2">
                Kumpulan poster kesehatan terbaru untuk meningkatkan kesadaran hidup 
                sehat secara visual dan aplikatif yang mudah dipahami oleh masyarakat.
            </p>
        </div>

        {{-- MOBILE SLIDER + DESKTOP GRID --}}
        {{-- Mengubah grid-cols-4 menjadi col-gap dan penyesuaian layout agar pas saat card membesar --}}
        <div
            class="flex lg:grid lg:grid-cols-4
                   gap-6 lg:gap-8
                   overflow-x-auto overflow-y-visible
                   lg:overflow-visible
                   snap-x snap-mandatory
                   scrollbar-hide pb-5"
        >

            @foreach ($posters->take(4) as $poster)

                {{-- MENINGKATKAN MIN-WIDTH MOBILE AGAR CARD LEBIH LEBAR SEDIKIT --}}
                <div class="relative min-w-[88%] sm:min-w-[48%] lg:min-w-0 snap-center">

                    <div
                        @click="openModal({{ $loop->index }})"
                        class="relative group overflow-hidden
                               rounded-[24px] lg:rounded-[28px]
                               h-[450px] sm:h-[480px] lg:h-[520px] {{-- UKURAN TINGGI DIPERBESAR (Sebelumnya: 420px/450px/480px) --}}
                               cursor-pointer
                               bg-white 
                               border-2 border-slate-200
                               shadow-[0_8px_30px_rgb(0,0,0,0.04)] 
                               hover:shadow-[0_20px_50px_rgba(59,130,246,0.2)]
                               hover:-translate-y-2
                               hover:border-red-500
                               transition-all duration-500"
                    >

                        {{-- IMAGE --}}
                        <img
                            src="{{ asset('storage/' . $poster->poster_file) }}"
                            alt="{{ $poster->title }}"
                            class="absolute inset-0 w-full h-full object-cover
                                   group-hover:scale-105 transition duration-700"
                        >

                        {{-- OVERLAY GRADIENT (OPACITY DIURANGI AGAR LEBIH TRANSPARAN) --}}
                        {{-- Mengubah dari from-blue-950/90 ke from-blue-950/75, dan dari via-blue-900/40 ke via-blue-900/20 --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-blue-950/65 via-blue-900/10 to-transparent"></div>

                        {{-- CATEGORY --}}
                        <div class="absolute top-4 left-4 z-20">
                            <span
                                class="inline-flex items-center px-2.5 py-1
                                       rounded-full
                                       bg-blue-600
                                       text-white text-[10px] md:text-xs
                                      tracking-wider
                                       shadow-md"
                            >
                                {{ $poster->category?->name ?? 'Poster' }}
                            </span>
                        </div>

                        {{-- CONTENT TEXT DI ATAS CARD --}}
                        <div class="absolute bottom-0 left-0 right-0 p-5 lg:p-6 text-white z-10">

                            <div class="text-blue-200 text-xs mb-1.5 font-medium">
                                {{ $poster->created_at->format('d M Y') }}
                            </div>

                            {{-- Ditambahkan text-shadow tipis (drop-shadow) agar teks putih tetap terbaca sangat tajam karena opacity gradient dikurangi --}}
                            <h3 class="font-bold text-base md:text-lg line-clamp-2 leading-snug group-hover:text-red-400 transition duration-300 filter drop-shadow-[0_2px_4px_rgba(0,0,0,0.8)]">
                                {{ $poster->title }}
                            </h3>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

        {{-- BUTTON LIHAT SEMUA --}}
        <div class="flex justify-center mt-12 lg:mt-16">
            <a
                href="{{ route('posters.index') }}"
                class="inline-flex items-center gap-2.5
                       px-8 py-4 rounded-2xl
                       bg-gradient-to-r from-red-500 to-rose-600
                       text-white text-sm font-semibold
                       shadow-lg shadow-red-500/20
                       hover:shadow-red-500/30
                       hover:scale-105
                       transition duration-300"
            >
                Lihat Semua Poster

                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

    </div>

    {{-- MODAL FULLSCREEN --}}
    <template x-teleport="body">
        <div
            x-show="open"
            x-transition.opacity
            x-cloak
            class="fixed inset-0 z-[9999999999] bg-slate-950/95 backdrop-blur-md"
            @keydown.escape.window="closeModal()"
            @keydown.arrow-right.window="next()"
            @keydown.arrow-left.window="prev()"
        >
            {{-- HEADER INFO --}}
            <div
                class="absolute top-0 left-0 right-0 z-[99999999999]
                       bg-gradient-to-b from-black/80 to-transparent
                       px-5 lg:px-10
                       pt-20 lg:pt-8
                       pb-8"
            >
                <div class="max-w-5xl mx-auto">
                    <span
                        class="inline-flex items-center px-3 py-1.5
                               rounded-full
                               bg-blue-600
                               text-white text-xs
                               font-semibold
                               mb-4"
                        x-text="current.category"
                    ></span>
                </div>
            </div>

            {{-- CLOSE --}}
            <button
                @click="closeModal()"
                class="fixed
                       top-[max(1rem,env(safe-area-inset-top))]
                       right-[max(1rem,env(safe-area-inset-right))]
                       z-[99999999999]
                       w-12 h-12 lg:w-14 lg:h-14
                       flex items-center justify-center
                       text-white text-2xl
                       bg-black/60 hover:bg-black/80
                       rounded-full transition"
            >
                ✕
            </button>

            {{-- PREV --}}
            <button
                @click="prev()"
                class="fixed left-2 lg:left-4 top-1/2 -translate-y-1/2
                       z-[99999999999]
                       w-12 h-12 lg:w-16 lg:h-16
                       flex items-center justify-center
                       text-white text-3xl
                       bg-black/30 hover:bg-black/60
                       rounded-full transition"
            >
                ‹
            </button>

            {{-- NEXT --}}
            <button
                @click="next()"
                class="fixed right-2 lg:right-4 top-1/2 -translate-y-1/2
                       z-[99999999999]
                       w-12 h-12 lg:w-16 lg:h-16
                       flex items-center justify-center
                       text-white text-3xl
                       bg-black/30 hover:bg-black/60
                       rounded-full transition"
            >
                ›
            </button>

            {{-- IMAGE container --}}
            <div class="absolute inset-0 flex items-center justify-center p-4 sm:p-6">
                <img
                    :src="current.image"
                    :alt="current.title"
                    class="max-h-[92vh]
                           max-w-[95vw]
                           w-auto h-auto
                           object-contain mx-auto"
                >
            </div>
        </div>
    </template>

</section>

<style>
[x-cloak]{
    display:none !important;
}

.scrollbar-hide::-webkit-scrollbar{
    display:none;
}

.scrollbar-hide{
    -ms-overflow-style:none;
    scrollbar-width:none;
}
</style>