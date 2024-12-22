<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Dashboard Admin';

        // Breadcrumbs array
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('admin.dashboard'), 'icon' => 'home'],
        ];

        // Ambil total jumlah user dan buku
        $totalUsers = User::where('role', 'user')->count();
        $totalBooks = Book::count();
        $totalLoans = Loan::count();

        return view('admin.dashboard', compact('title', 'breadcrumbs', 'totalUsers', 'totalBooks', 'totalLoans')); // View untuk admin dashboard
    }
}
