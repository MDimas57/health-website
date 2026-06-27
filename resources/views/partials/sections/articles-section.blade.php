<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<style>
@keyframes rotateWords {
    0%, 25% {
        transform: translateY(0);
    }

    33%, 58% {
        transform: translateY(-60px);
    }

    66%, 91% {
        transform: translateY(-120px);
    }

    100% {
        transform: translateY(-180px);
    }
}

.animate-rotate-words {
    animation: rotateWords 9s infinite;
}
</style>
<section class="relative w-screen
           left-1/2 -translate-x-1/2
           bg-white
           py-16 lg:py-24
           overflow-hidden">

    <div class="max-w-7xl mx-auto px-4 lg:px-8">

        {{-- HEADER --}}
        <div
                x-data="{
                    words: ['Artikel', 'Video', 'Poster Kesehatan'],
                    current: 0,
                    init() {
                        setInterval(() => {
                            this.current = (this.current + 1) % this.words.length
                        }, 2500)
                    }
                }"
                class="max-w-2xl mx-auto text-center mb-12 lg:mb-20"
            >

                <span
                    class="inline-flex items-center gap-2
                        px-4 py-2 rounded-full
                        bg-emerald-50
                        border border-emerald-100
                        text-emerald-700 text-xs sm:text-sm font-medium"
                >
                    Konten Terbaru
                </span>

               <h2 class="mt-4
                            text-3xl
                            sm:text-4xl
                            lg:text-5xl
                            font-bold
                            text-center">
                    <div
                        x-data="{
                            words:['Artikel','Video','Poster'],
                            current:0,
                            init(){
                                setInterval(()=>{
                                    this.current=(this.current+1)%this.words.length
                                },2500)
                            }
                        }"
                        class="flex justify-center items-center gap-1 sm:gap-2"
                    >

                        <div class="relative
                                    w-[100px]
                                    sm:w-[120px]
                                    lg:w-[140px]
                                    h-[50px]
                                    sm:h-[60px]
                                    lg:h-[70px]">

                            <template x-for="(word,index) in words" :key="index">

                                <span
                                    x-show="current===index"
                                    x-transition:enter="transition duration-700 ease-out"
                                    x-transition:enter-start="opacity-0 translate-y-5"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    x-transition:leave="transition duration-700 ease-in"
                                    x-transition:leave-start="opacity-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 -translate-y-5"
                                    class="absolute inset-0 flex items-center justify-end text-emerald-600"
                                    x-text="word"
                                ></span>

                            </template>

                        </div>

                        <span class="text-slate-900">
                            Kesehatan
                        </span>

                    </div>

                </h2>

                <p
                    class="mt-4
                        text-slate-600
                        leading-relaxed
                        text-base
                        lg:text-lg
                        px-2"
                >
                    Informasi kesehatan terbaru yang disajikan secara sederhana,
                    terpercaya, dan mudah dipahami oleh masyarakat.
                </p>

            </div>

        {{-- FEATURED AREA --}}
     <div class="grid lg:grid-cols-12 gap-5 lg:gap-8 mb-10">

            {{-- FEATURED ARTICLE --}}
            @if($featuredArticle)

                <a
                    href="{{ route('articles.show', $featuredArticle->slug) }}"
                    class="lg:col-span-8
                           bg-white
                           rounded-[32px]
                           overflow-hidden
                           border border-slate-200
                           shadow-sm
                           hover:shadow-2xl
                           hover:border-emerald-200
                           transition-all duration-500
                           group"
                >

                    <div class="relative h-[500px] overflow-hidden">

                        <img
                            src="{{ $featuredArticle->thumbnail
                                ? asset('storage/' . $featuredArticle->thumbnail)
                                : asset('images/default.jpg') }}"
                            alt="{{ $featuredArticle->title }}"
                            class="w-full h-full object-cover
                                   group-hover:scale-105
                                   transition duration-700"
                        >

                        <div
                            class="absolute inset-0
                                   bg-gradient-to-t
                                   from-black/60
                                   via-black/10
                                   to-transparent"
                        ></div>

                       <div class="absolute
                                top-4 left-4
                                lg:top-6 lg:left-6
                                flex flex-wrap gap-2">
                        

                            <span
                                class="px-4 py-2 rounded-full
                                       bg-white/90 backdrop-blur
                                       text-slate-800 text-xs font-semibold"
                            >
                                {{ optional($featuredArticle->category)->name ?? 'Kesehatan' }}
                            </span>

                            <span
                                class="px-4 py-2 rounded-full
                                       bg-emerald-600
                                       text-white text-xs font-semibold"
                            >
                                Artikel
                            </span>

                        </div>

                        <div
                            class="absolute bottom-5 left-5 right-5 lg:bottom-8 lg:left-8 lg:right-8 text-white"
                        >

                            <p class="text-sm text-white/80 mb-3">
                                {{ $featuredArticle->created_at->format('d M Y') }}
                            </p>

                            <h3
                                class="text-xl sm:text-2xl lg:text-4xl
                                       font-bold leading-tight
                                       line-clamp-2"
                            >
                                {{ $featuredArticle->title }}
                            </h3>

                            <p
                                class="mt-4 text-white/90
                                       max-w-2xl line-clamp-2"
                            >
                                {{ \Illuminate\Support\Str::limit(strip_tags($featuredArticle->content), 140) }}
                            </p>

                        </div>

                    </div>

                </a>

            @endif

            {{-- FEATURED POSTER --}}
            <div
                class="lg:col-span-4
                       rounded-[32px]
                       overflow-hidden
                       border border-slate-200
                       shadow-sm
                       hover:shadow-2xl
                       hover:border-emerald-200
                       transition-all duration-500 hidden md:block"
            >

                @if($featuredPosters->count())

                    @php
                        $poster = $featuredPosters->first();
                    @endphp

                    <a
                        href="{{ route('posters.show', $poster->slug) }}"
                        class="relative block h-full"
                    >

                        <img
                            src="{{ asset('storage/' . $poster->poster_file) }}"
                            alt="{{ $poster->title }}"
                            class="w-full h-[320px] sm:h-[420px] lg:h-[500px] object-cover hover:scale-105
                                   transition duration-700"
                        >

                        <div
                            class="absolute inset-0
                                   bg-gradient-to-t
                                   from-black/70
                                   via-black/20
                                   to-transparent"
                        ></div>

                        <div
                            class="absolute top-6 left-6"
                        >

                            <span
                                class="px-4 py-2 rounded-full
                                       bg-white/90 backdrop-blur
                                       text-slate-800 text-xs font-semibold"
                            >
                                Poster Terbaru
                            </span>

                        </div>

                        <div
                            class="absolute bottom-6 left-6 right-6 text-white"
                        >

                            <h3
                                class="text-2xl font-bold
                                       line-clamp-2"
                            >
                                {{ $poster->title }}
                            </h3>

                            <div class="mt-4">

                                <span
                                    class="inline-flex items-center gap-2
                                           px-4 py-2 rounded-full
                                           bg-white/15 backdrop-blur
                                           text-white text-sm"
                                >
                                    Lihat Poster →
                                </span>

                            </div>

                        </div>

                    </a>

                @endif

            </div>

        </div>

        {{-- LATEST CONTENT --}}
       <div
            x-data="autoSlider()"
            x-init="start()"
            x-ref="slider"
            class="
                flex
                md:grid md:grid-cols-2
                lg:grid-cols-3

                gap-5 lg:gap-7

                overflow-x-auto
                md:overflow-visible

                snap-x snap-mandatory
                scrollbar-hide

                scroll-smooth
                pb-2
            "
        >
            @foreach($latestPosts as $post)

                <a
                    href="{{ $post->content_type === 'video'
                        ? route('videos.show', $post->slug)
                        : route('articles.show', $post->slug) }}"
                    class="group min-w-[85%] sm:min-w-[70%] md:min-w-0 snap-center bg-white
                        rounded-[28px]
                        overflow-hidden
                        border border-slate-200
                        shadow-sm
                        hover:shadow-xl
                        hover:-translate-y-2
                        hover:border-emerald-200
                        transition-all duration-500"
                >

                    {{-- IMAGE --}}
                    <div class="h-48 sm:h-56 overflow-hidden">

                     @if($post->content_type === 'video')

                            <div class="relative w-full h-full">

                                <img
                                    src="https://img.youtube.com/vi/{{ $post->youtube_id }}/hqdefault.jpg"
                                    class="w-full h-full object-cover
                                        group-hover:scale-105
                                        transition duration-700"
                                >

                                {{-- OVERLAY --}}
                                <div class="absolute inset-0 bg-black/20"></div>

                                {{-- PLAY BUTTON --}}
                                <div
                                    class="absolute inset-0
                                        flex items-center justify-center"
                                >

                                    <div
                                        class="w-16 h-16 rounded-full
                                            bg-red-600/95
                                            shadow-2xl
                                            flex items-center justify-center
                                            group-hover:scale-110
                                            transition duration-300"
                                    >

                                        <svg
                                            class="w-8 h-8 text-white ml-1"
                                            fill="currentColor"
                                            viewBox="0 0 24 24"
                                        >

                                            <path d="M8 5v14l11-7z"/>

                                        </svg>

                                    </div>

                                </div>

                                {{-- LABEL VIDEO --}}
                                <div class="absolute top-4 left-4">

                                </div>

                            </div>

                        @else

                            <img
                                src="{{ $post->thumbnail
                                    ? asset('storage/' . $post->thumbnail)
                                    : asset('images/default.jpg') }}"
                                class="w-full h-full object-cover
                                       group-hover:scale-105
                                       transition duration-700"
                            >

                        @endif

                    </div>

                    {{-- CONTENT --}}
                    <div class="p-5 lg:p-6">

                        <span
                            class="inline-flex px-3 py-1 rounded-full
                                   bg-emerald-50
                                   border border-emerald-100
                                   text-emerald-700
                                   text-xs font-medium"
                        >
                            {{ $post->content_type === 'video'
                                ? 'Video'
                                : 'Artikel' }}
                        </span>

                        <h3 class="mt-4
                                text-lg lg:text-xl
                                font-bold
                                text-slate-900
                                line-clamp-2
                                group-hover:text-emerald-600
                                transition"
                            >
                            {{ $post->title }}
                        </h3>

                        <p
                            class="mt-3 text-slate-600
                                   text-sm leading-relaxed
                                   line-clamp-3"
                        >
                            {{ \Illuminate\Support\Str::limit(strip_tags($post->content ?? ''), 120) }}
                        </p>

                        <div
                            class="mt-5 flex items-center gap-2
                                   text-sm text-slate-500"
                        >

                            <span>
                                {{ $post->created_at->format('d M Y') }}
                            </span>

                        </div>

                    </div>

                </a>

            @endforeach

        </div>

        {{-- BUTTON --}}
        <div class="mt-12 text-center">

            <a
                href="{{ route('articles.index') }}"
                class="inline-flex items-center gap-3
                       px-8 py-4 rounded-2xl
                       bg-emerald-600
                       text-white font-semibold
                       hover:bg-emerald-700
                       transition"
            >

                Lihat Semua Konten

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

</section>

<script>
document.addEventListener('alpine:init', () => {

    Alpine.data('autoSlider', () => ({
        interval: null,

        start() {

            if (window.innerWidth >= 768) return;

            this.interval = setInterval(() => {

                const slider = this.$refs.slider;

                const card = slider.querySelector('a');

                if (!card) return;

                const scrollAmount = card.offsetWidth + 20;

                const maxScroll =
                    slider.scrollWidth - slider.clientWidth;

                if (slider.scrollLeft >= maxScroll - 10) {

                    slider.scrollTo({
                        left: 0,
                        behavior: 'smooth'
                    });

                } else {

                    slider.scrollBy({
                        left: scrollAmount,
                        behavior: 'smooth'
                    });

                }

            }, 3500);
        }
    }));

});

</script>
