@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="h-full bg-gray-200 p-8">
    <div class="bg-white rounded-lg shadow-xl pb-8">

        <div class="w-full h-[250px]">
            <img src="{{ asset('assets/img/perpus-2.jpg') }}"
                class="object-cover w-full h-full rounded-tl-lg rounded-tr-lg">
        </div>
        <div class="flex flex-col items-center -mt-20">
            <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('assets/img/default-profile.png') }}"
                class="w-40 h-40 border-4 border-white rounded-full object-cover" alt="{{ Auth::user()->name }}">
            <div class="flex items-center space-x-2 mt-2">
                <p class="text-2xl">{{ Auth::user()->name }}</p>
            </div>
        </div>
        <div class="flex-1 flex flex-col items-center lg:items-end justify-end px-8 mt-2">
            <div class="flex items-center space-x-4 mt-2">
                <a href="{{ route('profile') }}"
                    class="flex items-center bg-purple-600 hover:bg-purple-700 text-gray-100 px-4 py-2 rounded text-sm space-x-2 transition duration-100">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4">
                        <path
                            d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                        <path
                            d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                    </svg>
                    <span>Edit</span>
                </a>
                {{-- <button
                    class="flex items-center bg-purple-600 hover:bg-purple-700 text-gray-100 px-4 py-2 rounded text-sm space-x-2 transition duration-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span>Hapus Akun</span>
                </button> --}}
            </div>
        </div>
    </div>

    <div class="my-4 flex flex-col 2xl:flex-row space-y-4 2xl:space-y-0 2xl:space-x-4">
        <div class="w-full flex flex-col 2xl:w-1/3">
            <div class="flex-1 bg-white rounded-lg shadow-xl p-8">
                <h4 class="text-xl text-gray-900 font-bold">Informasi Pribadi</h4>
                <ul class="mt-2 text-gray-700">
                    <li class="flex border-y py-2">
                        <span class="font-bold w-32">Nama Lengkap:</span>
                        <span class="text-gray-700">{{ Auth::user()->name }}</span>
                    </li>
                    <li class="flex border-b py-2">
                        <span class="font-bold w-32">Email:</span>
                        <span class="text-gray-700">{{ Auth::user()->email }}</span>
                    </li>
                    <li class="flex border-b py-2">
                        <span class="font-bold w-32">Kelas:</span>
                        <span class="text-gray-700">
                            @if(Auth::user()->eduLevel)
                            {{ Auth::user()->eduLevel->name }} (Sepuluh)
                            @else
                            Kelas belum di tambah
                            @endif
                        </span>
                    </li>
                    <li class="flex border-b py-2">
                        <span class="font-bold w-32">Tanggal Lahir:</span>
                        <span class="text-gray-700">
                            @if(Auth::user()->dob)
                            {{ Auth::user()->dob }}
                            @else
                            Tanggal lahir belum di tambah
                            @endif
                        </span>
                    </li>
                    <li class="flex border-b py-2">
                        <span class="font-bold w-32">No Hp:</span>
                        <span class="text-gray-700">
                            @if(Auth::user()->phone)
                            {{ Auth::user()->phone }}
                            @else
                            Nomor Hp belum di tambah
                            @endif
                        </span>
                    </li>
                    <li class="flex border-b py-2">
                        <span class="font-bold w-32">Status:</span>
                        <span class="text-gray-700">
                            {{-- @if ($user->)
                            <span class="text-green-500 font-normal">Verified</span>
                            @else --}}
                            @if(Auth::user()->isEmailVerified())
                            <span class="text-green-500 font-normal">Verified</span>
                            @else
                            <span class="text-red-500 font-normal">Unverified</span>
                            @endif
                        </span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="flex flex-col w-full 2xl:w-2/3">
            <div class="flex-1 bg-white rounded-lg shadow-xl p-8">
                <h4 class="text-xl text-gray-900 font-bold">Statistics</h4>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-4">
                    <!-- Total Peminjaman -->
                    <div class="px-6 py-6 bg-gray-100 border border-gray-300 rounded-lg shadow-xl">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-sm text-indigo-600">Total Peminjaman</span>
                        </div>
                        <div class="mt-6">
                            <div class="flex flex-col">
                                <div class="flex items-end">
                                    <span class="text-2xl 2xl:text-3xl font-bold">{{ $totalPeminjaman }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Buku yang Sedang Dipinjam -->
                    <div class="px-6 py-6 bg-gray-100 border border-gray-300 rounded-lg shadow-xl">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-sm text-green-600">Buku yang Sedang Dipinjam</span>
                        </div>
                        <div class="mt-6">
                            <div class="flex flex-col">
                                <div class="flex items-end">
                                    <span class="text-2xl 2xl:text-3xl font-bold">{{ $bukuSedangDipinjam }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Keterlambatan Pengembalian -->
                    <div class="px-6 py-6 bg-gray-100 border border-gray-300 rounded-lg shadow-xl">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-sm text-purple-600">Keterlambatan Pengembalian</span>
                        </div>
                        <div class="mt-6">
                            <div class="flex flex-col">
                                <div class="flex items-end">
                                    <span class="text-2xl 2xl:text-3xl font-bold">{{ $overdueReturns }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection