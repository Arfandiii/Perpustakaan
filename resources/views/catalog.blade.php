@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="relative isolate overflow-hidden bg-gray-800 pb-24 sm:pb-24 w-screen">
    <div class="hidden sm:absolute sm:-top-10 sm:right-1/2 sm:-z-10 sm:mr-10 sm:block sm:transform-gpu sm:blur-3xl"
        aria-hidden="true">
        <div class="aspect-[1097/845] w-[68.5625rem] bg-gradient-to-tr from-[#ff4694] to-[#776fff] opacity-20"
            style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
        </div>
    </div>
    <div class="absolute -top-52 left-1/2 -z-10 -translate-x-1/2 transform-gpu blur-3xl sm:top-[-28rem] sm:ml-16 sm:translate-x-0 sm:transform-gpu"
        aria-hidden="true">
        <div class="aspect-[1097/845] w-[68.5625rem] bg-gradient-to-tr from-[#ff4694] to-[#776fff] opacity-20"
            style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
        </div>
    </div>
    <section class="pt-4">
        <div class="container mx-auto py-10 px-20">
            <h1 class="text-3xl font-semibold mb-6 text-white">Katalog Buku</h1>
            @if (session()->has('success'))
            <div class="p-3 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                <p>{{ session('success')}}</p>
            </div>
            @endif
            <!-- Form Pencarian -->
            <div class="mb-4">
                <form action="{{ route('searchBookUser') }}" method="GET">
                    <div class="lg:flex mb-4 items-center">
                        <!-- Dropdown Filter -->
                        <select name="filter" id="filter"
                            class="lg:mb-0 mb-2 lg:rounded-e-none rounded lg:w-28 w-full px-3 py-2 bg-gray-50 border border-slate-300 text-gray-900 text-sm focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-purple-500 block dark:bg-gray-700 dark:border-purple-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="Semua" {{ request('filter')=='Semua' ? 'selected' : '' }} selected>Semua
                            </option>
                            <option value="Judul" {{ request('filter')=='Judul' ? 'selected' : '' }}>Judul</option>
                            <option value="Penulis" {{ request('filter')=='Penulis' ? 'selected' : '' }}>Penulis
                            </option>
                            <option value="Penerbit" {{ request('filter')=='Penerbit' ? 'selected' : '' }}>
                                Penerbit
                            </option>
                        </select>
                        <!-- Search Input -->
                        <div class="relative w-full items-center text-center">
                            <input aria-label="Search" id="search" name="search" autocomplete="off" type="search"
                                class="lg:rounded-s-none rounded px-3 py-2 placeholder:text-neutral-500 shadow-sm placeholder-slate-400 focus:outline-none sm:text-sm focus:ring-1 block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-e-lg border border-gray-300 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:border-s-gray-700  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-purple-500"
                                placeholder="Cari Judul Buku, Author, Penerbit..." value="{{ request('search') }}" />
                            <!-- Search Button -->
                            <button type="submit"
                                class="bg-purple-600 text-white px-4 py-2 rounded-e hover:bg-purple-500 absolute top-0 end-0 h-full p-2.5 text-sm font-medium border border-purple-700 focus:ring-4 focus:outline-none focus:ring-purple-300 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800">
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
            @if (session()->has('error'))
            <div class="p-3 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                <p>{{ session('error')}}</p>
            </div>
            @endif
            @if (empty($results))
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-4">
                @foreach($books as $book)
                <div class="bg-white border rounded-md shadow hover:shadow p-4">
                    <img src="{{ $book->cover_image ? asset('storage/'.$book->cover_image) : asset('assets/img/default-book.png') }}"
                        alt="{{ $book->title }}" class="w-full h-48 object-cover mb-4">
                    <h2 class="font-semibold text-xl mb-2 text-gray-900 h-20">
                        <!-- Judul untuk layar kecil -->
                        <span class="block sm:hidden">{{ Str::limit($book->title, 40) }}</span>
                        <!-- Judul untuk layar lebih besar -->
                        <span class="hidden sm:block">{{ Str::limit($book->title, 50) }}</span>
                    </h2>
                    <p class="text-gray-700 text-sm mb-4 sm:h-8">Penulis: <span class="font-bold">{{
                            $book->author }}</span></p>
                    <p class="text-gray-600 text-sm lg:h-20">
                        <!-- Deskripsi untuk layar kecil -->
                        <span class="block sm:hidden">{{ Str::limit($book->description, 50) }}</span>
                        <!-- Deskripsi untuk layar lebih besar -->
                        <span class="hidden sm:block">{{ Str::limit($book->description, 100) }}</span>
                    </p>
                    <a href="{{ route('book.showUser', $book->slug) }}"
                        class="text-purple-500 mt-4 inline-block hover:underline">Baca Selengkapnya
                        &#8811;</a>
                </div>
                @endforeach
            </div>
            <div>
                {{ $books->links() }}
            </div>
            @else
            <div class="sm:mb-4 lg:mb-0 lg:flex lg:space-x-4">
                <div class="p-4 rounded-lg bg-gray-100 lg:w-1/5 mb-4">
                    <h3>Confusion Matrix</h3>
                    <p>True Positive (TP): {{ $confusionMatrix['TP'] ?? '-' }}</p>
                    <p>False Positive (FP): {{ $confusionMatrix['FP'] ?? '-' }}</p>
                    <p>True Negative (TN): {{ $confusionMatrix['TN'] ?? '-' }}</p>
                    <p>False Negative (FN): {{ $confusionMatrix['FN'] ?? '-' }}</p>
                </div>
                <div class="p-4 rounded-lg bg-gray-100 lg:w-1/5 mb-4">
                    <h3>Metrik</h3>
                    <p>Precision: {{ $metrics['precision'] ?? '-' }}%</p>
                    <p>Recall: {{ $metrics['recall'] ?? '-' }}%</p>
                </div>
            </div>
            <!-- Book Table Result -->

            <div class="overflow-x-auto mb-4">
                <!-- Example User Row -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-4">
                    @forelse ($paginatedResults as $result)
                    <div class="bg-white border rounded-md shadow hover:shadow p-4">
                        <img src="{{ $result['cover_image'] ? asset('storage/'.$result['cover_image']) : asset('assets/img/default-book.png') }}"
                            alt="{{ $result['title'] }}" class="w-full h-48 object-cover mb-4">
                        <h2 class="font-semibold text-xl mb-2 text-gray-900 h-20">
                            <!-- Judul untuk layar kecil -->
                            <span class="block sm:hidden">{{ Str::limit($result['title'], 40) }}</span>
                            <!-- Judul untuk layar lebih besar -->
                            <span class="hidden sm:block">{{ Str::limit($result['title'], 50) }}</span>
                        </h2>
                        <p class="text-gray-700 text-sm mb-2 sm:h-8">Penulis: <span class="font-bold">{{
                                $result['author'] }}</span></p>
                        <p class="text-gray-700 text-sm mb-4 sm:h-8">Similarity Score: <span class="font-bold">{{
                                number_format($result['similarity'] * 100, 2) }}%</span></p>
                        <p class="text-gray-600 text-sm sm:h-20">
                            <!-- Deskripsi untuk layar kecil -->
                            <span class="block sm:hidden">{{ Str::limit($result['description'], 50) }}</span>
                            <!-- Deskripsi untuk layar lebih besar -->
                            <span class="hidden sm:block">{{ Str::limit($result['description'], 100) }}</span>
                        </p>
                        <a href="{{ route('book.showUser', $result['slug']) }}"
                            class="text-purple-500 mt-4 inline-block hover:underline">Baca
                            Selengkapnya
                            &#8811;</a>
                    </div>
                    @empty
                    <div class="border-b bg-white rounded-lg">
                        <div class="py-4 px-6" colspan="7">Filter <span class="font-semibold text-red-500">{{
                                request('filter')
                                }}</span>
                            dengan pencarian <span class="font-semibold text-red-500">{{ request('search')
                                }}</span>
                            tidak
                            ditemukan, cobalah dengan filter
                            lain.</div>
                    </div>
                </div>
                @endforelse
                </tbody>
                </table>
            </div>
            <!-- Menampilkan link pagination -->
            <div class="flex justify-center mt-6">
                <nav class="inline-flex items-center space-x-2">
                    <!-- Previous Button -->
                    @if ($page > 1)
                    <a href="{{ route('searchBookUser', ['search' => request('search'), 'filter' => request('filter'), 'page' => $page - 1]) }}"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Prev
                    </a>
                    @else
                    <span
                        class="px-4 py-2 text-sm font-medium text-gray-300 bg-white border border-gray-300 rounded-lg cursor-not-allowed">
                        Prev
                    </span>
                    @endif

                    <!-- Page Numbers -->
                    @for ($i = 1; $i <= $lastPage; $i++) <a
                        href="{{ route('searchBookUser', ['search' => request('search'), 'filter' => request('filter'), 'page' => $i]) }}"
                        class="px-4 py-2 text-sm font-medium {{ $i == $page ? 'text-white bg-blue-600' : 'text-gray-700 bg-white border border-gray-300 hover:bg-gray-100' }} rounded-lg">
                        {{ $i }}
                        </a>
                        @endfor

                        <!-- Next Button -->
                        @if ($page < $lastPage) <a
                            href="{{ route('searchBookUser', ['search' => request('search'), 'filter' => request('filter'), 'page' => $page + 1]) }}"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Next
                            </a>
                            @else
                            <span
                                class="px-4 py-2 text-sm font-medium text-gray-300 bg-white border border-gray-300 rounded-lg cursor-not-allowed">
                                Next
                            </span>
                            @endif
                </nav>
            </div>
            @endif
        </div>
    </section>
</div>
@endsection