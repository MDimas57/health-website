@php
    use Illuminate\Support\Str;
@endphp

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<style>
@keyframes rotateWords {
    0%, 25% { transform: translateY(0); }
    33%, 58% { transform: translateY(-60px); }
    66%, 91% { transform: translateY(-120px); }
    100% { transform: translateY(-180px); }
}

.animate-rotate-words {
    animation: rotateWords 9s infinite;
}

.scrollbar-hide::-webkit-scrollbar {
    display: none;
}
.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>

{{-- Top Accent Line --}}
<div class="relative w-screen left-1/2 -translate-x-1/2 h-2 bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500 opacity-20"></div>

<section class="relative w-screen left-1/2 -translate-x-1/2 bg-gradient-to-r from-blue-800 to-blue-800 py-16 lg:py-24 overflow-hidden">

    <div class="max-w-7xl mx-auto px-4 lg:px-8">

        {{-- HEADER --}}
        <div class="max-w-2xl mx-auto text-center mb-12 lg:mb-20">

            {{-- Badge --}}
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-700 text-xs sm:text-sm font-medium">
                Konten Terbaru
            </span>

            {{-- Title with Dynamic Word Rotator --}}
            <h2 class="mt-3 text-3xl sm:text-4xl lg:text-5xl font-bold text-center">
                <div
                    x-data="{
                        words: ['Artikel', 'Video', 'Poster'],
                        current: 0,
                        init() {
                            setInterval(() => {
                                this.current = (this.current + 1) % this.words.length
                            }, 2500)
                        }
                    }"
                    class="flex justify-center items-center gap-1 sm:gap-2"
                >
                    <div class="relative w-[100px] sm:w-[120px] lg:w-[140px] h-[50px] sm:h-[60px] lg:h-[70px]">
                        <template x-for="(word, index) in words" :key="index">
                            <span
                                x-show="current === index"
                                x-transition:enter="transition duration-700 ease-out"
                                x-transition:enter-start="opacity-0 translate-y-5"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition duration-700 ease-in"
                                x-transition:leave-start="opacity-100 translate-y-0"
                                x-transition:leave-end="opacity-0 -translate-y-5"
                                class="absolute inset-0 flex items-center justify-end text-3xl sm:text-4xl lg:text-5xl font-bold text-red-600"
                                x-text="word"
                            ></span>
                        </template>
                    </div>

                    <span class="text-white text-3xl sm:text-4xl lg:text-5xl font-bold">
                        Kesehatan
                    </span>
                </div>
            </h2>

            <p class="mt-3 text-white/90 max-w-2xl mx-auto leading-relaxed text-base lg:text-lg px-2">
                Informasi kesehatan terbaru yang disajikan secara sederhana, terpercaya, dan mudah dipahami oleh masyarakat.
            </p>

        </div>

        {{-- FEATURED AREA --}}
        <div class="grid lg:grid-cols-12 gap-5 lg:gap-8 mb-10">

            {{-- FEATURED ARTICLE --}}
            @if($featuredArticle)
                <a
                    href="{{ route('articles.show', $featuredArticle->slug) }}"
                    class="lg:col-span-8 bg-white rounded-[32px] overflow-hidden border border-slate-200 shadow-sm hover:shadow-2xl hover:border-indigo-200 transition-all duration-500 group block"
                >
                    <div class="relative h-[500px] overflow-hidden">

                        <img
                            src="{{ $featuredArticle->thumbnail ? asset('storage/' . $featuredArticle->thumbnail) : asset('images/default.jpg') }}"
                            alt="{{ $featuredArticle->title }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-700"
                        >

                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent"></div>

                        {{-- Badges --}}
                        <div class="absolute top-4 left-4 lg:top-6 lg:left-6 flex flex-wrap gap-2">
                            <span class="px-4 py-2 rounded-full bg-white/90 backdrop-blur text-slate-800 text-xs font-semibold">
                                {{ optional($featuredArticle->category)->name ?? 'Kesehatan' }}
                            </span>

                            <span class="px-4 py-2 rounded-full bg-indigo-600 text-white text-xs font-semibold">
                                Artikel
                            </span>
                        </div>

                        {{-- Content --}}
                        <div class="absolute bottom-5 left-5 right-5 lg:bottom-8 lg:left-8 lg:right-8 text-white">
                            <p class="text-sm text-white/80 mb-3">
                                {{ optional($featuredArticle->published_at ?? $featuredArticle->created_at)->format('d M Y') }}
                            </p>

                            <h3 class="text-xl sm:text-2xl lg:text-4xl font-bold leading-tight line-clamp-2">
                                {{ $featuredArticle->title }}
                            </h3>

                            <div class="mt-4 max-w-2xl text-white/90 leading-relaxed text-sm lg:text-base line-clamp-3 overflow-hidden">
                                {{ Str::limit(strip_tags($featuredArticle->content), 220) }}
                            </div>
                        </div>

                    </div>
                </a>
            @endif

            {{-- FEATURED POSTER --}}
            <div class="lg:col-span-4 rounded-[32px] overflow-hidden border border-slate-200 shadow-sm hover:shadow-2xl hover:border-indigo-200 transition-all duration-500 hidden md:block bg-white">
                @if($featuredPosters->count())
                    @php
                        $poster = $featuredPosters->first();
                    @endphp

                    <a href="{{ route('posters.show', $poster->slug) }}" class="relative block h-full">
                        <img
                            src="{{ asset('storage/' . $poster->poster_file) }}"
                            alt="{{ $poster->title }}"
                            class="w-full h-[320px] sm:h-[420px] lg:h-[500px] object-cover hover:scale-105 transition duration-700"
                        >

                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>

                        <div class="absolute top-6 left-6">
                            <span class="px-4 py-2 rounded-full bg-white/90 backdrop-blur text-slate-800 text-xs font-semibold">
                                Poster Terbaru
                            </span>
                        </div>

                        <div class="absolute bottom-6 left-6 right-6 text-white">
                            <h3 class="text-2xl font-bold line-clamp-2">
                                {{ $poster->title }}
                            </h3>

                            <div class="mt-4">
                                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/15 backdrop-blur text-white text-sm hover:bg-white/25 transition">
                                    Lihat Poster &rarr;
                                </span>
                            </div>
                        </div>
                    </a>
                @endif
            </div>

        </div>

        {{-- LATEST CONTENT (SLIDER / GRID) --}}
        <div
            x-data="autoSlider()"
            x-init="start()"
            x-ref="slider"
            class="flex md:grid md:grid-cols-2 lg:grid-cols-3 gap-5 lg:gap-7 overflow-x-auto md:overflow-visible snap-x snap-mandatory scrollbar-hide scroll-smooth pb-2"
        >
            @foreach($latestPosts as $post)
                <a
                    href="{{ $post->content_type === 'video' ? route('videos.show', $post->slug) : route('articles.show', $post->slug) }}"
                    class="group min-w-[85%] sm:min-w-[70%] md:min-w-0 snap-center bg-white rounded-[28px] overflow-hidden border border-slate-200 shadow-sm hover:shadow-xl hover:-translate-y-2 hover:border-indigo-200 transition-all duration-500 flex flex-col"
                >
                    {{-- IMAGE --}}
                    <div class="h-48 sm:h-56 overflow-hidden relative">
                        @if($post->content_type === 'video')
                            <div class="relative w-full h-full">
                                <img
                                    src="https://img.youtube.com/vi/{{ $post->youtube_id }}/hqdefault.jpg"
                                    alt="{{ $post->title }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-700"
                                >
                                <div class="absolute inset-0 bg-black/25"></div>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="w-12 h-12 rounded-full bg-red-600/90 flex items-center justify-center shadow-lg group-hover:scale-110 transition">
                                        <svg class="w-6 h-6 text-white ml-0.5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        @else
                            <img
                                src="{{ $post->thumbnail ? asset('storage/' . $post->thumbnail) : asset('images/default.jpg') }}"
                                alt="{{ $post->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-700"
                            >
                        @endif
                    </div>

                    {{-- CONTENT --}}
                    <div class="p-6 flex flex-col flex-1">
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $post->content_type === 'video' ? 'bg-red-50 text-red-600' : 'bg-indigo-50 text-indigo-600' }}">
                                {{ $post->content_type === 'video' ? 'Video' : 'Artikel' }}
                            </span>

                            @if(isset($post->category))
                                <span class="text-xs text-slate-500 font-medium">
                                    {{ $post->category->name }}
                                </span>
                            @endif
                        </div>

                        <h3 class="text-lg font-bold text-slate-900 group-hover:text-indigo-600 transition line-clamp-2 leading-snug mb-2">
                            {{ $post->title }}
                        </h3>

                        <p class="text-slate-600 text-sm line-clamp-3 mb-6">
                            @if($post->content_type === 'video')
                                {{ Str::limit(html_entity_decode(strip_tags($post->description), ENT_QUOTES, 'UTF-8'), 120) }}
                            @else
                                {{ Str::limit(html_entity_decode(strip_tags($post->content), ENT_QUOTES, 'UTF-8'), 120) }}
                            @endif
                        </p>

                        <div class="mt-auto pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                            <span>
                                {{ optional($post->published_at ?? $post->created_at)->format('d M Y') }}
                            </span>
                            <span class="text-indigo-600 font-semibold group-hover:translate-x-1 transition duration-300">
                                Baca &rarr;
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- BUTTON ALL CONTENT --}}
        <div class="flex justify-center mt-12">
            <a
                href="{{ route('articles.index') }}"
                class="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 text-indigo-900 font-bold shadow-md hover:shadow-xl hover:bg-slate-50 hover:scale-105 transition duration-300"
            >
                Lihat Semua Konten
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

    </div>

</section>

{{-- Alpine JS Slider Function --}}
<script>
function autoSlider() {
    return {
        timer: null,
        start() {
            if (window.innerWidth >= 768) return;
            
            const slider = this.$refs.slider;
            this.timer = setInterval(() => {
                if (!slider) return;
                const maxScroll = slider.scrollWidth - slider.clientWidth;
                if (slider.scrollLeft >= maxScroll - 10) {
                    slider.scrollTo({ left: 0, behavior: 'smooth' });
                } else {
                    slider.scrollBy({ left: slider.clientWidth * 0.8, behavior: 'smooth' });
                }
            }, 4000);
        }
    }
}
</script>