<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EduLevel;
use Illuminate\Http\Request;

class EduLevelsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Kategori kelas';
        // Breadcrumbs array
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('admin.dashboard'), 'icon' => 'home'],
            ['name' => 'Users', 'url' => route('admin.users.index'), 'icon' => 'user-group'],
            ['name' => 'Kelas', 'url' => route('admin.edu-levels.index'), 'icon' => 'edu-level'],
        ];
        $eduLevels = EduLevel::all();
        return view('admin.users.eduLevels.index', compact('title', 'eduLevels', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tambah Kategori Kelas';
        
        // Breadcrumbs array
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('admin.dashboard'), 'icon' => 'home'],
            ['name' => 'Users', 'url' => route('admin.users.index'), 'icon' => 'user-group'],
            ['name' => 'Kelas', 'url' => route('admin.edu-levels.index'), 'icon' => 'edu-level'],
            ['name' => 'Tambah Kelas', 'url' => route('admin.edu-levels.create'), 'icon' => 'create']
        ];
        return view('admin.users.eduLevels.create', compact('title', 'breadcrumbs'));
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

        EduLevel::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.edu-levels.index')->with('success', 'Kelas Baru berhasil ditambahkan.');
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
    public function edit(EduLevel $eduLevel)
    {
        $title = 'Edit kategori kelas';

        // Breadcrumbs array
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('admin.dashboard'), 'icon' => 'home'],
            ['name' => 'Users', 'url' => route('admin.users.index'), 'icon' => 'user-group'],
            ['name' => 'Kelas', 'url' => route('admin.edu-levels.index'), 'icon' => 'edu-level'],
            ['name' => 'Edit Kelas', 'url' => route('admin.edu-levels.edit', $eduLevel->id), 'icon' => 'edit']
        ];

        return view('admin.users.eduLevels.edit', compact('title', 'eduLevel', 'breadcrumbs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EduLevel $eduLevel)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $eduLevel->update([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            ]);
            
        return redirect()->route('admin.edu-levels.index')->with('success', 'Kelas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $eduLevel = EduLevel::findOrFail($id);
            $eduLevel->delete(); // Menghapus data Kelas dari database
            return redirect()->route('admin.edu-levels.index')
            ->with('success', 'Kelas berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.edu-levels.index')
            ->with('error', 'Terjadi kesalahan saat menghapus Kelas: ' . $e->getMessage());
        }
    }
}
