@extends('admin.layouts.app')

@section('title', $title)

@section('content')
<div class="content ml-12 transform ease-in-out duration-500 pt-20 px-2 md:px-5 pb-4">
    <x-breadcrumb :breadcrumbs="$breadcrumbs"></x-breadcrumb>
    <div class="p-6 max-w-6xl mx-auto bg-white rounded-lg my-10">
        <!-- Main Content -->
        <main class="my-10 mx-auto flex-grow flex justify-center items-center">
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-lg">
                <!-- Form Header -->
                <h2 class="text-xl font-semibold mb-4 text-gray-700 text-center">Form Edit User</h2>

                <!-- Form -->
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <!-- Nama -->
                    <div>
                        <label for="name" class="block text-gray-700 font-medium mb-2">Nama</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                    </div>
                    @error('email')
                    <div class="text-pink-600">
                        {{ $message }}
                    </div>
                    @enderror

                    <!-- Kelas -->
                    <div>
                        <label for="edu_level_id" class="block text-gray-700 font-medium mb-2">Kelas</label>
                        <select id="edu_level_id" name="edu_level_id"
                            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                            <option value="" {{ !$user->edu_level_id ? 'selected' : '' }} disabled>Pilih Tingkat
                                Pendidikan
                            </option>
                            @foreach ($eduLevels as $eduLevel)
                            <option value="{{ $eduLevel->id }}" {{ old('edu_level_id', $user->edu_level_id) ==
                                $eduLevel->id
                                ? 'selected' : '' }}>
                                {{ $eduLevel->name }}
                            </option>
                            @endforeach
                        </select>
                        <a href="{{ route('admin.edu-levels.index') }}" class="hover:underline text-indigo-700"> <span
                                class="text-sm font-normal">Atur tingkatan kelas
                            </span></a>
                    </div>

                    <!-- No handphone -->
                    <div>
                        <label for="phone" class="block text-gray-700 font-medium mb-2">No Hp</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Tanggal lahir -->
                    <div>
                        <label for="dob" class="block text-gray-700 font-medium mb-2">Tanggal Lahir</label>
                        <input type="date" name="dob" id="dob"
                            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ old('dob', $user->dob) }}">
                    </div>
                    @error('dob')
                    <div class="text-pink-600">
                        {{ $message }}
                    </div>
                    @enderror

                    <!-- Action Buttons -->
                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('admin.users.index') }}"
                            class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition">
                            Kembali
                        </a>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </main>

    </div>
</div>
@endsection