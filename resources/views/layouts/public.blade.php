<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>@yield('title', 'PortalSehat')</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
 @stack('scripts')
<body class="bg-[#faf9f7] text-slate-800">
  @include('partials.navbar')

  <main>
    @yield('content')
  </main>

  @include('partials.footer')

</body>
<style>
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
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</html>