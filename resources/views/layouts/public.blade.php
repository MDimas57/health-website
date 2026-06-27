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
</style>
 @stack('scripts')

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