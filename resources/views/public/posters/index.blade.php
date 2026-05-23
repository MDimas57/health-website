@extends('layouts.public')

@section('content')
<section class="bg-gradient-to-b from-slate-50 to-white min-h-screen py-12">

    <div class="max-w-6xl mx-auto px-4 lg:px-8">

        {{-- HEADER --}}
        <div class="text-center mb-14 max-w-3xl mx-auto">


            {{-- TITLE --}}
            <h1 class="text-4xl md:text-5xl font-black text-slate-800 leading-tight">

                Poster Edukasi Kesehatan

            </h1>

            {{-- DESCRIPTION --}}
            <p class="text-slate-500 text-lg leading-relaxed mt-5">

                Temukan berbagai informasi kesehatan terpercaya mulai dari
                pola hidup sehat, gizi, kesehatan mental, hingga tips medis
                terbaru yang disajikan secara informatif dan mudah dipahami.

            </p>

        </div>

        @livewire('poster-search')

    </div>

</section>
@endsection