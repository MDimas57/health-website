@extends('layouts.public')

@section('content')

{{-- HERO BG --}}
<section class="relative overflow-hidden">

    {{-- BACKGROUND (Ubah gradien dari hijau ke biru/ungu pudar yang soft) --}}
    <div
        class="absolute inset-0
               bg-gradient-to-br
               from-slate-50 via-white to-indigo-50/50">
    </div>

</section>

{{-- BREADCRUMB & HERO CONTENT --}}
<section class="py-6">
    <div class="max-w-5xl mx-auto px-4 lg:px-8">
        
        {{-- BREADCRUMB --}}
        <nav class="flex items-center gap-2 text-sm text-slate-500 mb-6 font-medium">
            <a href="/" class="hover:text-indigo-600 transition">Home</a>
            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="{{ route('articles.index') }}" class="hover:text-indigo-600 transition">Artikel</a>
            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-slate-400 line-clamp-1 flex-1">{{ $article->title }}</span>
        </nav>

        {{-- MAIN HERO CARD --}}
        @if($article->thumbnail)
        <div
            class="relative overflow-hidden
                   rounded-[2.2rem]
                   shadow-2xl border border-white"
        >

            {{-- IMAGE --}}
            <img
                src="{{ Str::startsWith($article->thumbnail, 'http')
                    ? $article->thumbnail
                    : Storage::url($article->thumbnail) }}"
                alt="{{ $article->title }}"
                class="w-full h-[320px] md:h-[460px] lg:h-[560px] object-cover"
            >

            {{-- OVERLAY --}}
            <div
                class="absolute inset-0
                       bg-gradient-to-t
                       from-black via-black/50 to-black/10"
            ></div>

            {{-- CONTENT INSIDE HERO --}}
            <div
                class="absolute inset-0
                       flex flex-col justify-end
                       p-6 md:p-10 lg:p-14"
            >

                {{-- CATEGORY --}}
                @if($article->category)

                    <div class="mb-5">

                        <span
                            class="inline-flex items-center gap-2
                                   px-4 py-2 rounded-full
                                   bg-white/20 backdrop-blur-md
                                   border border-white/20
                                   text-white font-semibold text-sm"
                        >
                            🩺 {{ $article->category->name }}
                        </span>

                    </div>

                @endif

                {{-- TITLE --}}
                <h1
                    class="text-3xl md:text-4xl lg:text-5xl
                           font-black leading-tight
                           text-white max-w-4xl"
                >
                    {{ $article->title }}
                </h1>

                {{-- META --}}
                <div
                    class="flex flex-col md:flex-row
                           md:items-center md:justify-between
                           gap-6 mt-8"
                >

                    {{-- AUTHOR --}}
                    <div class="flex items-center gap-4">

                        <div
                            class="w-12 h-12 rounded-full
                                   bg-white/20 backdrop-blur-md
                                   border border-white/20
                                   text-white font-bold
                                   flex items-center justify-center"
                        >
                            {{ strtoupper(substr($article->user->name ?? 'A', 0, 1)) }}
                        </div>

                        <div>
                            <div class="font-bold text-white">
                                {{ $article->user->name ?? 'Admin' }}
                            </div>
                            <div class="text-sm text-white/70">
                                Penulis Artikel
                            </div>
                        </div>

                    </div>

                    {{-- META RIGHT --}}
                    <div class="flex flex-wrap items-center gap-3 md:gap-4">

                        {{-- DATE --}}
                        <div
                            class="px-4 py-2 rounded-xl
                                   bg-white/15 backdrop-blur-md
                                   border border-white/10
                                   text-white text-sm font-medium"
                        >
                            📅 {{ $article->published_at?->format('d F Y') }}
                        </div>

                        {{-- VIEWS (Ubah warna dari hijau ke biru medis) --}}
                        <div
                            class="px-4 py-2 rounded-xl
                                   bg-blue-600/80 backdrop-blur-md
                                   text-white text-sm font-medium shadow-sm"
                        >
                            👁 {{ number_format($article->views ?? 0) }} views
                        </div>

                    </div>

                </div>

            </div>

        </div>
        @endif

    </div>
</section>


