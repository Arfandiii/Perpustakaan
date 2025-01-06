@extends('layouts.app')

@section('content')

<div class="container mx-auto p-4">

    <!-- Title Section -->
    <h1 class="text-2xl font-bold mb-6 text-center">Contoh Data Buku untuk Perhitungan</h1>

    <!-- Table for Original Data -->
    <div class="mb-6">
        <h2 class="text-xl font-semibold mb-4">Data Buku</h2>
        <table class="min-w-full mb-4 bg-white border-collapse shadow-md rounded-lg">
            <thead>
                <tr class="bg-gray-200">
                    <th class="py-3 px-4 text-left">#</th>
                    <th class="py-3 px-4 text-left">Judul</th>
                    <th class="py-3 px-4 text-left">Penulis</th>
                    <th class="py-3 px-4 text-left">Penerbit</th>
                </tr>
            </thead>
            <tbody>
                @foreach($books as $index => $book)
                <tr class="border-b">
                    <td class="py-2 px-4">{{ $loop->iteration }}</td>
                    <td class="py-2 px-4">{{ $book['title'] }}</td>
                    <td class="py-2 px-4">{{ $book['author'] }}</td>
                    <td class="py-2 px-4">{{ $book['publisher'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Query Examples for Testing Dice Similarity -->
    <div class="mb-6">
        <h2 class="text-lg font-semibold mb-2">Query untuk Pengujian Dice Similarity</h2>
        <div class="mb-4">
            <h3 class="text-md font-semibold mb-2">Kemiripan Tinggi:</h3>
            <ul class="list-disc pl-5">
                <li>"19 KIAT SUKSES MEMBANGKITKAN MOTIVASI BELAJAR"</li>
            </ul>
            <p class="mt-2">Hasil yang Diharapkan: Dice Similarity menghasilkan nilai tinggi (mendekati 1).</p>
        </div>
        <div class="mb-4">
            <h3 class="text-md font-semibold mb-2">Kemiripan Sedang:</h3>
            <ul class="list-disc pl-5">
                <li>"KIAT MEMBANGKITKAN MOTIVASI BELAJAR"</li>
            </ul>
            <p class="mt-2">Hasil yang Diharapkan: Dice Similarity menghasilkan nilai sedang (0.3–0.7).</p>
        </div>
        <div class="mb-4">
            <h3 class="text-md font-semibold mb-2">Kemiripan rendah:</h3>
            <ul class="list-disc pl-5">
                <li>"TEKNIK BERKEBUN UNTUK PEMULA"</li>
            </ul>
            <p class="mt-2">Hasil yang Diharapkan: Dice Similarity menghasilkan nilai sangat rendah (mendekati 0).</p>
        </div>
    </div>

    <!-- Input for Query -->
    <div class="mb-6">
        <h2 class="text-lg font-semibold mb-2">Masukkan Query</h2>
        <form method="GET">
            <input type="text" name="query" id="query" class="w-full p-3 border rounded-md shadow-sm"
                value="{{ old('query', $query )}}" placeholder="Cari berdasarkan judul...">
            <button type="submit"
                class="mt-4 px-6 py-3 bg-blue-500 text-white rounded-md shadow-md hover:bg-blue-600 transition">
                Proses Data dan Hitung Dice Similarity
            </button>
        </form>
    </div>

    <!-- Tampilkan Nilai Query -->
    @if($query)
    <div class="mb-6">
        <h3 class="text-lg font-semibold mb-2">Query yang Anda Masukkan: "{{ old('query', $query) }}"</h3>
        <h4 class="text-md mt-2">Query yang telah di Preprocessing:</h4>
        <p>{{ implode(' ', array_map(fn($word) => '"' . $word . '"', $processedQuery)) }}</p>
    </div>
    @endif

    <!-- Table for Preprocessed Data -->
    @if(!empty($processedBooks))
    <div class="mb-6">
        <h2 class="text-xl font-semibold mb-4">Data Buku yang Telah Diproses</h2>
        <table class="min-w-full bg-white border-collapse shadow-md rounded-lg">
            <thead>
                <tr class="bg-gray-200">
                    <th class="py-3 px-4 text-left">#</th>
                    <th class="py-3 px-4 text-left">Tokens</th>
                    <th class="py-3 px-4 text-left">Filter tokens</th>
                </tr>
            </thead>
            <tbody>
                @foreach($processedBooks as $index => $book)
                <tr class="border-b">
                    <td class="py-2 px-4">{{ $loop->iteration }}</td>
                    <td class="py-2 px-4">{{ $book['tokens'] }}</td>
                    <td class="py-2 px-4">{{ $book['filter_tokens'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <table class="min-w-full bg-white border-collapse shadow-md rounded-lg">
            <thead>
                <tr class="bg-gray-200">
                    <th class="py-3 px-4 text-left">#</th>
                    <th class="py-3 px-4 text-left">Stop word</th>
                    <th class="py-3 px-4 text-left">Steming tokens</th>
                </tr>
            </thead>
            <tbody>
                @foreach($processedBooks as $index => $book)
                <tr class="border-b">
                    <td class="py-2 px-4">{{ $loop->iteration }}</td>
                    <td class="py-2 px-4">{{ $book['remove_stopwords'] }}</td>
                    <td class="py-2 px-4">{{ $book['stem_tokens'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- Table for Dice Similarity Results -->
    @if(!empty($results))
    <div class="mb-6">
        <h2 class="text-xl font-semibold mb-4">Buku dengan Dice Similarity >= 30% dianggap relevan (1), lainnya dianggap
            tidak relevan (0)</h2>
        <table class="min-w-full mb-4 bg-white border-collapse shadow-md rounded-lg">
            <thead>
                <tr class="bg-gray-200">
                    <th class="py-3 px-4 text-left">#</th>
                    <th class="py-3 px-4 text-left">Judul</th>
                    <th class="py-3 px-4 text-left">Dice Similarity</th>
                </tr>
            </thead>
            <tbody>
                @foreach($results as $result)
                <tr class="border-b">
                    <td class="py-2 px-4">{{ $loop->iteration }}</td>
                    <td class="py-2 px-4">{{ $result['book_title'] }}</td>
                    <td class="py-2 px-4">{{ number_format($result['dice_similarity'] * 100, 2) }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Confusion Matrix Table -->
    <div class="mb-6">
        <h3 class="text-lg font-semibold mb-4">Confusion Matrix</h3>
        <table class="min-w-full mb-4 bg-white border-collapse shadow-md rounded-lg">
            <thead>
                <tr class="bg-gray-200">
                    <th class="py-3 px-4 text-left">TP (True Positive)</th>
                    <th class="py-3 px-4 text-left">FP (False Positive)</th>
                    <th class="py-3 px-4 text-left">FN (False Negative)</th>
                    <th class="py-3 px-4 text-left">TN (True Negative)</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b">
                    <td class="py-2 px-4">{{ $confusionMatrix['TP'] ?? '-' }}</td>
                    <td class="py-2 px-4">{{ $confusionMatrix['FP'] ?? '-' }}</td>
                    <td class="py-2 px-4">{{ $confusionMatrix['FN'] ?? '-' }}</td>
                    <td class="py-2 px-4">{{ $confusionMatrix['TN'] ?? '-' }}</td>
                </tr>
            </tbody>
        </table>
        <div>
            <p>TP: Buku yang relevan dan diprediksi relevan.</p>
            <p>FP: Buku yang tidak relevan, tetapi diprediksi relevan.</p>
            <p>FN: Buku yang relevan, tetapi diprediksi tidak relevan.</p>
            <p>TN: Buku yang tidak relevan dan diprediksi tidak relevan.</p>
        </div>
    </div>
    <!-- Metrics Table -->
    <div class="mb-6">
        <h3 class="text-lg font-semibold mb-4">Metrics Evaluasi</h3>
        <table class="min-w-full mb-4 bg-white border-collapse shadow-md rounded-lg">
            <thead>
                <tr class="bg-gray-200">
                    <th class="py-3 px-4 text-left">Precision</th>
                    <th class="py-3 px-4 text-left">Recall</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b">
                    <td class="py-2 px-4">{{ $metrics['precision'] ?? '-' }}</td>
                    <td class="py-2 px-4">{{ $metrics['recall'] ?? '-' }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    @endif

</div>

@endsection