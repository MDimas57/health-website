@extends('layouts.public')

@section('content')

{{-- HERO BG --}}
<section class="relative overflow-hidden">

    {{-- BACKGROUND --}}
    <div
        class="absolute inset-0
               bg-gradient-to-br
               from-slate-50 via-white to-emerald-50">
    </div>

</section>


{{-- THUMBNAIL + HERO CONTENT --}}
@if($article->thumbnail)

<section class="pb-8">

    <div class="max-w-5xl mx-auto px-4 lg:px-8">

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

            {{-- CONTENT --}}
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

                            <div
                                class="font-bold text-white"
                            >
                                {{ $article->user->name ?? 'Admin' }}
                            </div>

                            <div
                                class="text-sm text-white/70"
                            >
                                Penulis Artikel
                            </div>

                        </div>

                    </div>


                    {{-- META RIGHT --}}
                    <div
                        class="flex flex-wrap items-center
                               gap-3 md:gap-4"
                    >

                        {{-- DATE --}}
                        <div
                            class="px-4 py-2 rounded-xl
                                   bg-white/15 backdrop-blur-md
                                   border border-white/10
                                   text-white text-sm font-medium"
                        >
                            📅 {{ $article->published_at?->format('d F Y') }}
                        </div>

                        {{-- VIEWS --}}
                        <div
                            class="px-4 py-2 rounded-xl
                                   bg-emerald-500/80 backdrop-blur-md
                                   text-white text-sm font-medium"
                        >
                            👁 {{ number_format($article->views ?? 0) }} views
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

@endif



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

                       prose-a:text-emerald-600

                       prose-strong:text-slate-900

                       prose-img:rounded-2xl
                       prose-img:shadow-lg

                       prose-blockquote:border-emerald-500
                       prose-blockquote:bg-emerald-50
                       prose-blockquote:rounded-xl
                       prose-blockquote:px-6
                       prose-blockquote:py-3"
            >

                {!! str($article->content)->sanitizeHtml() !!}

            </div>

        </div>


        {{-- SHARE --}}
        <div
            class="mt-8 bg-gradient-to-r
                   from-emerald-500 to-teal-500
                   rounded-[2rem]
                   p-6 md:p-8 text-white"
        >

            <div
                class="flex flex-col md:flex-row
                       items-start md:items-center
                       justify-between gap-5"
            >

                <div>

                    <h3
                        class="text-xl md:text-2xl
                               font-bold"
                    >
                        Bagikan Artikel Ini
                    </h3>

                    <p
                        class="text-white/80 mt-2
                               text-sm md:text-base"
                    >
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
                               hover:scale-105
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
                               hover:scale-105
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

<section class="pb-20 bg-slate-50 border-t border-slate-100">

    <div class="max-w-6xl mx-auto px-4 lg:px-8 pt-14">

        {{-- HEADER --}}
        <div class="mb-10 text-center">

            <div
                class="inline-flex items-center gap-2
                       px-4 py-2 rounded-full
                       bg-emerald-100 text-emerald-700
                       text-sm font-medium mb-4"
            >
                📚 Rekomendasi Bacaan
            </div>

            <h2
                class="text-2xl lg:text-3xl
                       font-black text-slate-900"
            >

                Artikel Terkait

            </h2>

            <p
                class="text-slate-500 mt-3
                       max-w-2xl mx-auto
                       text-sm md:text-base"
            >

                Temukan artikel kesehatan lainnya yang relevan dan menarik untuk dibaca.

            </p>

        </div>

        {{-- GRID --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">

            @foreach($relatedArticles as $item)

                <a
                    href="{{ route('articles.show', $item->slug) }}"
                    class="group bg-white rounded-[1.8rem]
                           overflow-hidden border border-slate-100
                           shadow-sm hover:shadow-2xl
                           hover:-translate-y-2
                           transition duration-500"
                >

                    {{-- IMAGE --}}
                    <div class="relative overflow-hidden">

                        <img
                            src="{{ Str::startsWith($item->thumbnail, 'http')
                                ? $item->thumbnail
                                : Storage::url($item->thumbnail) }}"
                            class="w-full h-[220px] object-cover
                                   group-hover:scale-110
                                   transition duration-700"
                        >

                        <div
                            class="absolute inset-0
                                   bg-gradient-to-t
                                   from-black/50 to-transparent"
                        ></div>

                    </div>

                    {{-- CONTENT --}}
                    <div class="p-5">

                        {{-- CATEGORY --}}
                        <div class="mb-4">

                            <span
                                class="px-3 py-1 rounded-full
                                       bg-emerald-100 text-emerald-700
                                       text-xs font-semibold"
                            >

                                {{ $item->category->name ?? 'Kesehatan' }}

                            </span>

                        </div>

                        {{-- TITLE --}}
                        <h3
                            class="text-lg font-bold
                                   text-slate-900 leading-snug
                                   group-hover:text-emerald-600
                                   transition line-clamp-2"
                        >

                            {{ $item->title }}

                        </h3>

                        {{-- DATE --}}
                        <div
                            class="mt-5 flex items-center
                                   justify-between text-sm text-slate-500"
                        >

                            <span>
                                {{ $item->published_at?->format('d M Y') }}
                            </span>

                            <span class="text-emerald-600 font-medium">
                                Baca →
                            </span>

                        </div>

                    </div>

                </a>

            @endforeach

        </div>

    </div>

</section>

@endif

@endsection