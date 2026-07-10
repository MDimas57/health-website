<div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6 md:gap-7">

    @forelse($posters as $poster)

        <article
            class="group
                   bg-white
                   rounded-[20px] sm:rounded-[28px]
                   overflow-hidden
                   border border-slate-100
                   shadow-sm hover:shadow-xl hover:border-purple-100/60
                   transition-all
                   duration-300
                   flex flex-col">

            <a
                href="{{ route('posters.show', $poster->slug) }}"
                class="relative block overflow-hidden aspect-[3/4] w-full bg-slate-50">

                {{-- Poster Image --}}
                <img
                    src="{{ Storage::url($poster->poster_file) }}"
                    alt="{{ $poster->title }}"
                    class="w-full
                           h-full
                           object-cover
                           group-hover:scale-105
                           transition
                           duration-700">

                {{-- Overlay Smooth Gradient (Dioptimalkan agar teks mobile tetap terbaca) --}}
                <div
                    class="absolute inset-0
                           bg-gradient-to-t
                           from-slate-950/80 via-slate-950/20 to-transparent
                           opacity-40 sm:opacity-0
                           group-hover:opacity-100
                           transition duration-300">
                </div>

                {{-- Badge Kategori Berwarna Ungu Pas --}}
                <div
                    class="absolute
                           top-3 sm:top-4
                           left-3 sm:left-4">

                    <span
                        class="px-2.5 py-1
                               rounded-full
                               bg-purple-50/90
                               backdrop-blur-md
                               text-[10px] sm:text-xs
                               font-semibold
                               text-purple-700
                               border border-purple-100/50">

                        {{ optional($poster->category)->name }}

                    </span>

                </div>

                {{-- Button Aksi Tengah (Hidden di mobile, muncul saat hover di desktop) --}}
                <div
                    class="absolute
                           inset-x-0
                           bottom-4 sm:bottom-5
                           hidden sm:flex
                           justify-center
                           opacity-0
                           translate-y-3
                           group-hover:opacity-100
                           group-hover:translate-y-0
                           transition duration-300">

                    <span
                        class="px-4 py-2
                               rounded-full
                               bg-white
                               text-purple-700
                               text-xs sm:text-sm
                               font-bold
                               shadow-md transition-transform active:scale-95">
                        Lihat Poster
                    </span>

                </div>

            </a>

            {{-- Footer Info --}}
            <div class="p-3.5 sm:p-5 flex-1 flex flex-col justify-between">

                <a href="{{ route('posters.show', $poster->slug) }}" class="block">
                    <h3
                        class="font-bold
                               text-xs sm:text-sm md:text-base
                               text-slate-900
                               leading-snug
                               line-clamp-2
                               group-hover:text-purple-600
                               transition duration-200">
                        {{ $poster->title }}
                    </h3>
                </a>

                {{-- Metadata Statis Bawah --}}
                <div
                    class="mt-3
                           pt-2.5
                           border-t border-slate-100
                           flex
                           flex-col sm:flex-row
                           sm:items-center
                           justify-between
                           gap-1 sm:gap-2
                           text-[11px] sm:text-xs
                           text-slate-400">

                    {{-- Date --}}
                    <div class="flex items-center gap-1.5 truncate">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="w-3.5 h-3.5 text-slate-400/80 flex-shrink-0"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="truncate">{{ $poster->published_at?->format('d M Y') }}</span>
                    </div>

                    {{-- Views --}}
                    <div class="flex items-center gap-1.5 flex-shrink-0">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="w-3.5 h-3.5 text-slate-400/80"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 0s-3 6-9 6-9-6-9-6 3-6 9-6 9 6 9 6z"/>
                        </svg>
                        <span>{{ number_format($poster->views ?? 0) }}</span>
                    </div>

                </div>

            </div>

        </article>

    @empty

        {{-- Empty State --}}
        <div class="col-span-full py-16 text-center">
            
            <div class="inline-flex p-4 rounded-full bg-slate-50 border border-slate-100 mb-4">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-10 h-10 mx-auto text-slate-300"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.5"
                        d="M4 16l4-4a2 2 0 012.828 0L16 17m-2-2l1-1a2 2 0 012.828 0L20 16M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>

            <h3 class="text-lg font-bold text-slate-800">Belum ada poster</h3>
            <p class="mt-1 text-xs text-slate-500 max-w-xs mx-auto">
                Poster edukasi menarik pada kategori ini akan segera ditambahkan.
            </p>

        </div>

    @endforelse

</div>