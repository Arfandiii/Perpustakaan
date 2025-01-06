<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Prunable;

class LoanBook extends Model
{
    use HasFactory, Prunable;

    protected $table = 'loan_book';

    protected $fillable = [
        'loan_id',
        'book_id',
        'status',
        'return_date',
    ];

    /**
     * Relasi ke model Loan.
     */
    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    /**
     * Relasi ke model Book.
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
