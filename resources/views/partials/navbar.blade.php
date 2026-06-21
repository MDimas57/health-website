
<nav class="sticky top-0 z-50 bg-[#0f3b2e]/95 backdrop-blur-md border-b border-emerald-900/30 shadow-lg">

    <div class="max-w-[1400px] mx-auto px-4 lg:px-8">

        <div class="h-20 flex items-center justify-between">

            {{-- LEFT --}}
            <div class="flex items-center gap-14">

                {{-- LOGO --}}
                <a href="{{ route('home') }}"
                   class="flex items-center gap-4 shrink-0">

                    <img src="/images/logo.png"
                         alt="Logo"
                         class="w-14 h-14 rounded-xl object-cover bg-white p-1">

                    <div class="leading-tight">

                        <h1 class="text-lg font-bold text-white">
                            PortalSehat
                        </h1>

                        <p class="text-emerald-100 text-sm">
                            Kesehatan Masyarakat
                        </p>

                    </div>

                </a>

                {{-- MENU --}}
                <div class="hidden xl:flex items-center gap-8">

                    {{-- BERANDA --}}
                    <a href="{{ route('home') }}"
                       class="text-white font-semibold text-[16px]
                              hover:text-emerald-200 transition">

                        Beranda

                    </a>

                    {{-- ARTICLE --}}
                    <a href="{{ route('articles.index') }}"
                       class="text-white/90 font-semibold text-[16px]
                              hover:text-emerald-200 transition">

                        Artikel

                    </a>

                    {{-- POSTER --}}
                    <a href="{{ route('posters.index') }}"
                       class="text-white/90 font-semibold text-[16px]
                              hover:text-emerald-200 transition">

                        Poster

                    </a>

                    {{-- VIDEO --}}
                    <a href="{{ route('videos.index') }}"
                       class="text-white/90 font-semibold text-[16px]
                              hover:text-emerald-200 transition">

                        Video

                    </a>

                    {{-- CATEGORY DROPDOWN --}}
                    <div class="relative group">

                        <button class="flex items-center gap-2
                                       text-white/90 font-semibold text-[16px]
                                       hover:text-emerald-200 transition">

                            Kategori

                            <i class="ti ti-chevron-down text-sm"></i>

                        </button>

                        {{-- DROPDOWN --}}
                        <div class="absolute top-full left-0 pt-5
                                    opacity-0 invisible
                                    group-hover:opacity-100
                                    group-hover:visible
                                    transition-all duration-200">

                            <div class="w-[420px]
                                        bg-white rounded-3xl
                                        shadow-2xl border border-slate-100
                                        overflow-hidden">

                                {{-- HEADER --}}
                                <div class="px-6 py-5 border-b border-slate-100">

                                    <h3 class="font-bold text-slate-800 text-lg">
                                        Kategori Kesehatan
                                    </h3>

                                    <p class="text-slate-500 text-sm mt-1">
                                        Jelajahi topik kesehatan pilihan
                                    </p>

                                </div>

                                {{-- CATEGORY LIST --}}
                                <div class="grid grid-cols-2 gap-2 p-4">

                                    @foreach($navCategories as $category)

                                        <a href="{{ route('category.show', $category->slug) }}"
                                           class="flex items-start gap-3
                                                  p-4 rounded-2xl
                                                  hover:bg-slate-50
                                                  transition group/item">

                                            {{-- ICON --}}
                                            <div class="w-11 h-11 rounded-xl
                                                        bg-emerald-100
                                                        text-emerald-700
                                                        flex items-center justify-center
                                                        shrink-0">

                                                <i class="ti ti-{{ $category->icon ?? 'heart' }} text-xl"></i>

                                            </div>

                                            {{-- TEXT --}}
                                            <div>

                                                <h4 class="font-semibold text-slate-800
                                                           group-hover/item:text-emerald-700">

                                                    {{ $category->name }}

                                                </h4>

                                            </div>

                                        </a>

                                    @endforeach

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


        </div>

    </div>

</nav>
