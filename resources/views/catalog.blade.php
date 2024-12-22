@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="relative isolate overflow-hidden bg-gray-800 pb-24 sm:pb-24">
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
    <section class="pt-4">
        <div class="container mx-auto py-10 px-20">
            <h1 class="text-3xl font-semibold mb-6 text-white">Katalog Buku</h1>

            <!-- Form Pencarian -->
            <div class="mb-4">
                <form class="flex justify-center">
                    <input type="search" placeholder="Masukkan judul atau kata kunci..."
                        class="shadow sm:w-1/2 w-full p-3 border border-gray-300 rounded-l focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <button type="submit"
                        class="shadow bg-purple-500 hover:bg-purple-600 text-white px-6 py-3 rounded-r transition">Cari</button>
                </form>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-4">
                @foreach($books as $book)
                <div class="bg-white border rounded-md shadow hover:shadow p-4">
                    <img src="{{ asset('storage/'.$book->cover_image) }}" alt="{{ $book->title }}"
                        class="w-full h-48 object-cover mb-4">
                    <h2 class="font-semibold text-xl mb-2 text-gray-900 h-20">
                        <!-- Judul untuk layar kecil -->
                        <span class="block sm:hidden">{{ Str::limit($book->title, 40) }}</span>
                        <!-- Judul untuk layar lebih besar -->
                        <span class="hidden sm:block">{{ Str::limit($book->title, 75) }}</span>
                    </h2>
                    <p class="text-gray-700 text-sm mb-4">Penulis: {{ $book->author }}</p>
                    <p class="text-gray-600 text-sm sm:h-20">
                        <!-- Deskripsi untuk layar kecil -->
                        <span class="block sm:hidden">{{ Str::limit($book->description, 50) }}</span>
                        <!-- Deskripsi untuk layar lebih besar -->
                        <span class="hidden sm:block">{{ Str::limit($book->description, 100) }}</span>
                    </p>
                    <a href="{{ route('book.showUser', $book->slug) }}"
                        class="text-purple-500 mt-4 inline-block hover:underline">Baca Selengkapnya
                        &#8811;</a>
                </div>
                @endforeach
            </div>
            <div>
                {{ $books->links() }}
            </div>
        </div>
    </section>
</div>
@endsection