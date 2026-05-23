<a
    href="{{ route('post.show', $poster->slug) }}"
    class="group block bg-white rounded-3xl
           overflow-hidden border border-slate-200
           shadow-sm hover:shadow-2xl
           hover:-translate-y-2 transition duration-300"
>

    @if($poster->poster_file)

        <div class="overflow-hidden bg-slate-100">

            <img
                src="{{ asset('storage/' . $poster->poster_file) }}"
                alt="{{ $poster->title }}"
                class="w-full h-[500px] object-cover
                       group-hover:scale-105 transition duration-500"
            >

        </div>

    @endif

    <div class="p-5">

        <span class="inline-flex items-center
                     bg-pink-100 text-pink-700
                     text-xs font-semibold
                     px-3 py-1 rounded-full mb-3">

            Poster

        </span>

        <h3 class="font-bold text-slate-800
                   leading-relaxed mb-3
                   group-hover:text-emerald-600 transition">

            {{ $poster->title }}

        </h3>

    </div>

</a>