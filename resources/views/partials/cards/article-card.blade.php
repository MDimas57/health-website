<section class="mb-20 bg-slate-50 w-full">

    {{-- CONTAINER --}}
    <div class="max-w-[1200px] mx-auto px-4 lg:px-8 py-16">

        {{-- HEADER --}}
        <div class="flex items-center justify-between mb-8">

            <div>

                <h2 class="text-3xl font-bold text-slate-800">
                    Artikel Terbaru
                </h2>

                <p class="text-slate-500 mt-2">
                    Temukan informasi dan wawasan kesehatan terbaru untuk hidup lebih sehat.
                </p>

            </div>

            <a href="#"
               class="text-sky-700 font-medium hover:underline">

                Lihat Semua →

            </a>

        </div>

        {{-- LAYOUT ARTIKEL --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- ARTIKEL UTAMA --}}
            <div class="lg:col-span-2">

                @php
                    $mainPost = $posts->first();
                @endphp

                @if($mainPost)

                    <a href="{{ route('post.show', $mainPost->slug) }}"
                       class="block bg-white rounded-3xl overflow-hidden
                              shadow-sm hover:shadow-xl transition group">

                        @if($mainPost->thumbnail)

                            <img src="{{ asset('storage/' . $mainPost->thumbnail) }}"
                                 class="w-full h-[350px] object-cover
                                        group-hover:scale-105 transition duration-300">

                        @endif

                        <div class="p-6">

                            <span class="inline-flex px-3 py-1 rounded-full
                                         text-xs bg-sky-100 text-sky-700 mb-4">

                                Artikel

                            </span>

                            <h3 class="text-2xl font-bold text-slate-800
                                       leading-snug mb-4">

                                {{ $mainPost->title }}

                            </h3>

                            <p class="text-slate-500 leading-relaxed">

                                {{ \Illuminate\Support\Str::limit(strip_tags($mainPost->content), 180) }}

                            </p>

                            <div class="mt-6 text-sm text-slate-400">

                                {{ $mainPost->created_at->format('d M Y') }}

                            </div>

                        </div>

                    </a>

                @endif

            </div>

            {{-- SIDEBAR --}}
            <div class="space-y-5">

                @foreach($posts->skip(1)->take(3) as $post)

                    <a href="{{ route('post.show', $post->slug) }}"
                       class="flex gap-4 bg-white rounded-2xl p-4
                              shadow-sm hover:shadow-lg transition group">

                        @if($post->thumbnail)

                            <img src="{{ asset('storage/' . $post->thumbnail) }}"
                                 class="w-28 h-28 object-cover rounded-xl
                                        group-hover:scale-105 transition">

                        @endif

                        <div class="flex-1">

                            <span class="text-xs text-slate-400 uppercase tracking-wide">
                                Artikel
                            </span>

                            <h3 class="font-semibold text-slate-800 mt-2 leading-snug">

                                {{ \Illuminate\Support\Str::limit($post->title, 60) }}

                            </h3>

                            <p class="text-sm text-slate-500 mt-2">

                                {{ \Illuminate\Support\Str::limit(strip_tags($post->content), 70) }}

                            </p>

                            <div class="mt-3 text-xs text-slate-400">

                                {{ $post->created_at->format('d M Y') }}

                            </div>

                        </div>

                    </a>

                @endforeach

            </div>

        </div>

    </div>

</section>