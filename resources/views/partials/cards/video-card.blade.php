<a
    href="{{ route('videos.show', $video->slug) }}"
    class="group bg-white rounded-3xl overflow-hidden
           border border-slate-200 shadow-sm
           hover:shadow-2xl hover:-translate-y-2
           transition-all duration-500 block"
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

        {{-- FALLBACK --}}
        @else

            <div class="w-full h-56 bg-slate-100 flex items-center justify-center">

                <i class="ti ti-video text-5xl text-slate-400"></i>

            </div>

        @endif

        {{-- OVERLAY --}}
        <div class="absolute inset-0
                    bg-gradient-to-t
                    from-black/50 via-black/10 to-transparent">
        </div>

        {{-- PLAY BUTTON --}}
        <div class="absolute inset-0 flex items-center justify-center">

            <div
                class="w-16 h-16 rounded-full
                       bg-white/90 backdrop-blur-md
                       flex items-center justify-center
                       shadow-xl
                       group-hover:scale-110
                       transition duration-300"
            >

                 <!-- SVG ICON -->
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
                       text-white text-xs font-semibold"
            >
                Video
            </span>

        </div>

    </div>

    {{-- CONTENT --}}
    <div class="p-6">

        {{-- CATEGORY --}}
        <span
            class="inline-flex items-center
                   px-3 py-1 rounded-full
                   bg-emerald-100 text-emerald-700
                   text-xs font-semibold mb-4"
        >

            {{ $video->category->name ?? 'Tanpa Kategori' }}

        </span>

        {{-- TITLE --}}
        <h3
            class="text-lg font-bold text-slate-800
                   leading-relaxed mb-4
                   line-clamp-2
                   group-hover:text-emerald-600
                   transition"
        >

            {{ $video->title }}

        </h3>

        {{-- META --}}
        <div class="flex items-center justify-between">

            <span class="text-sm text-slate-400">

                {{ $video->created_at->format('d M Y') }}

            </span>

            <span
                class="text-red-600 font-semibold
                       group-hover:translate-x-1
                       transition"
            >

                Tonton →

            </span>

        </div>

    </div>

</a>