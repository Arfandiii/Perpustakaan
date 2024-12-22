@extends('admin.layouts.app')

@section('title', $title)

@section('content')
<div class="content ml-12 transform ease-in-out duration-500 pt-20 px-2 md:px-5 pb-4">
    <x-breadcrumb :breadcrumbs="$breadcrumbs"></x-breadcrumb>
    <div class="p-6 max-w-6xl mx-auto bg-white rounded-lg shadow-md my-10">
        <div class="container mx-auto p-6">
            <!-- Judul Halaman -->
            <h1 class="text-3xl font-semibold text-gray-900 mb-6">Detail Buku</h1>

            <!-- Tabel Detail Buku -->
            <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Judul</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Kategori</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Pengarang</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Penerbit</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Tahun Terbit</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Stok</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Deskripsi</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Cover</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="px-4 py-2 text-sm text-gray-800">{{ $book->title }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800">{{ $book->category->name ?? 'N/A' }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800">{{ $book->author }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800">{{ $book->publisher }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800">{{ $book->published_year }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800">{{ $book->stock }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800">{{ $book->description }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800">
                                @if($book->cover_image)
                                <img src="{{ asset('storage/' . $book->cover_image ?? 'assets/img/default-book.png') }}"
                                    alt="Cover Image" class="w-20 h-30 object-cover">
                                @else
                                <span class="text-gray-500">No Image</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Action Buttons -->
            <div class="mt-6 flex justify-end space-x-2">
                <a href="{{ route('admin.books.index') }}"
                    class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition">
                    Kembali
                </a>
                <a href="{{ route('admin.books.edit', $book->id) }}"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    Edit
                </a>
                <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST"
                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection