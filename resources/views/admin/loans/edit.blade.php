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


        <div class="p-6">
            <table class="mb-4 tabel-fixed">
                <thead>
                    <tr>
                        <th class="text-left text-lg font-semibold text-gray-900 tracking-wider">Kelola
                            Peminjaman Buku</th>
                        </th>
                        <th class="px-2 text-left text-lg font-semibold text-gray-900 tracking-wider">:</th>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <tr>
                        <td>Judul Buku</td>
                        <td class="px-2">:</td>
                        <td><span class="font-semibold">{{ $loan->book->title }}</span></td>
                    </tr>
                    <tr>
                        <td>Nama Peminjam</td>
                        <td class="px-2">:</td>
                        <td><span class="font-semibold">{{ $loan->user->name }}</span></td>
                    </tr>
                    <tr>
                        <td>Durasi Peminjaman</td>
                        <td class="px-2">:</td>
                        <td><span class="font-semibold">{{ $loan->loan_duration }} Hari</span></td>
                    </tr>
                </tbody>
            </table>

            <form action="{{ route('admin.loans.update', $loan->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="mb-4">
                    <label for="loan_date" class="block text-sm font-medium text-gray-700">Tanggal
                        Pinjam</label>
                    <input type="date" id="loan_date" name="loan_date"
                        value="{{ old('loan_date', $loan->loan_date ? $loan->loan_date->format('Y-m-d') : '') }}"
                        class="mt-1 p-2 w-full border border-gray-300 rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="return_date" class="block text-sm font-medium text-gray-700">Tanggal
                        Pengembalian</label>
                    <input type="date" id="return_date" name="return_date"
                        value="{{ old('return_date', $loan->return_date ? $loan->return_date->format('Y-m-d') : now()->addDays($loan->loan_duration)->format('Y-m-d')) }}"
                        class="mt-1 p-2 w-full border border-gray-300 rounded-md" required>
                    {{-- <input type="text" id="return_date" name="return_date"
                        value="{{ now()->addDays($loan->duration)->format('d M Y') }}" readonly
                        class="mt-1 p-2 w-full border border-gray-300 rounded-md bg-gray-100"> --}}
                </div>
                {{-- Tombol Persetujuan dan Penolakan --}}
                <div class="flex items-center space-x-2">
                    {{-- Tombol Approve --}}
                    <button type="submit" name="action" value="approve"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md">
                        Approve
                    </button>

                    {{-- Tombol Reject --}}
                    <button type="submit" name="action" value="reject"
                        class="bg-red-600 hover:bg-red-500 text-white px-4 py-2 rounded-md">
                        Reject
                    </button>

                </div>
            </form>
            {{-- <form action="{{ route('admin.loans.destroy', $loan->id) }}" method="POST" class="inline-block mt-2">
                @csrf
                @method('DELETE')
                <button type="submit"
                    onclick="return confirm('Apakah Anda yakin ingin menghapus data peminjaman buku {{ $loan->book->title }} ini?')"
                    class="text-white px-4 py-2 rounded-md bg-red-600 hover:bg-red-500">
                    Hapus Data
                </button>
            </form> --}}
        </div>
    </div>
</div>
@endsection