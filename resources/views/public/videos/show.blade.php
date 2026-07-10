@extends('layouts.public')

@section('content')

<section class="pb-16 pt-6">

    <div class="max-w-6xl mx-auto px-4 lg:px-8">

        {{-- BREADCRUMB --}}
        <nav class="flex items-center gap-2 text-xs md:text-sm text-slate-500 mb-6 overflow-x-auto whitespace-nowrap pb-2 lg:pb-0 scrollbar-hide">
            <a href="/" class="hover:text-indigo-600 transition">Beranda</a>
            <span class="text-slate-300">/</span>
            <a href="{{ route('videos.index') }}" class="hover:text-indigo-600 transition">Video</a>
            <span class="text-slate-300">/</span>
            <span class="text-slate-800 font-medium truncate max-w-[200px] md:max-w-xs">
                {{ $video->title }}
            </span>
        </nav>

        {{-- PLAYER (Perbaikan: Menghapus z-10 dan menambahkan relative untuk memastikan iframe rendered sempurna) --}}
        <div
            class="relative overflow-hidden rounded-2xl md:rounded-[2rem]
                   shadow-2xl mb-8 bg-slate-950 border border-slate-900 isolation-auto"
        >

            <iframe
                src="{{ $video->embed_url }}"
                class="w-full aspect-video relative z-0"
                allow="autoplay; encrypted-media; picture-in-picture"
                allowfullscreen>
            </iframe>

        </div>

        {{-- CATEGORY (Aksen Badge Merah) --}}
        <span
            class="inline-flex items-center gap-2
                   px-4 py-1.5 rounded-full
                   bg-red-50 text-red-700 border border-red-100
                   font-bold text-xs md:text-sm shadow-sm"
        >
            🎥 {{ $video->category->name }}
        </span>

        {{-- TITLE --}}
        <h1
            class="text-2xl md:text-4xl lg:text-5xl
                   font-black text-slate-900
                   mt-5 mb-4 leading-tight"
        >
            {{ $video->title }}
        </h1>

        {{-- META --}}
        <div
            class="flex flex-wrap items-center gap-x-4 gap-y-2
                   text-xs md:text-sm text-slate-500 mb-8 pb-4 border-b border-slate-100"
        >

            <span class="font-medium text-slate-700">
                👤 {{ $video->user->name }}
            </span>

            <span class="text-slate-300">|</span>

            <span>
                📅 {{ $video->published_at?->format('d F Y') }}
            </span>

            <span class="text-slate-300">|</span>

            <span class="inline-flex items-center gap-1 text-xs font-semibold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-lg">
                👁 {{ number_format($video->views) }} x dilihat
            </span>

        </div>

        {{-- DESCRIPTION CONTAINER --}}
        <div
            class="bg-white rounded-2xl md:rounded-[2rem]
                   shadow-sm border border-slate-100
                   p-5 md:p-8"
        >

            <div
                class="article-content
                       prose prose-slate md:prose-lg
                       max-w-none

                       prose-headings:font-bold
                       prose-headings:text-slate-900

                       prose-p:text-slate-700
                       prose-p:leading-relaxed

                       prose-a:text-indigo-600
                       prose-a:font-semibold
                       hover:prose-a:text-indigo-700

                       prose-strong:text-slate-900

                       prose-img:rounded-2xl
                       prose-img:shadow-md

                       prose-blockquote:border-l-4
                       prose-blockquote:border-indigo-600
                       prose-blockquote:bg-indigo-50/50
                       prose-blockquote:rounded-r-xl
                       prose-blockquote:px-5
                       prose-blockquote:py-2"
            >

                {!! str($video->description)->sanitizeHtml() !!}

            </div>

        </div>

    </div>

</section>

{{-- RELATED VIDEOS --}}
@if($relatedVideos->count())

<section class="bg-slate-50 py-16 border-t border-slate-100">

    <div class="max-w-7xl mx-auto px-4 lg:px-8">

        <h2
            class="text-xl md:text-2xl lg:text-3xl font-black
                   text-slate-900 mb-8 flex items-center gap-2"
        >
            <span class="w-2.5 h-6 bg-indigo-600 rounded-full inline-block"></span>
            Video Terkait
        </h2>

        <div
            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6"
        >

            @foreach($relatedVideos as $item)

                <a
                    href="{{ route('videos.show',$item->slug) }}"
                    class="group bg-white flex flex-col h-full
                           rounded-2xl overflow-hidden
                           shadow-sm border border-slate-200/60
                           hover:shadow-xl hover:-translate-y-0.5 transition duration-300"
                >

                    <div class="relative aspect-video overflow-hidden bg-slate-900">
                        <img
                            src="{{ $item->youtube_thumbnail }}"
                            alt="{{ $item->title }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                        >
                        <div class="absolute inset-0 bg-indigo-950/10 opacity-0 group-hover:opacity-100 transition duration-300"></div>
                    </div>

                    <div class="p-4 flex-1 flex flex-col justify-between">

                        <h3
                            class="font-bold text-slate-800 text-sm md:text-base
                                   line-clamp-2 leading-snug group-hover:text-indigo-600 transition duration-200"
                        >
                            {{ $item->title }}
                        </h3>

                    </div>

                </a>

            @endforeach

        </div>

    </div>

</section>

@endif

@endsection