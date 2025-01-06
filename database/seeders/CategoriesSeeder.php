<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menambahkan kategori buku ke tabel categories
        DB::table('book_categories')->insert([
            ['name' => 'Pendidikan'],
            ['name' => 'Motivasi'],
            ['name' => 'Masakan'],
            ['name' => 'Penunjang Pelajaran'],
            ['name' => 'Kesehatan'],
            ['name' => 'Pendidikan Anak'],
            ['name' => 'Kata Hati'],
            ['name' => 'Pengembangan Diri'],
            ['name' => 'Budidaya'],
            ['name' => 'Diet and Health'],
            ['name' => 'Keterampilan SMK'],
            ['name' => 'Biografi'],
            ['name' => 'Buku Bijak'],
            ['name' => 'Business & Economic'],
            ['name' => 'Bisnis / Inspirasi'],
            ['name' => 'Keterampilan untuk Pelatihan Kerja'],
            ['name' => 'Agama'],
            ['name' => 'Fiksi/Novel'],
            ['name' => 'Kesehatan Islami'],
            ['name' => 'Business & Economics'],
            ['name' => 'Psikologi'],
            ['name' => 'Entertainment'],
            ['name' => 'Fashion'],
            ['name' => 'Ilmu Sosial'],
            ['name' => 'Komunikasi'],
            ['name' => 'Ilmu Perpustakaan'],
            ['name' => 'Self Improvement'],
            ['name' => 'School Books'],
            ['name' => 'Hukum'],
            ['name' => 'IPA'],
            ['name' => 'Sosiologi'],
            ['name' => 'Education & Teaching'],
            ['name' => 'Ilmu Pengetahuan'],
            ['name' => 'Agama Islam'],
            ['name' => 'Pendalaman materi SMK'],
            ['name' => 'Bahasa Inggris'],
            ['name' => 'cooking'],
            ['name' => 'Bahasa Mandarin'],
            ['name' => 'Keterampilan'],
            ['name' => 'Penunjang Pelajaran SMA'],
            ['name' => 'fiksi'],
            ['name' => 'novel'],
            ['name' => 'bisnis'],
        ]);
    }
}
