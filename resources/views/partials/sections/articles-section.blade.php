
{{-- DATA --}}
@php

    use App\Models\Article;
    use App\Models\Poster;
    use App\Models\Video;

    /*
    |--------------------------------------------------------------------------
    | FEATURED ARTICLE
    |--------------------------------------------------------------------------
    */

    $featuredArticle = Article::with('category')
        ->where('status', 'published')
        ->latest('published_at')
        ->first();

    $featuredPosters = Poster::with('category')
        ->where('status', 'published')
        ->latest('published_at')
        ->take(5)
        ->get();

    $latestArticles = Article::with('category')
        ->where('status', 'published')
        ->when($featuredArticle, function ($query) use ($featuredArticle) {
            $query->where('id', '!=', $featuredArticle->id);
        })
        ->latest('published_at')
        ->take(2)
        ->get()
        ->map(function ($item) {
            $item->content_type = 'article';
            return $item;
        });

    /*
    |--------------------------------------------------------------------------
    | LATEST VIDEOS
    |--------------------------------------------------------------------------
    */

    $latestVideos = Video::with('category')
        ->where('status', 'published')
        ->latest('published_at')
        ->take(2)
        ->get()
        ->map(function ($item) {
            $item->content_type = 'video';
            return $item;
        });

    /*
    |--------------------------------------------------------------------------
    | MERGE CONTENT
    |--------------------------------------------------------------------------
    */

    $latestPosts = $latestArticles
        ->merge($latestVideos)
        ->sortByDesc('published_at')
        ->take(3);

@endphp


