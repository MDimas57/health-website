<div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-8">

    @forelse($articles as $article)

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

            {{-- Thumbnail --}}
            <a
                href="{{ route('articles.show',$article->slug) }}"
                class="block relative overflow-hidden">

                <img
                    src="{{ $article->thumbnail
                        ? Storage::url($article->thumbnail)
                        : asset('images/default.jpg') }}"
                    class="w-full
                           h-60
                           object-cover
                           group-hover:scale-105
                           transition
                           duration-700">

                {{-- Overlay --}}
                <div
                    class="absolute
                           inset-0
                           bg-gradient-to-t
                           from-black/60
                           via-transparent
                           to-transparent">
                </div>

                {{-- Category --}}
                <div
                    class="absolute
                           top-5
                           left-5">

                    <span
                        class="px-3 py-1.5
                               rounded-full
                               bg-white/90
                               backdrop-blur
                               text-xs
                               font-medium
                               text-slate-700">

                        {{ optional($article->category)->name }}

                    </span>

                </div>

            </a>

            {{-- Body --}}
            <div class="p-6">

                {{-- Date --}}
                <div
                    class="flex
                           items-center
                           gap-2
                           text-sm
                           text-slate-400
                           mb-4">

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

                    {{ $article->published_at?->format('d M Y') }}

                </div>

                {{-- Title --}}
                <a
                    href="{{ route('articles.show',$article->slug) }}">

                    <h3
                        class="text-xl
                               font-bold
                               text-slate-900
                               leading-snug
                               line-clamp-2
                               group-hover:text-emerald-600
                               transition">

                        {{ $article->title }}

                    </h3>

                </a>

                {{-- Description --}}
                <p
                    class="mt-4
                           text-slate-600
                           leading-7
                           line-clamp-3">

                    {{ Str::limit(strip_tags(html_entity_decode($article->content)),130) }}

                </p>

                {{-- Footer --}}
                <div
                    class="mt-6
                           pt-5
                           border-t
                           border-slate-100
                           flex
                           items-center
                           justify-between">

                    <span
                        class="text-sm
                               text-slate-500">

                        {{ $article->user->name ?? 'Administrator' }}

                    </span>

                    <a
                        href="{{ route('articles.show',$article->slug) }}"
                        class="inline-flex
                               items-center
                               gap-2
                               text-sm
                               font-semibold
                               text-emerald-600
                               hover:text-emerald-700">

                        Baca

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
                                d="M9 5l7 7-7 7"/>

                        </svg>

                    </a>

                </div>

            </div>

        </article>

    @empty

        <div
            class="col-span-full
                   py-20
                   text-center">

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
                    d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z"/>

            </svg>

            <h3
                class="mt-6
                       text-xl
                       font-semibold
                       text-slate-700">

                Belum ada artikel

            </h3>

            <p
                class="mt-2
                       text-slate-500">

                Artikel pada kategori ini akan muncul di sini.

            </p>

        </div>

    @endforelse

</div>