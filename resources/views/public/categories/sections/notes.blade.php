@if($notes->count())

<section class="py-20 bg-white overflow-hidden">

    <div class="max-w-7xl mx-auto px-6">

        <div class="relative overflow-hidden">

            {{-- Fade kiri --}}
            <div
                class="absolute inset-y-0 left-0 w-20
                       bg-gradient-to-r
                       from-white
                       to-transparent
                       z-20">
            </div>

            {{-- Fade kanan --}}
            <div
                class="absolute inset-y-0 right-0 w-20
                       bg-gradient-to-l
                       from-white
                       to-transparent
                       z-20">
            </div>

            <div class="marquee">

                <div class="marquee-content">

                    @php
                        $cardColors = [
                            'background:#FFF9C4;border-color:#FDE68A;',
                            'background:#DDFCE8;border-color:#BBF7D0;',
                            'background:#E0F2FE;border-color:#BAE6FD;',
                            'background:#FCE7F3;border-color:#F9A8D4;',
                            'background:#F3E8FF;border-color:#D8B4FE;',
                            'background:#FFE4D6;border-color:#FDBA74;',
                        ];
                    @endphp

                    @foreach($notes->concat($notes) as $index => $note)

                    <article
                        style="{{ $cardColors[$index % count($cardColors)] }}"
                        class="relative
                               w-60
                               h-[280px]
                               flex-shrink-0
                               rounded-2xl
                               border
                               shadow-sm
                               p-5
                               flex flex-col">

                        {{-- Quote --}}
                        <div
                            class="absolute
                                   top-2
                                   right-4
                                   text-5xl
                                   font-serif
                                   text-black/10
                                   select-none">

                            “

                        </div>

                        {{-- Title --}}
                        <h3
                            class="font-semibold
                                   text-[15px]
                                   leading-snug
                                   text-slate-900">

                            {{ $note->title }}

                        </h3>

                        {{-- Content --}}
                        <div
                            class="flex-1
                                   flex
                                   items-center
                                   justify-center
                                   py-3">

                            <p
                                class="italic
                                       text-sm
                                       leading-6
                                       text-slate-700
                                       text-center
                                       line-clamp-6">

                                {{ Str::limit(html_entity_decode(strip_tags($note->content)),130) }}

                            </p>

                        </div>

                        {{-- Footer --}}
                        <div
                            class="pt-3
                                   border-t
                                   border-black/10
                                   flex
                                   items-center
                                   justify-between">

                            <span
                                class="text-xs
                                       text-slate-600
                                       font-medium">

                                — {{ $note->user->name }}

                            </span>

                            <span class="text-sm opacity-60">
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

<style>
.marquee{
    overflow:hidden;
    position:relative;
}

.marquee-content{
    display:flex;
    gap:1rem;
    width:max-content;
    animation:scrollNotes 35s linear infinite;
}

.marquee:hover .marquee-content{
    animation-play-state:paused;
}

@keyframes scrollNotes{

    from{
        transform:translateX(0);
    }

    to{
        transform:translateX(calc(-50% - .5rem));
    }

}

@media(max-width:1024px){

    .marquee-content{
        animation-duration:28s;
    }

}

@media(max-width:768px){

    .marquee-content article{
        width:210px;
        height:250px;
    }

    .marquee-content{
        animation-duration:22s;
    }

}
</style>

@endif