<section
    x-data="{ tab: 'article' }"
    class="py-24 bg-white border-t border-slate-100">

    <div class="max-w-7xl mx-auto px-6">
        {{-- ================= HEADER ================= --}}
<div class="text-center mb-14">

    <span
        class="inline-flex
               items-center
               gap-2
               px-4 py-2
               rounded-full
               bg-emerald-50
               text-emerald-700
               text-sm
               font-semibold">

        <svg class="w-4 h-4"
             fill="none"
             stroke="currentColor"
             stroke-width="2"
             viewBox="0 0 24 24">

            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M19 11H5m14-6H5m14 12H5m14 6H5"/>

        </svg>

        Pusat Edukasi

    </span>

    <h2
        class="mt-5
               text-3xl
               lg:text-5xl
               font-bold
               tracking-tight
               text-slate-900">

        Jelajahi Konten
        <span class="text-emerald-600">
            {{ $category->name }}
        </span>

    </h2>

</div>
       
        {{-- ================= TAB MENU ================= --}}
        <div
            class="inline-flex
                   bg-slate-100
                   rounded-2xl
                   p-2
                   gap-2
                   mb-12">

            {{-- Artikel --}}
            <button
                @click="tab='article'"
                :class="tab=='article'
                    ? 'bg-white shadow text-emerald-600'
                    : 'text-slate-500'"
                class="px-6
                       py-3
                       rounded-xl
                       font-medium
                       transition">

                📄 Artikel

                <span
                    class="ml-2
                           text-xs
                           bg-slate-100
                           px-2 py-1
                           rounded-full">

                    {{ $articles->count() }}

                </span>

            </button>

            {{-- Poster --}}
            <button
                @click="tab='poster'"
                :class="tab=='poster'
                    ? 'bg-white shadow text-emerald-600'
                    : 'text-slate-500'"
                class="px-6
                       py-3
                       rounded-xl
                       font-medium
                       transition">

                🖼 Poster

                <span
                    class="ml-2
                           text-xs
                           bg-slate-100
                           px-2 py-1
                           rounded-full">

                    {{ $posters->count() }}

                </span>

            </button>

            {{-- Video --}}
            <button
                @click="tab='video'"
                :class="tab=='video'
                    ? 'bg-white shadow text-emerald-600'
                    : 'text-slate-500'"
                class="px-6
                       py-3
                       rounded-xl
                       font-medium
                       transition">

                ▶ Video

                <span
                    class="ml-2
                           text-xs
                           bg-slate-100
                           px-2 py-1
                           rounded-full">

                    {{ $videos->count() }}

                </span>

            </button>

        </div>

        {{-- ================= CONTENT ================= --}}

        <div
            x-show="tab=='article'"
            x-transition.opacity.duration.300ms>

            @include(
                'public.categories.sections.tab-articles',
                ['articles'=>$articles]
            )

        </div>

        <div
            x-show="tab=='poster'"
            x-transition.opacity.duration.300ms>

            @include(
                'public.categories.sections.tab-posters',
                ['posters'=>$posters]
            )

        </div>

        <div
            x-show="tab=='video'"
            x-transition.opacity.duration.300ms>

            @include(
                'public.categories.sections.tab-videos',
                ['videos'=>$videos]
            )

        </div>
        {{-- ================= BUTTON ================= --}}
            <div class="mt-12 flex justify-center">

                <a
                    x-show="tab=='article'"
                    x-transition.opacity.duration.300ms
                    href="{{ route('articles.index') }}"
                    class="inline-flex items-center gap-3
                        px-7 py-3.5
                        rounded-2xl
                        bg-emerald-600
                        text-white
                        font-semibold
                        hover:bg-emerald-700
                        transition">

                    Lihat Semua Artikel

                    <svg class="w-5 h-5"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 5l7 7-7 7"/>

                    </svg>

                </a>

                <a
                    x-show="tab=='poster'"
                    x-transition.opacity.duration.300ms
                    href="{{ route('posters.index') }}"
                    class="inline-flex items-center gap-3
                        px-7 py-3.5
                        rounded-2xl
                        bg-emerald-600
                        text-white
                        font-semibold
                        hover:bg-emerald-700
                        transition">

                    Lihat Semua Poster

                    <svg class="w-5 h-5"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 5l7 7-7 7"/>

                    </svg>

                </a>

                <a
                    x-show="tab=='video'"
                    x-transition.opacity.duration.300ms
                    href="{{ route('videos.index') }}"
                    class="inline-flex items-center gap-3
                        px-7 py-3.5
                        rounded-2xl
                        bg-emerald-600
                        text-white
                        font-semibold
                        hover:bg-emerald-700
                        transition">

                    Lihat Semua Video

                    <svg class="w-5 h-5"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 5l7 7-7 7"/>

                    </svg>

                </a>

            </div>

    </div>

</section>