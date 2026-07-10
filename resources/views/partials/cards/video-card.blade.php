<a
    href="{{ route('videos.show', $video->slug) }}"
    class="group block h-full transition-all duration-500 rounded-3xl overflow-hidden
           {{ $isDark 
               ? 'bg-zinc-950/40 border border-white/10 hover:border-white/20 hover:shadow-xl hover:-translate-y-2' 
               : 'bg-white border border-zinc-100 shadow-md hover:shadow-xl hover:-translate-y-2' 
           }}"
>

    {{-- THUMBNAIL --}}
    <div class="relative overflow-hidden">

        {{-- YOUTUBE THUMBNAIL --}}
        @if($video->youtube_id)

            <img
                src="https://img.youtube.com/vi/{{ $video->youtube_id }}/hqdefault.jpg"
                alt="{{ $video->title }}"
                class="w-full h-56 object-cover
                       group-hover:scale-105
                       transition duration-700"
            >

        {{-- LOCAL THUMBNAIL --}}
        @elseif($video->thumbnail)

            <img
                src="{{ asset('storage/' . $video->thumbnail) }}"
                alt="{{ $video->title }}"
                class="w-full h-56 object-cover
                       group-hover:scale-105
                       transition duration-700"
            >

        {{-- FALLBACK (Menyesuaikan dengan mode terang/gelap) --}}
        @else

            <div class="w-full h-56 flex items-center justify-center border-b transition-colors duration-500
                {{ $isDark ? 'bg-zinc-900 border-white/5' : 'bg-zinc-50 border-zinc-100' }}">

                <i class="ti ti-video text-5xl {{ $isDark ? 'text-zinc-600' : 'text-zinc-300' }}"></i>

            </div>

        @endif

        {{-- OVERLAY --}}
        <div class="absolute inset-0
                    bg-gradient-to-t
                    from-black/60 via-black/10 to-transparent">
        </div>

        {{-- PLAY BUTTON --}}
        <div class="absolute inset-0 flex items-center justify-center">

            <div
                class="w-16 h-16 rounded-full
                       bg-white/95 backdrop-blur-md
                       flex items-center justify-center
                       shadow-xl
                       group-hover:scale-110
                       transition duration-300"
            >

                 <svg class="w-8 h-8 text-red-600 ml-1"
                    fill="currentColor"
                    viewBox="0 0 24 24">
                    <path d="M8 5v14l11-7z"/>
                </svg>

            </div>

        </div>

        {{-- BADGE --}}
        <div class="absolute top-4 left-4">

            <span
                class="inline-flex items-center
                       px-3 py-1 rounded-full
                       bg-red-600/90 backdrop-blur
                       text-white text-xs font-semibold shadow-sm"
            >
                Video
            </span>

        </div>

    </div>

    {{-- CONTENT --}}
    <div class="p-6">

        {{-- CATEGORY (Badge disesuaikan: Hijau pastel/lembut untuk card putih) --}}
        <span
            class="inline-flex items-center
                   px-2.5 py-1 rounded-md text-xs font-semibold mb-4 transition-colors duration-500
                   {{ $isDark 
                       ? 'bg-emerald-950/80 border border-emerald-500/30 text-emerald-400' 
                       : 'bg-emerald-50 border border-emerald-100 text-emerald-600' 
                   }}"
        >

            {{ $video->category->name ?? 'Tanpa Kategori' }}

        </span>

        {{-- TITLE --}}
        <h3
            class="text-lg font-bold leading-relaxed mb-4 line-clamp-2 transition-colors duration-300
                   {{ $isDark 
                       ? 'text-white group-hover:text-red-400' 
                       : 'text-zinc-900 group-hover:text-red-600' 
                   }}"
        >

            {{ $video->title }}

        </h3>
        

        {{-- META --}}
        <div class="flex items-center justify-between">

            <span class="text-sm transition-colors duration-500 {{ $isDark ? 'text-zinc-400' : 'text-zinc-500' }}">

                {{ $video->created_at->format('d M Y') }}

            </span>

            <span
                class="font-semibold text-sm transition-all duration-300 group-hover:translate-x-1
                       {{ $isDark ? 'text-red-400' : 'text-red-600' }}"
            >

                Tonton →

            </span>

        </div>
        

    </div>

</a>