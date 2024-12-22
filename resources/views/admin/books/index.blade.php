@extends('admin.layouts.app')

@section('title', $title)

@section('content')
<div class="content ml-12 transform ease-in-out duration-500 pt-20 px-2 md:px-5 pb-4">
    <x-breadcrumb :breadcrumbs="$breadcrumbs"></x-breadcrumb>
    <div class="p-6 max-w-6xl mx-auto bg-white rounded-lg shadow-md my-10">
        <div class="relative mb-4">
            <form action="{{ route('admin.books.search') }}" method="GET">
                <div class="lg:flex mb-4 items-center">
                    <!-- Dropdown Filter -->
                    <select name="filter" id="filter"
                        class="lg:mb-0 mb-2 lg:rounded-e-none rounded lg:w-28 w-full px-3 py-2 bg-gray-50 border border-slate-300 text-gray-900 text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 block p-2.5 dark:bg-gray-700 dark:border-indigo-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="Semua" {{ request('filter')=='Semua' ? 'selected' : '' }} selected>Semua
                        </option>
                        <option value="Judul" {{ request('filter')=='Judul' ? 'selected' : '' }}>Judul</option>
                        <option value="Penulis" {{ request('filter')=='Penulis' ? 'selected' : '' }}>Penulis</option>
                        <option value="Penerbit" {{ request('filter')=='Penerbit' ? 'selected' : '' }}>
                            Penerbit
                        </option>
                    </select>
                    <!-- Search Input -->
                    <div class="relative w-full items-center text-center">
                        <input aria-label="Search" id="search" name="search" autocomplete="off" type="search"
                            class="lg:rounded-s-none rounded px-3 py-2 placeholder:text-neutral-500 shadow-sm placeholder-slate-400 focus:outline-none sm:text-sm focus:ring-1 block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-e-lg border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-s-gray-700  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-indigo-500"
                            placeholder="Cari Judul Buku, Author, Penerbit..." value="{{ request('search') }}" />
                        <!-- Search Button -->
                        <button type="submit"
                            class="bg-indigo-600 text-white px-4 py-2 rounded-e hover:bg-indigo-500 absolute top-0 end-0 h-full p-2.5 text-sm font-medium border border-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-300 dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-800">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                            <span class="sr-only">Search</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        {{-- Massage --}}
        @if (session()->has('success'))
        <div class="p-3 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
            <p>{{ session('success')}}</p>
        </div>
        @endif
        @if (session()->has('error'))
        <div class="p-3 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
            <p>{{ session('error')}}</p>
        </div>
        @endif
        <!-- Header -->
        <div class="sm:flex items-center justify-between mb-4">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">Daftar Buku</h2>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.books.create') }}">
                    <button class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-500">
                        Tambah Buku
                    </button>
                </a>
            </div>
        </div>
        <!-- Kondisi: hanya tampilkan informasi Confusion Matrix jika pencarian dilakukan -->
        @if(request()->has('search'))
        <div class="my-4 w-full flex justify-end">
            <a href="{{ route('admin.books.index') }}">
                <button class="bg-red-400 text-white px-4 py-2 rounded-md hover:bg-red-300">
                    Hapus pencarian
                </button>
            </a>
        </div>
        @if (count($books) > 0)

        <div class="mb-4 flex space-x-4 p-4">
            <div class="p-4 rounded-lg bg-gray-100 w-1/5">
                <h3>Confusion Matrix</h3>
                <p>True Positive (TP): </p>{{-- {{ $tp }} --}}
                <p>False Positive (FP): </p>{{-- {{ $fp }} --}}
                <p>True Negative (TN): </p>{{-- {{ $tn }} --}}
                <p>False Negative (FN): </p>{{-- {{ $fn }} --}}
            </div>
            <div class="p-4 rounded-lg bg-gray-100 w-1/5">
                <h3>Hasil Lainnya</h3>
                <p>Accuracy: {{-- {{ number_format($accuracy * 100, 2) }} --}}%</p>
                <p>Accuracy: {{-- {{ number_format($accuracy * 100, 2) }} --}}%</p>
                <p>Accuracy: {{-- {{ number_format($accuracy * 100, 2) }} --}}%</p>
            </div>
        </div>
        @endif
        @endif

        <!-- Book Table -->
        <div class="overflow-x-auto mb-4">
            <table class="min-w-full bg-white border-collapse">
                <thead class="text-gray-700">
                    <tr class="border-y">
                        <th class="text-left py-3 px-6 font-semibold text-gray-600">No</th>
                        <th class="text-left py-3 px-6 font-semibold text-gray-600">Judul Buku</th>
                        <th class="text-left py-3 px-6 font-semibold text-gray-600">Penulis</th>
                        <th class="text-left py-3 px-6 font-semibold text-gray-600">Penerbit</th>
                        <th class="text-left py-3 px-6 font-semibold text-gray-600">Kategori</th>
                        <th class="text-left py-3 px-6 font-semibold text-gray-600">Stok</th>
                        <th class="text-left py-3 px-10 font-semibold text-gray-600">Aksi</th>
                        @if(request()->has('search') && count($books) > 0)
                        <th class="text-left py-3 px-6 font-semibold text-gray-600">Similarity</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <!-- Example User Row -->
                    @forelse ($books as $book)
                    <tr class="border-b">
                        <td class="py-4 px-6">{{ $loop->iteration }}</td>
                        <td class="py-4 px-6">{{ Str::limit($book->title, 60) }}</td>
                        <td class="py-4 px-6">{{ $book->author }}</td>
                        <td class="py-4 px-6">{{ $book->publisher }}</td>
                        <td class="py-4 px-6">{{ $book->category->name }}</td>
                        <td class="py-4 px-6">{{ $book->stock }}</td>
                        <td class="py-4 px-10">
                            <div class="flex space-x-2">
                                <!-- Manage Button -->
                                <div class="relative before:content-[attr(data-tip)] before:absolute before:px-2 before:py-1 before:left-1/2 before:-top-3 before:w-max before:max-w-xs before:-translate-x-1/2 before:-translate-y-full before:bg-gray-700 before:text-white before:rounded-md before:opacity-0 before:transition-all after:absolute after:left-1/2 after:-top-3 after:h-0 after:w-0 after:-translate-x-1/2 after:border-8 after:border-t-gray-700 after:border-l-transparent after:border-b-transparent after:border-r-transparent after:opacity-0 after:transition-all hover:before:opacity-100 hover:after:opacity-100"
                                    data-tip="Manage Buku">
                                    <a href="{{ route('admin.books.show', $book->slug) }}"
                                        class="flex items-center justify-center w-8 h-8 text-white transition-colors duration-150 rounded-full bg-indigo-600 hover:bg-blue-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                            class="size-5 fill-current">
                                            <path fill-rule="evenodd"
                                                d="M1.5 5.625c0-1.036.84-1.875 1.875-1.875h17.25c1.035 0 1.875.84 1.875 1.875v12.75c0 1.035-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 0 1 1.5 18.375V5.625ZM21 9.375A.375.375 0 0 0 20.625 9h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 0 0 .375-.375v-1.5Zm0 3.75a.375.375 0 0 0-.375-.375h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 0 0 .375-.375v-1.5Zm0 3.75a.375.375 0 0 0-.375-.375h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 0 0 .375-.375v-1.5ZM10.875 18.75a.375.375 0 0 0 .375-.375v-1.5a.375.375 0 0 0-.375-.375h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h7.5ZM3.375 15h7.5a.375.375 0 0 0 .375-.375v-1.5a.375.375 0 0 0-.375-.375h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375Zm0-3.75h7.5a.375.375 0 0 0 .375-.375v-1.5A.375.375 0 0 0 10.875 9h-7.5A.375.375 0 0 0 3 9.375v1.5c0 .207.168.375.375.375Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                </div>
                                <!-- Edit Button -->
                                <div class="relative before:content-[attr(data-tip)] before:absolute before:px-2 before:py-1 before:left-1/2 before:-top-3 before:w-max before:max-w-xs before:-translate-x-1/2 before:-translate-y-full before:bg-gray-700 before:text-white before:rounded-md before:opacity-0 before:transition-all after:absolute after:left-1/2 after:-top-3 after:h-0 after:w-0 after:-translate-x-1/2 after:border-8 after:border-t-gray-700 after:border-l-transparent after:border-b-transparent after:border-r-transparent after:opacity-0 after:transition-all hover:before:opacity-100 hover:after:opacity-100"
                                    data-tip="Edit Buku">
                                    <a href="{{ route('admin.books.edit', $book->id) }}"
                                        class="flex items-center justify-center w-8 h-8 text-white transition-colors duration-150 rounded-full bg-green-600 hover:bg-green-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                            class="size-5 fill-current">
                                            <path
                                                d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                            <path
                                                d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                                        </svg>
                                    </a>
                                </div>
                                <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST"
                                    class="inline-block ml-2">
                                    @csrf
                                    @method('DELETE')
                                    <div class="relative before:content-[attr(data-tip)] before:absolute before:px-2 before:py-1 before:left-1/2 before:-top-3 before:w-max before:max-w-xs before:-translate-x-1/2 before:-translate-y-full before:bg-gray-700 before:text-white before:rounded-md before:opacity-0 before:transition-all after:absolute after:left-1/2 after:-top-3 after:h-0 after:w-0 after:-translate-x-1/2 after:border-8 after:border-t-gray-700 after:border-l-transparent after:border-b-transparent after:border-r-transparent after:opacity-0 after:transition-all hover:before:opacity-100 hover:after:opacity-100"
                                        data-tip="Delete Buku">
                                        <button type="submit"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus buku {{ $book->title }} ini?')"
                                            class="flex items-center justify-center w-8 h-8 text-white transition-colors duration-150 rounded-full bg-red-600 hover:bg-red-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="currentColor" class="size-5 fill-current">
                                                <path fill-rule="evenodd"
                                                    d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </td>
                        @if(request()->has('search') )
                        {{-- <td class="py-4 px-6">{{ $similarity }}</td> --}}
                        @endif
                    </tr>
                    @empty
                    <tr class="border-b">
                        <td class="py-4 px-6" colspan="7">Filter <span class="font-semibold text-red-500">{{
                                request('filter')
                                }}</span>
                            dengan pencarian <span class="font-semibold text-red-500">{{ request('search') }}</span>
                            tidak
                            ditemukan, cobalah dengan filter
                            lain.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div>
            {{ $books->links() }}
        </div>
    </div>
</div>
@endsection