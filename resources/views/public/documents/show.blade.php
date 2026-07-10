@extends('layouts.public')

@section('content')

@php
    $extension = strtolower(pathinfo($document->document_file, PATHINFO_EXTENSION));

    // Pemetaan warna badge & ikon berdasarkan tipe file secara dinamis
    list($bgType, $textType, $iconSvg) = match ($extension) {
        'pdf' => [
            'bg-red-50 text-red-700 border-red-100/60', 
            'PDF DOKUMEN',
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2zM9 9h1.5M9 13h6m-6 4h6"/>'
        ],
        'doc', 'docx' => [
            'bg-blue-50 text-blue-700 border-blue-100/60', 
            'WORD DOKUMEN',
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>'
        ],
        'ppt', 'pptx' => [
            'bg-orange-50 text-orange-700 border-orange-100/60', 
            'POWERPOINT',
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 12l3-3 3 3 4-4M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>'
        ],
        default => [
            'bg-slate-50 text-slate-700 border-slate-200/60', 
            strtoupper($extension) ?: 'BERKAS',
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>'
        ],
    };
@endphp

<section class="py-6 sm:py-10 bg-slate-50/50 min-h-screen">
    <div class="max-w-5xl mx-auto px-4 sm:px-6">

        {{-- BREADCRUMB NAVIGASI --}}
        <nav class="flex flex-wrap items-center gap-2 text-xs sm:text-sm text-slate-400 font-medium mb-5 sm:mb-6">
            <a href="/" class="hover:text-blue-600 transition flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span>Beranda</span>
            </a>
            
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
            </svg>

            <a href="{{ route('documents.index') }}" class="hover:text-blue-600 transition">Arsip Dokumen</a>
            
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
            </svg>

            <span class="text-slate-600 truncate max-w-[180px] sm:max-w-xs">{{ $document->title }}</span>
        </nav>

        {{-- KONTEN UTAMA DETAIL DOKUMEN --}}
        <div class="bg-white rounded-[24px] sm:rounded-[32px] border border-slate-100 shadow-sm p-5 sm:p-8 md:p-10">
            
            {{-- Bagian Atas: Info Dokumen --}}
            <div class="flex flex-col md:flex-row md:items-start gap-4 sm:gap-5">
                
                {{-- Lingkaran Ikon File --}}
                <div class="p-3.5 sm:p-4 rounded-2xl bg-blue-50/70 text-blue-600 w-fit h-fit flex-shrink-0 mx-auto md:mx-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 sm:w-10 sm:h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        {!! $iconSvg !!}
                    </svg>
                </div>

                {{-- Judul & Informasi Meta --}}
                <div class="flex-1 text-center md:text-left">
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-2 mb-2.5">
                        <span class="px-2.5 py-0.5 rounded-md border text-[10px] font-bold tracking-wider {{ $bgType }}">
                            {{ $textType }}
                        </span>
                        <span class="px-2.5 py-0.5 rounded-md bg-blue-50 text-blue-700 text-[10px] font-bold">
                            {{ $document->category->name }}
                        </span>
                    </div>

                    <h1 class="text-xl sm:text-2xl md:text-3xl font-extrabold text-slate-900 leading-tight tracking-tight">
                        {{ $document->title }}
                    </h1>

                    {{-- Data Informasi Meta --}}
                    <div class="mt-3.5 flex flex-wrap justify-center md:justify-start items-center gap-x-3 gap-y-1.5 text-xs sm:text-sm text-slate-400 font-medium">
                        <span class="text-slate-600 flex items-center gap-1">
                            <span class="text-slate-300">Oleh</span> {{ $document->user->name }}
                        </span>
                        <span class="hidden sm:inline text-slate-200">•</span>
                        <span class="flex items-center gap-1">
                            <span>📅</span> {{ $document->published_at?->format('d M Y') ?? 'Baru saja' }}
                        </span>
                        <span class="hidden sm:inline text-slate-200">•</span>
                        <span class="flex items-center gap-1">
                            <span>📥</span> {{ number_format($document->download_count) }} Kali diunduh
                        </span>
                    </div>
                </div>
            </div>

            {{-- Bagian Tengah: Deskripsi Dokumen --}}
            @if($document->description)
                <div class="mt-8 pt-6 border-t border-slate-100">
                    <h3 class="font-bold text-sm sm:text-base text-slate-800 tracking-tight mb-3">
                        Deskripsi / Ringkasan:
                    </h3>
                    <div class="prose prose-slate max-w-none text-slate-600 text-xs sm:text-sm leading-relaxed prose-headings:font-bold prose-a:text-blue-600">
                        {!! $document->description !!}
                    </div>
                </div>
            @endif

            {{-- Bagian Bawah: Tombol Aksi (Sticky khusus Mobile di bagian bawah layar bisa dipertimbangkan, namun ini versi standar responsif) --}}
            <div class="mt-8 pt-6 border-t border-slate-100 flex flex-col sm:flex-row gap-3">
                
                <a
                    href="{{ route('documents.download', $document->slug) }}"
                    class="flex-1 order-last sm:order-first inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl bg-blue-600 text-white font-bold text-sm shadow-sm shadow-blue-100 hover:bg-blue-700 transition active:scale-[0.99]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    <span>Unduh Berkas Sekarang</span>
                </a>

                @if(Route::has('documents.preview'))
                <a
                    href="{{ route('documents.preview', $document->slug) }}"
                    class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 font-bold text-sm hover:bg-slate-100 transition active:scale-[0.99]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <span>Pratinjau (Preview)</span>
                </a>
                @endif

            </div>

        </div>

        {{-- AREA BLOK DOKUMEN TERKAIT --}}
        @if($relatedDocuments->count())
            <div class="mt-12 sm:mt-16">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg sm:text-xl md:text-2xl font-extrabold text-slate-800 tracking-tight">
                        Dokumen Terkait Lainnya
                    </h2>
                    <span class="w-12 h-1 bg-blue-500 rounded-full hidden sm:block flex-1 max-w-[100px] ml-4"></span>
                </div>

                {{-- Grid Menggunakan Kombinasi Grid Responsif untuk Menyerasikan Komponen Card --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">
                    @foreach($relatedDocuments as $relatedDoc)
                        @include('public.documents.components.card', ['document' => $relatedDoc])
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</section>

@endsection