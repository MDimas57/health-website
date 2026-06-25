@extends('layouts.public')

@section('content')

<section class="pb-16">

    <div class="max-w-6xl mx-auto px-4 lg:px-8">

        {{-- PLAYER --}}
        <div
            class="overflow-hidden rounded-[2rem]
                   shadow-2xl mb-8"
        >

            <iframe
                src="{{ $video->embed_url }}"
                class="w-full aspect-video"
                allowfullscreen>
            </iframe>

        </div>

        {{-- CATEGORY --}}
        <span
            class="inline-flex items-center gap-2
                   px-4 py-2 rounded-full
                   bg-red-100 text-red-700
                   font-semibold text-sm"
        >
            🎥 {{ $video->category->name }}
        </span>

        {{-- TITLE --}}
        <h1
            class="text-4xl lg:text-5xl
                   font-black text-slate-900
                   mt-6 mb-5"
        >
            {{ $video->title }}
        </h1>

        {{-- META --}}
        <div
            class="flex flex-wrap gap-4
                   text-sm text-slate-500 mb-8"
        >

            <span>
                👤 {{ $video->user->name }}
            </span>

            <span>
                📅 {{ $video->published_at?->format('d F Y') }}
            </span>

            <span>
                👁 {{ number_format($video->views) }}
            </span>

        </div>

        {{-- DESCRIPTION --}}
        <div
            class="bg-white rounded-[2rem]
                   shadow-sm border border-slate-100
                   p-8"
        >

            <p
                class="leading-8 text-slate-700"
            >
                {{ $video->description }}
            </p>

        </div>

    </div>

</section>

{{-- RELATED --}}
@if($relatedVideos->count())

<section class="bg-slate-50 py-16">

    <div class="max-w-7xl mx-auto px-4 lg:px-8">

        <h2
            class="text-3xl font-black
                   text-slate-900 mb-8"
        >
            Video Terkait
        </h2>

        <div
            class="grid md:grid-cols-2
                   lg:grid-cols-4 gap-6"
        >

            @foreach($relatedVideos as $item)

                <a
                    href="{{ route('videos.show',$item->slug) }}"
                    class="group bg-white
                           rounded-3xl overflow-hidden
                           shadow-sm border border-slate-100
                           hover:shadow-xl transition"
                >

                    <img
                        src="{{ $item->youtube_thumbnail }}"
                        class="w-full h-48 object-cover"
                    >

                    <div class="p-5">

                        <h3
                            class="font-bold
                                   line-clamp-2"
                        >
                            {{ $item->title }}
                        </h3>

                    </div>

                </a>

            @endforeach

        </div>

    </div>

</section>

@endif

@endsection