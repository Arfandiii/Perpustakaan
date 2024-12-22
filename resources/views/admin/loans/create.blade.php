@extends('admin.layouts.app')

@section('title', $title)

@section('content')
<div class="content ml-12 transform ease-in-out duration-500 pt-20 px-2 md:px-5 pb-4">
    <x-breadcrumb :breadcrumbs="$breadcrumbs"></x-breadcrumb>
    <div class="p-6 max-w-6xl mx-auto bg-white rounded-lg shadow-md my-10">
        <div class="container mx-auto py-6">
            <h2 class="text-2xl font-semibold mb-4">Peminjaman Buku</h2>
            <form action="{{ route('admin.loans.store') }}" method="POST">
                @csrf
                <div class="mb-5">
                    <label for="book_id" class="block mb-2 text-sm font-medium text-gray-900">Buku</label>
                    <input type="text" value="{{ $book->title }}" readonly
                        class="bg-gray-100 text-gray-900 text-sm rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                </div>

                <div class="mb-5">
                    <label for="tanggal_peminjaman" class="block mb-2 text-sm font-medium text-gray-900">Tanggal
                        Peminjaman</label>
                    <input type="date" id="tanggal_peminjaman" name="tanggal_peminjaman" required
                        class="bg-gray-50 focus:outline-none focus:ring-1 border border-indigo-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                </div>

                <input type="hidden" name="book_id" value="{{ $book->id }}">

                <button type="submit"
                    class="w-full bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded-md">
                    Pinjam Buku
                </button>
            </form>
        </div>
    </div>
</div>
@endsection