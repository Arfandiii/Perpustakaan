<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookCategory;
use Illuminate\Http\Request;

class BookCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Kategori Buku';
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('admin.dashboard'), 'icon' => 'home'],
            ['name' => 'Books', 'url' => route('admin.books.index'), 'icon' => 'book-list'],
            ['name' => 'Kategori Buku', 'url' => route('admin.categories.index'), 'icon' => 'category-book'],
        ];

        $bookCategories = BookCategory::all();
        return view('admin.books.categories.index', compact('title', 'bookCategories', 'breadcrumbs'));
    }
    // public function index()
    // {
    //     $title = 'Kategori kelas';
    //     // Breadcrumbs array
    //     $breadcrumbs = [
    //         ['name' => 'Dashboard', 'url' => route('admin.dashboard'), 'icon' => 'home'],
    //         ['name' => 'Users', 'url' => route('admin.users.index'), 'icon' => 'user-group'],
    //         ['name' => 'Kelas', 'url' => route('admin.edu-levels.index'), 'icon' => 'edu-level'],
    //     ];
    //     $eduLevels = EduLevel::all();
    //     return view('admin.users.eduLevels.index', compact('title', 'eduLevels', 'breadcrumbs'));
    // }

    // /**
    //  * Show the form for creating a new resource.
    //  */
    // public function create()
    // {
    //     $title = 'Tambah Kategori Kelas';
        
    //     // Breadcrumbs array
    //     $breadcrumbs = [
    //         ['name' => 'Dashboard', 'url' => route('admin.dashboard'), 'icon' => 'home'],
    //         ['name' => 'Users', 'url' => route('admin.users.index'), 'icon' => 'user-group'],
    //         ['name' => 'Kelas', 'url' => route('admin.edu-levels.index'), 'icon' => 'edu-level'],
    //         ['name' => 'Tambah Kelas', 'url' => route('admin.edu-levels.create'), 'icon' => 'create']
    //     ];
    //     return view('admin.users.eduLevels.create', compact('title', 'breadcrumbs'));
    // }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        $title = 'Tambah Kategori Buku';
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('admin.dashboard'), 'icon' => 'home'],
            ['name' => 'Books', 'url' => route('admin.books.index'), 'icon' => 'book-list'],
            ['name' => 'Kategori Buku', 'url' => route('admin.categories.index'), 'icon' => 'category-book'],
            ['name' => 'Tambah Kategori Buku', 'url' => route('admin.categories.create'), 'icon' => 'create']
        ];
        $bookCategories = BookCategory::all();
        return view('admin.books.categories.create', compact('title', 'bookCategories', 'breadcrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        BookCategory::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'kategori Baru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $bookCategory = BookCategory::findOrFail($id);
            $bookCategory->delete(); // Menghapus data Kelas dari database
            return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori buku berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.categories.index')
            ->with('error', 'Terjadi kesalahan saat menghapus Kategori buku: ' . $e->getMessage());
        }
    }
}
