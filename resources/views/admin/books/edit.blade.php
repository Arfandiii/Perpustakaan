@extends('admin.layouts.app')

@section('title', $title)

@section('content')
<div class="content ml-12 transform ease-in-out duration-500 pt-20 px-2 md:px-5 pb-4">
    <x-breadcrumb :breadcrumbs="$breadcrumbs"></x-breadcrumb>
    <div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-lg my-10">
        <h2 class="text-2xl font-bold mb-6">Form Edit Buku</h2>
        <form action="{{ route('admin.books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <!-- Judul -->
            <div class="mb-5">
                <label for="judul" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Judul
                    Buku</label>
                <input type="text" name="judul" id="judul" required
                    class="bg-gray-50 border border-indigo-300 text-gray-900 text-sm rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-indigo-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Masukkan judul buku" value="{{ old('judul', $book->title) }}">
            </div>

            <!-- Penulis -->
            <div class="mb-5">
                <label for="penulis"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Penulis</label>
                <input type="text" name="penulis" id="penulis" required
                    class="bg-gray-50 border border-indigo-300 text-gray-900 text-sm rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-indigo-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Masukkan nama penulis" value="{{ old('penulis', $book->author) }}">
            </div>

            <!-- Penerbit -->
            <div class="mb-5 flex justify-between">
                <div>
                    <label for="penerbit"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Penerbit</label>
                    <input type="text" name="penerbit" id="penerbit" required
                        class="bg-gray-50 border border-indigo-300 text-gray-900 text-sm rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-indigo-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Masukkan nama penerbit" value="{{ old('penerbit', $book->publisher) }}">
                </div>
                <!-- Tahun Terbit -->
                <div>
                    <label for="tahun_terbit" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tahun
                        Terbit</label>
                    <input type="number" name="tahun_terbit" id="tahun_terbit" required
                        class="bg-gray-50 border border-indigo-300 text-gray-900 text-sm rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-indigo-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Masukkan tahun terbit" value="{{ old('tahun_terbit', $book->published_year) }}">
                </div>
                <!-- Stok -->
                <div>
                    <label for="stok" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Stok
                        Buku</label>
                    <input type="number" name="stok" id="stok" required
                        class="bg-gray-50 border border-indigo-300 text-gray-900 text-sm rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-indigo-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Masukkan jumlah stok" value="{{ old('stok', $book->stock) }}">
                </div>
                <!-- Kategori -->
                <div>
                    <label for="kategori_id"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kategori
                        Buku</label>
                    <select name="kategori_id" id="kategori_id" required
                        class="bg-gray-50 border border-indigo-300 text-gray-900 text-sm rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-indigo-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="" {{ !$book->categori_id ? 'selected' : '' }} disabled>Pilih kategori
                        </option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('kategori_id', $book->category_id) ==
                            $category->id
                            ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                    <a href="{{ route('admin.categories.index') }}" class="hover:underline text-indigo-700"><span
                            class="text-sm font-normal">Atur
                            kategori buku</span></a>
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="mb-5">
                <label for="deskripsi"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="4" required
                    class="bg-gray-50 border border-indigo-300 text-gray-900 text-sm rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-indigo-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Masukkan deskripsi buku">{{ old('deskripsi', $book->description) }}</textarea>
            </div>


            <!-- Cover Image -->
            <div class="mb-5">
                <label for="cover_img" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cover
                    Buku
                </label>
                <div class="border-indigo-300 border-dashed mx-auto font-[sans-serif} relative border-2 rounded mb-5">

                    <!-- Input File -->
                    <input type="file" name="cover_img" id="file-upload"
                        class="absolute inset-0 w-full h-full opacity-0 z-50 hover:cursor-pointer"
                        accept="image/png, image/jpeg, image/jpg" onchange="displayPreview(event)" />



                    <!-- Preview Gambar -->
                    @if($book->cover_image)
                    <img src="{{ asset('storage/'.$book->cover_image ?? 'assets/img/default-book.png') }}"
                        class="my-4 mx-auto max-h-40 h-100" id="preview" alt="Preview Image">
                    @else
                    <!-- Konten Label -->
                    <div class="bg-white text-gray-500 font-semibold text-base cursor-pointer flex flex-col items-center justify-center h-52"
                        id="upload-label">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-11 mb-2 fill-gray-500" viewBox="0 0 32 32">
                            <path
                                d="M23.75 11.044a7.99 7.99 0 0 0-15.5-.009A8 8 0 0 0 9 27h3a1 1 0 0 0 0-2H9a6 6 0 0 1-.035-12 1.038 1.038 0 0 0 1.1-.854 5.991 5.991 0 0 1 11.862 0A1.08 1.08 0 0 0 23 13a6 6 0 0 1 0 12h-3a1 1 0 0 0 0 2h3a8 8 0 0 0 .75-15.956z"
                                data-original="#000000" />
                            <path
                                d="M20.293 19.707a1 1 0 0 0 1.414-1.414l-5-5a1 1 0 0 0-1.414 0l-5 5a1 1 0 0 0 1.414 1.414L15 16.414V29a1 1 0 0 0 2 0V16.414z"
                                data-original="#000000" />
                        </svg>
                        Cover Buku
                        <p class="text-xs font-medium text-gray-400 mt-2">PNG, JPG, JPEG are Allowed.</p>
                    </div>
                    @endif

                    @error('cover_img')
                    <div class="text-pink-600">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="mb-5">
                    <button type="submit"
                        class="w-full bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded-md">
                        Simpan Perubahan Buku
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection