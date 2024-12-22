@extends('admin.layouts.app')

@section('title', $title)

@section('content')
<div class="content ml-12 transform ease-in-out duration-500 pt-20 px-2 md:px-5 pb-4">
    <x-breadcrumb :breadcrumbs="$breadcrumbs"></x-breadcrumb>
    <div class="p-6 max-w-6xl mx-auto bg-white rounded-lg shadow-md my-10">
        <!-- Edu Level Index View (resources/views/admin/edu_levels/index.blade.php) -->
        <div class="container mx-auto p-4">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">Tingkatan Kelas</h2>

            <!-- Button to Add New Edu Level -->
            <a href="{{ route('admin.edu-levels.create') }}"
                class="mb-4 inline-block px-6 py-2 bg-indigo-600 text-white font-bold rounded-md hover:bg-indigo-500">
                Tambah Kelas Baru
            </a>

            <!-- Table for Edu Levels -->
            <table class="min-w-full bg-white border border-gray-200 rounded-md shadow-md">
                <thead class="bg-indigo-600 text-white">
                    <tr>
                        <th class="px-4 py-2 text-left">No</th>
                        <th class="px-4 py-2 text-left">Nama</th>
                        <th class="px-4 py-2 text-left">Deskripsi</th>
                        <th class="px-4 py-2 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($eduLevels as $eduLevel)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2">{{ $eduLevel->name }}</td>
                        <td class="px-4 py-2">{{ $eduLevel->description ?? 'Tidak ada deskripsi' }}</td>
                        <td class="px-4 py-2">
                            <!-- Edit and Delete Actions -->
                            <a href="{{ route('admin.edu-levels.edit', $eduLevel->id) }}"
                                class="text-indigo-600 hover:text-indigo-500 hover:underline">Edit</a>
                            |
                            <form action="{{ route('admin.edu-levels.destroy', $eduLevel->id) }}" method="POST"
                                class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-red-600 hover:text-red-500 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Display Success or Error Message -->
            @if(session('success'))
            <div class="mt-4 p-2 bg-green-100 text-green-700 rounded-md">
                {{ session('success') }}
            </div>
            @elseif(session('error'))
            <div class="mt-4 p-2 bg-red-100 text-red-700 rounded-md">
                {{ session('error') }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection