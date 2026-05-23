@extends('layouts.public')

@section('content')

    {{-- HERO --}}
    @include('partials.hero')

    {{-- MAIN CONTENT --}}
    <div class="max-w-[1200px] mx-auto px-4 lg:px-8">

        {{-- CATEGORY --}}
        <div class="mt-8">

            @include('partials.sections.categories-section', [
                'categories' => $categories
            ])

        </div>
        

        {{-- ARTICLES --}}
        <div>

            @include('partials.sections.articles-section', [
                'articles' => $articles
            ])

        </div>

        {{-- POSTERS --}}
        <div>

            @include('partials.sections.posters-section', [
                'posters' => $posters
            ])

        </div>

        {{-- VIDEOS --}}
        <div class="mt-20 mb-20">

            @include('partials.sections.videos-section', [
                'videos' => $videos
            ])

        </div>

    </div>

@endsection