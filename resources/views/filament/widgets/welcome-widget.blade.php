<x-filament-widgets::widget>

<div class="overflow-hidden rounded-3xl bg-gradient-to-r from-cyan-600 via-sky-600 to-indigo-700 shadow-xl">

    @php
        $user = auth()->user();

        $role = $user->hasRole('super_admin')
            ? 'Super Admin'
            : 'Contributor';
    @endphp

    <div class="px-10 py-8">

        <div class="flex flex-col lg:flex-row justify-between items-center">

            <div>

                <p class="text-cyan-100 text-lg">
                    👋 Selamat Datang Kembali
                </p>

                <h1 class="mt-2 text-5xl font-bold text-white">
                    {{ $user->name }}
                </h1>

                <p class="mt-3 text-cyan-100 text-lg">
                    PortalSehat Content Management System
                </p>

                <div class="mt-8 flex flex-wrap gap-3">

                    <div
                        class="rounded-full bg-white/20 px-5 py-2 text-white font-medium">

                        🛡 {{ $role }}

                    </div>

                    @if($user->hasRole('contributor'))

                        <div
                            class="rounded-full bg-white/20 px-5 py-2 text-white font-medium">

                            📁 {{ $user->category?->name }}

                        </div>

                    @endif

                    <div
                        class="rounded-full bg-white/20 px-5 py-2 text-white font-medium">

                        📅 {{ now()->translatedFormat('l, d F Y') }}

                    </div>

                </div>

            </div>

            <div class="hidden lg:flex">

                <div
                    class="flex h-40 w-40 items-center justify-center rounded-full bg-white/10">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        class="h-24 w-24 text-white">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.5"
                            d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/>

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.5"
                            d="M4.5 20.118a7.5 7.5 0 0115 0"/>

                    </svg>

                </div>

            </div>

        </div>

    </div>

</div>

</x-filament-widgets::widget>