{{-- SECTION --}}
<section class="relative bg-[#efeeec]
                left-1/2 right-1/2 w-screen
                -translate-x-1/2
                py-24 overflow-hidden">

    {{-- BACKGROUND --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">

        <div class="absolute -top-32 -left-32
                    w-[450px] h-[450px]
                    bg-sky-200/40 rounded-full blur-3xl">
        </div>

        <div class="absolute bottom-0 right-0
                    w-[400px] h-[400px]
                    bg-emerald-200/40 rounded-full blur-3xl">
        </div>

    </div>

    {{-- CONTAINER --}}
    <div class="relative z-10 max-w-[1280px] mx-auto px-4 lg:px-8">

        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row
                    md:items-end md:justify-between
                    gap-6 mb-12">

            <div>

                <span class="inline-flex items-center gap-2
                             px-4 py-2 rounded-full
                             bg-white border border-slate-200
                             text-sky-700 text-sm font-medium
                             shadow-sm mb-5">

                    <div class="w-2 h-2 rounded-full bg-sky-500"></div>

                    Update Informasi Kesehatan

                </span>

                <h2 class="text-4xl lg:text-5xl
                           font-bold text-slate-900
                           leading-tight">

                    Konten
                    <span class="text-sky-600">
                        Terbaru
                    </span>

                </h2>

                <p class="text-slate-500 mt-5
                          text-lg leading-relaxed
                          max-w-2xl">

                    Temukan informasi, artikel, video,
                    dan poster kesehatan terbaru.

                </p>

            </div>

        </div>

        {{-- TOP GRID --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-7 items-stretch">

            {{-- FEATURED ARTICLE --}}
            @if($featuredArticle)

                <a href="{{ route('articles.show', $featuredArticle->slug) }}"
                   class="lg:col-span-2
                          h-[620px]
                          bg-white/80 backdrop-blur-xl
                          rounded-[32px]
                          overflow-hidden
                          border border-white/70
                          shadow-[0_10px_40px_rgba(15,23,42,0.08)]
                          hover:shadow-[0_20px_60px_rgba(15,23,42,0.12)]
                          hover:-translate-y-1
                          transition-all duration-500
                          group flex flex-col">

                    {{-- IMAGE --}}
                    <div class="relative overflow-hidden h-[340px] flex-shrink-0">
                        <div class="absolute top-5 left-5 right-5 z-20 flex items-center justify-between">

                            {{-- CATEGORY --}}
                            @if($featuredArticle->category)
                                <span class="inline-flex items-center gap-2
                                            px-4 py-2 rounded-full
                                            bg-white/90 backdrop-blur-md
                                            text-slate-800 text-xs font-semibold
                                            shadow-lg">

                                    <div class="w-2 h-2 rounded-full"
                                        style="background: {{ $featuredArticle->category->color ?? '#0ea5e9' }}">
                                    </div>

                                    {{ $featuredArticle->category->name }}
                                </span>
                            @else
                                <span></span>
                            @endif

                            {{-- TYPE --}}
                            <span class="px-4 py-2 rounded-full
                                        bg-sky-600 text-white
                                        text-xs font-bold shadow-lg">

                                Artikel

                            </span>

                        </div>
                        <img
                            src="{{ $featuredArticle->thumbnail
                                    ? asset('storage/' . $featuredArticle->thumbnail)
                                    : asset('images/default.jpg') }}"
                            alt="{{ $featuredArticle->title }}"
                            class="w-full h-full object-cover
                                   group-hover:scale-105
                                   transition duration-700"
                        >

                        <div class="absolute inset-0
                                    bg-gradient-to-t
                                    from-black/50
                                    via-black/10
                                    to-transparent">
                        </div>

                    </div>

                    {{-- CONTENT --}}
                    <div class="p-8 flex-1 flex flex-col justify-between">

                        <div>

                            <h3 class="text-3xl font-bold
                                       text-slate-900
                                       leading-snug mb-5
                                       line-clamp-2">

                                {{ $featuredArticle->title }}

                            </h3>

                            <p class="text-slate-600
                                      leading-relaxed text-lg
                                      line-clamp-4">

                                {{ \Illuminate\Support\Str::limit(strip_tags($featuredArticle->content), 180) }}

                            </p>

                        </div>

                        <div class="flex items-center gap-4
                                    mt-8 text-sm text-slate-400">

                            <span>
                                {{ $featuredArticle->created_at->diffForHumans() }}
                            </span>

                            <span>•</span>

                            <span>
                                {{ $featuredArticle->created_at->format('d M Y') }}
                            </span>

                        </div>

                    </div>

                </a>

            @endif


            {{-- FEATURED POSTER SLIDER --}}
            @if($featuredPosters->count())

            <div 
                x-data="{
                    active: 0,
                    total: {{ $featuredPosters->count() }},
                    autoplay() {
                        setInterval(() => {
                            this.active = (this.active + 1) % this.total
                        }, 4000)
                    }
                }"
                x-init="autoplay()"
                class="relative h-[620px] rounded-[32px] overflow-hidden shadow-[0_10px_40px_rgba(15,23,42,0.08)]"
            >

                {{-- SLIDES --}}
                <template x-for="(poster, index) in {{ $featuredPosters->values() }}" :key="index">

                    <div
                        x-show="active === index"
                        x-transition:enter="transition ease-out duration-700"
                        x-transition:enter-start="opacity-0 scale-105"
                        x-transition:enter-end="opacity-100 scale-100"
                        class="absolute inset-0"
                    >

                        <img
                            :src="'/storage/' + poster.poster_file"
                            class="w-full h-full object-cover"
                        >

                        {{-- OVERLAY --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>

                        {{-- CONTENT --}}
                        <div class="absolute bottom-0 left-0 right-0 p-8 text-white">

                            <h3 class="text-2xl font-bold">
                                <span x-text="poster.title"></span>
                            </h3>

                            <p class="text-white/70 mt-2 text-sm"
                            x-text="new Date(poster.created_at).toLocaleDateString()">
                            </p>

                        </div>

                    </div>

                </template>

                {{-- DOT NAV --}}
                <div class="absolute bottom-5 left-1/2 -translate-x-1/2 flex gap-2">
                    <template x-for="(poster, index) in {{ $featuredPosters->values() }}">
                        <button
                            @click="active = index"
                            class="w-2.5 h-2.5 rounded-full transition-all"
                            :class="active === index ? 'bg-white w-6' : 'bg-white/50'"
                        ></button>
                    </template>
                </div>

            </div>

            @endif

        </div>

        {{-- BOTTOM GRID --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-7 mt-7">

            @foreach($latestPosts as $post)

                <a href="{{ $post->content_type === 'video'
                            ? route('videos.show', $post->slug)
                            : route('articles.show', $post->slug) }}"
                class="group relative
                        bg-white/80 backdrop-blur-xl
                        rounded-[28px]
                        overflow-hidden
                        border border-white/60
                        shadow-[0_10px_30px_rgba(15,23,42,0.06)]
                        hover:shadow-[0_20px_50px_rgba(15,23,42,0.12)]
                        hover:-translate-y-1
                        transition-all duration-500">

                    {{-- IMAGE --}}
                    <div class="relative overflow-hidden">

                        @if($post->content_type === 'video')

                         {{-- THUMBNAIL YOUTUBE --}}
                        <div class="relative">

                            <img
                                src="https://img.youtube.com/vi/{{ $post->youtube_id }}/hqdefault.jpg"
                                class="w-full h-[230px] object-cover"
                            />

                            {{-- PLAY BUTTON OVERLAY --}}
                            <div class="absolute inset-0 flex items-center justify-center">

                                <div class="w-16 h-16 rounded-full
                                            bg-white/90 backdrop-blur-md
                                            flex items-center justify-center
                                            shadow-lg
                                            group-hover:scale-110
                                            transition duration-300">

                                    <svg class="w-8 h-8 text-red-600 ml-1"
                                        fill="currentColor"
                                        viewBox="0 0 24 24">

                                        <path d="M8 5v14l11-7z"/>
                                    </svg>

                                </div>

                            </div>

                        </div>

                        @else

                            {{-- IMAGE ARTICLE --}}
                            <img
                                src="{{ $post->thumbnail
                                        ? asset('storage/' . $post->thumbnail)
                                        : asset('images/default.jpg') }}"
                                alt="{{ $post->title }}"
                                class="w-full h-[230px] object-cover
                                    group-hover:scale-105
                                    transition duration-700"
                            >

                        @endif

                        {{-- OVERLAY --}}
                        <div class="absolute inset-0
                                    bg-gradient-to-t
                                    from-black/40
                                    via-black/5
                                    to-transparent">
                        </div>

                        {{-- TOP BADGES --}}
                        <div class="absolute top-4 left-4 right-4
                                    flex items-center justify-between z-20">

                            {{-- CATEGORY --}}
                            <span
                                class="inline-flex items-center gap-2
                                    px-3 py-1.5 rounded-full
                                    bg-white/90 backdrop-blur-md
                                    text-slate-800 text-xs font-semibold
                                    shadow-lg"
                            >

                                <div class="w-2 h-2 rounded-full"
                                    style="background: {{ $post->category->color ?? '#0ea5e9' }}">
                                </div>

                                {{ $post->category->name ?? 'Kategori' }}

                            </span>

                            {{-- TYPE --}}
                            @if($post->content_type === 'video')

                                <span
                                    class="px-3 py-1.5 rounded-full
                                        bg-red-600 text-white
                                        text-xs font-bold shadow-lg">

                                    Video

                                </span>

                            @else

                                <span
                                    class="px-3 py-1.5 rounded-full
                                        bg-sky-600 text-white
                                        text-xs font-bold shadow-lg">

                                    Artikel

                                </span>

                            @endif

                        </div>

                    </div>

                    {{-- CONTENT --}}
                    <div class="p-6">

                        {{-- DATE --}}
                        <div class="flex items-center gap-2
                                    text-sm text-slate-400 mb-4">

                            <i class="ti ti-calendar text-base"></i>

                            <span>
                                {{ $post->created_at->format('d M Y') }}
                            </span>

                        </div>

                        {{-- TITLE --}}
                        <h3 class="text-xl font-bold
                                text-slate-900
                                leading-snug
                                line-clamp-2
                                group-hover:text-sky-600
                                transition">

                            {{ \Illuminate\Support\Str::limit($post->title, 60) }}

                        </h3>

                        {{-- DESCRIPTION --}}
                        <p class="text-slate-500
                                text-sm leading-relaxed
                                mt-4 line-clamp-3">

                            {{ \Illuminate\Support\Str::limit(strip_tags($post->content ?? ''), 90) }}

                        </p>

                    </div>

                </a>

            @endforeach

        </div>

    </div>

</section>
