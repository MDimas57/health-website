<div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-7">

    @forelse($posters as $poster)

        <article
            class="group
                   bg-white
                   rounded-3xl
                   overflow-hidden
                   border border-slate-200
                   shadow-sm
                   hover:shadow-xl
                   transition-all
                   duration-300">

            <a
                href="{{ route('posters.show',$poster->slug) }}"
                class="relative block overflow-hidden">

                {{-- Poster --}}
                <img
                    src="{{ Storage::url($poster->poster_file) }}"
                    alt="{{ $poster->title }}"
                    class="w-full
                           aspect-[3/4]
                           object-cover
                           group-hover:scale-105
                           transition
                           duration-700">

                {{-- Overlay --}}
                <div
                    class="absolute inset-0
                           bg-gradient-to-t
                           from-black/70
                           via-black/10
                           to-transparent
                           opacity-0
                           group-hover:opacity-100
                           transition">

                </div>

                {{-- Badge --}}
                <div
                    class="absolute
                           top-4
                           left-4">

                    <span
                        class="px-3 py-1.5
                               rounded-full
                               bg-white/90
                               backdrop-blur
                               text-xs
                               font-medium
                               text-slate-700">

                        {{ optional($poster->category)->name }}

                    </span>

                </div>

                {{-- Button --}}
                <div
                    class="absolute
                           inset-x-0
                           bottom-5
                           flex
                           justify-center
                           opacity-0
                           translate-y-3
                           group-hover:opacity-100
                           group-hover:translate-y-0
                           transition">

                    <span
                        class="px-5 py-2.5
                               rounded-full
                               bg-white
                               text-slate-900
                               text-sm
                               font-semibold
                               shadow">

                        Lihat Poster

                    </span>

                </div>

            </a>

            {{-- Footer --}}
            <div class="p-5">

                <h3
                    class="font-bold
                           text-slate-900
                           leading-snug
                           line-clamp-2">

                    {{ $poster->title }}

                </h3>

                <div
                    class="mt-4
                           flex
                           items-center
                           justify-between
                           text-sm
                           text-slate-500">

                    {{-- Date --}}
                    <div class="flex items-center gap-2">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="w-4 h-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>

                        </svg>

                        {{ $poster->published_at?->format('d M Y') }}

                    </div>

                    {{-- Views --}}
                    <div class="flex items-center gap-2">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="w-4 h-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 0s-3 6-9 6-9-6-9-6 3-6 9-6 9 6 9 6z"/>

                        </svg>

                        {{ number_format($poster->views ?? 0) }}

                    </div>

                </div>

            </div>

        </article>

    @empty

        <div class="col-span-full py-20 text-center">

            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-16 h-16 mx-auto text-slate-300"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor">

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 16l4-4a2 2 0 012.828 0L16 17m-2-2l1-1a2 2 0 012.828 0L20 16M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>

            </svg>

            <h3
                class="mt-5
                       text-xl
                       font-semibold
                       text-slate-700">

                Belum ada poster

            </h3>

            <p class="mt-2 text-slate-500">

                Poster edukasi akan tampil di sini.

            </p>

        </div>

    @endforelse

</div>