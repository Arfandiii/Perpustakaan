@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="container mx-auto py-10 px-4">
    {{-- Massage --}}
    @if (session()->has('success'))
    <div class="p-4 mb-4 text-green-700 bg-green-100 rounded-lg my-4" role="alert">
        <p>{{ session('success')}}</p>
    </div>
    @endif
    @if(session('info'))
    <div class="bg-yellow-500 text-white p-3 rounded mb-4 my-4">
        {{ session('info') }}
    </div>
    @endif
    <div class="bg-white shadow-lg rounded-lg p-6 md:p-10">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Konfirmasi Peminjaman</h2>
        <p class="text-gray-600 mb-6">
            Apakah Anda yakin ingin meminjam buku ini?
        </p>
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-700">Judul Buku:</h3>
            <p class="text-gray-800 font-medium">{{ $book->title }}</p>
        </div>
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-700">Author:</h3>
            <p class="text-gray-800 font-medium">{{ $book->author }}</p>
        </div>
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-700">Stock:</h3>
            <p class="text-gray-800 font-medium">{{ $book->stock }}</p>
        </div>

        <!-- Tambahkan dropdown untuk durasi peminjaman -->
        <form action="{{ route('loans.createLoan', $book->slug) }}" method="POST">
            @csrf
            <div class="mb-6">
                <label for="duration" class="block text-lg font-semibold text-gray-700 mb-2">
                    Durasi Peminjaman:
                </label>
                <select name="duration" id="duration" class="border rounded-lg px-4 py-2 w-full" required>
                    <option value="" disabled selected>Pilih Durasi</option>
                    <option value="5" {{ old('duration')==5 ? 'selected' : '' }}>5 Hari</option>
                    <option value="7" {{ old('duration')==7 ? 'selected' : '' }}>7 Hari</option>
                    <option value="14" {{ old('duration')==14 ? 'selected' : '' }}>14 Hari</option>
                </select>
            </div>
            <div class="flex items-center gap-4">
                <button type="submit"
                    class="bg-purple-600 text-white py-2 px-4 rounded-lg font-semibold hover:bg-purple-700 transition">
                    Konfirmasi Peminjaman
                </button>
                <a href="{{ route('book.showUser', $book->slug) }}"
                    class="bg-gray-500 text-white py-2 px-4 rounded-lg font-semibold hover:bg-gray-600 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection