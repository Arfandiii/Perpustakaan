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
            <h2 class="text-lg font-semibold text-gray-900">Daftar Peminjaman Buku</h2>
        </div>

        <!-- Filter Status -->
        <form action="{{ route('admin.loans.index') }}" method="GET" class="mb-4 sm:flex justify-between">
            <div class="mb-4 sm:mb-0">
                <label for="status" class="mr-2">Filter Status:</label>
                <select name="status" id="status" class="border rounded px-3 py-2" onchange="this.form.submit()">
                    <option value="" {{ request('status')=='' ? 'selected' : '' }}>Semua</option>
                    <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status')=='approved' ? 'selected' : '' }}>Disetujui</option>
                    <option value="rejected" {{ request('status')=='rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <div>
                <label for="search" class="mr-2">Pencarian:</label>
                <input type="text" name="search" id="search" class="border rounded px-3 py-2 w-64"
                    value="{{ request('search') }}" placeholder="Nama Peminjam atau Judul Buku" />

                <button type="submit"
                    class="ml-4 bg-indigo-500 text-white px-3 py-1 rounded hover:bg-indigo-600 inli">Cari</button>
            </div>
        </form>

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
                            Durasi Peminjaman
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
                    @forelse ($loans as $loan)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $loan->user->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ Str::limit($loan->book->title, 40) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $loan->loan_date ? $loan->loan_date->format('d M Y') : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $loan->loan_duration ?: '-' }} Hari
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $loan->status == 'pending' ? 'bg-gray-100 text-gray-800' : ($loan->status == 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($loan->status) }}
                            </span>
                        </td>
                        {{-- <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('admin.loans.edit', $loan->id) }}"
                                class="text-blue-600 hover:text-blue-900 hover:underline">
                                Atur Peminjaman
                            </a>
                        </td> --}}
                        {{-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            @if ($loan->status == 'pending')
                            <form action="{{ route('admin.loans.approve', $loan->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit"
                                    class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
                                    Setujui
                                </button>
                            </form>
                            <form action="{{ route('admin.loans.reject', $loan->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                    Tolak
                                </button>
                            </form>
                            @elseif ($loan->status == 'approved')
                            <span class="text-green-600 font-bold">Disetujui</span>
                            @elseif ($loan->status == 'rejected')
                            <span class="text-red-600 font-bold">Ditolak</span>
                            @endif
                        </td> --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('admin.loans.show', $loan->id) }}"
                                class="text-blue-600 hover:text-blue-900">
                                Manage
                            </a>
                        </td>
                    </tr>@empty
                    <tr class="border-b">
                        <td class="py-4 px-6 text-red-500" colspan="7">Data tidak ditemukan.</td>{{--{{ $message }} --}}
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div>
            {{ $loans->links() }}
        </div>
    </div>
</div>
@endsection

{{-- @extends('admin.layouts.app')

@section('title', 'Manajemen Peminjaman')

@section('content')
<div class="container mx-auto py-10 px-4">
    <h1 class="text-2xl font-bold mb-6">Manajemen Peminjaman</h1>

    <!-- Filter Status -->
    <form action="{{ route('admin.loans.index') }}" method="GET" class="mb-4">
        <label for="status" class="mr-2">Filter Status:</label>
        <select name="status" id="status" class="border rounded px-3 py-2" onchange="this.form.submit()">
            <option value="" {{ request('status')=='' ? 'selected' : '' }}>Semua</option>
            <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Pending</option>
            <option value="approved" {{ request('status')=='approved' ? 'selected' : '' }}>Disetujui</option>
            <option value="rejected" {{ request('status')=='rejected' ? 'selected' : '' }}>Ditolak</option>
            <option value="returned" {{ request('status')=='returned' ? 'selected' : '' }}>Dikembalikan</option>
        </select>
    </form>

    <!-- Daftar Peminjaman -->
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-lg font-bold mb-4">Daftar Peminjaman</h2>
        <table class="w-full border-collapse">
            <thead>
                <tr>
                    <th class="border px-4 py-2">No</th>
                    <th class="border px-4 py-2">Nama User</th>
                    <th class="border px-4 py-2">Judul Buku</th>
                    <th class="border px-4 py-2">Tanggal Pinjam</th>
                    <th class="border px-4 py-2">Estimasi Pengembalian</th>
                    <th class="border px-4 py-2">Status</th>
                    <th class="border px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($loans as $loan)
                <tr>
                    <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                    <td class="border px-4 py-2">{{ $loan->user->name }}</td>
                    <td class="border px-4 py-2">{{ $loan->book->title }}</td>
                    <td class="border px-4 py-2">{{ $loan->loan_date }}</td>
                    <td class="border px-4 py-2">{{ $loan->return_date }}</td>
                    <td class="border px-4 py-2">
                        <span
                            class="px-2 py-1 rounded-full text-white {{ $loan->status == 'pending' ? 'bg-yellow-500' : ($loan->status == 'approved' ? 'bg-green-500' : 'bg-red-500') }}">
                            {{ ucfirst($loan->status) }}
                        </span>
                    </td>
                    <td class="border px-4 py-2">
                        @if ($loan->status == 'pending')
                        <form action="{{ route('admin.loans.approve', $loan->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
                                Setujui
                            </button>
                        </form>
                        <form action="{{ route('admin.loans.reject', $loan->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                Tolak
                            </button>
                        </form>
                        @elseif ($loan->status == 'approved')
                        <span class="text-green-600 font-bold">Disetujui</span>
                        @elseif ($loan->status == 'rejected')
                        <span class="text-red-600 font-bold">Ditolak</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="border px-4 py-2 text-center">Tidak ada peminjaman yang ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $loans->links() }}
        </div>
    </div>
</div>
@endsection --}}