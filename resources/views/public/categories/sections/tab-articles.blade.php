<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 md:gap-8">

    @forelse($articles as $article)

        <article
            class="group
                   bg-white
                   rounded-[24px] md:rounded-[32px]
                   overflow-hidden
                   border border-slate-100
                   shadow-sm hover:shadow-xl hover:border-blue-100/60
                   transition-all
                   duration-300
                   flex flex-col">

            {{-- Thumbnail --}}
            <a
                href="{{ route('articles.show', $article->slug) }}"
                class="block relative overflow-hidden aspect-[16/10] sm:h-52 md:h-60 w-full bg-slate-100">

                <img
                    src="{{ $article->thumbnail ? Storage::url($article->thumbnail) : asset('images/default.jpg') }}"
                    alt="{{ $article->title }}"
                    class="w-full
                           h-full
                           object-cover
                           group-hover:scale-105
                           transition
                           duration-700">

                {{-- Overlay Gradient --}}
                <div
                    class="absolute
                           inset-0
                           bg-gradient-to-t
                           from-slate-950/40
                           via-transparent
                           to-transparent">
                </div>

                {{-- Category Badge (Diubah Menyesuaikan Palet Biru) --}}
                <div
                    class="absolute
                           top-4
                           left-4">

                    <span
                        class="px-3 py-1
                               rounded-full
                               bg-blue-50/90
                               backdrop-blur-md
                               text-[11px] sm:text-xs
                               font-semibold
                               text-blue-700
                               border border-blue-100/50">

                        {{ optional($article->category)->name }}

                    </span>

                </div>

            </a>

            {{-- Body --}}
            <div class="p-5 sm:p-6 flex-1 flex flex-col">

                {{-- Date --}}
                <div
                    class="flex
                           items-center
                           gap-2
                           text-xs sm:text-sm
                           text-slate-400
                           mb-3">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4 text-slate-400/80"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>

                    {{ $article->published_at?->format('d M Y') }}

                </div>

                {{-- Title (Hover berganti ke Biru Palet) --}}
                <a
                    href="{{ route('articles.show', $article->slug) }}"
                    class="block group/title">

                    <h3
                        class="text-lg sm:text-xl
                               font-bold
                               text-slate-900
                               leading-snug
                               line-clamp-2
                               group-hover/title:text-blue-600
                               group-hover:text-blue-600
                               transition duration-200">

                        {{ $article->title }}

                    </h3>

                </a>

                {{-- Description --}}
                <p
                    class="mt-3
                           text-slate-600
                           text-xs sm:text-sm
                           leading-relaxed
                           line-clamp-3
                           flex-1">

                    {{ Str::limit(strip_tags(html_entity_decode($article->content)), 110) }}

                </p>

                {{-- Footer --}}
                <div
                    class="mt-5
                           pt-4
                           border-t
                           border-slate-100
                           flex
                           items-center
                           justify-between">

                    <span
                        class="text-xs sm:text-sm
                               font-medium
                               text-slate-500 truncate max-w-[65%]">

                        {{ $article->user->name ?? 'Administrator' }}

                    </span>

                    {{-- Tombol Aksi Kanan Bawah --}}
                    <a
                        href="{{ route('articles.show', $article->slug) }}"
                        class="inline-flex
                               items-center
                               gap-1.5
                               text-xs sm:text-sm
                               font-semibold
                               text-blue-600
                               hover:text-blue-700
                               transition">

                        Baca

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="w-3.5 h-3.5 transform group-hover:translate-x-0.5 transition-transform"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2.5"
                                d="M9 5l7 7-7 7"/>
                        </svg>

                    </a>

                </div>

            </div>

        </article>

    @empty

        {{-- State Kosong Berwarna Netral & Terpusat --}}
        <div
            class="col-span-full
                   py-16 md:py-24
                   text-center">

            <div class="inline-flex p-4 rounded-full bg-slate-50 border border-slate-100 mb-4">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-10 h-10 md:w-12 md:h-12 mx-auto text-slate-300"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.5"
                        d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z"/>
                </svg>
            </div>

            <h3
                class="text-lg md:text-xl
                       font-bold
                       text-slate-800">
                Belum ada artikel
            </h3>

            <p
                class="mt-1.5
                       text-xs md:text-sm
                       text-slate-500 max-w-sm mx-auto">
                Artikel pada kategori ini akan segera diperbarui dalam waktu dekat.
            </p>

        </div>

    @endforelse

</div>