<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Online SMA 1 Siantan | {{ $title ?? 'Peronsmansasi' }}</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="flex items-center justify-center h-screen bg-gray-200">
    <div class="bg-white p-8 rounded-lg shadow-md w-96">
        @if (session()->has('loginError'))
        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
            <span class="font-medium">{{ session('loginError') }}</span> Coba lagi.
        </div>
        @endif
        @if (session()->has('success'))
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
            <span class="font-medium">{{ session('success') }}</span> silahkan login.
        </div>
        @endif
        @yield('content')
    </div>
</body>

</html>