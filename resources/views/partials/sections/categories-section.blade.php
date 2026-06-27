{{-- OWL CAROUSEL CSS --}}
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"/>

<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"/>


<section class="pb-8 w-full">

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-6">

        <h2 class="text-2xl font-bold text-slate-800">
            Kategori Unggulan
        </h2>

    </div>

    {{-- WRAPPER --}}
    <div class="relative">

        {{-- FADE LEFT --}}
        <div class="absolute left-0 top-0 bottom-0 w-4
                    bg-gradient-to-r from-white to-transparent
                    z-10 pointer-events-none">
        </div>

        {{-- FADE RIGHT --}}
        <div class="absolute right-0 top-0 bottom-0 w-4
                    bg-gradient-to-l from-white to-transparent
                    z-10 pointer-events-none">
        </div>

        {{-- OWL CAROUSEL --}}
        <div class="owl-carousel category-carousel">

            @foreach($categories as $category)

                <a
                    href="{{ route('category.show', $category->slug) }}"
                    class="
                        relative overflow-hidden
                        h-[180px]
                        rounded-[24px]
                        group transition duration-500
                        hover:-translate-y-1
                        hover:shadow-2xl
                        block
                    "
                >

                    {{-- BACKGROUND IMAGE --}}
                    <div class="absolute inset-0">

                        <img
                            src="{{ asset('storage/' . $category->image) }}"
                            alt="{{ $category->name }}"
                            class="w-full h-full object-cover
                                   group-hover:scale-105
                                   transition duration-700"
                        >

                    </div>

                    {{-- FULL OVERLAY --}}
                    <div class="absolute inset-0
                                bg-black/45
                                group-hover:bg-black/55
                                transition duration-500">
                    </div>

                    {{-- CONTENT --}}
                    <div class="absolute inset-0 z-10
                                flex items-center justify-center
                                p-4 text-center">

                        <h3 class="text-white font-bold
                                   text-lg leading-snug
                                   drop-shadow-lg">

                            {{ $category->name }}

                        </h3>

                    </div>

                </a>

            @endforeach

        </div>

    </div>

</section>

<style>
.owl-carousel .owl-stage {
    display: flex;
}

.owl-carousel .owl-item {
    display: flex;
    height: auto;
}

.owl-carousel .owl-item a {
    width: 100%;
}

.owl-nav {
    display: none;
}

.owl-dots {
    margin-top: 20px;
    text-align: center;
}

.owl-dots .owl-dot span {
    width: 10px;
    height: 10px;
    margin: 5px;
    display: block;
    border-radius: 999px;
    background: #cbd5e1;
    transition: .3s;
}

.owl-dots .owl-dot.active span {
    width: 28px;
    background: #0f172a;
}
</style>


{{-- JQUERY --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

{{-- OWL JS --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<script>
    $(document).ready(function () {

        $('.category-carousel').owlCarousel({
            loop: true,
            margin: 16,
            nav: false,
            dots: true,
            autoplay: true,
            autoplayTimeout: 3500,
            autoplayHoverPause: true,
            smartSpeed: 700,

            responsive: {
                0: {
                    items: 1.2
                },
                640: {
                    items: 2
                },
                1024: {
                    items: 5
                }
            }
        });

    });
</script>