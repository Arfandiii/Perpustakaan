@extends('admin.layouts.app')

@section('title', $title)

@section('content')
<div class="content ml-12 transform ease-in-out duration-500 pt-20 px-2 md:px-5 pb-4">
    <x-breadcrumb :breadcrumbs="$breadcrumbs"></x-breadcrumb>
    <div class="p-6 max-w-6xl mx-auto bg-white rounded-lg shadow-md my-10">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-900 dark:text-white">Nama Kategori
                    Buku</label>
                <input type="text" name="name" id="name"
                    class="block w-full px-3 py-2 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                    placeholder="Masukan Nama Kategori Buku" required value="{{ old('name') }}">
            </div>

            <div class="mb-6">
                <label for="description"
                    class="block text-sm font-medium text-gray-900 dark:text-white">Deskripsi</label>
                <input name="description" id="description" rows="4"
                    class="block w-full px-3 py-2 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                    placeholder="Masukan Deskripsi Kategori Buku" value="{{ old('description') }}">
            </div>

            <div class="mb-6">
                <button type="submit" class="w-full py-2 px-4 bg-indigo-600 hover:bg-indigo-500 text-white rounded-md">
                    Tambah Kategori Buku
                </button>
            </div>
        </form>
    </div>
</div>
@endsection