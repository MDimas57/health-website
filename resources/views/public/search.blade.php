@extends('layouts.public')

@section('content')

<div class="max-w-7xl mx-auto px-4 py-10">

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-800">
            Hasil Pencarian
        </h1>

        <p class="text-slate-500 mt-2">
            Kata kunci:
            <span class="font-semibold text-emerald-600">
                "{{ $q }}"
            </span>
        </p>

    </div>

    {{-- Jika ada hasil --}}
    @if($posts->count())

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            @foreach($posts as $post)

                <a href="{{ route('post.show', $post->slug) }}"
                   class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-200 hover:shadow-xl transition duration-300 group">

                    {{-- Thumbnail --}}
                    <div class="aspect-video overflow-hidden bg-slate-100">

                        @if($post->thumbnail)
                            <img
                                src="{{ Storage::url($post->thumbnail) }}"
                                alt="{{ $post->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                            >
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-400">
                                <i class="ti ti-photo text-5xl"></i>
                            </div>
                        @endif

                    </div>

                    {{-- Content --}}
                    <div class="p-5">

                        <div class="flex items-center gap-2 mb-3">

                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">
                                {{ $post->category->name ?? '-' }}
                            </span>

                            <span class="text-xs text-slate-400">
                                {{ $post->published_at?->translatedFormat('d M Y') }}
                            </span>

                        </div>

                        <h2 class="text-lg font-bold text-slate-800 mb-2 line-clamp-2 group-hover:text-emerald-600 transition">
                            {{ $post->title }}
                        </h2>

                        <p class="text-sm text-slate-500 line-clamp-3">
                            {{ \Illuminate\Support\Str::limit(strip_tags($post->content), 120) }}
                        </p>

                    </div>

                </a>

            @endforeach

        </div>

        {{-- Pagination --}}
        <div class="mt-10">
            {{ $posts->links() }}
        </div>

    @else

        {{-- Empty --}}
        <div class="bg-white border border-dashed border-slate-300 rounded-2xl p-12 text-center">

            <i class="ti ti-search-off text-6xl text-slate-300"></i>

            <h2 class="text-xl font-semibold text-slate-700 mt-4">
                Konten tidak ditemukan
            </h2>

            <p class="text-slate-500 mt-2">
                Coba gunakan kata kunci lain.
            </p>

        </div>

    @endif

</div>

@endsection