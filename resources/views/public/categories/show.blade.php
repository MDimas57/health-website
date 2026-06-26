@extends('layouts.public')

@section('content')

    {{-- HERO --}}
    @include('public.categories.sections.hero')
          {{-- NOTES --}}
    @include('public.categories.sections.notes')

    {{-- CONTENT TABS --}}

    @include('public.categories.sections.content-tabs')


@endsection