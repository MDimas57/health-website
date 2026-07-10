@extends('layouts.public')

@section('content')

<div class="max-w-7xl mx-auto px-4 lg:px-8 pt-6 pb-12">
    
    {{-- BREADCRUMB --}}
    <nav class="flex items-center gap-2 text-xs md:text-sm text-slate-500 mb-8 overflow-x-auto whitespace-nowrap pb-2 lg:pb-0">
        <a href="/" class="hover:text-indigo-600 transition">Beranda</a>
        <span class="text-slate-300">/</span>
        <a href="{{ route('posters.index') }}" class="hover:text-indigo-600 transition">Poster</a>
        <span class="text-slate-300">/</span>
        <span class="text-slate-800 font-medium truncate max-w-[200px] md:max-w-xs">
            {{ $poster->title }}
        </span>
    </nav>

    {{-- MAIN CONTENT GRID --}}
    <div class="block lg:flow-root">
        
        {{-- LEFT COLUMN: IMAGE & DOWNLOAD BUTTON (Float kiri di desktop, stack di mobile) --}}
        <div class="w-full lg:w-[420px] lg:float-left lg:mr-12 mb-8 lg:mb-6">
            
            {{-- IMAGE --}}
            <div class="relative overflow-hidden rounded-[2rem] shadow-xl border border-slate-100 bg-slate-50">
                <img
                    src="{{ Str::startsWith($poster->poster_file,'http')
                        ? $poster->poster_file
                        : Storage::url($poster->poster_file) }}"
                    alt="{{ $poster->title }}"
                    class="w-full h-auto object-cover"
                >
            </div>

            {{-- DOWNLOAD BUTTON (Tepat di bawah poster) --}}
            <a
                href="{{ Storage::url($poster->poster_file) }}"
                download
                class="inline-flex items-center justify-center gap-2
                       mt-5 w-full px-6 py-4 rounded-2xl
                       bg-red-600 text-white font-bold text-sm md:text-base
                       hover:bg-red-700 transition shadow-lg shadow-red-100"
            >
                ⬇ Download Poster
            </a>

        </div>

        {{-- RIGHT COLUMN: DETAILS & TEXT CONTENT --}}
        <div class="text-slate-900">
            
            {{-- CATEGORY BADGE (Aksen Biru Medis) --}}
            <span
                class="inline-flex items-center gap-2
                       px-4 py-1.5 rounded-full
                       bg-blue-50 text-blue-700
                       text-xs md:text-sm font-bold shadow-sm border border-blue-100"
            >
                🖼️ {{ $poster->category->name }}
            </span>

            {{-- TITLE --}}
            <h1
                class="text-2xl md:text-4xl lg:text-5xl
                       font-black text-slate-900
                       mt-4 mb-4 leading-tight"
            >
                {{ $poster->title }}
            </h1>

            {{-- META DATA --}}
            <div
                class="flex flex-wrap items-center gap-x-4 gap-y-2
                       text-xs md:text-sm text-slate-500 mb-8 pb-5 border-b border-slate-100"
            >
                <span class="flex items-center gap-1.5 font-medium text-slate-700">
                    👤 {{ $poster->user->name }}
                </span>
                <span class="text-slate-300">|</span>
                <span class="flex items-center gap-1.5">
                    📅 {{ $poster->published_at?->format('d F Y') }}
                </span>
                <span class="text-slate-300">|</span>
                <span class="flex items-center gap-1.5">
                    👁 {{ number_format($poster->views) }} x dilihat
                </span>
            </div>

            {{-- DESKRIPSI / ARTICLE CONTENT --}}
            {{-- (Menggunakan float layout agar jika teks panjang otomatis mengalir memenuhi bawah poster) --}}
            <div
                class="article-content
                       prose prose-slate md:prose-lg
                       max-w-none
                       
                       prose-headings:font-bold
                       prose-headings:text-slate-900
                       
                       prose-p:text-slate-700
                       prose-p:leading-relaxed
                       prose-p:mb-4
                       
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
                {!! str($poster->description)->sanitizeHtml() !!}
            </div>

        </div>

    </div>

</div>

{{-- RELATED POSTER (Warna Latar Belakang & Hover Mengikuti Tema Indigo) --}}
@if($relatedPosters->count())

<section class="bg-slate-50 py-16 border-t border-slate-100">

    <div class="max-w-7xl mx-auto px-4 lg:px-8">

        <h2
            class="text-xl md:text-2xl lg:text-3xl font-black
                   text-slate-900 mb-8 flex items-center gap-2"
        >
            <span class="w-2.5 h-6 bg-indigo-600 rounded-full inline-block"></span>
            Poster Terkait
        </h2>

        <div
            class="grid grid-cols-2
                   sm:grid-cols-3
                   lg:grid-cols-6 gap-4 md:gap-6"
        >

            @foreach($relatedPosters as $item)

                <a
                    href="{{ route('posters.show',$item->slug) }}"
                    class="group block relative aspect-[2/3] overflow-hidden rounded-2xl shadow-sm hover:shadow-xl border border-slate-200/60 transition duration-300"
                >

                    <img
                        src="{{ Storage::url($item->poster_file) }}"
                        alt="Poster terkait"
                        class="w-full h-full object-cover
                               group-hover:scale-105
                               transition duration-500"
                    >
                    
                    {{-- Soft Overlay on Hover --}}
                    <div class="absolute inset-0 bg-indigo-900/10 opacity-0 group-hover:opacity-100 transition duration-300"></div>

                </a>

            @endforeach

        </div>

    </div>

</section>

@endif

@endsection