@extends('layouts.app')

@section('title', $title)

@section('content')

{{-- <div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-lg my-10">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Edit Profil Saya</h2>

    <!-- Form Profil Pengguna -->
    <form method="POST" {{-- action="{{ route('user.updateProfile') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Nama Lengkap -->
        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-medium mb-2">Nama Lengkap</label>
            <input type="text" id="name" name="name"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                value="{{ old('name', $user->name) }}" required>
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Email</label>
            <input type="email" id="email" name="email"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                value="{{ old('email', $user->email) }}" required>
        </div>

        <!-- Kelas -->
        <div class="mb-4">
            <label for="edu_level_id" class="block text-gray-700 text-sm font-medium mb-2">Kelas</label>
            <select id="edu_level_id" name="edu_level_id"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                required>
                <option value="" disabled>Pilih Kelas</option>
                @foreach($eduLevels as $level)
                <option value="{{ $level->id }}" {{ old('edu_level_id', $user->edu_level_id) == $level->id ?
                    'selected'
                    : '' }}>
                    {{ $level->name }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Tanggal Lahir -->
        <div class="mb-4">
            <label for="dob" class="block text-gray-700 text-sm font-medium mb-2">Tanggal Lahir</label>
            <input type="date" id="dob" name="dob"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                value="{{ old('dob', $user->dob ? \Carbon\Carbon::parse($user->dob)->format('Y-m-d') : '') }}">
        </div>

        <!-- No HP -->
        <div class="mb-4">
            <label for="phone" class="block text-gray-700 text-sm font-medium mb-2">No HP</label>
            <input type="text" id="phone" name="phone"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                value="{{ old('phone', $user->phone) }}">
        </div>

        <!-- Ganti Password -->
        <div class="mb-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Ganti Password</h3>

            <!-- Password Baru -->
            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm font-medium mb-2">Password Baru</label>
                <input type="password" id="password" name="password"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                    placeholder="Masukkan password baru">
            </div>

            <!-- Konfirmasi Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="block text-gray-700 text-sm font-medium mb-2">Konfirmasi
                    Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                    placeholder="Konfirmasi password baru">
            </div>
        </div>

        <!-- Submit Button -->
        <div class="mt-6">
            <button type="submit"
                class="w-full py-2 px-4 bg-purple-500 text-white rounded-md hover:bg-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-500">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div> --}}

<section class="py-10 my-auto dark:bg-gray-900">

    <div class="lg:w-[80%] md:w-[90%] xs:w-[96%] mx-auto flex gap-4">
        <div
            class="lg:w-[88%] md:w-[80%] sm:w-[88%] xs:w-full mx-auto shadow-2xl p-4 rounded-xl h-fit self-center dark:bg-gray-800/40">
            <!--  -->
            @if(session('success'))
            <div class="bg-green-500 text-white p-3 rounded mb-4">
                {{ session('success') }}
            </div>
            @endif
            @if(session('info'))
            <div class="bg-yellow-500 text-white p-3 rounded mb-4">
                {{ session('info') }}
            </div>
            @endif
            <div>
                <h1 class="lg:text-3xl md:text-2xl sm:text-xl xs:text-xl font-bold mb-2 dark:text-white">
                    Profile
                </h1>
                <form action="{{ route('updateProfile') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <!-- Cover Image -->
                    <div class="py-4 w-full flex flex-col items-center">
                        <!-- Gambar Background -->
                        <img src="{{ asset('assets/img/perpus-2.jpg') }}" alt="Background"
                            class="w-full rounded-sm object-cover h-40">

                        <!-- Profile Image -->
                        <div class="relative w-[141px] h-[141px] mt-[-70px]">
                            <img id="profileImage"
                                src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('assets/img/default-profile.png') }}"
                                alt="Profile"
                                class="rounded-full w-full h-full object-cover border-4 border-white shadow-lg">
                            <!-- Icon untuk Upload -->
                            <div
                                class="absolute bottom-0 right-0 bg-white/90 rounded-full w-8 h-8 flex items-center justify-center shadow-md transition-transform duration-300 hover:scale-105">
                                <input type="file" name="upload_profile" id="upload_profile" hidden>
                                <label for="upload_profile" class="cursor-pointer">
                                    <svg data-slot="icon" class="w-6 h-6 text-blue-700" fill="none" stroke-width="1.5"
                                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                        aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z">
                                        </path>
                                    </svg>
                                </label>
                            </div>
                        </div>
                    </div>
                    <h2 class="text-center font-semibold dark:text-gray-300 text-2xl">Ubah Data Profil
                    </h2>
                    <div class="flex lg:flex-row md:flex-col sm:flex-col xs:flex-col gap-2 justify-center w-full">
                        <div class="w-full  mb-4 mt-6">
                            <label for="name" class="mb-2 dark:text-gray-300">Nama Lengkap</label>
                            <input type="text" name="name" id="name" required
                                class="mt-2 p-4 w-full border-2 rounded-lg dark:text-gray-200 dark:border-gray-600 dark:bg-gray-800"
                                placeholder="Nama Lengkap" value="{{ old('name', $user->name) }}">
                        </div>
                        <div class="w-full  mb-4 lg:mt-6">
                            <label for="email" class=" dark:text-gray-300">Email</label>
                            <input type="text" name="email" id="email" required
                                class="mt-2 p-4 w-full border-2 rounded-lg dark:text-gray-200 dark:border-gray-600 dark:bg-gray-800"
                                placeholder="Email" value="{{ old('email', $user->email) }}">
                        </div>
                    </div>

                    <div class="flex lg:flex-row md:flex-col sm:flex-col xs:flex-col gap-2 justify-center w-full">
                        <div class="w-full">
                            <label for="phone" class=" dark:text-gray-300">No Handphone</label>
                            <input type="text" id="phone" name="phone"
                                class="mt-2 p-4 w-full border-2 rounded-lg dark:text-gray-200 dark:border-gray-600 dark:bg-gray-800"
                                placeholder="No Handphone" value="{{ old('phone', $user->phone) }}">
                        </div>
                        <div class="w-full">
                            <h3 class="dark:text-gray-300 mb-2">Kelas</h3>
                            <select id="edu_level_id" name="edu_level_id"
                                class="w-full text-grey border-2 rounded-lg p-4 pl-2 pr-2 dark:text-gray-200 dark:border-gray-600 dark:bg-gray-800">
                                <option value="" {{ !$user->edu_level_id ? 'selected' : '' }} disabled>Pilih Kelas
                                </option>
                                @foreach($eduLevels as $level)
                                <option value="{{ $level->id }}" {{ old('edu_level_id', $user->edu_level_id) ==
                                    $level->id ?
                                    'selected'
                                    : '' }}>
                                    {{ $level->name }}
                                </option>
                                @endforeach
                            </select>

                        </div>
                        <div class="w-full">
                            <h3 class="dark:text-gray-300 mb-2">Tanggal Lahir</h3>
                            <input type="date" id="dob" name="dob"
                                class="text-grey p-4 w-full border-2 rounded-lg dark:text-gray-200 dark:border-gray-600 dark:bg-gray-800"
                                value="{{ old('dob', $user->dob ? \Carbon\Carbon::parse($user->dob)->format('Y-m-d') : '') }}">
                        </div>
                    </div>
                    <div class="w-full rounded-lg bg-blue-600 hover:bg-blue-500 mt-4 text-white text-lg font-semibold">
                        <button type="submit" class="w-full p-4">Perbarui Profil</button>
                    </div>
                </form>

                <form action="{{ route('changePassword') }}" class="mt-6" method="POST">
                    @csrf
                    <h2 class="text-center mt-1 text-2xl font-semibold dark:text-gray-300">Ganti Password
                    </h2>
                    <div class="flex lg:flex-row md:flex-col sm:flex-col xs:flex-col gap-2 justify-center w-full">
                        <div class="w-full  mb-4 mt-6">
                            <label for="password" class="mb-2 dark:text-gray-300">Password</label>
                            <input type="password" name="password" id="password"
                                class="mt-2 p-4 w-full border-2 rounded-lg dark:text-gray-200 dark:border-gray-600 dark:bg-gray-800"
                                placeholder="Password">
                            @error('password')
                            <div class="text-red-500 text-sm">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="w-full  mb-4 lg:mt-6">
                            <label for="password_confirmation" class=" dark:text-gray-300">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="mt-2 p-4 w-full border-2 rounded-lg dark:text-gray-200 dark:border-gray-600 dark:bg-gray-800"
                                placeholder="Konfirmasi Password">
                            @error('password_confirmation')
                            <div class="text-red-500 text-sm">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="w-full rounded-lg bg-blue-600 hover:bg-blue-500 mt-4 text-white text-lg font-semibold">
                        <button type="submit" class="w-full p-4">Ganti Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<script>
    document.getElementById('upload_profile').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profileImage').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection