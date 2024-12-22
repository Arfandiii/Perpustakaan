@extends('admin.layouts.app')

@section('title', $title)

@section('content')
<div class="content ml-12 transform ease-in-out duration-500 pt-20 px-2 md:px-5 pb-4">
    <x-breadcrumb :breadcrumbs="$breadcrumbs"></x-breadcrumb>
    <div class="p-6 max-w-6xl mx-auto bg-white rounded-lg shadow-md my-10">
        <!-- Form Header -->
        <h2 class="text-xl font-semibold mb-4 text-gray-700 text-center">Form Edit Kelas</h2>
        <form action="{{ route('admin.edu-levels.update', $eduLevel->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-900 dark:text-white">Nama Kelas</label>
                <input type="text" name="name" id="name"
                    class="block w-full px-3 py-2 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                    placeholder="Masukan Nama Kelas" required value="{{ old('name', $eduLevel->name) }}">
            </div>

            <div class="mb-6">
                <label for="description"
                    class="block text-sm font-medium text-gray-900 dark:text-white">Deskripsi</label>
                <input name="description" id="description" rows="4"
                    class="block w-full px-3 py-2 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                    placeholder="Masukan Deskripsi Kelas" value="{{ old('description', $eduLevel->description) }}">
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-2">
                <a href="{{ route('admin.edu-levels.index') }}"
                    class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition">
                    Kembali
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection