<?php

namespace App\Console\Commands;

use App\Models\LoanBook;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateBookStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:book-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status buku yang terlambat dikembalikan';
    
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Mengambil semua data pinjaman yang terlambat
        $loans = LoanBook::where('status', 'borrowed')
            ->where('return_date', '<', Carbon::now()) // Menyaring yang belum dikembalikan
            ->get();

        foreach ($loans as $loan) {
            // Mengubah status buku yang terlambat
            $loan->status = 'overdue';
            $loan->save();

            $this->info("Status buku dengan ID {$loan->id} telah diperbarui menjadi terlambat.");
        }
    }
}
