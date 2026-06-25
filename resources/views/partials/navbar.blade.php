<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">

<nav x-data="{ mobileMenu:false }"
    class="sticky top-0 z-50
           bg-gradient-to-r
           from-emerald-950
           via-emerald-900
           to-teal-900
           backdrop-blur-xl
           border-b border-white/10
           shadow-2xl">

    <div class="max-w-[1400px] mx-auto px-4 lg:px-8">

        <div class="h-20 flex items-center justify-between">

            {{-- LEFT --}}
            <div class="flex items-center gap-14">

                {{-- LOGO --}}
                <a href="{{ route('home') }}"
                   class="flex items-center gap-4 shrink-0">

                    <div class="relative">

                        <div class="absolute inset-0
                                    bg-emerald-400/30
                                    blur-xl rounded-full">
                        </div>

                        <img src="/images/logo.png"
                             alt="Logo"
                             class="relative
                                    w-14 h-14
                                    rounded-2xl
                                    bg-white
                                    p-1.5
                                    shadow-lg">

                    </div>

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
                class="relative text-[16px] font-semibold transition
                {{ request()->routeIs('home')
                        ? 'text-white after:w-full'
                        : 'text-white/90 hover:text-white after:w-0 hover:after:w-full' }}
                after:absolute after:left-0 after:-bottom-2
                after:h-[2px]
                after:bg-emerald-300
                after:transition-all">

                    Beranda

                </a>

                {{-- ARTIKEL --}}
                <a href="{{ route('articles.index') }}"
                class="relative text-[16px] font-semibold transition
                {{ request()->routeIs('articles.*')
                        ? 'text-white after:w-full'
                        : 'text-white/90 hover:text-white after:w-0 hover:after:w-full' }}
                after:absolute after:left-0 after:-bottom-2
                after:h-[2px]
                after:bg-emerald-300
                after:transition-all">

                    Artikel

                </a>

                {{-- POSTER --}}
                <a href="{{ route('posters.index') }}"
                class="relative text-[16px] font-semibold transition
                {{ request()->routeIs('posters.*')
                        ? 'text-white after:w-full'
                        : 'text-white/90 hover:text-white after:w-0 hover:after:w-full' }}
                after:absolute after:left-0 after:-bottom-2
                after:h-[2px]
                after:bg-emerald-300
                after:transition-all">

                    Poster

                </a>

                {{-- VIDEO --}}
                <a href="{{ route('videos.index') }}"
                class="relative text-[16px] font-semibold transition
                {{ request()->routeIs('videos.*')
                        ? 'text-white after:w-full'
                        : 'text-white/90 hover:text-white after:w-0 hover:after:w-full' }}
                after:absolute after:left-0 after:-bottom-2
                after:h-[2px]
                after:bg-emerald-300
                after:transition-all">

                    Video

                </a>


                    {{-- DROPDOWN KATEGORI --}}
                    <div class="relative group">

                        <button class="flex items-center gap-2
                                       text-white/90 font-semibold text-[16px]
                                       hover:text-white transition">

                            Kategori

                            <i class="ti ti-chevron-down text-sm
                                      transition-transform
                                      group-hover:rotate-180"></i>

                        </button>

                        {{-- DROPDOWN MENU --}}
                        <div class="absolute top-full left-0 pt-5
                                    opacity-0 invisible
                                    translate-y-3
                                    group-hover:opacity-100
                                    group-hover:visible
                                    group-hover:translate-y-0
                                    transition-all duration-300">

                            <div class="w-[460px]
                                        bg-white/95
                                        backdrop-blur-xl
                                        rounded-3xl
                                        shadow-2xl
                                        border border-slate-100
                                        overflow-hidden">

                                {{-- HEADER --}}
                                <div class="px-6 py-5
                                            bg-gradient-to-r
                                            from-emerald-50
                                            to-teal-50
                                            border-b border-slate-100">

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
                                           class="group/item
                                                  flex items-start gap-4
                                                  p-4 rounded-2xl
                                                  hover:bg-gradient-to-r
                                                  hover:from-emerald-50
                                                  hover:to-teal-50
                                                  hover:shadow-md
                                                  transition-all duration-300">

                                            {{-- ICON --}}
                                            <div class="w-12 h-12 rounded-2xl
                                                        bg-gradient-to-br
                                                        from-emerald-500
                                                        to-teal-600
                                                        text-white
                                                        flex items-center justify-center
                                                        shadow-lg
                                                        shrink-0
                                                        transition-all duration-300
                                                        group-hover/item:scale-110">

                                                <i class="ti ti-{{ $category->icon ?: 'heart' }} text-xl"></i>

                                            </div>

                                            {{-- TEXT --}}
                                            <div>

                                                <h4 class="font-semibold text-slate-800
                                                           group-hover/item:text-emerald-700
                                                           transition">

                                                    {{ $category->name }}

                                                </h4>

                                                <p class="text-xs text-slate-500 mt-1">
                                                    Lihat Konten kesehatan
                                                </p>

                                            </div>

                                        </a>

                                    @endforeach

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>
        {{-- MOBILE MENU BUTTON --}}
                <button
                    @click="mobileMenu = !mobileMenu"
                    class="xl:hidden
                        w-11 h-11
                        rounded-xl
                        bg-white/10
                        border border-white/10
                        text-white
                        flex items-center justify-center"
                >

                    <i
                        class="ti"
                        :class="mobileMenu ? 'ti-x' : 'ti-menu-2'"
                    ></i>

                </button>
            {{-- RIGHT --}}
            <div class="hidden lg:flex items-center gap-3">

                {{-- SEARCH --}}
                <a href="{{ route('articles.index') }}"
                   class="w-11 h-11
                          rounded-xl
                          bg-white/10
                          border border-white/10
                          text-white
                          flex items-center justify-center
                          hover:bg-white/20
                          transition">

                    <i class="ti ti-search text-lg"></i>

                </a>

                {{-- CTA BUTTON --}}
                <a href="{{ route('articles.index') }}"
                   class="px-5 py-2.5
                          rounded-xl
                          bg-gradient-to-r
                          from-emerald-500
                          to-teal-500
                          text-white
                          font-semibold
                          shadow-lg
                          hover:shadow-emerald-500/30
                          hover:scale-105
                          transition-all duration-300">

                    Jelajahi Artikel

                </a>

            </div>

        </div>

                    {{-- MOBILE MENU --}}
            <div
                x-show="mobileMenu"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 -translate-y-4 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 -translate-y-4 scale-95"
                x-cloak
                class="xl:hidden pb-6"
            >

                <div
                      class="mt-3
                        bg-white/95
                        backdrop-blur-xl
                        rounded-[18px]
                        shadow-2xl
                        border border-slate-100
                        overflow-hidden"
                >


                    {{-- BERANDA --}}
                    <a
                 href="{{ route('home') }}"
                    class="group relative
                        flex items-center gap-3
                        px-5 py-4
                        text-slate-700
                        hover:bg-gradient-to-r
                        hover:from-emerald-50
                        hover:to-teal-50
                        hover:text-emerald-700
                        transition-all duration-300"
                >

                   <span
                        class="absolute bottom-0 left-0
                            h-[2px] w-0
                            bg-gradient-to-r
                            from-emerald-500
                            to-teal-500
                            transition-all duration-300
                            group-hover:w-full">
                    </span>
                    <div
                        class="w-10 h-10 rounded-xl
                            bg-gradient-to-br
                            from-emerald-500
                            to-teal-600
                            text-white
                            flex items-center justify-center"
                    >
                        <i class="ti ti-home"></i>
                    </div>
                       <span>Beranda</span>
                    </a>

                    {{-- ARTIKEL --}}
                 <a
                    href="{{ route('articles.index') }}"
                    class="group relative
                        flex items-center gap-3
                        px-5 py-4
                        transition-all duration-300

                        {{ request()->routeIs('articles.*')
                                ? 'bg-emerald-50 text-emerald-700'
                                : 'text-slate-700 hover:bg-gradient-to-r hover:from-emerald-50 hover:to-teal-50 hover:text-emerald-700' }}"
                >

                    <div
                        class="w-10 h-10 rounded-xl
                            bg-gradient-to-br
                            from-emerald-500
                            to-teal-600
                            text-white
                            flex items-center justify-center"
                    >
                        <i class="ti ti-file-text"></i>
                    </div>

                    <span>Artikel</span>

                    {{-- Bottom Line --}}
                    <span
                        class="absolute bottom-0 left-0
                            h-[2px]
                            bg-gradient-to-r
                            from-emerald-500
                            to-teal-500
                            transition-all duration-300

                            {{ request()->routeIs('articles.*')
                                    ? 'w-full'
                                    : 'w-0 group-hover:w-full' }}">
                    </span>

                </a>

                    {{-- POSTER --}}
                    <a
                        href="{{ route('posters.index') }}"
                       class="group relative
                        flex items-center gap-3
                        px-5 py-4
                        transition-all duration-300

                        {{ request()->routeIs('posters.*')
                                ? 'bg-emerald-50 text-emerald-700'
                                : 'text-slate-700 hover:bg-gradient-to-r hover:from-emerald-50 hover:to-teal-50 hover:text-emerald-700' }}"
                    >
                      <div
                        class="w-10 h-10 rounded-xl
                            bg-gradient-to-br
                            from-emerald-500
                            to-teal-600
                            text-white
                            flex items-center justify-center"
                    >
                        <i class="ti ti-photo"></i>
                    </div>
                        <span>Poster</span>
                         {{-- Bottom Line --}}
                    <span
                        class="absolute bottom-0 left-0
                            h-[2px]
                            bg-gradient-to-r
                            from-emerald-500
                            to-teal-500
                            transition-all duration-300

                            {{ request()->routeIs('posters.*')
                                    ? 'w-full'
                                    : 'w-0 group-hover:w-full' }}">
                    </span>
                    </a>

                    {{-- VIDEO --}}
                    <a
                        href="{{ route('videos.index') }}"
                        class="group relative
                        flex items-center gap-3
                        px-5 py-4
                        transition-all duration-300

                        {{ request()->routeIs('videos.*')
                                ? 'bg-emerald-50 text-emerald-700'
                                : 'text-slate-700 hover:bg-gradient-to-r hover:from-emerald-50 hover:to-teal-50 hover:text-emerald-700' }}"
                    >
                    <div
                        class="w-10 h-10 rounded-xl
                            bg-gradient-to-br
                            from-emerald-500
                            to-teal-600
                            text-white
                            flex items-center justify-center"
                    >
                         <i class="ti ti-video"></i>
                    </div>
                    
                        <span>Video</span>
                         {{-- Bottom Line --}}  
                            <span
                                class="absolute bottom-0 left-0
                                    h-[2px]
                                    bg-gradient-to-r
                                    from-emerald-500
                                    to-teal-500
                                    transition-all duration-300

                                    {{ request()->routeIs('videos.*')
                                            ? 'w-full'
                                            : 'w-0 group-hover:w-full' }}">
                            </span>
                    </a>

                    {{-- KATEGORI --}}
                  <div
                        x-data="{ openCategory:false }"
                        class="border-t border-slate-100"
                    >

                        <button
                            @click="openCategory = !openCategory"
                            class="w-full
                                flex items-center justify-between
                                px-5 py-4
                                text-slate-700
                                font-semibold
                                hover:bg-gradient-to-r
                                hover:from-emerald-50
                                hover:to-teal-50
                                transition"
                        >

                            <div class="flex items-center gap-3">

                                <div
                                    class="w-10 h-10 rounded-xl
                                        bg-gradient-to-br
                                        from-emerald-500
                                        to-teal-600
                                        text-white
                                        flex items-center justify-center"
                                >
                                    <i class="ti ti-category"></i>
                                </div>

                                <span>Kategori</span>
                                <span
                                    class="px-2 py-1 rounded-xl
                                        text-sm"
                                >
                                    {{ $navCategories->count() }}
                                </span>

                            </div>

                            <i
                                class="ti ti-chevron-down transition duration-300"
                                :class="openCategory ? 'rotate-180' : ''"
                            ></i>

                        </button>

                      <div
                        x-show="openCategory"
                        x-collapse
                        class="px-5 pb-5"
                    >

                        <div
                            class="mobile-category-scroll
                                max-h-[220px]
                                overflow-y-auto
                                pr-2
                                space-y-2"
                        >

                            @foreach($navCategories as $category)

                                <a
                                    href="{{ route('category.show', $category->slug) }}"
                                    class="group
                                        flex items-center gap-3
                                        p-3 rounded-xl
                                        hover:bg-gradient-to-r
                                        hover:from-emerald-50
                                        hover:to-teal-50
                                        transition"
                                >

                                    <div
                                        class="w-9 h-9 
                                            bg-white/10
                                            
                                            flex items-center justify-center"
                                    >
                                        <i class="ti ti-{{ $category->icon ?: 'bulb' }}"></i>
                                    </div>

                                    <span
                                        class="text-sm text-slate-700
                                            group-hover:text-emerald-700"
                                    >
                                        {{ $category->name }}
                                    </span>

                                </a>

                            @endforeach

                        </div>

                    </div>

                    </div>

                    {{-- CTA --}}
                    <div class="p-5 pt-0">

                        <a
                            href="{{ route('articles.index') }}"
                            class="w-full flex items-center justify-center
                                px-5 py-3 rounded-xl
                                bg-gradient-to-r
                                from-emerald-500
                                to-teal-500
                                text-white font-semibold"
                        >
                            Jelajahi Artikel
                        </a>

                    </div>

                </div>

            </div>

    </div>
</nav>