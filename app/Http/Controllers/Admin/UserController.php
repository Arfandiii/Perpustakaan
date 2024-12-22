<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EduLevel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function getLastLogin($userId)
    {
        $session = DB::table('sessions')
            ->where('user_id', $userId)
            ->orderBy('last_activity', 'desc')
            ->first();

        return $session ? \Carbon\Carbon::createFromTimestamp($session->last_activity) : null;
    }

    public function verify(Request $request, User $user)
    {
        if ($user->email_verified_at) {
            return redirect()->back()->with('info', 'User telah terverifikasi.');
        }

        $user->update(['email_verified_at' => Carbon::now()]);

        return redirect()->back()->with('success', 'User berhasil diverifikasi.');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'List Pengguna';

        // Breadcrumbs array
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('admin.dashboard'), 'icon' => 'home'],
            ['name' => 'Users', 'url' => route('admin.users.index'), 'icon' => 'user-group']
        ];

        $users = User::with('eduLevel')->where('role', 'user')->latest()->paginate(5);
        $users->appends(request()->query());

        return view('admin.users.index', compact('users', 'title', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tambah Pengguna';

        // Breadcrumbs array
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('admin.dashboard'), 'icon' => 'home'],
            ['name' => 'Users', 'url' => route('admin.users.index'), 'icon' => 'user-group'],
            ['name' => 'Create User', 'url' => route('admin.users.create'), 'icon' => 'create']
        ];

        return view('admin.users.create', compact('breadcrumbs', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data yang diterima menggunakan metode validate dari objek $request
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambah.');
    }

    /**
     * Display the specified resource.
     */
        public function show(User $user)
        {
            $title = 'Show User';
            // Breadcrumbs array
            $breadcrumbs = [
                ['name' => 'Dashboard', 'url' => route('admin.dashboard'), 'icon' => 'home'],
                ['name' => 'Users', 'url' => route('admin.users.index'), 'icon' => 'user-group'],
                ['name' => 'Show User', 'url' => route('admin.users.show', $user->id), 'icon' => 'eye']
            ];


            return view('admin.users.show', compact('title', 'breadcrumbs', 'user'));
        }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $title = 'Edit User';
        $eduLevels = EduLevel::all();

        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('admin.dashboard'), 'icon' => 'home'],
            ['name' => 'Users', 'url' => route('admin.users.index'), 'icon' => 'user-group'],
            ['name' => 'Edit User', 'url' => route('admin.users.show',  $user->id), 'icon' => 'edit']
        ];

        // dd($user);
        return view('admin.users.edit', compact('title', 'breadcrumbs', 'user', 'eduLevels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:dns', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string'],
            'dob' => ['nullable', 'date'],
            'edu_level_id' => ['nullable', 'exists:edu_levels,id'], // Kelas/EduLevel
            'password' => ['nullable', 'string', 'min:8', 'confirmed'], // Password bersifat opsional saat update
            'profile_picture' => 'nullable|image|file|mimes:jpg,png,jpeg|max:4096'
        ]);
        // Cek apakah user adalah admin
        if (Auth::user()->role === 'admin') {
            // Admin hanya bisa mengubah nama, email, edu_level_id, phone, dan dob
            $user->update([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'edu_level_id' => $validatedData['edu_level_id'],
                'phone' => $validatedData['phone'],
                'dob' => $validatedData['dob']
            ]);
        } else {
            // Pengguna biasa bisa mengubah semua kolom, termasuk password
            $picturePath = $request->file('profile_picture')->store('profile', 'public');
            $user->update([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'phone' => $validatedData['phone'],
                'dob' => $validatedData['dob'],
                'profile_picture' => $picturePath, // Misalnya jika ada opsi untuk mengubah foto profil
                'password' => $request->password ? Hash::make($request->password) : $user->password,
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete(); // Menghapus data user dari database
            return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.users.index')
            ->with('error', 'Terjadi kesalahan saat menghapus User: ' . $e->getMessage());
        }
    }
}
