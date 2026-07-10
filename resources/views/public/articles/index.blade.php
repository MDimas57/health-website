@extends('layouts.public')

@section('content')

<section class="bg-gradient-to-b from-slate-50 to-white min-h-screen py-6 sm:py-12">

    <div class="max-w-6xl mx-auto px-4 lg:px-8">

        {{-- BREADCRUMB NAVIGASI --}}
        <nav class="flex items-center gap-2 text-xs sm:text-sm text-slate-400 font-medium mb-6 sm:mb-8">
            <a href="/" class="hover:text-blue-600 transition duration-200 flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span>Beranda</span>
            </a>
            
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
            </svg>

            <span class="text-slate-600 truncate">Artikel Kesehatan</span>
        </nav>

        {{-- HEADER --}}
        <div class="text-center mb-10 sm:mb-14 max-w-3xl mx-auto">
            {{-- TITLE --}}
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-slate-800 leading-tight">
                Artikel Kesehatan
            </h1>
        </div>

        @livewire('article-search')

    </div>

</section>

@endsection