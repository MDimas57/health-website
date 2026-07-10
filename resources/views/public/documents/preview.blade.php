@extends('layouts.public')

@section('content')

<section class="py-6 sm:py-10 bg-slate-50/50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">

        {{-- BREADCRUMB NAVIGASI --}}
        <nav class="flex flex-wrap items-center gap-2 text-xs sm:text-sm text-slate-400 font-medium mb-5">
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

            <a href="{{ route('documents.show', $document->slug) }}" class="hover:text-blue-600 transition truncate max-w-[120px] sm:max-w-xs">{{ $document->title }}</a>

            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
            </svg>

            <span class="text-slate-600">Pratinjau</span>
        </nav>

        {{-- AREA PANEL PRATINJAU DOKUMEN --}}
        <div class="bg-white rounded-[24px] sm:rounded-[32px] border border-slate-100 shadow-sm overflow-hidden">
            
            {{-- Panel Atas / Header Kontrol --}}
            <div class="border-b border-slate-100 p-4 sm:p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white">
                <div class="flex items-start gap-3">
                    <div class="p-2.5 rounded-xl bg-blue-50 text-blue-600 mt-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-base sm:text-lg font-bold text-slate-800 leading-snug line-clamp-1 sm:line-clamp-none">
                            Pratinjau: {{ $document->title }}
                        </h1>
                        <p class="text-xs text-slate-400 font-medium mt-0.5">
                            Kategori: <span class="text-blue-600 font-semibold">{{ $document->category->name }}</span>
                        </p>
                    </div>
                </div>

                {{-- Tombol Navigasi Kanan --}}
                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <a
                        href="{{ route('documents.show', $document->slug) }}"
                        class="flex-1 sm:flex-none inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 font-bold text-xs hover:bg-slate-100 transition">
                        Kembali Ke Detail
                    </a>
                    
                    <a
                        href="{{ route('documents.download', $document->slug) }}"
                        class="flex-1 sm:flex-none inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-xl bg-blue-600 text-white font-bold text-xs shadow-sm shadow-blue-100 hover:bg-blue-700 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        <span>Unduh Berkas</span>
                    </a>
                </div>
            </div>

            {{-- Area Rendering Preview Dokument --}}
            <div class="bg-slate-100/70 p-2 sm:p-4 md:p-6 min-h-[400px] flex flex-col justify-center">

                @if($extension == 'pdf')
                    {{-- Container PDF Responsif (Tinggi otomatis mengecil sedikit di layar HP kecil agar nyaman) --}}
                    <div class="w-full rounded-2xl overflow-hidden border border-slate-200 shadow-sm bg-white">
                        <iframe
                            src="{{ Storage::url($document->document_file) }}"
                            class="w-full h-[550px] sm:h-[750px] md:h-[850px] lg:h-[950px]"
                            frameborder="0"
                            allow="autoplay">
                        </iframe>
                    </div>

                @elseif(in_array($extension, ['doc', 'docx']))
                    {{-- State Tampilan Ekstensi Microsoft Word --}}
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm py-14 px-6 text-center max-w-xl mx-auto my-4 sm:my-8">
                        <div class="inline-flex p-4 rounded-full bg-blue-50 text-blue-600 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-slate-800">
                            Dokumen Microsoft Word
                        </h2>
                        <p class="mt-2 text-xs sm:text-sm text-slate-500 max-w-sm mx-auto leading-relaxed">
                            Browser tidak dapat menampilkan file Word secara langsung. Silakan gunakan Office Online Web Viewer resmi di bawah ini.
                        </p>
                        <div class="mt-6">
                            <a
                                target="_blank"
                                href="https://view.officeapps.live.com/op/view.aspx?src={{ urlencode(url(Storage::url($document->document_file))) }}"
                                class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-blue-600 text-white text-xs sm:text-sm font-bold shadow-md hover:bg-blue-700 transition">
                                <span>🌐</span> Buka via Office Web Viewer
                            </a>
                        </div>
                    </div>

                @elseif(in_array($extension, ['ppt', 'pptx']))
                    {{-- State Tampilan Ekstensi PowerPoint --}}
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm py-14 px-6 text-center max-w-xl mx-auto my-4 sm:my-8">
                        <div class="inline-flex p-4 rounded-full bg-orange-50 text-orange-600 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 12l3-3 3 3 4-4M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-slate-800">
                            Presentasi PowerPoint
                        </h2>
                        <p class="mt-2 text-xs sm:text-sm text-slate-500 max-w-sm mx-auto leading-relaxed">
                            Pratinjau berkas presentasi Anda secara aman menggunakan layanan ekstensi Microsoft Office Cloud Apps.
                        </p>
                        <div class="mt-6">
                            <a
                                target="_blank"
                                href="https://view.officeapps.live.com/op/view.aspx?src={{ urlencode(url(Storage::url($document->document_file))) }}"
                                class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-orange-600 text-white text-xs sm:text-sm font-bold shadow-md hover:bg-orange-700 transition">
                                <span>📊</span> Buka via PowerPoint Viewer
                            </a>
                        </div>
                    </div>

                @else
                    {{-- State Jika Format File Tidak Dikenali --}}
                    <div class="bg-white rounded-2xl border border-slate-100 p-10 text-center max-w-sm mx-auto">
                        <span class="text-4xl block mb-2">⚠️</span>
                        <p class="text-sm font-bold text-slate-700">Format tidak didukung</p>
                        <p class="text-xs text-slate-400 mt-1">Pratinjau langsung untuk tipe berkas ini tidak tersedia.</p>
                    </div>
                @endif

            </div>

        </div>
    </div>
</section>

@endsection