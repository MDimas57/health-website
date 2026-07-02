<section
    x-data="{
        active: 0,
        total: {{ $banners->count() }},
        start() {
            if (this.total <= 1) return;

            setInterval(() => {
                this.active = (this.active + 1) % this.total;
            }, 5000);
        }
    }"
    x-init="start()"
    class="relative overflow-hidden
           h-[430px]
           sm:h-[520px]
           lg:h-[620px]">

    @foreach($banners as $index => $banner)

    <div
        x-show="active === {{ $index }}"
        x-transition.opacity.duration.700ms
        class="absolute inset-0">

        {{-- Background --}}
        <img
            src="{{ Storage::url($banner->image) }}"
            alt="{{ $banner->title }}"
            class="absolute inset-0 w-full h-full object-cover">

        {{-- Overlay --}}
        <div
            class="absolute inset-0
                   bg-gradient-to-r
                   from-black/70
                   via-black/45
                   to-black/5">
        </div>

        {{-- Content --}}
        <div class="relative z-20 h-full flex items-center">

            <div class="max-w-7xl mx-auto w-full px-5 sm:px-8 lg:px-10">

                <div class="max-w-xl lg:max-w-2xl">

                    {{-- Badge --}}
                    <span
                        class="inline-flex items-center
                               px-4 py-2
                               sm:px-5 sm:py-2.5
                               rounded-full
                               bg-white/10
                               backdrop-blur-md
                               border border-white/20
                               text-white
                               text-xs sm:text-sm
                               font-medium">

                        Selamat Datang di PortalSehat

                    </span>

                    {{-- Title --}}
                    <h1
                        class="mt-5
                               text-3xl
                               sm:text-4xl
                               lg:text-5xl
                               xl:text-6xl
                               font-bold
                               leading-tight
                               text-white">

                        {{ $banner->title }}

                    </h1>

                    {{-- Subtitle --}}
                    @if($banner->subtitle)

                        <p
                            class="mt-4
                                   text-sm
                                   sm:text-base
                                   lg:text-lg
                                   text-white/90
                                   leading-relaxed
                                   max-w-lg">

                            {{ $banner->subtitle }}

                        </p>

                    @endif

                    {{-- Button --}}
                    @if($banner->button_text)

                    <div class="mt-8">

                        <a
                            href="{{ $banner->button_link }}"
                            class="inline-flex
                                   w-full
                                   sm:w-auto
                                   justify-center
                                   items-center
                                   gap-2
                                   px-6
                                   py-3.5
                                   rounded-xl
                                   bg-gradient-to-r
                                   from-red-500
                                   to-rose-600
                                   text-white
                                   font-semibold
                                   shadow-lg
                                   hover:scale-105
                                   transition">

                            {{ $banner->button_text }}

                            <svg
                                class="w-5 h-5"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24">

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M9 5l7 7-7 7"/>

                            </svg>

                        </a>

                    </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

    @endforeach

</section>