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
            'cover_img' => 'nullable|image|mimes:jpg,png,jpeg|max:4096',
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
    //         // Memeriksa filter yang dipilih dan membuat query pencarian yang sesuai
    //         if ($filter == 'Judul') {
    //             $books->where('title', 'LIKE', "%$query%");
    //         } elseif ($filter == 'Penulis') {
    //             $books->where('Author', 'LIKE', "%$query%");
    //         } elseif ($filter == 'Penerbit') {
    //             $books->where('Publisher', 'LIKE', "%$query%");
    //         } elseif ($filter == 'Semua') {
    //             // Jika tidak ada filter, lakukan pencarian pada semua kolom
    //             $books->where(function($queryBuilder) use ($query) {
    //                 $queryBuilder->where('Title', 'LIKE', "%$query%")
    //                             ->orWhere('Author', 'LIKE', "%$query%")
    //                             ->orWhere('Publisher', 'LIKE', "%$query%");
    //             });
    //         }
    //     }

    //     // Mendapatkan buku yang sesuai dengan pencarian dan filter
    //     $books = $books->with('category')->latest()->paginate(10);

    //     // Menambahkan query string agar tetap ada dalam pagination
    //     $books->appends($request->all());
        
    //     return view('admin.books.index', compact('title', 'books', 'query', 'breadcrumbs', 'filter', ));
    // }

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

    public function search(Request $request)
    {
        // Mendapatkan nilai pencarian dan filter
        $query = $request->search;
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

        $books = Book::with('category')->get();
        
        // Inisialisasi array untuk hasil perhitungan
        $results = [];
        
        // Tokenisasi dan Preprocessing Query
        // Jika query ada, lakukan preprocessing
        $processedQuery = [];
        if ($query) {
            $processedQuery = TextPreprocessingHelper::preprocessText($query);
            // dd($processedQuery);
            
            foreach($books as $book){
                
                if ($filter == 'Judul') {
                    // Preprocessing berdasarkan judul buku
                    $processedBook = TextPreprocessingHelper::preprocessText($book['title']);
                    // dd($processedBook);
                } elseif ($filter == 'Penulis') {
                    $processedBook = TextPreprocessingHelper::preprocessText($book['author']);
                    // dd($processedBook);
                } elseif ($filter == 'Penerbit') {
                    $processedBook = TextPreprocessingHelper::preprocessText($book['publisher']);
                    // dd($processedBook);
                } elseif ($filter == 'Semua') {
                    $processedBook = TextPreprocessingHelper::preprocessText($book['title'] . ' ' . $book['author'] . ' ' . $book['publisher']);
                    // dd($processedBook);
                }

                // $processedBookTitle = TextPreprocessingHelper::preprocessText($book['title']);
                // Hitung Dice Similarity antara query dan deskripsi buku
                $diceSimilarity = DiceSimilarityHelper::calculateDiceSimilarity($processedQuery, $processedBook);
                // dd($diceSimilarity);
                if ($diceSimilarity > 0) {
                    $results[] = [
                        'id' => $book['id'],
                        'title' => $book['title'],
                        'author' => $book['author'],
                        'publisher' => $book['publisher'],
                        'category' => $book['category']['name'],
                        'stock' => $book['stock'],
                        'slug' => $book['slug'],
                        'similarity' => $diceSimilarity
                    ];
                }
                // dd($results);
            }
        }

        // Hitung Confusion Matrix dan Metrik Evaluasi
        // Misalnya kita anggap prediksi berdasarkan threshold similarity > 0.4 dianggap relevan (1), lainnya dianggap tidak relevan (0)
        $predicted = array_map(function($result) {
            return $result['similarity'] >= 0.3 ? $result['id'] : null;
        }, $results);
        $predicted = array_filter($predicted);

        // ambil buku yang relevan dari data buku berdasarkan query
        $actual = $this->getTrueResultsFromDatabase($processedQuery, $filter);


        // Hitung Confusion Matrix
        $confusionMatrix = DiceSimilarityHelper::calculateConfusionMatrix($predicted, $actual);
        
        // Hitung Precision, Recall, Accuracy
        $metrics = DiceSimilarityHelper::calculateMetrics(
            $confusionMatrix['TP'],
            $confusionMatrix['FP'],
            $confusionMatrix['FN'],
            $confusionMatrix['TN']
        );
        
        // Urutkan hasil berdasarkan nilai similarity
        usort($results, function($a, $b) {
            return $b['similarity'] <=> $a['similarity'];
        });

        // Pagination: Ambil data pada halaman tertentu
        $perPage = 5; // Jumlah hasil per halaman
        $page = $request->get('page', 1); // Mendapatkan nomor halaman dari query string
        $results = collect($results);
        $paginatedResults = $results->forPage($page, $perPage); // Ambil hasil untuk halaman tertentu

        // Hitung jumlah total halaman
        $total = count($results);
        $lastPage = (int) ceil($total / $perPage); // Menghitung total halaman

        return view('admin.books.index', compact('title', 'breadcrumbs', 'filter', 'books', 'query', 'processedQuery', 'results', 'confusionMatrix', 'metrics', 'paginatedResults', 'lastPage', 'page', 'total'));
    }

    private function getTrueResultsFromDatabase($query, $filter)
    {
        $keywords = $query;
        $books = Book::with('category')->get();
        // Mencari buku relevan yang judulnya mengandung salah satu kata kunci
        $relevantBooks = [];
        // Query database dengan filter
        $books = Book::with('category')
            ->where(function($queryBuilder) use ($keywords, $filter) {
                // Menentukan kolom mana yang akan dipakai berdasarkan filter
                if ($filter == 'Judul') {
                    foreach ($keywords as $keyword) {
                        $queryBuilder->orWhere('title', 'LIKE', '%' . $keyword . '%');
                    }
                } elseif ($filter == 'Penulis') {
                    foreach ($keywords as $keyword) {
                        $queryBuilder->orWhere('author', 'LIKE', '%' . $keyword . '%');
                    }
                } elseif ($filter == 'Penerbit') {
                    foreach ($keywords as $keyword) {
                        $queryBuilder->orWhere('publisher', 'LIKE', '%' . $keyword . '%');
                    }
                } elseif ($filter == 'Semua') {
                    foreach ($keywords as $keyword) {
                        $queryBuilder->orWhere('title', 'LIKE', '%' . $keyword . '%')
                                    ->orWhere('author', 'LIKE', '%' . $keyword . '%')
                                    ->orWhere('publisher', 'LIKE', '%' . $keyword . '%');
                    }
                }
            })->get();
            // Mengumpulkan ID buku yang relevan dari hasil query
        foreach ($books as $book) {
            $relevantBooks[] = $book->id;
        }

        return $relevantBooks; // Mengembalikan array ID buku yang relevan
    }

    public function searchBookUser(Request $request)
    {
        // Mendapatkan nilai pencarian dan filter
        $query = $request->search;
        $filter = $request->filter;

        $title = 'Katalog Buku';
        // Breadcrumbs array

        // Jika input kosong, hanya kembalikan tampilan tanpa perhitungan tambahan
        if (empty($query)) {
            return redirect()->route('catalog')->with('error', 'Silakan masukkan kata kunci pencarian.');
        }

        $books = Book::with('category')->get();
        
        // Inisialisasi array untuk hasil perhitungan
        $results = [];
        
        // Tokenisasi dan Preprocessing Query
        // Jika query ada, lakukan preprocessing
        $processedQuery = [];
        if ($query) {
            $processedQuery = TextPreprocessingHelper::preprocessText($query);
            // dd($processedQuery);
            
            foreach($books as $book){
                
                if ($filter == 'Judul') {
                    // Preprocessing berdasarkan judul buku
                    $processedBook = TextPreprocessingHelper::preprocessText($book['title']);
                    // dd($processedBook);
                } elseif ($filter == 'Penulis') {
                    $processedBook = TextPreprocessingHelper::preprocessText($book['author']);
                    // dd($processedBook);
                } elseif ($filter == 'Penerbit') {
                    $processedBook = TextPreprocessingHelper::preprocessText($book['publisher']);
                    // dd($processedBook);
                } elseif ($filter == 'Semua') {
                    $processedBook = TextPreprocessingHelper::preprocessText($book['title'] . ' ' . $book['author'] . ' ' . $book['publisher']);
                    // dd($processedBook);
                }

                // $processedBookTitle = TextPreprocessingHelper::preprocessText($book['title']);
                // Hitung Dice Similarity antara query dan deskripsi buku
                $diceSimilarity = DiceSimilarityHelper::calculateDiceSimilarity($processedQuery, $processedBook);
                // dd($diceSimilarity);
                if ($diceSimilarity > 0) {
                    $results[] = [
                        'id' => $book['id'],
                        'title' => $book['title'],
                        'author' => $book['author'],
                        'publisher' => $book['publisher'],
                        'category' => $book['category']['name'],
                        'stock' => $book['stock'],
                        'description' => $book['description'],
                        'cover_image' => $book['cover_image'],
                        'slug' => $book['slug'],
                        'similarity' => $diceSimilarity
                    ];
                }
                // dd($results);
            }
        }

        // Hitung Confusion Matrix dan Metrik Evaluasi
        // Misalnya kita anggap prediksi berdasarkan threshold similarity > 0.4 dianggap relevan (1), lainnya dianggap tidak relevan (0)
        $predicted = array_map(function($result) {
            return $result['similarity'] >= 0.3 ? $result['id'] : null;
        }, $results);
        $predicted = array_filter($predicted);

        // ambil buku yang relevan dari data buku berdasarkan query
        $actual = $this->getTrueResultsFromDatabase($processedQuery, $filter);


        // Hitung Confusion Matrix
        $confusionMatrix = DiceSimilarityHelper::calculateConfusionMatrix($predicted, $actual);
        
        // Hitung Precision, Recall, Accuracy
        $metrics = DiceSimilarityHelper::calculateMetrics(
            $confusionMatrix['TP'],
            $confusionMatrix['FP'],
            $confusionMatrix['FN'],
            $confusionMatrix['TN']
        );
        
        // Urutkan hasil berdasarkan nilai similarity
        usort($results, function($a, $b) {
            return $b['similarity'] <=> $a['similarity'];
        });

        // Pagination: Ambil data pada halaman tertentu
        $perPage = 12; // Jumlah hasil per halaman
        $page = $request->get('page', 1); // Mendapatkan nomor halaman dari query string
        $results = collect($results);
        $paginatedResults = $results->forPage($page, $perPage); // Ambil hasil untuk halaman tertentu

        // Hitung jumlah total halaman
        $total = count($results);
        $lastPage = (int) ceil($total / $perPage); // Menghitung total halaman

        return view('catalog', compact('title', 'filter', 'books', 'query', 'processedQuery', 'results', 'confusionMatrix', 'metrics', 'paginatedResults', 'lastPage', 'page', 'total'));
    }

}