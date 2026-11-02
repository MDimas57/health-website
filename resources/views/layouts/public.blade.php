<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>@yield('title', 'PortalSehat')</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<style>
[x-cloak]{
    display:none !important;
}

.scrollbar-hide::-webkit-scrollbar {
    display: none;
}

.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
    body {
        font-family: 'Inter', sans-serif;
    }
@keyframes wobble {
    0%, 90%, 100% { transform: rotate(0deg); }
    92% { transform: rotate(-8deg); }
    94% { transform: rotate(7deg); }
    96% { transform: rotate(-5deg); }
    98% { transform: rotate(3deg); }
}
/* Pastikan seluruh teks di dalam konten artikel bisa turun ke bawah secara otomatis */
.article-content p, 
.article-content span, 
.article-content li, 
.article-content td, 
.article-content th {
    overflow-wrap: break-word;
    word-break: break-word;
}
</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js"></script>

@stack('scripts')
@unless(Route::is('consultation'))
<a href="{{ route('consultation') }}"
   class="fixed bottom-6 right-6 z-50 group pointer-events-auto"
   aria-label="Konsultasi Kesehatan">

    {{-- Efek Lingkaran Memancar (Ping/Ripple) - Diaktifkan kembali jika ingin efek memancar --}}
    {{-- Tooltip Kecil Mobile (Bisa dihapus jika teks di tombol sudah muncul, atau biarkan sebagai dekorasi) --}}
    <span class="absolute bottom-full right-1/2 translate-x-1/2 lg:translate-x-0 lg:right-0 mb-3 
                 scale-0 group-hover:scale-100 md:group-hover:scale-0
                 bg-zinc-900 text-white text-xs font-medium px-3 py-1.5 rounded-xl shadow-xl 
                 transition-all duration-300 whitespace-nowrap backdrop-blur-sm bg-opacity-90">
        Konsultasi Yuk!
        <span class="absolute top-full right-1/2 translate-x-1/2 w-2 h-2 bg-zinc-900 rotate-45"></span>
    </span>

    {{-- Tombol Utama --}}
    <div
        class="flex items-center justify-center gap-2
               bg-gradient-to-r from-red-600 to-red-500
               hover:from-red-700 hover:to-red-600
               text-white
               border-2 border-white
               /* Menyesuaikan padding agar pas di mobile & desktop */
               px-4 py-2.5 md:px-5 md:py-3.5
               rounded-full
               shadow-[0_8px_30px_rgb(239,68,68,0.4)]
               hover:shadow-[0_8px_35px_rgb(239,68,68,0.6)]
               transition-all duration-300 ease-out
               hover:scale-110 active:scale-95
               animate-[wobble_3s_ease-in-out_infinite]">

        {{-- Icon Stetoskop / Chat Kesehatan --}}
        <i class="ti ti-messages text-xl md:text-2xl transition-transform duration-500 group-hover:rotate-[360deg]"></i>

        {{-- Teks Deskripsi (Sekarang Aktif di Mobile dan Desktop) --}}
        <span class="font-bold text-xs md:text-sm tracking-wide">
            {{-- Menggunakan utility span untuk membedakan teks di mobile & desktop --}}
            <span class="inline md:hidden">Konsultasi Yuk!</span>
            <span class="hidden md:inline">Konsultasi di sini!</span>
        </span>

    </div>
</a>
@endunless
<body class="bg-white text-slate-800">
  @include('partials.navbar')

  <main>
    @yield('content')
  </main>

  @include('partials.footer')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
 <script>
        document.addEventListener('alpine:init', () => {

            Alpine.data('counter', (target) => ({
                count: 0,

                start() {

                    let current = 0;

                    let increment = target / 40;

                    let timer = setInterval(() => {

                        current += increment;

                        if(current >= target){

                            this.count = target;

                            clearInterval(timer);

                        }else{

                            this.count = Math.floor(current);

                        }

                    },25);

                }

            }));

        });
    
</script>
</body>
<style>

</style>

</html>