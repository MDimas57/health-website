@php
    $extension = strtolower(pathinfo($document->document_file, PATHINFO_EXTENSION));

    // Pemetaan warna badge & ikon berdasarkan tipe file secara dinamis
    list($bgType, $textType, $iconSvg) = match ($extension) {
        'pdf' => [
            'bg-red-50 text-red-700 border-red-100/50', 
            'PDF',
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2zM9 9h1.5M9 13h6m-6 4h6"/>'
        ],
        'doc', 'docx' => [
            'bg-blue-50 text-blue-700 border-blue-100/50', 
            'DOCX',
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>'
        ],
        'ppt', 'pptx' => [
            'bg-orange-50 text-orange-700 border-orange-100/50', 
            'PPTX',
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>'
        ],
        default => [
            'bg-slate-50 text-slate-700 border-slate-200/60', 
            strtoupper($extension) ?: 'FILE',
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>'
        ],
    };
@endphp

<article
    class="group bg-white rounded-[24px] md:rounded-[28px] border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col justify-between">

    <div class="p-5 sm:p-7 flex-1 flex flex-col justify-between">
        
        <div>
            {{-- Header Card: Ikon Jenis File & Badge Status --}}
            <div class="flex items-center justify-between gap-2">
                
                {{-- Jenis Ekstensi dengan Warna Identitas File --}}
                <div class="flex items-center gap-2">
                    <span class="p-2 rounded-xl bg-slate-50 text-slate-500 group-hover:text-blue-600 group-hover:bg-blue-50/50 transition duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            {!! $iconSvg !!}
                        </svg>
                    </span>
                    <span class="px-2.5 py-0.5 rounded-md border text-[10px] font-bold tracking-wider {{ $bgType }}">
                        {{ $textType }}
                    </span>
                </div>

                {{-- Badge Unggulan (Aksen Kuning Emas Elegan) --}}
                @if($document->is_featured)
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-amber-50 border border-amber-100 text-amber-700 text-[10px] sm:text-xs font-semibold shadow-sm">
                        <span>⭐</span>
                        <span class="hidden sm:inline">Unggulan</span>
                    </span>
                @endif

            </div>

            {{-- Judul Dokumen --}}
            <a href="{{ route('documents.show', $document->slug) }}" class="block mt-4 sm:mt-5">
                <h3 class="font-bold text-base sm:text-lg text-slate-900 leading-snug line-clamp-2 group-hover:text-blue-600 transition duration-200">
                    {{ $document->title }}
                </h3>
            </a>

            {{-- Badge Kategori Bawaan (Aksen Biru Menu) --}}
            <div class="mt-3 flex flex-wrap gap-1.5">
                <span class="px-2.5 py-1 rounded-lg bg-blue-50/80 text-blue-700 text-[11px] sm:text-xs font-medium border border-blue-100/30">
                    {{ $document->category->name }}
                </span>
            </div>
        </div>

        {{-- Panel Informasi Detail Metadata --}}
        <div>
            <div class="mt-5 pt-4 border-t border-slate-50 space-y-2 text-xs sm:text-sm text-slate-500">
                
                <div class="flex justify-between items-center">
                    <span class="text-slate-400">Total Unduh</span>
                    <span class="font-semibold text-slate-700 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        {{ number_format($document->download_count) }} kali
                    </span>
                </div>

                <div class="flex justify-between items-center">
                    <span class="text-slate-400">Pengunggah</span>
                    <span class="text-slate-600 truncate max-w-[150px] sm:max-w-[180px] text-right font-medium" title="{{ $document->user->name }}">
                        {{ $document->user->name }}
                    </span>
                </div>

            </div>

            {{-- Tombol Aksi Bawah Teroptimasi Mobile --}}
            <div class="mt-6 sm:mt-7 flex gap-2.5">
                
                <a
                    href="{{ route('documents.show', $document->slug) }}"
                    class="flex-1 rounded-xl bg-slate-50 border border-slate-100 py-2.5 sm:py-3 text-center text-xs sm:text-sm font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-800 transition active:scale-[0.98]">
                    Detail
                </a>

                <a
                    href="{{ route('documents.download', $document->slug) }}"
                    class="flex-1 rounded-xl bg-blue-600 py-2.5 sm:py-3 text-center text-xs sm:text-sm font-semibold text-white shadow-sm shadow-blue-100 hover:bg-blue-700 transition active:scale-[0.98] flex items-center justify-center gap-1">
                    <span>Unduh</span>
                </a>

            </div>
        </div>

    </div>

</article>