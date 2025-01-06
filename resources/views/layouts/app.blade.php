<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Online SMA 1 Siantan | {{ $title ?? 'Peronsmansasi' }}</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="h-full overflow-x-hidden ">
    <div class="min-h-full">
        <!-- Navbar -->
        @include('layouts.header')
        {{-- <x-navbar></x-navbar> --}}

        <!-- Content -->
        <div>
            @yield('content')
            <!-- Konten spesifik halaman -->
        </div>
        {{-- <main>
            {{ $slot }}
        </main> --}}

        <!-- Footer -->
        @include('layouts.footer')
        {{-- <x-footer></x-footer> --}}

    </div>
</body>

</html>