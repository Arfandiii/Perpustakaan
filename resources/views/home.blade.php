@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="relative isolate overflow-hidden bg-gray-800 py-24 sm:py-32 h-screen">
    <img src="{{ asset('assets/img/perpus-2.jpg') }}" alt="perpustakaan"
        class="absolute inset-0 bg-black opacity-20 -z-10 h-full w-full object-cover object-right md:object-center">
    <div class="hidden sm:absolute sm:-top-10 sm:right-1/2 sm:-z-10 sm:mr-10 sm:block sm:transform-gpu sm:blur-3xl"
        aria-hidden="true">
        <div class="aspect-[1097/845] w-[68.5625rem] bg-gradient-to-tr from-[#ff4694] to-[#776fff] opacity-20"
            style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
        </div>
    </div>
    <div class="absolute -top-52 left-1/2 -z-10 -translate-x-1/2 transform-gpu blur-3xl sm:top-[-28rem] sm:ml-16 sm:translate-x-0 sm:transform-gpu"
        aria-hidden="true">
        <div class="aspect-[1097/845] w-[68.5625rem] bg-gradient-to-tr from-[#ff4694] to-[#776fff] opacity-20"
            style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
        </div>
    </div>
    <div
        class="container flex flex-col items-center justify-center h-full mx-auto px-6 text-center text-white space-y-8">
        <!-- Heading -->
        <h1 class="text-4xl font-extrabold sm:text-5xl lg:text-6xl">
            Selamat Datang di Perpustakaan Digital <br />
            <span class="text-purple-500 leading-tight">SMA Negeri 1 Siantan</span>
        </h1>

        <!-- Subtitle -->
        <p class="max-w-2xl text-lg sm:text-xl">
            Tempat di mana belajar tak terbatas, temukan informasi dan inspirasi untuk menggapai masa depan yang
            gemilang.
        </p>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4">
            <a href="{{ route('catalog') }}"
                class="w-40 px-6 py-3 bg-purple-500 rounded-full text-white font-medium hover:bg-purple-600 transition">Jelajahi
                Koleksi
            </a>
        </div>
    </div>
</div>

<div class="relative isolate overflow-hidden bg-gray-800">
    <div class="hidden sm:absolute sm:-top-10 sm:right-1/2 sm:-z-10 sm:mr-10 sm:block sm:transform-gpu sm:blur-3xl"
        aria-hidden="true">
        <div class="aspect-[1097/845] w-[68.5625rem] bg-gradient-to-tr from-[#ff4694] to-[#776fff] opacity-20"
            style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
        </div>
    </div>
    <div class="absolute -top-52 left-1/2 -z-10 -translate-x-1/2 transform-gpu blur-3xl sm:top-[-28rem] sm:ml-16 sm:translate-x-0 sm:transform-gpu"
        aria-hidden="true">
        <div class="aspect-[1097/845] w-[68.5625rem] bg-gradient-to-tr from-[#ff4694] to-[#776fff] opacity-20"
            style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
        </div>
    </div>
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <!-- Katalog Buku -->
        <section class="mb-8">
            <div class="container mx-auto px-12 sm:px-8">
                <h2 class="text-center text-2xl font-semibold mb-8 text-white">Katalog Buku Terbaru</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-4">
                    <!-- Buku -->
                    @foreach($books as $book)
                    <div class="bg-white rounded-lg shadow hover:shadow-lg transition">
                        <img src="{{ $book->cover_image ? asset('storage/'.$book->cover_image) : asset('assets/img/default-book.png') }}"
                            alt="{{ $book->title }}" class="w-full h-48 object-cover rounded-t-lg">
                        <div class="p-4">
                            <h5 class="text-lg font-semibold sm:h-14">{{ Str::limit($book->title, 34) }}</h5>
                            <p class="text-gray-600 my-2 h-12">{{ $book->author }}</p>
                            <a href="{{ route('book.showUser', $book->slug) }}"
                                class="block bg-purple-500 text-white font-medium text-center py-2 rounded mt-4 hover:bg-purple-600 transition">Detail</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
</div>
@endsection