
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
class="relative py-14 lg:py-20
       w-screen
       ml-[calc(50%-50vw)]
       overflow-hidden
       bg-[#d9d6d1]"
style="isolation:isolate;"
>

    {{-- BACKGROUND --}}
    <div class="absolute inset-0 bg-gradient-to-br from-[#161616] via-[#1b1b1b] to-[#252525]"></div>

    <div class="absolute -top-32 -left-32 w-[300px] h-[300px] lg:w-[500px] lg:h-[500px] bg-emerald-500/10 rounded-full blur-3xl"></div>

    <div class="absolute -bottom-32 -right-32 w-[300px] h-[300px] lg:w-[500px] lg:h-[500px] bg-slate-500/10 rounded-full blur-3xl"></div>

    <div
        class="absolute inset-0 opacity-[0.03]"
        style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 22px 22px;"
    ></div>

    {{-- CONTENT --}}
    <div class="relative z-10 max-w-[1250px] mx-auto px-4 lg:px-8">

        {{-- HEADER --}}
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-10 lg:mb-12">

            <div>
                <span
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full
                           bg-white/5 border border-white/10
                           text-emerald-300 text-xs lg:text-sm
                           font-medium backdrop-blur-xl mb-4 lg:mb-5"
                >
                    <div class="w-2 h-2 rounded-full bg-emerald-400"></div>
                    Edukasi Visual Kesehatan
                </span>

                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white">
                    Poster Kesehatan
                    <span class="text-emerald-400">Terbaru</span>
                </h2>

                <p class="text-slate-300 mt-4 lg:mt-5 max-w-2xl">
                    Kumpulan poster kesehatan terbaru untuk meningkatkan kesadaran hidup sehat.
                </p>
            </div>

        </div>

        {{-- MOBILE SLIDER + DESKTOP GRID --}}
        <div
            class="flex lg:grid lg:grid-cols-4
                   gap-5 lg:gap-7
                   overflow-x-auto overflow-y-visible
                   lg:overflow-visible
                   snap-x snap-mandatory
                   scrollbar-hide pb-3"
        >

            @foreach ($posters->take(4) as $poster)

                <div class="relative min-w-[85%] sm:min-w-[48%] lg:min-w-0 snap-center">

                    <div
                        @click="openModal({{ $loop->index }})"
                        class="relative group overflow-hidden
                               rounded-[24px] lg:rounded-[28px]
                               h-[420px] sm:h-[450px] lg:h-[480px]
                               cursor-pointer
                               bg-white/5 border border-white/10
                               backdrop-blur-sm
                               hover:-translate-y-2
                               hover:border-white/20
                               transition-all duration-500"
                    >

                        {{-- IMAGE --}}
                        <img
                            src="{{ asset('storage/' . $poster->poster_file) }}"
                            alt="{{ $poster->title }}"
                            class="absolute inset-0 w-full h-full object-cover
                                   group-hover:scale-105 transition duration-700"
                        >

                        {{-- OVERLAY --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent"></div>

                        {{-- CATEGORY --}}
                        <div class="absolute top-4 left-4 z-20">

                            <span
                                class="inline-flex items-center px-3 py-1.5
                                       rounded-full
                                       bg-emerald-500/90
                                       text-white text-[11px] lg:text-xs
                                       font-semibold
                                       shadow-lg backdrop-blur-md"
                            >
                                {{ $poster->category?->name ?? 'Poster' }}
                            </span>

                        </div>

                        {{-- CONTENT --}}
                        <div class="absolute bottom-0 left-0 right-0 p-5 lg:p-6 text-white">

                            <div class="text-white/70 text-xs lg:text-sm mb-2">
                                {{ $poster->created_at->format('d M Y') }}
                            </div>

                            <h3 class="font-bold text-lg line-clamp-2">
                                {{ $poster->title }}
                            </h3>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

        {{-- BUTTON LIHAT SEMUA --}}
        <div class="flex justify-center mt-10 lg:mt-14">

            <a
                href="{{ route('posters.index') }}"
                class="inline-flex items-center gap-3
                       px-7 py-4
                       rounded-2xl
                       bg-emerald-500 hover:bg-emerald-400
                       text-white font-semibold
                       shadow-lg shadow-emerald-500/20
                       transition-all duration-300
                       hover:scale-[1.02]"
            >
                Lihat Semua Poster

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M17 8l4 4m0 0l-4 4m4-4H3"
                    />
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
            class="fixed inset-0 z-[9999999999] bg-black/95 backdrop-blur-sm"
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

                    {{-- CATEGORY --}}
                    <span
                        class="inline-flex items-center px-3 py-1.5
                               rounded-full
                               bg-emerald-500/90
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

            {{-- IMAGE --}}
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
