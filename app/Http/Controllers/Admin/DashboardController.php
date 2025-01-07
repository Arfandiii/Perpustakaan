<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Loan;
use App\Models\LoanBook;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Dashboard Admin';

        // Ambil data peminjaman per hari (minggu ini) dari loan_book
        $loansPerDay = DB::table('loan_book')
            ->select(DB::raw('DAYNAME(created_at) as day_of_week'), DB::raw('count(*) as total_loans'))
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->groupBy(DB::raw('DAYNAME(created_at)'))
            ->get();

        $days = $loansPerDay->pluck('day_of_week');
        $total_loans = $loansPerDay->pluck('total_loans');

        // Ambil data kategori buku populer dari loan_book melalui loans
        $categoryData = DB::table('loan_book')
            ->join('loans', 'loan_book.loan_id', '=', 'loans.id') // Gabung dengan tabel loans
            ->join('books', 'loans.book_id', '=', 'books.id') // Gabung dengan tabel books melalui loans
            ->join('book_categories', 'books.category_id', '=', 'book_categories.id') // Gabung dengan tabel book_categories
            ->select('book_categories.name as category', DB::raw('count(*) as total_loans'))
            ->groupBy('book_categories.name')
            ->get();

        $categories = $categoryData->pluck('category');
        $categoryLoans = $categoryData->pluck('total_loans');

        // Ambil data aktivitas pengguna berdasarkan login terakhir
        $userActivity = DB::table('users')
            ->where('role', 'user')  // Pastikan hanya pengguna dengan role 'user'
            ->select(DB::raw('DAYNAME(last_login_at) as day_of_week'), DB::raw('count(*) as total_logins'))
            ->whereNotNull('last_login_at')  // Hanya ambil pengguna yang memiliki login terakhir
            ->groupBy(DB::raw('DAYNAME(last_login_at)'))
            ->get();

        $activityDays = $userActivity->pluck('day_of_week');
        $logins = $userActivity->pluck('total_logins');


        $activityDays = $userActivity->pluck('day_of_week');
        $logins = $userActivity->pluck('total_logins');

        $activities = [];

        // Get recent user registrations
        $registrations = User::where('role', 'user')->latest()->take(5)->get()->map(function($user) {
            return [
                'type' => 'registration',
                'name' => $user->name,
                'time' => $user->created_at->diffForHumans(),
                'avatar' => $user->profile_picture,
                'status' => 'Baru'
            ];
        });

        // Get recent book loans
        $loans = Loan::latest()->take(5)->get()->map(function($loan) {
            return [
                'type' => 'loan',
                'name' => $loan->book->title,
                'time' => $loan->created_at->diffForHumans(),
                'avatar' => $loan->user->profile_picture,
                'status' => 'Peminjaman',
                'user' => $loan->user->name
            ];
        });

        // Merge all activities
        $activities = $registrations->merge($loans)
                                    ->sortByDesc('time') // Sort by latest time
                                    ->take(5);           // Take only the last 5 activities

        // Breadcrumbs array
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('admin.dashboard'), 'icon' => 'home'],
        ];

        // Ambil total jumlah user dan buku
        $totalUsers = User::where('role', 'user')->count();
        $totalBooks = Book::count();
        $totalLoans = LoanBook::count();
        // $totalLoans = Loan::count();

        return view('admin.dashboard', compact('days', 'total_loans', 'categories', 'categoryLoans','activities', 'activityDays', 'logins','title', 'breadcrumbs', 'totalUsers', 'totalBooks', 'totalLoans')); // View untuk admin dashboard
    }

    // tambahkan fungsi setting
    public function setting()
    {
        $user = Auth::user();
        $title = 'Settings';

        // Breadcrumbs array
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('admin.dashboard'), 'icon' => 'home'],
            ['name' => 'Edit', 'url' => route('admin.settings'), 'icon' => 'edit'],
        ];

        return view('admin.settings', compact('user', 'title', 'breadcrumbs')); // View untuk admin settings
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
    }// fungsi untuk mengubah password
    
    public function updateProfile(Request $request)
    {
        $user = Auth::user(); // Ambil data user yang sedang login

        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email, ' . $user->id,
            'upload_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
        ]);

        
        if ($request->hasFile('upload_profile')) {
            $profilePath = $request->file('upload_profile')->store('profiles', 'public');
            $user->profile_picture = $profilePath;
        }

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function notification()
    {
        $title = "Notification";
        return view('admin.errors.404', compact('title'));
    }
}
