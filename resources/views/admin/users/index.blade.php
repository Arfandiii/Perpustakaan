@extends('admin.layouts.app')

@section('title', $title)

@section('content')
<div class="content ml-12 transform ease-in-out duration-500 pt-20 px-2 md:px-5 pb-4">
    <x-breadcrumb :breadcrumbs="$breadcrumbs"></x-breadcrumb>
    <div class="p-6 max-w-7xl mx-auto bg-white rounded-lg shadow-md my-10">
        <div class="relative mb-4">
            <form action="{{ route('admin.users.search') }}" method="GET">
                <input type="search"
                    class="px-3 py-2 bg-white placeholder:text-neutral-500 border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-indigo-500 focus:ring-indigo-500 block w-full rounded-md sm:text-sm focus:ring-1"
                    placeholder="Search" aria-label="Search" id="search" name="search" value="{{ request('search') }}"
                    autocomplete="off" />
            </form>
        </div>

        {{-- Massage --}}
        @if (session()->has('success'))
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
            <p>{{ session('success')}}</p>
        </div>
        @endif
        @if(session('info'))
        <div class="bg-yellow-500 text-white p-3 rounded mb-4">
            {{ session('info') }}
        </div>
        @endif
        @if (session()->has('error'))
        <div class="p-3 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
            <p>{{ session('error')}}</p>
        </div>
        @endif
        <!-- Header -->
        <div class="sm:flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-900">Daftar Pengguna</h2>
            <div class="mt-4">
                <a href="{{ route('admin.users.create') }}">
                    <button class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-500">
                        Tambah pengguna
                    </button>
                </a>
            </div>
        </div>



        <!-- User Table -->
        <div class="overflow-x-auto mb-4">
            <table class="min-w-full bg-white">
                <thead class="text-gray-700">
                    <tr class="border-b">
                        <th class="text-left py-4 font-semibold text-gray-600">Name</th>
                        <th class="text-left py-4 font-semibold text-gray-600">Kelas</th>
                        <th class="text-left py-4 font-semibold text-gray-600">Email</th>
                        <th class="text-left py-4 font-semibold text-gray-600">No Hp</th>
                        <th class="text-left py-4 font-semibold text-gray-600">Status</th>
                        <th class="text-left py-4 font-semibold text-gray-600">Terakhir Login</th>
                        <th class="text-left py-4 font-semibold text-gray-600">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <!-- Example User Row -->

                    @forelse ($users as $user)
                    @if ($user->role === 'user')
                    <tr class="border-b">
                        <td class="py-4">{{ $user->name }}</td>
                        <td class="py-4">{{ $user->eduLevel->name ?? 'N/A' }} ({{
                            $user->eduLevel->description ?? '' }})</td>
                        <td class="py-4">{{ $user->email }}</td>
                        <td class="py-4">{{ $user->phone ?? 'N/A'}}</td>
                        <td class="py-4">
                            @if ($user->isEmailVerified())
                            <span class="text-green-500 font-normal">Verified</span>
                            @else
                            <span class="text-red-500 font-normal">Unverified</span>
                            <form action="{{ route('admin.users.verify', $user->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-1 px-4 rounded">
                                    Verify
                                </button>
                            </form>
                            @endif
                        </td>
                        <td class="py-4">{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Belum pernah
                            login' }}</td>
                        <td class="py-4">
                            <div class="flex space-x-2">
                                <!-- Manage Button -->
                                <div class="relative before:content-[attr(data-tip)] before:absolute before:px-2 before:py-1 before:left-1/2 before:-top-3 before:w-max before:max-w-xs before:-translate-x-1/2 before:-translate-y-full before:bg-gray-700 before:text-white before:rounded-md before:opacity-0 before:transition-all after:absolute after:left-1/2 after:-top-3 after:h-0 after:w-0 after:-translate-x-1/2 after:border-8 after:border-t-gray-700 after:border-l-transparent after:border-b-transparent after:border-r-transparent after:opacity-0 after:transition-all hover:before:opacity-100 hover:after:opacity-100"
                                    data-tip="Manage User">
                                    <a href="{{ route('admin.users.show', $user->id) }}"
                                        class="flex items-center justify-center w-8 h-8 text-white transition-colors duration-150 rounded-full bg-blue-600 hover:bg-blue-500">
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
                                    data-tip="Edit User">
                                    <a href="{{ route('admin.users.edit', $user->id) }}"
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
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                    class="inline-block ml-2">
                                    @csrf
                                    @method('DELETE')
                                    <div class="relative before:content-[attr(data-tip)] before:absolute before:px-2 before:py-1 before:left-1/2 before:-top-3 before:w-max before:max-w-xs before:-translate-x-1/2 before:-translate-y-full before:bg-gray-700 before:text-white before:rounded-md before:opacity-0 before:transition-all after:absolute after:left-1/2 after:-top-3 after:h-0 after:w-0 after:-translate-x-1/2 after:border-8 after:border-t-gray-700 after:border-l-transparent after:border-b-transparent after:border-r-transparent after:opacity-0 after:transition-all hover:before:opacity-100 hover:after:opacity-100"
                                        data-tip="Delete User">
                                        <button type="submit"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna {{ $user->name }} ini?')"
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
                    @endif
                    @empty
                    <tr class="border-b">
                        <td class="py-4 px-6 text-red-500">User tidak ditemukan.</td>{{--{{ $message }} --}}
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div>
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection