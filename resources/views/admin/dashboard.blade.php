@extends('admin.layouts.app')

@section('title', $title)

@section('content')
<!-- CONTENT -->
<div class="content ml-12 transform ease-in-out duration-500 pt-20 px-2 md:px-5 pb-4">
    <x-breadcrumb :breadcrumbs="$breadcrumbs"></x-breadcrumb>
    <div class="flex flex-wrap my-5 -mx-2">
        <div class="w-full md:w-1/2 lg:w-1/3 p-2">
            <a href="{{ route('admin.users.index') }}">
                <div
                    class="flex items-center flex-row w-full hover:shadow hover:bg-indigo-500 bg-indigo-600 rounded-md p-3">
                    <div
                        class="flex text-indigo-600 items-center bg-white p-2 rounded-md flex-none w-8 h-8 md:w-12 md:h-12 ">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="object-scale-down transition duration-500">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>
                    </div>
                    <div class="flex flex-col justify-around flex-grow ml-5 text-white">
                        <div class="text-xs whitespace-nowrap">
                            Total Pengguna
                        </div>
                        <div class="">
                            {{ $totalUsers }}
                        </div>
                    </div>
                    <div class=" flex items-center flex-none text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5}
                            stroke="currentColor" class="w-6 h-6">
                            <path strokeLinecap="round" strokeLinejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>

                    </div>
                </div>
            </a>
        </div>
        <div class="w-full md:w-1/2 lg:w-1/3 p-2">
            <a href="{{ route('admin.books.index') }}">
                <div
                    class="flex items-center flex-row w-full hover:shadow hover:bg-indigo-500 bg-indigo-600 rounded-md p-3">
                    <div
                        class="flex text-indigo-600 items-center bg-white p-2 rounded-md flex-none w-8 h-8 md:w-12 md:h-12 ">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="object-scale-down transition duration-500">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                        </svg>
                    </div>
                    <div class="flex flex-col justify-around flex-grow ml-5 text-white">
                        <div class="text-xs whitespace-nowrap">
                            Total Buku
                        </div>
                        <div class="">
                            {{ $totalBooks }}
                        </div>
                    </div>
                    <div class=" flex items-center flex-none text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5}
                            stroke="currentColor" class="w-6 h-6">
                            <path strokeLinecap="round" strokeLinejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </div>
                </div>
            </a>
        </div>

        <div class="w-full md:w-1/2 lg:w-1/3 p-2">
            <a href="{{ route('admin.loans.index') }}">
                <div
                    class="flex items-center flex-row w-full hover:shadow hover:bg-indigo-500 bg-indigo-600 rounded-md p-3">
                    <div
                        class="flex text-indigo-600 items-center bg-white p-2 rounded-md flex-none w-8 h-8 md:w-12 md:h-12 ">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="object-scale-down transition duration-500">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M7.5 7.5h-.75A2.25 2.25 0 0 0 4.5 9.75v7.5a2.25 2.25 0 0 0 2.25 2.25h7.5a2.25 2.25 0 0 0 2.25-2.25v-7.5a2.25 2.25 0 0 0-2.25-2.25h-.75m-6 3.75 3 3m0 0 3-3m-3 3V1.5m6 9h.75a2.25 2.25 0 0 1 2.25 2.25v7.5a2.25 2.25 0 0 1-2.25 2.25h-7.5a2.25 2.25 0 0 1-2.25-2.25v-.75" />
                        </svg>
                    </div>
                    <div class="flex flex-col justify-around flex-grow ml-5 text-white">
                        <div class="text-xs whitespace-nowrap">
                            Buku yang Dipinjam
                        </div>
                        <div class="">
                            {{ $totalLoans }}
                        </div>
                    </div>
                    <div class=" flex items-center flex-none text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5}
                            stroke="currentColor" class="w-6 h-6">
                            <path strokeLinecap="round" strokeLinejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>

                    </div>
                </div>
            </a>
        </div>
        <div class="w-full md:w-1/2 lg:w-1/3 p-2">
            <a href="{{ route('admin.books.index') }}">
                <div
                    class="flex items-center flex-row w-full hover:shadow hover:bg-indigo-500 bg-indigo-600 rounded-md p-3">
                    <div
                        class="flex text-indigo-600 items-center bg-white p-2 rounded-md flex-none w-8 h-8 md:w-12 md:h-12 ">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="object-scale-down transition duration-500">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <div class="flex flex-col justify-around flex-grow ml-5 text-white">
                        <div class="text-xs whitespace-nowrap">
                            Buku Overdue
                        </div>
                        <div class="">
                            500
                        </div>
                    </div>
                    <div class=" flex items-center flex-none text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5}
                            stroke="currentColor" class="w-6 h-6">
                            <path strokeLinecap="round" strokeLinejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>

                    </div>
                </div>
            </a>
        </div>
        <div class="w-full md:w-1/2 lg:w-1/3 p-2">
            <a href="{{ route('admin.books.index') }}">
                <div
                    class="flex items-center flex-row w-full hover:shadow hover:bg-indigo-500 bg-indigo-600 rounded-md p-3">
                    <div
                        class="flex text-indigo-600 items-center bg-white p-2 rounded-md flex-none w-8 h-8 md:w-12 md:h-12 ">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="object-scale-down transition duration-500">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                        </svg>
                    </div>
                    <div class="flex flex-col justify-around flex-grow ml-5 text-white">
                        <div class="text-xs whitespace-nowrap">
                            Total Ulasan
                        </div>
                        <div class="">
                            500
                        </div>
                    </div>
                    <div class=" flex items-center flex-none text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5}
                            stroke="currentColor" class="w-6 h-6">
                            <path strokeLinecap="round" strokeLinejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>

                    </div>
                </div>
            </a>
        </div>
        <div class="w-full md:w-1/2 lg:w-1/3 p-2">
            <a href="{{ route('admin.books.index') }}">
                <div
                    class="flex items-center flex-row w-full hover:shadow hover:bg-indigo-500 bg-indigo-600 rounded-md p-3">
                    <div
                        class="flex text-indigo-600 items-center bg-white p-2 rounded-md flex-none w-8 h-8 md:w-12 md:h-12 ">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="object-scale-down transition duration-500">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5m.75-9 3-3 2.148 2.148A12.061 12.061 0 0 1 16.5 7.605" />
                        </svg>
                    </div>
                    <div class="flex flex-col justify-around flex-grow ml-5 text-white">
                        <div class="text-xs whitespace-nowrap">
                            Pengguna Aktif Hari Ini
                        </div>
                        <div class="">
                            500
                        </div>
                    </div>
                    <div class=" flex items-center flex-none text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5}
                            stroke="currentColor" class="w-6 h-6">
                            <path strokeLinecap="round" strokeLinejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>

                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="flex flex-wrap my-5 -mx-2">
        <!-- Statistik Peminjaman Buku -->
        <div class="w-full md:w-1/2 lg:w-1/3 p-2">
            <div class="bg-white rounded-lg shadow p-3">
                <h2 class="text-lg font-semibold text-gray-700 mb-2">Peminjaman Buku</h2>
                <canvas id="borrowChart" width="400" height="200"></canvas>
            </div>
        </div>

        <!-- Statistik Kategori Buku -->
        <div class="w-full md:w-1/2 lg:w-1/3 p-2">
            <div class="bg-white rounded-lg shadow p-3">
                <h2 class="text-lg font-semibold text-gray-700 mb-2">Kategori Buku Populer</h2>
                <canvas id="categoryChart" width="400" height="200"></canvas>
            </div>
        </div>

        <!-- Aktivitas Pengguna -->
        <div class="w-full md:w-1/2 lg:w-1/3 p-2">
            <div class="bg-white rounded-lg shadow p-3">
                <h2 class="text-lg font-semibold text-gray-700 mb-2">Aktivitas Pengguna</h2>
                <canvas id="userActivityChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>



    <div class="bg-white shadow rounded-lg p-4 mt-4">
        <h3 class="text-lg font-bold mb-4">Aktivitas Terbaru</h3>
        <ul>
            <!-- Item 1 -->
            <li class="flex items-center justify-between py-2 border-b">
                <div class="flex items-center">
                    <img class="w-10 h-10 rounded-full" src="https://via.placeholder.com/40" alt="User Avatar">
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-800">John Doe</p>
                        <p class="text-xs text-gray-500">Mendaftar 10 menit yang lalu</p>
                    </div>
                </div>
                <span class="text-xs bg-green-100 text-green-600 px-2 py-1 rounded">Baru</span>
            </li>
            <!-- Item 2 -->
            <li class="flex items-center justify-between py-2 border-b">
                <div class="flex items-center">
                    <img class="w-10 h-10 rounded-full" src="https://via.placeholder.com/40" alt="Book Cover">
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-800">"Atomic Habits"</p>
                        <p class="text-xs text-gray-500">Dipinjam oleh Jane Smith 1 jam yang lalu</p>
                    </div>
                </div>
                <span class="text-xs bg-blue-100 text-blue-600 px-2 py-1 rounded">Peminjaman</span>
            </li>
            <!-- Item 3 -->
            <li class="flex items-center justify-between py-2">
                <div class="flex items-center">
                    <img class="w-10 h-10 rounded-full" src="https://via.placeholder.com/40" alt="User Avatar">
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-800">Michael Brown</p>
                        <p class="text-xs text-gray-500">Memberikan review pada "The Power of Habit"</p>
                    </div>
                </div>
                <span class="text-xs bg-yellow-100 text-yellow-600 px-2 py-1 rounded">Review</span>
            </li>
        </ul>
    </div>
</div>
@endsection

{{--
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
</head>

<body>
    admin page
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
    </form>
</body>

</html> --}}