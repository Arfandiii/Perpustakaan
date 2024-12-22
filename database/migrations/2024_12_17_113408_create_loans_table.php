<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Referensi ke pengguna
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade'); // Referensi ke buku
            $table->dateTime('loan_date');
            $table->dateTime('return_date')->nullable(); // Tanggal pengembalian, bisa kosong
            $table->enum('status', ['pending','borrowed','returned','overdue'])->default('pending'); // Status peminjaman
            $table->timestamps();   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
