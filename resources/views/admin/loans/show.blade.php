@extends('admin.layouts.app')

@section('title', $title)

@section('content')
<div class="content ml-12 transform ease-in-out duration-500 pt-20 px-2 md:px-5 pb-4">
    <x-breadcrumb :breadcrumbs="$breadcrumbs"></x-breadcrumb>
    <div class="p-6 max-w-6xl mx-auto bg-white rounded-lg shadow-md my-10">

        {{-- Message --}}
        @if (session()->has('success'))
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
            <p>{{ session('success')}}</p>
        </div>
        @endif

        <div class="p-6">
            <table class="mb-4 w-full table-fixed">
                <thead>
                    <tr>
                        <th colspan="4" class="text-left text-lg font-semibold text-gray-900 tracking-wider">
                            Manage Peminjaman Buku
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <tr>
                        <td class="py-2 font-medium text-gray-700">Nama Peminjam</td>
                        <td class="py-2">{{ $loan->user->name }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 font-medium text-gray-700">Judul Buku</td>
                        <td class="py-2">{{ $loan->book->title }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 font-medium text-gray-700">Durasi Peminjaman</td>
                        <td class="py-2">{{ $loan->loan_duration }} Hari</td>
                    </tr>
                    @if (!$loanBook)
                    {{-- Kondisi jika loanBook tidak ada --}}
                    <tr>
                        <td class="py-2 font-medium text-gray-700">Tanggal Peminjaman</td>
                        <td class="py-2">{{ $loanBook ? $loanBook->created_at->format('d M Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 font-medium text-gray-700">Status</td>
                        <td class="py-2 text-gray-600">{{ $loan->status }}</td>
                    </tr>
                    @if ($loan->status === 'rejected')
                    <tr>
                        <td class="py-2 font-medium text-gray-700">
                            <a href="{{ route('admin.loans.index') }}"
                                class="bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-600">
                                Kembali
                            </a>
                        </td>
                    </tr>
                    @else
                    <tr>
                        <td class="py-2 font-medium text-gray-700">
                            <a href="{{ route('admin.loans.edit', $loan->id) }}"
                                class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                Atur Peminjaman
                            </a>
                        </td>
                    </tr>
                    @endif
                    @else
                    {{-- Kondisi jika loanBook ada --}}
                    <tr>
                        <td class="py-2 font-medium text-gray-700">Tanggal Peminjaman</td>
                        <td class="py-2">{{ $loanBook->created_at->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 font-medium text-gray-700">Tanggal Pengembalian</td>
                        <td class="py-2">{{ $loanBook->return_date ?
                            \Carbon\Carbon::parse($loanBook->return_date)->format('d M Y') : '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="py-2 font-medium text-gray-700">Status</td>
                        <td class="py-2">
                            @if ($loanBook->status === 'borrowed')
                            <span class="text-blue-600 font-semibold">Dipinjam</span>
                            @elseif ($loanBook->status === 'returned')
                            <span class="text-green-600 font-semibold">Dikembalikan</span>
                            @elseif ($loanBook->status === 'overdue')
                            <span class="text-red-600 font-semibold">Terlambat</span>
                            @else
                            <span class="text-gray-600">Pending</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="py-2 font-medium text-gray-700">
                            <a href="{{ route('admin.loans.editLoanBook', $loanBook->id) }}"
                                class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                Atur Peminjaman buku
                            </a>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection