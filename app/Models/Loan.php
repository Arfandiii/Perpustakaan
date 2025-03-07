<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{

    protected $fillable = [
        'user_id', // Menambahkan user_id ke fillable
        'book_id',
        'loan_date',
        'loan_duration',
        'status', // Jika ada kolom untuk tanggal pengembalian
    ];
    // Di dalam model Loan
    protected $casts = [
        'loan_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // Relasi ke LoanBook
    public function loanBooks()
    {
        return $this->hasOne(LoanBook::class);
    }
}
