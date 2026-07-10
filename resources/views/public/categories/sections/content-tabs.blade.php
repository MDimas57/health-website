<section
    x-data="{ tab: 'article' }"
    class="py-16 md:py-24 bg-white border-t border-slate-100 relative overflow-hidden">

    {{-- BACKGROUND GRADASI PALET (Menyatu dari bawah ke atas) --}}
    <div class="absolute inset-0 bg-gradient-to-t from-blue-50/40 via-purple-50/20 to-white pointer-events-none z-0"></div>
    <div class="absolute bottom-0 left-1/3 w-[300px] h-[150px] rounded-full bg-purple-400/10 blur-[80px] pointer-events-none z-0"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        {{-- ================= HEADER ================= --}}
        <div class="text-center mb-10 md:mb-14">
            <span
                class="inline-flex
                       items-center
                       gap-2
                       px-4 py-2
                       rounded-full
                       bg-purple-50
                       text-purple-700
                       text-xs sm:text-sm
                       font-semibold
                       border border-purple-100">
                <svg class="w-4 h-4 text-purple-600"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14-6H5m14 12H5m14 6H5"/>
                </svg>
                Pusat Edukasi
            </span>

            <h2
                class="mt-4 sm:mt-5
                       text-2xl sm:text-3xl md:text-4xl lg:text-5xl
                       font-bold
                       tracking-tight
                       text-slate-900
                       px-2">
                Jelajahi Konten
                <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent block sm:inline mt-1 sm:mt-0">
                    {{ $category->name }}
                </span>
            </h2>
        </div>
       
        {{-- ================= TAB MENU (RESPONSIVE SCROLLABLE) ================= --}}
        <div class="flex justify-center mb-8 md:mb-12">
            <div
                class="inline-flex
                       bg-slate-100/80
                       backdrop-blur-sm
                       rounded-2xl
                       p-1.5
                       gap-1 sm:gap-2
                       max-w-full
                       overflow-x-auto
                       scrollbar-none
                       -mx-4 px-4 sm:mx-0 sm:px-1.5">

                {{-- Artikel --}}
                <button
                    @click="tab='article'"
                    :class="tab=='article'
                        ? 'bg-white shadow-sm text-blue-600 font-semibold border-slate-200/50'
                        : 'text-slate-600 hover:text-slate-900 border-transparent'"
                    class="px-4 sm:px-6
                           py-2.5 sm:py-3
                           rounded-xl
                           text-sm sm:text-base
                           whitespace-nowrap
                           border
                           transition-all duration-200">
                    📄 Artikel
                    <span
                        :class="tab=='article' ? 'bg-blue-50 text-blue-600' : 'bg-slate-200/60 text-slate-600'"
                        class="ml-1.5 sm:ml-2
                               text-xs
                               px-2 py-0.5
                               rounded-full transition-colors">
                        {{ $articles->count() }}
                    </span>
                </button>

                {{-- Poster --}}
                <button
                    @click="tab='poster'"
                    :class="tab=='poster'
                        ? 'bg-white shadow-sm text-purple-600 font-semibold border-slate-200/50'
                        : 'text-slate-600 hover:text-slate-900 border-transparent'"
                    class="px-4 sm:px-6
                           py-2.5 sm:py-3
                           rounded-xl
                           text-sm sm:text-base
                           whitespace-nowrap
                           border
                           transition-all duration-200">
                    🖼 Poster
                    <span
                        :class="tab=='poster' ? 'bg-purple-50 text-purple-600' : 'bg-slate-200/60 text-slate-600'"
                        class="ml-1.5 sm:ml-2
                               text-xs
                               px-2 py-0.5
                               rounded-full transition-colors">
                        {{ $posters->count() }}
                    </span>
                </button>

                {{-- Video --}}
                <button
                    @click="tab='video'"
                    :class="tab=='video'
                        ? 'bg-white shadow-sm text-red-600 font-semibold border-slate-200/50'
                        : 'text-slate-600 hover:text-slate-900 border-transparent'"
                    class="px-4 sm:px-6
                           py-2.5 sm:py-3
                           rounded-xl
                           text-sm sm:text-base
                           whitespace-nowrap
                           border
                           transition-all duration-200">
                    ▶ Video
                    <span
                        :class="tab=='video' ? 'bg-red-50 text-red-600' : 'bg-slate-200/60 text-slate-600'"
                        class="ml-1.5 sm:ml-2
                               text-xs
                               px-2 py-0.5
                               rounded-full transition-colors">
                        {{ $videos->count() }}
                    </span>
                </button>

            </div>
        </div>

        {{-- ================= CONTENT ================= --}}
        <div class="min-h-[250px]">
            <div
                x-show="tab=='article'"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0">
                @include('public.categories.sections.tab-articles', ['articles'=>$articles])
            </div>

            <div
                x-show="tab=='poster'"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-cloak>
                @include('public.categories.sections.tab-posters', ['posters'=>$posters])
            </div>

            <div
                x-show="tab=='video'"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-cloak>
                @include('public.categories.sections.tab-videos', ['videos'=>$videos])
            </div>
        </div>

        {{-- ================= BUTTON ACTION (DENGAN WARNA PALET TERPADU) ================= --}}
        <div class="mt-12 flex justify-center px-4">

            {{-- Button Artikel --}}
            <a
                x-show="tab=='article'"
                x-transition.opacity.duration.200ms
                href="{{ route('articles.index') }}"
                class="w-full sm:w-auto inline-flex items-center justify-center gap-3
                       px-7 py-3.5
                       rounded-2xl
                       bg-blue-600
                       text-white
                       font-semibold
                       hover:bg-blue-700
                       shadow-md shadow-blue-500/10
                       transition-all active:scale-95">
                Lihat Semua Artikel
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </a>

            {{-- Button Poster --}}
            <a
                x-show="tab=='poster'"
                x-transition.opacity.duration.200ms
                href="{{ route('posters.index') }}"
                class="w-full sm:w-auto inline-flex items-center justify-center gap-3
                       px-7 py-3.5
                       rounded-2xl
                       bg-purple-600
                       text-white
                       font-semibold
                       hover:bg-purple-700
                       shadow-md shadow-purple-500/10
                       transition-all active:scale-95"
                x-cloak>
                Lihat Semua Poster
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </a>

            {{-- Button Video --}}
            <a
                x-show="tab=='video'"
                x-transition.opacity.duration.200ms
                href="{{ route('videos.index') }}"
                class="w-full sm:w-auto inline-flex items-center justify-center gap-3
                       px-7 py-3.5
                       rounded-2xl
                       bg-red-600
                       text-white
                       font-semibold
                       hover:bg-red-700
                       shadow-md shadow-red-500/10
                       transition-all active:scale-95"
                x-cloak>
                Lihat Semua Video
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </a>

        </div>

    </div>

</section>

{{-- Tambahan utility untuk menghilangkan scrollbar bawaan browser pada menu horizontal mobile --}}
<style>
    .scrollbar-none::-webkit-scrollbar { display: none; }
    .scrollbar-none { -ms-overflow-style: none; scrollbar-width: none; }
    [x-cloak] { display: none !important; }
</style>