{{-- ARTICLE CONTENT --}}
<section class="pb-20">

    <div class="max-w-5xl mx-auto px-4 lg:px-8">

        {{-- ARTICLE BODY --}}
        <div
            class="bg-white rounded-[2rem]
                   shadow-sm border border-slate-100
                   p-6 md:p-8 lg:p-10"
        >

            <div
                class="article-content
                       prose md:prose-lg
                       max-w-none

                       prose-headings:font-bold
                       prose-headings:text-slate-900

                       prose-p:text-slate-700
                       prose-p:leading-8

                       prose-a:text-indigo-600 hover:prose-a:text-indigo-700

                       prose-strong:text-slate-900

                       prose-img:rounded-2xl
                       prose-img:shadow-lg

                       prose-blockquote:border-indigo-500
                       prose-blockquote:bg-indigo-50/50
                       prose-blockquote:rounded-xl
                       prose-blockquote:px-6
                       prose-blockquote:py-3"
            >

                {!! str($article->content)->sanitizeHtml() !!}

            </div>

        </div>


        {{-- SHARE (Ubah gradien dari hijau ke paduan Ungu & Merah yang modern) --}}
        <div
            class="mt-8 bg-gradient-to-r
                   from-indigo-600 via-purple-600 to-rose-500
                   rounded-[2rem]
                   p-6 md:p-8 text-white shadow-xl shadow-indigo-100"
        >

            <div
                class="flex flex-col md:flex-row
                       items-start md:items-center
                       justify-between gap-5"
            >

                <div>

                    <h3 class="text-xl md:text-2xl font-bold">
                        Bagikan Artikel Ini
                    </h3>

                    <p class="text-white/80 mt-2 text-sm md:text-base">
                        Bantu sebarkan informasi kesehatan yang bermanfaat.
                    </p>

                </div>

                <div class="flex gap-3">

                    {{-- FACEBOOK --}}
                    <a
                        href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"
                        target="_blank"
                        class="px-5 py-3 rounded-xl
                               bg-white text-slate-800
                               font-semibold text-sm
                               hover:scale-105 shadow-sm
                               transition"
                    >
                        Facebook
                    </a>

                    {{-- WHATSAPP --}}
                    <a
                        href="https://wa.me/?text={{ urlencode($article->title . ' - ' . request()->fullUrl()) }}"
                        target="_blank"
                        class="px-5 py-3 rounded-xl
                               bg-white text-slate-800
                               font-semibold text-sm
                               hover:scale-105 shadow-sm
                               transition"
                    >
                        WhatsApp
                    </a>

                </div>

            </div>

        </div>

    </div>

</section>


{{-- RELATED ARTICLES --}}
@if($relatedArticles->count())

<section class="w-full bg-slate-50 border-t border-slate-100 py-20 relative clear-both block">

    <div class="max-w-6xl mx-auto px-4 lg:px-8">

        {{-- HEADER --}}
        <div class="mb-12 text-center">

            <div
                class="inline-flex items-center gap-2
                       px-4 py-2 rounded-full
                       bg-indigo-50 border border-indigo-100 text-indigo-700
                       text-sm font-medium mb-4"
            >
                📚 Rekomendasi Bacaan
            </div>

            <h2 class="text-2xl lg:text-3xl font-black text-slate-900">
                Artikel Terkait
            </h2>

            <p class="text-slate-500 mt-3 max-w-2xl mx-auto text-sm md:text-base">
                Temukan artikel kesehatan lainnya yang relevan dan menarik untuk dibaca.
            </p>

        </div>

        {{-- GRID SYSTEM (Menggunakan isolasi grid yang ketat agar tidak menabrak) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 items-stretch content-start w-full clear-both">

            @foreach($relatedArticles as $item)

                <div class="h-full flex">
                    <a
                        href="{{ route('articles.show', $item->slug) }}"
                        class="group w-full bg-white rounded-[1.8rem]
                               overflow-hidden border border-slate-100
                               shadow-sm hover:shadow-2xl hover:-translate-y-2
                               transition duration-500 flex flex-col justify-between"
                    >

                        {{-- IMAGE LAYER --}}
                        <div class="relative w-full h-[220px] overflow-hidden shrink-0">

                            <img
                                src="{{ Str::startsWith($item->thumbnail, 'http')
                                    ? $item->thumbnail
                                    : Storage::url($item->thumbnail) }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition duration-700"
                                alt="{{ $item->title }}"
                            >

                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>

                        </div>

                        {{-- CONTENT LAYER --}}
                        <div class="p-6 flex flex-col flex-grow justify-between bg-white">

                            <div class="w-full">
                                {{-- BADGE --}}
                                <div class="mb-3">
                                    <span
                                        class="px-3 py-1 rounded-full
                                               bg-blue-50 border border-blue-100 text-blue-600
                                               text-xs font-semibold inline-block"
                                    >
                                        {{ $item->category->name ?? 'Kesehatan' }}
                                    </span>
                                </div>

                                {{-- TITLE --}}
                                <h3
                                    class="text-lg font-bold text-slate-900 leading-snug
                                           group-hover:text-indigo-600 transition line-clamp-2"
                                >
                                    {{ $item->title }}
                                </h3>
                            </div>

                            {{-- FOOTER CARD --}}
                            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-sm text-slate-500 shrink-0 w-full">
                                
                                <span>
                                    {{ $item->published_at?->format('d M Y') }}
                                </span>

                                <span class="text-red-600 font-semibold group-hover:text-red-700 transition">
                                    Baca →
                                </span>

                            </div>

                        </div>

                    </a>
                </div>

            @endforeach

        </div>

    </div>

</section>

@endif
@endsection