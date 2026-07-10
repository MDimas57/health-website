@extends('layouts.public')

@section('content')

{{-- MAIN CONTENT SECTION --}}
<section class="py-6 sm:py-10 bg-slate-50/50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">

        {{-- BARIS ATAS: BREADCRUMB & HEADER CONTROL --}}
        <div class="mb-6 md:mb-8">
            {{-- Breadcrumb Navigasi --}}
            <nav class="flex items-center gap-2 text-xs sm:text-sm text-slate-400 font-medium mb-4">
                <a href="/" class="hover:text-blue-600 transition duration-200 flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Beranda</span>
                </a>
                
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                </svg>

                <span class="text-slate-600 truncate">Arsip Dokumen</span>
            </nav>

            {{-- Flex Container: Memisahkan Judul (Kiri) dan Fitur Cari Dokumen (Kanan) --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-1">
                <div>
                    <span
                        class="inline-flex
                               items-center
                               gap-2
                               px-4 py-2
                               rounded-full
                               bg-blue-50
                               border border-blue-100
                               text-blue-700
                               text-xs sm:text-sm
                               font-bold
                               tracking-wide
                               shadow-sm">
                        <span class="text-base leading-none">📄</span> Arsip Dokumen Kesehatan
                    </span>
                </div>

                {{-- Fitur Cari Dokumen Sekarang Berada di Atas Kanan --}}
                <div class="w-full sm:w-72">
                    <form method="GET" class="relative">
                        {{-- Mempertahankan parameter filter aktif saat submit cari --}}
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        @if(request('sort'))
                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                        @endif

                        {{-- Input Search dengan Ikon Kaca Pembesar di Sisi Kiri --}}
                        <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari nama dokumen..."
                            class="w-full pl-9 pr-10 py-2 rounded-xl border border-slate-200 
                                   text-xs sm:text-sm text-slate-800 placeholder-slate-400 shadow-sm
                                   focus:border-blue-500 focus:ring focus:ring-blue-100 focus:outline-none
                                   transition duration-200">
                        
                        <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-blue-600 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- GRID TATA LETAK UTAMA --}}
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 md:gap-8 lg:gap-10">

            {{-- Segmen Kiri: Sidebar --}}
            <div class="order-first lg:order-none">
                @include('public.documents.components.sidebar')
            </div>

            {{-- Segmen Kanan: Main List Dokumen --}}
            <div class="lg:col-span-3">

                @if($documents->count())

                    {{-- Grid List Dokumen --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5 sm:gap-6">
                        @foreach($documents as $document)
                            @include('public.documents.components.card', ['document' => $document])
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-10 sm:mt-14">
                        {{ $documents->links() }}
                    </div>

                @else

                    {{-- State Kosong --}}
                    <div
                        class="bg-white
                               rounded-[24px] md:rounded-[32px]
                               border border-slate-100
                               shadow-sm
                               py-16 px-6 sm:p-20
                               text-center
                               max-w-xl
                               mx-auto">

                        <div class="inline-flex p-5 rounded-full bg-slate-50 border border-slate-100 mb-5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6m-6 4h6"/>
                            </svg>
                        </div>

                        <h3 class="text-xl font-bold text-slate-800">
                            Berkas tidak ditemukan
                        </h3>

                        <p class="mt-2 text-sm text-slate-500 max-w-sm mx-auto leading-relaxed">
                            Maaf, dokumen yang Anda cari belum tersedia atau tidak masuk dalam kriteria filter saat ini.
                        </p>
                        
                        @if(request()->anyFilled(['search', 'category', 'sort']))
                            <div class="mt-6">
                                <a href="{{ route('documents.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-600 font-semibold text-xs transition duration-200">
                                    ❌ Reset Semua Filter
                                </a>
                            </div>
                        @endif

                    </div>

                @endif

            </div>

        </div>

    </div>
</section>

@endsection