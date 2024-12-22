<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3), // Judul buku dengan 3 kata
            'category_id' => $this->faker->numberBetween(1, 3),
            'author' => $this->faker->name, // Nama penulis acak
            'publisher' => $this->faker->company, // Nama penerbit acak
            'published_year' => $this->faker->year, // Tahun terbit acak
            'description' => $this->faker->paragraph, // Deskripsi buku
            'stock' => $this->faker->numberBetween(1, 50), // Stok antara 1 hingga 50
            'cover_image' => $this->faker->imageUrl(200, 300, 'books', true, 'Cover'), // URL gambar sampul
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
