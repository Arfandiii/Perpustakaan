<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id(); // id INT PRIMARY KEY AUTO_INCREMENT
            $table->foreignId('category_id')->nullable()->constrained('book_categories')->nullOnDelete();
            $table->string('title', 255); // title VARCHAR(255)
            $table->string('slug')->unique(); // slug untuk url
            $table->string('author', 255); // author VARCHAR(255)
            $table->string('publisher', 255); // publisher VARCHAR(255)
            $table->year('published_year'); // published_year YEAR
            $table->text('description')->nullable(); // description TEXT
            $table->integer('stock'); // stock INT
            $table->string('cover_image', 255)->nullable(); // cover_image VARCHAR(255)
            $table->timestamps(); // created_at TIMESTAMP and updated_at TIMESTAMP
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
