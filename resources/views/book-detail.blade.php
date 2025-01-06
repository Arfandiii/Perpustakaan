@extends('layouts.app')

@section('title', $title)

@section('content')

<div class="container py-10 px-4 mx-auto">
    <!-- Tombol Batal -->
    <div class="mb-6">
        <a href="{{ route('catalog') }}"
            class="bg-gray-500 text-white py-2 px-4 rounded-lg font-semibold hover:bg-gray-600 transition">
            Kembali ke Katalog
        </a>
    </div>
    <div class="flex flex-col md:flex-row gap-8 shadow-md rounded-lg w-full">
        <!-- Bagian Gambar -->
        <div class="flex-shrink-0 w-full md:w-1/2">
            <div class="rounded-lg overflow-hidden sm:py-10">
                <img src="{{ $book->cover_image ? asset('storage/'.$book->cover_image) : asset('assets/img/default-book.png') ?? asset('images/default-book.png') }}"
                    alt="{{ $book->title }}" class="w-full sm:w-6/12 h-full object-cover m-auto rounded-md shadow-lg">
            </div>
        </div>

        <!-- Bagian Detail Buku -->
        <div class="flex-1 px-8 py-10">
            <p class="text-purple-500 mb-2 font-semibold">Detail Buku</p>
            <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $book->title }}</h1>
            <ul class="mb-6 text-gray-600">
                <li class="font-normal text-lg"><span class="font-semibold text-xl">Penulis:</span> {{
                    $book->author }}</li>
                <li class="font-normal text-lg"><span class="font-semibold text-xl">Kategori:</span> {{
                    $book->category->name }}
                </li>
                <li class="font-normal text-lg"><span class="font-semibold text-xl">Tahun Terbit:</span>
                    {{
                    $book->published_year }}</li>
                <li class="font-normal text-lg"><span class="font-semibold text-xl">Stock:</span> {{
                    $book->stock }}
                </li>
                <li class="font-normal text-lg"><span class="font-semibold text-xl">Stock Tersedia:</span> {{
                    $book->stock }}
                </li>
            </ul>
            <hr class="my-4">
            <div>
                <h2 class="text-xl font-semibold text-purple-600 mb-2">Sinopsis</h2>
                <p class="text-gray-700 leading-relaxed text-lg">{{ $book->description }}</p>
            </div>
            <hr class="my-4">
            <div class="mt-6">
                @if (auth()->check())
                @if ($book->stock > 0)
                @if (auth()->user()->email_verified_at)
                <!-- Mengecek apakah email sudah diverifikasi -->
                <a href="{{ route('loans.confirmLoan', $book->slug) }}"
                    class="text-center font-semibold hover:cursor-pointer block w-full bg-purple-600 text-white text-lg py-3 rounded-lg hover:bg-purple-700 transition">
                    Pinjam Buku
                </a>
                @else
                @if(auth()->user()->role === 'admin')
                <button
                    class="bg-purple-500 font-bold px-4 opacity-50 cursor-not-allowed w-full text-white text-lg py-3 rounded-lg">
                    Anda sebagai admin tidak dapat meminjam buku</button>
                @else
                <button
                    class="bg-purple-500 font-bold px-4 opacity-50 cursor-not-allowed w-full text-white text-lg py-3 rounded-lg">
                    Verifikasi email untuk meminjam buku</button>
                @endif
                @endif
                @else
                <button
                    class="bg-purple-500 font-bold px-4 opacity-50 cursor-not-allowed w-full text-white text-lg py-3 rounded-lg">
                    Stok Buku Tidak Tersedia
                </button>
                @endif
                @else
                <button
                    class="bg-purple-500 font-bold px-4 opacity-50 cursor-not-allowed w-full text-white text-lg py-3 rounded-lg">
                    Login dan verifikasi untuk meminjam.</button>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection