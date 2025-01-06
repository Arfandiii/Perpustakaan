<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory;
    protected $guarded= ["id"];

    // Mutator untuk membuat slug otomatis
    public static function boot()
    {
        parent::boot();

        static::creating(function ($book) {
            $book->slug = Str::slug($book->title);
        });

        static::updating(function ($book) {
            $book->slug = Str::slug($book->title);
        });
    }
    
    public function category()
    {
        return $this->belongsTo(BookCategory::class);
    }

    public function loan()
    {
        return $this->hasMany(Loan::class);
    }

    // Relasi ke LoanBook
    public function loanBooks()
    {
        return $this->hasMany(LoanBook::class);
    }
}
