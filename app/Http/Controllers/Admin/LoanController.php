<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Loan;
use App\Models\LoanBook;
use Illuminate\Support\Facades\Auth; // Pastikan ini ada di bagian atas file controller
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = 'List Peminjaman';

        // Breadcrumbs array
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('admin.dashboard'), 'icon' => 'home'],
            ['name' => 'Peminjaman', 'url' => route('admin.loans.index'), 'icon' => 'loan-list']
        ];
        
        $status = $request->query('status');
        $search = $request->query('search');

        // Initialize the loan query
        $loans = Loan::with('user', 'book')
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->whereHas('user', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('book', function ($query) use ($search) {
                        $query->where('title', 'like', '%' . $search . '%');
                    });
                });
            })
            ->latest()
            ->paginate(10);

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
        
        // Validasi stok buku
        if ($book->stock <= 0) {
            return redirect()->back()->with('error', 'Stok buku tidak tersedia.');
        }
        
        // Validasi input durasi
        $request->validate([
            'duration' => 'required|integer|in:5,7,14',
        ]);
        
        // Cek apakah user sudah mengajukan peminjaman buku ini sebelumnya
        $existingLoan = Loan::where('user_id', $user->id)
        ->where('book_id', $book->id)
        ->where('status', 'pending')
        ->first();
        
        if ($existingLoan) {
            return redirect()->route('loans.confirmLoan', $book->slug)
            ->with('info', 'Pengajuan peminjaman Anda sudah ada dalam antrian.');
        }
        
        // Kurangi stok buku
        $book->decrement('stock');

        // Simpan data peminjaman
        Loan::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'loan_date' => now(),
            'loan_duration' => $request->duration,
            'status' => 'pending', // Status awal adalah pending
        ]);
        
        return redirect()->back()->with('success', 'Peminjaman berhasil diajukan dengan durasi ' . $request->duration . ' hari. Tunggu konfirmasi dari admin.');
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
            ['name' => 'Peminjaman', 'url' => route('admin.loans.index'), 'icon' => 'loan-list'],
            ['name' => 'Detail Peminjaman', 'url' => route('admin.loans.show', $loan), 'icon' => 'loan-book']
        ];

        // Ambil data dari relasi loanBook
        $loanBook = $loan->loanBooks;

        return view('admin.loans.show', compact('loan', 'loanBook', 'title', 'breadcrumbs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Loan $loan)
    {
        $title = 'Manage Peminjaman Buku';
        // Breadcrumbs array
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('admin.dashboard'), 'icon' => 'home'],
            ['name' => 'Peminjaman', 'url' => route('admin.loans.index'), 'icon' => 'loan-list'],
            ['name' => 'Detail Peminjaman', 'url' => route('admin.loans.show', $loan), 'icon' => 'loan-book'],
            ['name' => 'Peminjaman', 'url' => route('admin.loans.index'), 'icon' => 'edit'],
        ];
        
        return view('admin.loans.edit', compact('loan', 'title', 'breadcrumbs'));
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, Loan $loan)
    // {
    //     $validated = $request->validate([
    //         'loan_date' => 'required|date',
    //         'return_date' => 'required|date',
    //         'status' => 'required|in:borrowed,returned,overdue',
    //     ]);
        
    //     // Validasi status peminjaman
    //     if ($validated['status'] === 'borrowed' && !$validated['return_date']) {
    //         return back()->withErrors(['return_date' => 'Tanggal pengembalian harus diatur.']);
    //     }
        
        
    //     // Update data peminjaman
    //     $loan->update([
    //         'loan_date' => $validated['loan_date'],
    //         'return_date' => $validated['return_date'],
    //         'status' => $validated['status'],
    //     ]);

    //     return redirect()->route('admin.loans.index')->with('success', 'Peminjaman berhasil diperbarui.');
    // }
    public function update(Request $request, $id)
    {
        $loan = Loan::findOrFail($id);
        $book = $loan->book; // Relasi ke tabel books

        // Pastikan return_date yang diberikan valid
        $returnDate = $request->return_date ? Carbon::parse($request->return_date) : null;

        // Handle action: approve
        if ($request->action === 'approve') {
            if ($loan->status !== 'pending') {
                return redirect()->route('admin.loans.index')->with('error', 'Status peminjaman tidak valid untuk disetujui.');
            }

            // Pindahkan data ke tabel loan_book
            LoanBook::create([
                'loan_id' => $loan->id,
                'status' => 'borrowed',
                'return_date' => $returnDate ? $returnDate : now()->addDays($loan->loan_duration), // Gunakan return_date manual jika ada
            ]);

            // Perbarui status loan menjadi approved
            $loan->update(['status' => 'approved']);

            return redirect()->route('admin.loans.index')->with('success', 'Pengajuan berhasil disetujui.');
        }

        // Handle action: reject
        if ($request->action === 'reject') {
            if ($loan->status !== 'pending') {
                return redirect()->route('admin.loans.index')->with('error', 'Status peminjaman tidak valid untuk ditolak.');
            }

            // Kembalikan stok buku karena pengajuan ditolak
            $book->increment('stock');

            // Perbarui status loan menjadi rejected
            $loan->update(['status' => 'rejected']);

            return redirect()->route('admin.loans.index')->with('success', 'Pengajuan berhasil ditolak.');
        }

        // Jika aksi tidak valid
        return redirect()->back()->with('error', 'Aksi tidak valid.');
    }


    public function updateStatus(Request $request, $id)
    {
        $loanBook = LoanBook::findOrFail($id);

        // Validasi input data
        $request->validate([
            'return_date' => 'required|date',
            'status' => 'required|in:borrowed,returned,overdue',
        ]);

        // Perbarui tanggal pengembalian dan status
        $loanBook->update([
            'return_date' => Carbon::parse($request->return_date),
            'status' => $request->status,
        ]);

        return redirect()->route('admin.loans.index')
            ->with('success', 'Data peminjaman buku berhasil diperbarui.');

    }

    public function updateLoanBook($id)
    {
        $loanBook = LoanBook::findOrFail($id); // Ambil data loan_book berdasarkan ID

        $title = 'Manage Peminjaman Buku';
        // Breadcrumbs array
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('admin.dashboard'), 'icon' => 'home'],
            ['name' => 'Peminjaman', 'url' => route('admin.loans.index'), 'icon' => 'loan-list'],
            ['name' => 'Detail Peminjaman', 'url' => route('admin.loans.show', $id), 'icon' => 'loan-book'],
            ['name' => 'Edit Peminjaman', 'url' => route('admin.loans.editLoanBook', $id), 'icon' => 'edit'],
        ];
        return view('admin.loans.edit-loan-book', compact('loanBook', 'title', 'breadcrumbs'));
    }   


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $book = Loan::findOrFail($id);
            $book->delete(); // Menghapus data buku dari database
            return redirect()->route('admin.loans.index')
            ->with('success', 'Data peminjaman berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.loans.index')
            ->with('error', 'Terjadi kesalahan saat menghapus data peminjaman: ' . $e->getMessage());
        }
    }
}
