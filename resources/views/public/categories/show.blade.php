@extends('layouts.public')

@section('content')

<section class="relative overflow-hidden">

    @if($banner)

        <img
            src="{{ Storage::url($banner->image) }}"
            class="absolute inset-0 w-full h-full object-cover"
        >

        <div class="absolute inset-0 bg-black/60"></div>

    @else

        <div class="absolute inset-0 bg-gradient-to-r from-emerald-700 to-emerald-500"></div>

    @endif

    <div class="relative max-w-7xl mx-auto px-6 py-28">

        <span
            class="inline-flex px-4 py-2 rounded-full
                   bg-white/20 backdrop-blur
                   text-white text-sm font-semibold"
        >
            Kategori Kesehatan
        </span>

        <h1
            class="mt-6 text-5xl font-black
                   text-white max-w-3xl"
        >
            {{ $category->name }}
        </h1>

        <p
            class="mt-5 text-white/90
                   max-w-2xl text-lg"
        >
            {{ $banner->subtitle ?? $category->description }}
        </p>

    </div>

</section>
@if($notes->count())

<section class="py-16 bg-amber-50">

    <div class="max-w-7xl mx-auto px-6">

        <!-- <h2 class="text-3xl font-bold mb-8">
            Catatan Kesehatan
        </h2> -->

        <div class="grid md:grid-cols-2 gap-6">

            @foreach($notes as $note)

                <div
                    class="bg-white rounded-3xl
                           shadow-sm border
                           border-amber-200 p-6"
                >
<!-- 
                    <h3
                        class="font-bold text-xl mb-4"
                    >
                        {{ $note->title }}
                    </h3> -->

                    <div
                        class="prose max-w-none"
                    >
                        {!! $note->content !!}
                    </div>

                    <div
                        class="mt-4 text-sm text-slate-500"
                    >
                        Oleh:
                        {{ $note->user->name }}
                    </div>

                </div>

            @endforeach

        </div>

    </div>

</section>

@endif
<section class="py-20">

    <div class="max-w-7xl mx-auto px-6">

        <div class="flex justify-between items-center mb-8">

            <h2 class="text-3xl font-bold">
                Artikel Terbaru
            </h2>

        </div>

        <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-8">

            @foreach($articles as $article)

                <a href="{{ route('articles.show', $article->slug) }}"
                   class="bg-white rounded-3xl overflow-hidden shadow-sm">

                    <img
                        src="{{ Storage::url($article->thumbnail) }}"
                        class="w-full h-60 object-cover"
                    >

                    <div class="p-6">

                        <h3 class="font-bold text-lg">
                            {{ $article->title }}
                        </h3>

                    </div>

                </a>

            @endforeach

        </div>

    </div>

</section>
<section class="py-20 bg-slate-50">

    <div class="max-w-7xl mx-auto px-6">

        <h2 class="text-3xl font-bold mb-8">
            Poster Edukasi
        </h2>

        <div class="grid md:grid-cols-3 xl:grid-cols-4 gap-8">

            @foreach($posters as $poster)

                <div
                    class="bg-white rounded-3xl overflow-hidden shadow-sm"
                >

                    <img
                        src="{{ Storage::url($poster->poster_file) }}"
                        class="w-full h-[420px] object-cover"
                    >

                </div>

            @endforeach

        </div>

    </div>

</section>
<section class="py-20">

    <div class="max-w-7xl mx-auto px-6">

        <h2 class="text-3xl font-bold mb-8">
            Video Edukasi
        </h2>

        <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-8">

            @foreach($videos as $video)

                <div
                    class="bg-white rounded-3xl overflow-hidden shadow-sm"
                >

                    <img
                        src="{{ $video->youtube_thumbnail }}"
                        class="w-full h-60 object-cover"
                    >

                    <div class="p-5">

                        <h3 class="font-semibold">
                            {{ $video->title }}
                        </h3>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</section>

@endsection