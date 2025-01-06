<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\EduLevel;
use App\Models\LoanBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Dashboard Admin';
        $user = Auth::user(); // Ambil data user yang sedang login
        // Get the total number of loans (peminjaman) berdasarkan user
        $totalPeminjaman = LoanBook::whereHas('loan', function($query) use ($user) {
            $query->where('user_id', $user->id); // Pastikan hanya peminjaman yang terkait dengan user ini
        })->count();
        
        // Get the number of books currently borrowed (Buku yang Sedang Dipinjam)
        // Termasuk status 'borrowed' dan 'overdue' dari tabel loan_book
        $bukuSedangDipinjam = LoanBook::whereHas('loan', function($query) use ($user) {
            $query->where('user_id', $user->id); // Pastikan hanya peminjaman yang terkait dengan user ini
        })
        ->whereIn('status', ['borrowed', 'overdue']) // Buku yang masih dipinjam (termasuk terlambat)
        ->count();
        
        // Get the number of overdue returns (Keterlambatan Pengembalian)
        // Buku yang sudah terlambat (status 'overdue')
        $overdueReturns = LoanBook::whereHas('loan', function($query) use ($user) {
            $query->where('user_id', $user->id); // Pastikan hanya peminjaman yang terkait dengan user ini
        })
        ->where('status', 'overdue') // Buku yang terlambat
        ->count();
        $eduLevels = EduLevel::all(); // Ambil semua data level pendidikan
        return view('user.dashboard', compact('title', 'user', 'eduLevels','totalPeminjaman', 'bukuSedangDipinjam', 'overdueReturns')); // View untuk user dashboard
    }
    
    public function profile()
    {
        $user = Auth::user(); // Ambil data user yang sedang login
        $eduLevels = EduLevel::all(); // Ambil semua data level pendidikan
        $title = 'Dashboard User';
        return view('user.profile', compact('title', 'user', 'eduLevels')); // View untuk profil pengguna
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user(); // Ambil data user yang sedang login

        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email, ' . $user->id,
            'phone' => 'nullable|string|max:15',
            'edu_level_id' => 'nullable|exists:edu_levels,id',
            'dob' => 'nullable|date',
            'upload_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
        ]);

        
        if ($request->hasFile('upload_profile')) {
            $profilePath = $request->file('upload_profile')->store('profiles', 'public');
            $user->profile_picture = $profilePath;
        }

        $user->update([
            'edu_level_id' => $validated['edu_level_id'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'dob' => $validated['dob'],
        ]);

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function changePassword(Request $request)
    {
        // Validate the password fields
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:8|confirmed', // Ensures password and confirmation match
            'password_confirmation' => 'required|string|min:8', // Ensure confirmation matches
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Get the currently authenticated user
        $user = Auth::user();

        // Update the password with hashed value
        $user->password = Hash::make($request->input('password'));
        $user->save();

        // Redirect with success message
        return redirect()->back()->with('success', 'Password Berhasil diperbaharui.');
    }

    public function notification()
    {
        $title = "Notification";
        return view('errors.404', compact('title'));
    }
}
