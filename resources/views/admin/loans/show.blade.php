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
            <table class="mb-4">
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
                    <select id="return_date" name="return_date"
                        class="mt-1 p-2 w-full border border-gray-300 rounded-md">
                        <option value="">Pilih Kelipatan Hari</option>
                        @foreach([3, 7, 10, 14] as $days)
                        <option value="{{ now()->addDays($days)->format('Y-m-d') }}" {{ $loan->return_date &&
                            $loan->return_date->isSameDay(now()->addDays($days)) ? 'selected' : '' }}>
                            {{ $days }} hari ({{ now()->addDays($days)->format('d M Y') }})
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select id="status" name="status" class="mt-1 p-2 w-full border border-gray-300 rounded-md"
                        required>
                        <option value="borrowed" {{ $loan->status === 'borrowed' ? 'selected' : '' }}>Dipinjam
                        </option>
                        <option value="returned" {{ $loan->status === 'returned' ? 'selected' : ''
                            }}>Dikembalikan
                        </option>
                        <option value="overdue" {{ $loan->status === 'overdue' ? 'selected' : '' }}>Terlambat
                        </option>
                    </select>
                </div>

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md">Simpan
                    Perubahan</button>
            </form>
        </div>
    </div>
</div>
@endsection