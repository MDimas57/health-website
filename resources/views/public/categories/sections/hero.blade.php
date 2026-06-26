<section class="relative">

    {{-- FULL WIDTH BANNER --}}
    <div
        class="relative
               left-1/2 right-1/2
               -translate-x-1/2
               w-screen
               h-[340px] md:h-[430px] lg:h-[500px]
               overflow-hidden">

        @if($banner)

            <img
                src="{{ Storage::url($banner->image) }}"
                class="absolute inset-0 w-full h-full object-cover"
            >

            {{-- Overlay lebih terang --}}
            <div class="absolute inset-0 bg-gradient-to-r from-black/30 via-black/20 to-black/30"></div>

        @else

            <div class="absolute inset-0 bg-gradient-to-r from-emerald-600 via-teal-500 to-cyan-500"></div>

        @endif


        {{-- Breadcrumb --}}
        <div class="relative max-w-7xl mx-auto h-full px-6">

            <div class="pt-10">

                <nav
                    class="inline-flex items-center gap-2
                           rounded-full
                           bg-white/15
                           backdrop-blur-xl
                           border border-white/20
                           px-5 py-2.5
                           text-white
                           text-sm">

                    <a href="/" class="hover:text-white/80">

                        Beranda

                    </a>

                    <span>/</span>

                    <span class="font-medium">

                        {{ $category->name }}

                    </span>

                </nav>

            </div>

        </div>

    </div>


    {{-- FLOATING STATISTIC --}}
{{-- FLOATING STATISTIC --}}
<div
    class="relative
           z-20
           max-w-4xl
           mx-auto
           px-4
           -mt-6 md:-mt-8">

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-2">

        {{-- Artikel --}}
        <div class="bg-white rounded-lg shadow-md p-3 text-center">

            <p class="text-[10px] text-slate-500 uppercase tracking-wide">
                Artikel
            </p>

            <h3
                x-data="counter({{ $articles->count() }})"
                x-init="start()"
                x-text="count"
                class="mt-1 text-2xl font-bold text-emerald-600">
            </h3>

        </div>

        {{-- Poster --}}
        <div class="bg-white rounded-lg shadow-md p-3 text-center">

            <p class="text-[10px] text-slate-500 uppercase tracking-wide">
                Poster
            </p>

            <h3
                x-data="counter({{ $posters->count() }})"
                x-init="start()"
                x-text="count"
                class="mt-1 text-2xl font-bold text-sky-600">
            </h3>

        </div>

        {{-- Video --}}
        <div class="bg-white rounded-lg shadow-md p-3 text-center">

            <p class="text-[10px] text-slate-500 uppercase tracking-wide">
                Video
            </p>

            <h3
                x-data="counter({{ $videos->count() }})"
                x-init="start()"
                x-text="count"
                class="mt-1 text-2xl font-bold text-red-600">
            </h3>

        </div>

        {{-- Catatan --}}
        <div class="bg-white rounded-lg shadow-md p-3 text-center">

            <p class="text-[10px] text-slate-500 uppercase tracking-wide">
                Catatan
            </p>

            <h3
                x-data="counter({{ $notes->count() }})"
                x-init="start()"
                x-text="count"
                class="mt-1 text-2xl font-bold text-amber-500">
            </h3>

        </div>

    </div>

</div>


</section>