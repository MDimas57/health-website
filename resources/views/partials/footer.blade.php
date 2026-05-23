
<footer class="bg-[#0a3d2e] text-white mt-20">

    {{-- Wave --}}
    <div class="overflow-hidden leading-none">
        <svg viewBox="0 0 1440 60"
             preserveAspectRatio="none"
             xmlns="http://www.w3.org/2000/svg"
             class="w-full h-[60px]">

            <path
                d="M0,30 C240,60 480,0 720,30 C960,60 1200,0 1440,30 L1440,60 L0,60 Z"
                fill="#064e3b"/>

        </svg>
    </div>

    {{-- Main Footer --}}
    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-14">

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-10">

            {{-- BRAND --}}
            <div>

                <a href="{{ route('home') }}"
                   class="flex items-center gap-4 mb-5">

                    <div class="w-14 h-14 rounded-2xl bg-emerald-500/20
                                flex items-center justify-center text-2xl">

                        🏥

                    </div>

                    <div>

                        <div class="text-2xl font-bold">
                            PortalSehat
                        </div>

                        <div class="text-emerald-200 text-sm">
                            Puskesmas Kotabumi
                        </div>

                    </div>

                </a>

                <p class="text-emerald-100 leading-relaxed text-sm">

                    Portal informasi kesehatan resmi Puskesmas Kotabumi,
                    Lampung Utara. Menyediakan edukasi kesehatan terpercaya,
                    mudah diakses, dan gratis untuk masyarakat.

                </p>

                <div class="mt-6 space-y-3 text-sm">

                    <div class="flex items-start gap-3">

                        <i class="ti ti-map-pin text-emerald-300 text-lg"></i>

                        <span>
                            Jl. Kesehatan No.1, Kotabumi, Lampung Utara
                        </span>

                    </div>

                    <div class="flex items-center gap-3">

                        <i class="ti ti-phone text-emerald-300 text-lg"></i>

                        <span>(0724) 21XXX</span>

                    </div>

                    <div class="flex items-center gap-3">

                        <i class="ti ti-clock text-emerald-300 text-lg"></i>

                        <span>Senin – Jumat, 08.00 – 15.00 WIB</span>

                    </div>

                    <div class="flex items-center gap-3">

                        <i class="ti ti-mail text-emerald-300 text-lg"></i>

                        <span>puskesmas@kotabumi.go.id</span>

                    </div>

                </div>

            </div>

            {{-- KATEGORI --}}
            <div>

                <h3 class="text-lg font-semibold mb-5">
                    Tema Kesehatan
                </h3>

                <ul class="space-y-3">

                    @foreach($navCategories as $category)

                        <li>

                            <a href="{{ route('category.show', $category->slug) }}"
                               class="flex items-center gap-3 text-emerald-100
                                      hover:text-white transition">

                                <span class="w-3 h-3 rounded-full"
                                      style="background: {{ $category->color }}"></span>

                                {{ $category->name }}

                            </a>

                        </li>

                    @endforeach

                </ul>

            </div>

            {{-- JENIS KONTEN --}}
            <div>

                <h3 class="text-lg font-semibold mb-5">
                    Jenis Konten
                </h3>

                <ul class="space-y-3">

                    <li>

                        <a href="{{ route('articles.index') }}"
                           class="flex items-center gap-3 text-emerald-100 hover:text-white transition">

                            <i class="ti ti-file-text"></i>

                            Artikel

                        </a>

                    </li>

                    <li>

                        <a href="{{ route('posters.index') }}"
                           class="flex items-center gap-3 text-emerald-100 hover:text-white transition">

                            <i class="ti ti-photo"></i>

                            Poster

                        </a>

                    </li>

                    <li>

                        <a href="{{ route('videos.index') }}"
                           class="flex items-center gap-3 text-emerald-100 hover:text-white transition">

                            <i class="ti ti-brand-youtube"></i>

                            Video

                        </a>

                    </li>

                </ul>

                {{-- TAUTAN --}}
                <h3 class="text-lg font-semibold mt-10 mb-5">
                    Tautan
                </h3>

                <ul class="space-y-3">

                    <li>

                        <a href="{{ route('home') }}"
                           class="flex items-center gap-3 text-emerald-100 hover:text-white transition">

                            <i class="ti ti-home"></i>

                            Beranda

                        </a>

                    </li>

                    <li>

                        <a href="{{ route('search') }}"
                           class="flex items-center gap-3 text-emerald-100 hover:text-white transition">

                            <i class="ti ti-search"></i>

                            Pencarian

                        </a>

                    </li>

                    <li>

                        <a href="{{ route('filament.admin.auth.login') }}"
                           class="flex items-center gap-3 text-emerald-100 hover:text-white transition">

                            <i class="ti ti-login"></i>

                            Login Admin

                        </a>

                    </li>

                </ul>

            </div>

            {{-- KONTEN TERBARU --}}
            <div>

                <h3 class="text-lg font-semibold mb-5">
                    Konten Terbaru
                </h3>

                <div class="space-y-4">

                    @forelse($footerRecentPosts as $recent)

                        @php
                            $detailRoute = '#';

                            if ($recent instanceof \App\Models\Article) {
                                $detailRoute = route('articles.show', $recent->slug);
                            } elseif ($recent instanceof \App\Models\Poster) {
                                $detailRoute = route('posters.show', $recent->slug);
                            } elseif ($recent instanceof \App\Models\Video) {
                                $detailRoute = route('videos.show', $recent->slug);
                            }
                        @endphp

                        <a href="{{ $detailRoute }}"
                           class="flex gap-4 group">

                            {{-- THUMBNAIL --}}
                            <div class="w-24 h-20 rounded-xl overflow-hidden
                                        bg-white/10 flex-shrink-0">

                                @if($recent->thumbnail)

                                    <img
                                        src="{{ Storage::url($recent->thumbnail) }}"
                                        alt="{{ $recent->title }}"
                                        class="w-full h-full object-cover
                                               group-hover:scale-105
                                               transition duration-300">

                                @elseif(isset($recent->poster_file))

                                    <img
                                        src="{{ Storage::url($recent->poster_file) }}"
                                        alt="{{ $recent->title }}"
                                        class="w-full h-full object-cover
                                               group-hover:scale-105
                                               transition duration-300">

                                @else

                                    <div class="w-full h-full
                                                flex items-center justify-center
                                                text-2xl text-emerald-200">

                                        <i class="ti ti-file-text"></i>

                                    </div>

                                @endif

                            </div>

                            {{-- INFO --}}
                            <div class="flex-1">

                                <span class="inline-block text-xs
                                             px-2 py-1 rounded-full mb-2"
                                      style="
                                        background: {{ $recent->category->color ?? '#22c55e' }}22;
                                        color: {{ $recent->category->color ?? '#86efac' }};
                                      ">

                                    {{ $recent->category->name ?? '-' }}

                                </span>

                                <p class="text-sm leading-relaxed text-emerald-50
                                          group-hover:text-white transition">

                                    {{ Str::limit($recent->title, 50) }}

                                </p>

                                <div class="mt-2 text-xs text-emerald-300
                                            flex items-center gap-2">

                                    <i class="ti ti-calendar"></i>

                                    {{ $recent->published_at?->translatedFormat('d M Y') ?? '-' }}

                                </div>

                            </div>

                        </a>

                    @empty

                        <div class="text-emerald-200 text-sm">
                            Belum ada konten terbaru.
                        </div>

                    @endforelse

                </div>

            </div>

        </div>

    </div>

    {{-- BOTTOM --}}
    <div class="border-t border-white/10">

        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-5
                    flex flex-col md:flex-row items-center
                    justify-between gap-4 text-sm">

            <p class="text-emerald-200">

                © {{ date('Y') }} Puskesmas Kotabumi — Lampung Utara.
                Hak cipta dilindungi.

            </p>

            <div class="flex items-center gap-2 text-emerald-200">

                Dibuat dengan

                <i class="ti ti-heart-filled text-pink-400"></i>

                oleh Tim Puskesmas Kotabumi

            </div>

        </div>

    </div>

</footer>
