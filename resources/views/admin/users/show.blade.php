@extends('admin.layouts.app')

@section('title', $title)

@section('content')
<div class="content ml-12 transform ease-in-out duration-500 pt-20 px-2 md:px-5 pb-4">
    <x-breadcrumb :breadcrumbs="$breadcrumbs"></x-breadcrumb>
    <div class="p-6 max-w-6xl mx-auto bg-white rounded-lg my-10">
        <!-- Container -->
        <!-- Header -->
        <!-- User Info -->
        <div class="bg-white overflow-hidden shadow rounded-lg border">
            <div class="px-4 py-5 sm:px-6">
                <h1 class="text-2xl font-bold text-gray-800 text-center">Detail User</h1>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                <dl class="sm:divide-y sm:divide-gray-200">
                    <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Nama Lengkap :
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $user->name ?? 'N/A' }}
                        </dd>
                    </div>
                    <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Tanggal Lahir :
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $user->dob ?? 'Tanggal lahir belum diatur.' }}
                        </dd>
                    </div>
                    <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Alamat Email :
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $user->email ?? 'Email belum diatur.' }}
                        </dd>
                    </div>
                    <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            No Hp :
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $user->phone ?? 'No hp belum di atur.' }}
                        </dd>
                    </div>
                    <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Kelas :
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $user->eduLevel->name ?? 'Kelas belum dipilih' }} ({{
                            $user->eduLevel->description ?? ' ' }}).
                        </dd>
                    </div>
                    <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Status :
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            @if ($user->isEmailVerified())
                            <span class="text-green-500 font-normal">Verified</span>
                            @else
                            <span class="text-red-500 font-normal">Unverified</span>
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-6 flex justify-end space-x-2">
            <a href="{{ route('admin.users.index') }}"
                class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition">
                Kembali
            </a>
            <a href="{{ route('admin.users.edit', $user->id) }}"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                Edit
            </a>
            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>
@endsection