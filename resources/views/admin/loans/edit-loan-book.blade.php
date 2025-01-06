@extends('admin.layouts.app')

@section('title', $title)

@section('content')
<div class="content ml-12 transform ease-in-out duration-500 pt-20 px-2 md:px-5 pb-4">
    <x-breadcrumb :breadcrumbs="$breadcrumbs"></x-breadcrumb>
    <div class="p-6 max-w-6xl mx-auto bg-white rounded-lg shadow-md my-10">
        {{-- Message --}}
        @if (session()->has('success'))
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
            <p>{{ session('success') }}</p>
        </div>
        @endif

        <div class="p-6">
            <form action="{{ route('admin.loans.updateLoanBook', $loanBook->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <table class="mb-4 w-full table-fixed">
                    <thead>
                        <tr>
                            <th colspan="4" class="text-left text-lg font-semibold text-gray-900 tracking-wider">
                                Edit Peminjaman Buku
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        <tr>
                            <td class="py-2 font-medium text-gray-700">Nama Peminjam</td>
                            <td class="py-2">{{ $loanBook->loan->user->name }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 font-medium text-gray-700">Judul Buku</td>
                            <td class="py-2">{{ $loanBook->loan->book->title }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 font-medium text-gray-700">Tanggal Peminjaman</td>
                            <td class="py-2">{{ $loanBook->created_at->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 font-medium text-gray-700">Tanggal Pengembalian</td>
                            {{-- <td class="py-2">{{ $loanBook->return_date ?
                                \Carbon\Carbon::parse($loanBook->return_date)->format('d M Y') : '-'}}</td> --}}
                            <td class="py-2">
                                <input type="date" name="return_date"
                                    value="{{ old('return_date', $loanBook->return_date ? \Carbon\Carbon::parse($loanBook->return_date)->format('Y-m-d') : '-') }}"
                                    class="mt-1 p-2 w-full border border-gray-300 rounded-md">
                            </td>
                        </tr>
                        <tr>
                            <td class="py-2 font-medium text-gray-700">Status</td>
                            <td class="py-2">
                                <select name="status" class="mt-1 p-2 w-full border border-gray-300 rounded-md">
                                    <option value="borrowed" {{ $loanBook->status === 'borrowed' ? 'selected' : '' }}>
                                        Dipinjam
                                    </option>
                                    <option value="returned" {{ $loanBook->status === 'returned' ? 'selected' : '' }}>
                                        Dikembalikan
                                    </option>
                                    <option value="overdue" {{ $loanBook->status === 'overdue' ? 'selected' : '' }}>
                                        Terlambat
                                    </option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="flex justify-end space-x-2">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.loans.index') }}"
                        class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection