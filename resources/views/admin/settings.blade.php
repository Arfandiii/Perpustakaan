@extends('admin.layouts.app')

@section('title', $title)

@section('content')
<div class="content ml-12 transform ease-in-out duration-500 pt-20 px-2 md:px-5 pb-4">
    <x-breadcrumb :breadcrumbs="$breadcrumbs"></x-breadcrumb>
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
                    <form action="{{ route('admin.updateProfile') }}" method="POST" enctype="multipart/form-data">
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
                                        <svg data-slot="icon" class="w-6 h-6 text-blue-700" fill="none"
                                            stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
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
                        <div
                            class="w-full rounded-lg bg-blue-600 hover:bg-blue-500 mt-4 text-white text-lg font-semibold">
                            <button type="submit" class="w-full p-4">Perbarui Profil</button>
                        </div>
                    </form>

                    <form action="{{ route('admin.changePassword') }}" class="mt-6" method="POST">
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
                                <label for="password_confirmation" class=" dark:text-gray-300">Konfirmasi
                                    Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="mt-2 p-4 w-full border-2 rounded-lg dark:text-gray-200 dark:border-gray-600 dark:bg-gray-800"
                                    placeholder="Konfirmasi Password">
                                @error('password_confirmation')
                                <div class="text-red-500 text-sm">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div
                            class="w-full rounded-lg bg-blue-600 hover:bg-blue-500 mt-4 text-white text-lg font-semibold">
                            <button type="submit" class="w-full p-4">Ganti Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
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