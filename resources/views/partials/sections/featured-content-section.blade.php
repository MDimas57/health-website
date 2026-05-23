<section class="py-section-gap bg-surface-container-low">

<div class="max-w-[1200px] mx-auto px-margin-desktop">

    <h2 class="text-2xl font-bold mb-8">Konten Terbaru</h2>

    <div class="grid md:grid-cols-12 gap-6">

        {{-- Featured --}}
        @php $featured = $latestPosts->first(); @endphp

        <div class="md:col-span-8 bg-white rounded-xl overflow-hidden shadow">

            <img src="{{ asset('storage/' . $featured->thumbnail) }}" class="w-full h-[350px] object-cover">

            <div class="p-6">
                <h3 class="text-xl font-bold">{{ $featured->title }}</h3>
                <p class="text-gray-500 mt-2">
                    {{ \Str::limit(strip_tags($featured->content), 150) }}
                </p>
            </div>

        </div>

    </div>

</div>

</section>