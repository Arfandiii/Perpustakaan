@extends('layouts.app')

@section('title', 'Buku yang Dipinjam')

@section('content')
<div class="container mx-auto py-10 px-4">
    <h1 class="text-2xl font-bold mb-6">Daftar Buku yang Dipinjam</h1>

    @foreach ($loans as $loan)
    <div class="bg-white shadow-lg rounded-lg p-6 mb-4">
        <h3 class="text-lg font-semibold text-gray-700">Judul Buku: {{ $loan->book->title }}</h3>
        <p class="text-gray-600">Author: {{ $loan->book->author }}</p>
        <p class="text-gray-600">Status: {{ $loan->status }}</p>
        <p class="text-gray-600">Tanggal Pengembalian: {{ $loan->return_date ?? 'Belum Dikembalikan' }}</p>
        <form action="{{ route('loans.return', $loan->id) }}" method="POST">
            @csrf
            <button type="submit"
                class="bg-green-600 text-white py-2 px-4 rounded-lg font-semibold hover:bg-green-700 transition">
                Kembalikan Buku
            </button>
        </form>
    </div>
    @endforeach
</div>
@endsection