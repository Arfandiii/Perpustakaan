<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Loan;
use Illuminate\Support\Facades\Auth; // Pastikan ini ada di bagian atas file controller
use Illuminate\Http\Request;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'List Peminjaman';

        // Breadcrumbs array
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('admin.dashboard'), 'icon' => 'home'],
            ['name' => 'Peminjaman', 'url' => route('admin.loans.index'), 'icon' => 'loan-list']
        ];

        $loans = Loan::with('user', 'book')->latest()->paginate(10);
        $loans->appends(request()->query());

        return view('admin.loans.index', compact('title', 'breadcrumbs', 'loans'));
    }

    // Controller untuk admin yang menampilkan peminjaman pending
    public function showPendingLoans()
    {
        $loans = Loan::where('status', 'pending')->get(); // Ambil data peminjaman dengan status 'pending'
        return view('admin.loans.index', compact('loans'));
    }

    // Controller untuk memfilter peminjaman yang sudah disetujui atau ditolak
    public function showApprovedLoans()
    {
        $loans = Loan::where('status', 'approved')->get();
        // return view('admin.loans.approved', compact('loans'));
        return view('admin.loans.index', compact('loans'));
    }

    public function showRejectedLoans()
    {
        $loans = Loan::where('status', 'rejected')->get();
        // return view('admin.loans.rejected', compact('loans'));
        return view('admin.loans.index', compact('loans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Peminjaman Buku';
    }

    public function confirmLoanUser($slug)
    {
        $title = 'Peminjaman Buku';

        $book = Book::with('category')->where('slug', $slug)->firstOrFail();

        return view('loan-book', compact('book', 'title'));
    }

    public function createLoanUser(Request $request, $slug)
    {
        $user = Auth::user();
        $book = Book::where('slug', $slug)->firstOrFail();

        // Pastikan stok buku tersedia
        if ($book->stock <= 0) {
            return redirect()->back()->with('error', 'Buku tidak tersedia.');
        }

        // Cek apakah user sudah mengajukan peminjaman buku ini sebelumnya
        $existingLoan = Loan::where('user_id', $user->id)
                            ->where('book_id', $book->id)
                            ->where('status', 'pending')
                            ->first();

        if ($existingLoan) {
            return redirect()->route('loans.confirmLoan', $book->slug)->with('info', 'Pengajuan peminjaman Anda sudah ada dalam antrian.');
        }

        // Kurangi stok buku
        $book->stock -= 1;
        $book->save();

        // Simpan data peminjaman
        Loan::create([
            'user_id' => Auth::user()->id,
            'book_id' => $book->id,
            'loan_date' => now()->toDateString(),
            'status' => 'pending', // Status peminjaman
        ]);

        return redirect()->back()->with('success', 'Peminjaman berhasil, tunggu konfirmasi dari admin');
    }

    public function approveLoan($loanId)
    {
        $loan = Loan::findOrFail($loanId);
        $loan->status = 'approved';
        $loan->save();

        // Decrease book stock
        $loan->book->decrement('stock');

        return redirect()->route('admin.loans.index')->with('success', 'Peminjaman disetujui.');
    }

    public function rejectLoan($loanId)
    {
        $loan = Loan::findOrFail($loanId);
        $loan->status = 'rejected';
        $loan->save();

        return redirect()->route('admin.loans.index')->with('success', 'Peminjaman ditolak.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Loan $loan)
    {
        $title = 'Manage Peminjaman Buku';
        // Breadcrumbs array
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('admin.dashboard'), 'icon' => 'home'],
            ['name' => 'Peminjaman', 'url' => route('admin.loans.index'), 'icon' => 'loan-list']
        ];
        return view('admin.loans.show', compact('loan', 'title', 'breadcrumbs'));
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
    public function update(Request $request, Loan $loan)
    {
        $validated = $request->validate([
            'loan_date' => 'required|date',
            'return_date' => 'required|date',
            'status' => 'required|in:borrowed,returned,overdue',
        ]);
        
        // Validasi status peminjaman
        if ($validated['status'] === 'borrowed' && !$validated['return_date']) {
            return back()->withErrors(['return_date' => 'Tanggal pengembalian harus diatur.']);
        }
        
        
        // Update data peminjaman
        $loan->update([
            'loan_date' => $validated['loan_date'],
            'return_date' => $validated['return_date'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.loans.index')->with('success', 'Peminjaman berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
