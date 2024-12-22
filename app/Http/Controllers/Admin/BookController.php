<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DiceSimilarityHelper;
use App\Helpers\TextPreprocessingHelper;
use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookCategory;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function home()
    {
        // title halaman
        $title = 'Home';

        // Ambil 4 buku untuk halaman home dengan pagination
        $books = Book::with('category')->latest()->paginate(4); // 4 per halaman
        $books->appends(request()->query());

        // Mengirim data ke view
        return view('home', compact('title', 'books')); // View untuk admin dashboard
    }
    /**
     * Display a listing of the resource.
     */
    public function catalog()
    {
        // title halaman
        $title = 'Katalog Buku';

        // Ambil 12 buku untuk halaman katalog dengan pagination
        $books = Book::with('category')->latest()->paginate(12); // 12 per halaman
        $books->appends(request()->query());
        
        // Mengirim data ke view
        return view('catalog', compact('title', 'books')); // View untuk admin dashboard
    }

    public function showUser($slug)
    {
        $title = 'Detail Buku';
        $book = Book::with('category')->where('slug', $slug)->firstOrFail(); // Mengambil buku dengan relasi kategori

        return view('book-detail', compact('book', 'title')); // Tampilan untuk user
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'List Buku';

        // Breadcrumbs array
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('admin.dashboard'), 'icon' => 'home'],
            ['name' => 'Books', 'url' => route('admin.books.index'), 'icon' => 'book-list']
        ];

        $books = Book::with('category')->latest()->paginate(10);
        $books->appends(request()->query());

        return view('admin.books.index', compact('title', 'breadcrumbs', 'books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tambah Buku';
        $categories = BookCategory::all(); // Ambil semua kategori
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('admin.dashboard'), 'icon' => 'home'],
            ['name' => 'Books', 'url' => route('admin.books.index'), 'icon' => 'book-list'],
            ['name' => 'Create Book', 'url' => route('admin.books.create'), 'icon' => 'create']
        ];

        return view('admin.books.create', compact('title','breadcrumbs', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id' => 'required',
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer',
            'deskripsi' => 'required|string',
            'stok' => 'required|integer|min:0',
            'cover_img' => 'nullable|image|file|mimes:jpg,png,jpeg|max:4096',
        ]);

        // Inisialisasi variabel path gambar
        $coverPath = null;

        // Periksa apakah file diunggah
        if ($request->hasFile('cover_img')) {
            $coverPath = $request->file('cover_img')->store('covers', 'public');
        }

        // dd($validated);
        Book::create([
            'category_id' => $validated['kategori_id'],
            'title' => $validated['judul'],
            'author' => $validated['penulis'],
            'publisher' => $validated['penerbit'],
            'published_year' => $validated['tahun_terbit'],
            'description' => $validated['deskripsi'],
            'stock' => $validated['stok'],
            'cover_image' => $coverPath,
        ]);

        return redirect()->route('admin.books.create')->with('success', 'Buku berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $title = 'Show Book';
        // Breadcrumbs array
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('admin.dashboard'), 'icon' => 'home'],
            ['name' => 'Books', 'url' => route('admin.books.index'), 'icon' => 'book-list'],
            ['name' => 'Show Book', 'url' => route('admin.books.show', $slug), 'icon' => 'eye']
        ];
        
        $book = Book::with('category')->where('slug', $slug)->firstOrFail(); // Mengambil buku dengan relasi kategori
        
        return view('admin.books.show', compact('title', 'breadcrumbs', 'book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        $title = 'Edit Buku';
        $categories = BookCategory::all(); // Ambil semua kategori
        
        // Breadcrumbs array
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('admin.dashboard'), 'icon' => 'home'],
            ['name' => 'Books', 'url' => route('admin.books.index'), 'icon' => 'book-list'],
            ['name' => 'Edit Book', 'url' => route('admin.books.edit', $book->id), 'icon' => 'edit']
        ];
        
        return view('admin.books.edit', compact('title', 'breadcrumbs', 'book', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'kategori_id' => 'required',
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer',
            'deskripsi' => 'required|string',
            'stok' => 'required|integer|min:0',
            'cover_img' => 'nullable|image|file|mimes:jpg,png,jpeg|max:4096',
        ]);

        if ($request->hasFile('cover_img')) {
            $coverPath = $request->file('cover_img')->store('covers', 'public');
            $book->cover_image = $coverPath;
        }

        $book->update([
            'category_id' => $validated['kategori_id'],
            'title' => $validated['judul'],
            'author' => $validated['penulis'],
            'publisher' => $validated['penerbit'],
            'published_year' => $validated['tahun_terbit'],
            'description' => $validated['deskripsi'],
            'stock' => $validated['stok'],
        ]);

        return redirect()->route('admin.books.index')->with('success', 'Data buku berhasil diperbarui.');
    }
    
    public function search(Request $request)
    {
        // Mendapatkan nilai pencarian dan filter
        $query = $request->search;
        // $query = $request->input('search');
        $filter = $request->filter;

        $title = 'List Buku';
        // Breadcrumbs array
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('admin.dashboard'), 'icon' => 'home'],
            ['name' => 'Books', 'url' => route('admin.books.index'), 'icon' => 'book-list']
        ];

        // Jika input kosong, hanya kembalikan tampilan tanpa perhitungan tambahan
        if (empty($query)) {
            return redirect()->route('admin.books.index')->with('error', 'Silakan masukkan kata kunci pencarian.');
        }

        // Menentukan query pencarian berdasarkan filter
        $books = Book::query();

        if ($query) {
            // Memeriksa filter yang dipilih dan membuat query pencarian yang sesuai
            if ($filter == 'Judul') {
                $books->where('title', 'LIKE', "%$query%");
            } elseif ($filter == 'Penulis') {
                $books->where('Author', 'LIKE', "%$query%");
            } elseif ($filter == 'Penerbit') {
                $books->where('Publisher', 'LIKE', "%$query%");
            } elseif ($filter == 'Semua') {
                // Jika tidak ada filter, lakukan pencarian pada semua kolom
                $books->where(function($queryBuilder) use ($query) {
                    $queryBuilder->where('Title', 'LIKE', "%$query%")
                                ->orWhere('Author', 'LIKE', "%$query%")
                                ->orWhere('Publisher', 'LIKE', "%$query%");
                });
            }
        }

        // Mendapatkan buku yang sesuai dengan pencarian dan filter
        $books = $books->with('category')->latest()->paginate(10);

        // Menambahkan query string agar tetap ada dalam pagination
        $books->appends($request->all());
        
        return view('admin.books.index', compact('title', 'books', 'query', 'breadcrumbs', 'filter'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $book = Book::findOrFail($id);
            $book->delete(); // Menghapus data buku dari database
            return redirect()->route('admin.books.index')
            ->with('success', 'Buku berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.books.index')
            ->with('error', 'Terjadi kesalahan saat menghapus Buku: ' . $e->getMessage());
        }
    }

    // public function search(Request $request)
    // {
    //     // Mendapatkan nilai pencarian dan filter
    //     $query = $request->search;
    //     $filter = $request->filter;

    //     $title = 'List Buku';
    //     // Breadcrumbs array
    //     $breadcrumbs = [
    //         ['name' => 'Dashboard', 'url' => route('admin.dashboard'), 'icon' => 'home'],
    //         ['name' => 'Books', 'url' => route('admin.books.index'), 'icon' => 'book-list']
    //     ];

    //     // Jika input kosong, hanya kembalikan tampilan tanpa perhitungan tambahan
    //     if (empty($query)) {
    //         return redirect()->route('admin.books.index')->with('error', 'Silakan masukkan kata kunci pencarian.');
    //     }

    //     // Menentukan query pencarian berdasarkan filter
    //     $books = Book::query();

    //     if ($query) {

    //         $keywords = explode(' ', $query); // Misalnya, ["Lala", "Handayani", "Puput", "Ratna", "Agustina"]
            
    //         // Memeriksa filter yang dipilih dan membuat query pencarian yang sesuai
    //         if ($filter == 'Judul') {
    //             $books->where(function($queryBuilder) use ($keywords) {
    //                 foreach ($keywords as $keyword) {
    //                     $queryBuilder->where('title', 'LIKE', "%$keyword%");
    //                 }
    //             });
    //         } elseif ($filter == 'Penulis') {
    //             $books->where(function($queryBuilder) use ($keywords) {
    //                 foreach ($keywords as $keyword) {
    //                     $queryBuilder->where('Author', 'LIKE', "%$keyword%");
    //                 }
    //             });
    //         } elseif ($filter == 'Penerbit') {
    //             $books->where(function($queryBuilder) use ($keywords) {
    //                 foreach ($keywords as $keyword) {
    //                     $queryBuilder->where('Publisher', 'LIKE', "%$keyword%");
    //                 }
    //             });
    //         } elseif ($filter == 'Semua') {
    //             // Jika tidak ada filter, lakukan pencarian pada semua kolom
    //             $books->where(function($queryBuilder) use ($keywords) {
    //                 foreach ($keywords as $keyword) {
    //                     $queryBuilder->where('Title', 'LIKE', "%$keyword%")
    //                                 ->orWhere('Author', 'LIKE', "%$keyword%")
    //                                 ->orWhere('Publisher', 'LIKE', "%$keyword%");
    //                 }
    //             });
    //         }
    //         // if ($filter == 'Judul') {
    //         //     $books->where('title', 'LIKE', "%$query%");
    //         // } elseif ($filter == 'Penulis') {
    //         //     $books->where('Author', 'LIKE', "%$query%");
    //         // } elseif ($filter == 'Penerbit') {
    //         //     $books->where('Publisher', 'LIKE', "%$query%");
    //         // } elseif ($filter == 'Semua') {
    //         //     // Jika tidak ada filter, lakukan pencarian pada semua kolom
    //         //     $books->where(function($queryBuilder) use ($query) {
    //         //         $queryBuilder->where('Title', 'LIKE', "%$query%")
    //         //                     ->orWhere('Author', 'LIKE', "%$query%")
    //         //                     ->orWhere('Publisher', 'LIKE', "%$query%");
    //         //     });
    //         // }
    //     }

    //     // Mendapatkan buku yang sesuai dengan pencarian dan filter
    //     $books = $books->with('category')->latest()->paginate(10);

    //     // Menambahkan query string agar tetap ada dalam pagination
    //     $books->appends($request->all());

    //     // Preprocessing untuk query pencarian
    //     $processedQuery = TextPreprocessingHelper::preprocessText($query);

    //     // Daftar prediksi dan hasil yang sebenarnya untuk menghitung confusion matrix
    //     $predicted = [];
    //     $actual = [];

    //     // Fungsi untuk menghitung Dice Similarity untuk setiap buku
    //     foreach ($books as $book) {
    //         $similarity = 0;
    //         $match = 0;

    //         // Tentukan teks yang akan dibandingkan (judul, penulis, penerbit)
    //         if ($filter == 'Judul') {
    //             $processedBookTitle = TextPreprocessingHelper::preprocessText($book->title);
    //             $similarity = DiceSimilarityHelper::calculateDiceSimilarity($processedQuery, $processedBookTitle);
    //             $match = $similarity > 0.5 ? 1 : 0;  // Jika similarity > 0.5, dianggap match (1)
    //         } elseif ($filter == 'Penulis') {
    //             $processedBookAuthor = TextPreprocessingHelper::preprocessText($book->author);
    //             $similarity = DiceSimilarityHelper::calculateDiceSimilarity($processedQuery, $processedBookAuthor);
    //             $match = $similarity > 0.5 ? 1 : 0;  // Jika similarity > 0.5, dianggap match (1)
    //         } elseif ($filter == 'Penerbit') {
    //             $processedBookPublisher = TextPreprocessingHelper::preprocessText($book->publisher);
    //             $similarity = DiceSimilarityHelper::calculateDiceSimilarity($processedQuery, $processedBookPublisher);
    //             $match = $similarity > 0.5 ? 1 : 0;  // Jika similarity > 0.5, dianggap match (1)
    //         } elseif ($filter == 'Semua') {
    //             // Hitung kesamaan untuk semua kolom jika filter "Semua"
    //             $processedBookTitle = TextPreprocessingHelper::preprocessText($book->title);
    //             $processedBookAuthor = TextPreprocessingHelper::preprocessText($book->author);
    //             $processedBookPublisher = TextPreprocessingHelper::preprocessText($book->publisher);

    //             $similarity = max(
    //                 DiceSimilarityHelper::calculateDiceSimilarity($processedQuery, $processedBookTitle),
    //                 DiceSimilarityHelper::calculateDiceSimilarity($processedQuery, $processedBookAuthor),
    //                 DiceSimilarityHelper::calculateDiceSimilarity($processedQuery, $processedBookPublisher)
    //             );
    //             $match = $similarity > 0.5 ? 1 : 0;  // Jika similarity > 0.5, dianggap match (1)
    //         }

    //         // Tambahkan nilai Dice Similarity ke dalam objek buku
    //         $book->similarity = $similarity;
    //         // Simpan prediksi dan hasil yang sebenarnya untuk matriks kebingunguan
    //         $predicted[] = $match;  // Prediksi (1 = match, 0 = tidak match)
    //         $actual[] = $book->is_match;  // Asumsikan is_match adalah nilai yang menyatakan apakah buku ini relevan dengan pencarian (1 atau 0)
    //     }
    //     // Menghitung confusion matrix
    //     $confusionMatrix = DiceSimilarityHelper::calculateConfusionMatrix($predicted, $actual);

    //     // Menghitung metrik lainnya (Precision, Recall, F1-Score)
    //     // $metrics = DiceSimilarityHelper::calculateMetrics(
    //     //     $confusionMatrix['TP'],
    //     //     $confusionMatrix['FP'],
    //     //     $confusionMatrix['FN'],
    //     //     $confusionMatrix['TN']
    //     // );

    //     // Return view dengan data buku yang sudah dihitung similarity-nya
    //     return view('admin.books.index', compact('title', 'books', 'query', 'breadcrumbs', 'filter', 'confusionMatrix'));
    // }

}