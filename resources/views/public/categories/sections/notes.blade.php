@if($notes->count())

{{-- SECTION DENGAN GRADASI LATAR BELAKANG YANG LEBIH TERANG & BERWARNA --}}
<section class="py-16 md:py-24 bg-white overflow-hidden w-screen ml-[calc(50%-50vw)] relative">
    
    {{-- GRADASI DIUBAH LEBIH TERANG: Menaikkan intensitas warna dari ungu cerah ke biru muda --}}
    <!-- <div class="absolute inset-0 bg-gradient-to-t from-purple-400 via-blue-100 to-white pointer-events-none z-0"></div> -->

    {{-- AKSEN GLOW DIBUAT LEBIH TERANG: Menggunakan opasitas /20 agar pendaran warna palet lebih memancar --}}
    <div class="absolute bottom-0 left-10 w-[250px] sm:w-[400px] h-[120px] sm:h-[220px] rounded-full bg-blue-500/20 blur-[60px] sm:blur-[90px] pointer-events-none z-0"></div>
    <div class="absolute bottom-0 right-10 w-[250px] sm:w-[400px] h-[120px] sm:h-[220px] rounded-full bg-red-500/15 blur-[60px] sm:blur-[90px] pointer-events-none z-0"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

        <div class="relative overflow-hidden rounded-[32px]">

            {{-- FADE KIRI DIKECILKAN (w-6 sm:w-12): Agar kartu terlihat full dari ujung ke ujung --}}
            <div
                class="absolute inset-y-0 left-0 w-6 sm:w-12
                       bg-gradient-to-r
                       from-white via-white/40 to-transparent
                       z-20 pointer-events-none">
            </div>

            {{-- FADE KANAN DIKECILKAN (w-6 sm:w-12): Agar kartu terlihat full dari ujung ke ujung --}}
            <div
                class="absolute inset-y-0 right-0 w-6 sm:w-12
                       bg-gradient-to-l
                       from-white via-white/40 to-transparent
                       z-20 pointer-events-none">
            </div>

            {{-- Wrapper Marquee --}}
            <div class="marquee py-4">

                <div class="marquee-content">

                    @php
                        $cardColors = [
                            'background:#FFF9C4;border-color:rgba(253,230,138,0.8);',
                            'background:#DDFCE8;border-color:rgba(187,247,208,0.8);',
                            'background:#E0F2FE;border-color:rgba(186,230,253,0.8);',
                            'background:#FCE7F3;border-color:rgba(249,168,212,0.8);',
                            'background:#F3E8FF;border-color:rgba(216,180,254,0.8);',
                            'background:#FFE4D6;border-color:rgba(253,186,116,0.8);',
                        ];
                    @endphp

                    @foreach($notes->concat($notes) as $index => $note)

                    <article
                        style="{{ $cardColors[$index % count($cardColors)] }}"
                        class="relative
                               w-56 sm:w-64
                               h-[260px] sm:h-[290px]
                               flex-shrink-0
                               rounded-2xl
                               border
                               shadow-sm hover:shadow-md
                               p-5 sm:p-6
                               transition-all duration-300
                               hover:-translate-y-2
                               flex flex-col">

                        {{-- Quote Icon --}}
                        <div
                            class="absolute
                                   top-2
                                   right-4
                                   text-4xl sm:text-5xl
                                   font-serif
                                   text-slate-900/10
                                   select-none">
                            “
                        </div>

                        {{-- Title --}}
                        <h3
                            class="font-bold
                                   text-sm sm:text-[15px]
                                   leading-snug
                                   text-slate-900
                                   line-clamp-2">
                            {{ $note->title }}
                        </h3>

                        {{-- Content --}}
                        <div
                            class="flex-1
                                   flex
                                   items-center
                                   justify-center
                                   py-2">
                            <p
                                class="italic
                                       text-xs sm:text-sm
                                       leading-relaxed
                                       text-slate-700
                                       text-center
                                       line-clamp-5 sm:line-clamp-6">
                                {{ Str::limit(html_entity_decode(strip_tags($note->content)), 120) }}
                            </p>
                        </div>

                        {{-- Footer --}}
                        <div
                            class="pt-3
                                   border-t
                                   border-slate-950/10
                                   flex
                                   items-center
                                   justify-between">

                            <span
                                class="text-[11px] sm:text-xs
                                       text-slate-700
                                       font-bold truncate max-w-[80%]">
                                — {{ $note->user->name }}
                            </span>

                            @php
                                $sparkleColors = ['text-blue-500', 'text-purple-500', 'text-red-500'];
                                $currentColor = $sparkleColors[$index % count($sparkleColors)];
                            @endphp
                            <span class="text-xs {{ $currentColor }} opacity-90 animate-pulse">
                                ✦
                            </span>

                        </div>

                    </article>

                    @endforeach

                </div>

            </div>

        </div>

    </div>

</section>

{{-- Style Marquee --}}
<style>
.marquee {
    overflow: hidden;
    position: relative;
    width: 100%;
}

.marquee-content {
    display: flex;
    gap: 1.5rem;
    width: max-content;
    animation: scrollNotes 38s linear infinite;
    will-change: transform;
}

@media (hover: hover) {
    .marquee:hover .marquee-content {
        animation-play-state: paused;
    }
}

@keyframes scrollNotes {
    from { transform: translateX(0); }
    to { transform: translateX(calc(-50% - 0.75rem)); }
}

@media(max-width: 1024px) {
    .marquee-content {
        animation-duration: 32s;
    }
}

@media(max-width: 640px) {
    .marquee-content {
        gap: 1rem;
        animation-duration: 24s;
    }
    @keyframes scrollNotes {
        from { transform: translateX(0); }
        to { transform: translateX(calc(-50% - 0.5rem)); }
    }
}
</style>

@endif