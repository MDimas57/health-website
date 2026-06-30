@extends('layouts.public')

@section('content')

{{-- HERO --}}
<section class="pb-12">

    <div class="max-w-7xl mx-auto px-4 lg:px-8">

        <div class="grid lg:grid-cols-2 gap-12 items-center">

            {{-- IMAGE --}}
            <div>

                <img
                    src="{{ Str::startsWith($poster->poster_file,'http')
                        ? $poster->poster_file
                        : Storage::url($poster->poster_file) }}"
                    class="w-full rounded-[2rem]
                           shadow-2xl border border-slate-100"
                >

            </div>

            {{-- CONTENT --}}
            <div>

                <span
                    class="inline-flex items-center gap-2
                           px-4 py-2 rounded-full
                           bg-orange-100 text-orange-700
                           text-sm font-semibold"
                >
                    🖼️ {{ $poster->category->name }}
                </span>

                <h1
                    class="text-4xl lg:text-5xl
                           font-black text-slate-900
                           mt-6 mb-6"
                >
                    {{ $poster->title }}
                </h1>

                <div
                    class="flex flex-wrap gap-4
                           text-sm text-slate-500 mb-8"
                >

                    <span>
                        👤 {{ $poster->user->name }}
                    </span>

                    <span>
                        📅 {{ $poster->published_at?->format('d F Y') }}
                    </span>

                    <span>
                        👁 {{ number_format($poster->views) }}
                    </span>

                </div>

              
            <div
                class="article-content
                       prose md:prose-lg
                       max-w-none

                       prose-headings:font-bold
                       prose-headings:text-slate-900

                       prose-p:text-slate-700
                       prose-p:leading-8

                       prose-a:text-emerald-600

                       prose-strong:text-slate-900

                       prose-img:rounded-2xl
                       prose-img:shadow-lg

                       prose-blockquote:border-emerald-500
                       prose-blockquote:bg-emerald-50
                       prose-blockquote:rounded-xl
                       prose-blockquote:px-6
                       prose-blockquote:py-3"
            >

                {!! str($poster->description)->sanitizeHtml() !!}

            </div>

                <a
                    href="{{ Storage::url($poster->poster_file) }}"
                    download
                    class="inline-flex items-center gap-2
                           mt-8 px-6 py-4 rounded-2xl
                           bg-orange-500 text-white
                           font-semibold
                           hover:bg-orange-600"
                >
                    ⬇ Download Poster
                </a>

            </div>

        </div>

    </div>

</section>

{{-- RELATED POSTER --}}
@if($relatedPosters->count())

<section class="bg-slate-50 py-16">

    <div class="max-w-7xl mx-auto px-4 lg:px-8">

        <h2
            class="text-3xl font-black
                   text-slate-900 mb-8"
        >
            Poster Terkait
        </h2>

        <div
            class="grid grid-cols-2
                   md:grid-cols-3
                   lg:grid-cols-6 gap-6"
        >

            @foreach($relatedPosters as $item)

                <a
                    href="{{ route('posters.show',$item->slug) }}"
                    class="group"
                >

                    <img
                        src="{{ Storage::url($item->poster_file) }}"
                        class="rounded-2xl
                               shadow-md
                               group-hover:scale-105
                               transition"
                    >

                </a>

            @endforeach

        </div>

    </div>

</section>

@endif

@endsection