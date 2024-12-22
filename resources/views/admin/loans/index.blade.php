@extends('admin.layouts.app')

@section('title', $title)

@section('content')
<div class="content ml-12 transform ease-in-out duration-500 pt-20 px-2 md:px-5 pb-4">
    <x-breadcrumb :breadcrumbs="$breadcrumbs"></x-breadcrumb>
    <div class="p-6 max-w-6xl mx-auto bg-white rounded-lg shadow-md my-10">

        {{-- Massage --}}
        @if (session()->has('success'))
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
            <p>{{ session('success')}}</p>
        </div>
        @endif
        <!-- Header -->
        <div class="sm:flex items-center justify-between mb-4">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">Daftar Peminjaman Buku</h2>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.books.create') }}">
                    <button class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-500">
                        Tambah Peminjam
                    </button>
                </a>
            </div>
        </div>

        <div class="overflow-x-auto mt-6">
            <table class="min-w-full divide-y divide-gray-200 bg-white">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            No
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nama Peminjam
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Judul Buku
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal Pengajuan
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal Pengembalian
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($loans as $loan)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $loan->user->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $loan->book->title }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $loan->loan_date ? $loan->loan_date->format('d M Y') : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $loan->return_date ? $loan->return_date->format('d M Y') : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if ($loan->status === 'borrowed')
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Dipinjam
                            </span>
                            @elseif ($loan->status === 'returned')
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Dikembalikan
                            </span>
                            @elseif ($loan->status === 'overdue')
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Terlambat
                            </span>
                            @elseif($loan->status === 'pending')
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                Pending
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('admin.loans.show', $loan->id) }}"
                                class="text-blue-600 hover:text-blue-900">
                                Manage
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>




        <!-- Book Table -->
        {{-- <div class="overflow-x-auto mb-4">
            <table class="min-w-full bg-white">
                <thead class="text-gray-700">
                    <tr class="border-b">
                        <th class="text-left py-3 px-6 font-semibold text-gray-600">No</th>
                        <th class="text-left py-3 px-6 font-semibold text-gray-600">Nama Pengguna</th>
                        <th class="text-left py-3 px-6 font-semibold text-gray-600">Judul Buku</th>
                        <th class="text-left py-3 px-6 font-semibold text-gray-600">Tanggal Peminjaman</th>
                        <th class="text-left py-3 px-6 font-semibold text-gray-600">Tanggal Pengembalian</th>
                        <th class="text-left py-3 px-6 font-semibold text-gray-600">Status</th>
                        <th class="text-left py-3 px-6 font-semibold text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <!-- Example User Row -->
                    @forelse ($loans as $loan)
                    <tr class="border-b">
                        <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                        <td class="py-4 px-6">{{ $loan->user->name }}</td>
                        <td class="py-4 px-6">{{ $loan->book->title }}</td>
                        <td class="py-4 px-6">{{ $loan->loan_date }}</td>
                        <td class="py-4 px-6">{{ $loan->return_date }}</td>
                        <div class="p-4 bg-white border rounded-lg shadow-md mb-4">
                            <h3 class="text-xl font-semibold text-gray-800">{{ $loan->book->title }} - {{
                                $loan->user->name }}</h3>
                            <p class="text-gray-600">Status:
                                <span class="font-semibold text-blue-500">{{ $loan->status }}</span>
                            </p>

                            <div class="mt-4 flex space-x-4">
                                <!-- Setujui Button -->
                                <form action="{{ route('admin.loans.approve', $loan->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400">
                                        Setujui
                                    </button>
                                </form>

                                <!-- Tolak Button -->
                                <form action="{{ route('admin.loans.reject', $loan->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400">
                                        Tolak
                                    </button>
                                </form>
                            </div>
                        </div>
                        <td class="py-4 px-6">
                            @if($loan->status == 'borrowed')
                            <span class="text-yellow-500">Dipinjam</span>
                            @elseif($loan->status == 'dikembalikan')
                            <span class="text-green-500">Dikembalikan</span>
                            @else
                            <span class="text-red-500">Terlambat</span>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            @if($loan->status == 'borrowed')
                            <form action="{{ route('admin.loans.return', $loan->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-blue-500 hover:text-blue-700">Kembalikan</button>
                            </form>
                            @endif
                        </td>
                        {{-- <td class="py-4 px-10">
                            <div class="flex space-x-2">
                                <!-- Manage Button -->
                                <div class="relative before:content-[attr(data-tip)] before:absolute before:px-2 before:py-1 before:left-1/2 before:-top-3 before:w-max before:max-w-xs before:-translate-x-1/2 before:-translate-y-full before:bg-gray-700 before:text-white before:rounded-md before:opacity-0 before:transition-all after:absolute after:left-1/2 after:-top-3 after:h-0 after:w-0 after:-translate-x-1/2 after:border-8 after:border-t-gray-700 after:border-l-transparent after:border-b-transparent after:border-r-transparent after:opacity-0 after:transition-all hover:before:opacity-100 hover:after:opacity-100"
                                    data-tip="Manage Peminjam">
                                    <a href="{{ route('admin.books.show', $loan->id) }}"
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
                                    data-tip="Edit Peminjam">
                                    <a href="{{ route('admin.loans.edit', $loan->id) }}"
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
                                <form action="{{ route('admin.loans.destroy', $loan->id) }}" method="POST"
                                    class="inline-block ml-2">
                                    @csrf
                                    @method('DELETE')
                                    <div class="relative before:content-[attr(data-tip)] before:absolute before:px-2 before:py-1 before:left-1/2 before:-top-3 before:w-max before:max-w-xs before:-translate-x-1/2 before:-translate-y-full before:bg-gray-700 before:text-white before:rounded-md before:opacity-0 before:transition-all after:absolute after:left-1/2 after:-top-3 after:h-0 after:w-0 after:-translate-x-1/2 after:border-8 after:border-t-gray-700 after:border-l-transparent after:border-b-transparent after:border-r-transparent after:opacity-0 after:transition-all hover:before:opacity-100 hover:after:opacity-100"
                                        data-tip="Delete Peminjam">
                                        <button type="submit"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus buku {{ $loan->title }} ini?')"
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
                    </tr>
                    @empty
                    <tr class="border-b">
                        <td class="py-4 px-6 text-red-500">Data Peminjaman tidak ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div> --}}
        <div>
            {{ $loans->links() }}
        </div>
    </div>
</div>
@endsection