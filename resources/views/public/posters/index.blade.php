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

        </div>

        @livewire('poster-search')

    </div>

</section>
@endsection