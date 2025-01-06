<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DiceSimilarityHelper;
use App\Helpers\TextPreprocessingHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DiceSimilarityController extends Controller
{
    private $books = [
        ['id' => 1, 'title' => '45 MODEL PEMBELAJARAN SPEKTAKULER', 'author' => 'Jasa Ungguh Muliawan', 'publisher' => 'Ar-Ruzz Media'],
        ['id' => 2, 'title' => '19 KIAT SUKSES MEMBANGKITKAN Motivasi BELAJAR PESERTA DIDIK', 'author' => 'Erwin Widianworo S.Pd.', 'publisher' => 'Ar-Ruzz Media'],
        ['id' => 3, 'title' => '9 JURUS CERDAS MENYONGSONG KARIER GEMILANG', 'author' => 'H. Heri Kuswara, S.Kom, M.Kom.', 'publisher' => 'Ar-Ruzz Media'],
        ['id' => 4, 'title' => '71 RAHASIA SUKSES MENJADI GURU: Plus Ide-ide Kreatif Untuk Anak', 'author' => 'Fatiharifah & Nisa Yustisia', 'publisher' => 'Ar-Ruzz Media'],
        ['id' => 5, 'title' => '101 JURUS JITU MENJADI GURU HEBAT', 'author' => 'Haryono', 'publisher' => 'Ar-Ruzz Media'],
        ['id' => 6, 'title' => '100 MASALAH PEMBELAJARAN : Identifikasi dan Solusi Masalah Teknis Pengelolaan Pembelajaran di Kelas', 'author' => 'Lubis Grafura, M.Pd & Ari Wijayanti, S.Pd.', 'publisher' => 'Ar-Ruzz Media'],
        ['id' => 7, 'title' => '100+1 Cara Bahagia: 100 Inspirasi, 1 Aksi', 'author' => 'Ainun Mahya & Triyanto', 'publisher' => 'Trans Idea Publishing'],
        ['id' => 8, 'title' => '101 RESEP KUE KERING KLASIK & MODERN', 'author' => 'Ny. Rita TN', 'publisher' => 'Kata Hati'],
        ['id' => 9, 'title' => '18 Profesi Asyik Zaman Now', 'author' => 'Keen Achroni', 'publisher' => 'Trans Idea Publishing'],
        ['id' => 10, 'title' => '50 Dongeng Terpopuler Dunia: Fabel, Legenda, dan Kisah-kisah Lainnya', 'author' => 'Siti Masruroh', 'publisher' => 'Trans Idea Publishing'],
        // ['id' => 11, 'title' => '68 MODEL PEMBELAJARAN INOVATIF DALAM KURIKULUM 2013', 'author' => 'Aris Shoimin', 'publisher' => 'Ar-Ruzz Media'],
        // ['id' => 12, 'title' => '50 Perkara tentang Jodoh', 'author' => 'Dwi Suwiknyo', 'publisher' => 'Trans Idea Publishing'],
        // ['id' => 13, 'title' => '75 RAHASIA ANAK CERDAS: Mengenali Potensi dan Strategi Mengembangkan Kecerdasan Buah Hati', 'author' => 'N. Yustisia', 'publisher' => 'Kata Hati'],
        // ['id' => 14, 'title' => '78 Resep Antikanker, Diabetes, Kolesterol, Asam Urat', 'author' => 'Dewi Kurniasari', 'publisher' => 'Trans Idea Publishing'],
        // ['id' => 15, 'title' => '99 PERMAINAN EDUKATIF UNTUK MELATIH KECERDASAN & KREATIVITAS ANAK', 'author' => 'Wikanda Satria Putra', 'publisher' => 'Penunjang Pelajaran'],
        // ['id' => 16, 'title' => '68 BUAH AJAIB PENANGKAL PENYAKIT', 'author' => 'Wikanda Satria Putra', 'publisher' => 'Kata Hati'],
        // ['id' => 17, 'title' => '9 Smart Strategies to Be A Young Entrepreneur: Langkah Jitu Menjadi Pengusaha Sukses di Usia Muda', 'author' => '', 'publisher' => 'Ar-Ruzz Media'],
        // ['id' => 18, 'title' => 'Akuaponik: Bisnis Unik Peluang Menarik', 'author' => 'Aditya Prananta', 'publisher' => 'Trans Idea Publishing'],
        // ['id' => 19, 'title' => 'Ampuhnya Enzim Tubuh', 'author' => 'Eka Sumaryati dan Karina Tyas Widyaningrum', 'publisher' => 'Trans Idea Publishing'],
        // ['id' => 20, 'title' => 'Aneka Kerajinan Kain Perca', 'author' => 'Puput Lestari', 'publisher' => 'Litera Media Creativa'],
        // ['id' => 21, 'title' => 'Aneka Kreasi Aksesoris dari Barang Bekas (Sedotan dan Botol Plastik)', 'author' => 'Musiatun Wahaningsih', 'publisher' => 'Litera Media Creativa'],
        // ['id' => 22, 'title' => 'Aneka Kreasi Gift Box', 'author' => 'Fatiah Arinda', 'publisher' => 'Litera Media Creativa'],
        // ['id' => 23, 'title' => 'Apa yang Terjadi di Abad 20?: Kecil-kecil Hafal Peristiwa Sejarah Dunia', 'author' => 'Husna Widiani', 'publisher' => 'Trans Idea Publishing'],
        // ['id' => 24, 'title' => 'ANALISIS & STRATEGI MENINGKATKAN DAYA SAING SEKOLAH', 'author' => 'Mohammad Saroni', 'publisher' => 'Ar-Ruzz Media'],
        // ['id' => 25, 'title' => 'B.J. HABIBIE: Guru Terbesar Saya Adalah Otak Saya', 'author' => 'Ade Ma\'ruf', 'publisher' => 'Ar-Ruzz Media'],
        // ['id' => 26, 'title' => 'Belajar & Cerdas Bersama Psikolog Dunia: Kritik terhadap Dunia Pendidikan, Pembelajaran, dan Kecerdasan', 'author' => 'C. George Boeree; Penerjemah: Abdul Qodir Shaleh', 'publisher' => 'Psikologi'],
        // ['id' => 27, 'title' => 'Belajar Teknik Merangkai Janur untuk Dekorasi', 'author' => 'Cikal Gading', 'publisher' => 'Lembaga Kajian Profesi'],
        // ['id' => 28, 'title' => 'Berkenalan dengan Teknik Vertikultur: Tata Cara dan Keunggulannya', 'author' => 'Kurniawan Dwi Setyadi', 'publisher' => 'Trans Idea Publishing'],
        // ['id' => 29, 'title' => 'BERDAMAI DENGAN ALZHEIMER: Strategi Menjadi Caregiver bagi Penderita Penyakit Alzheimer', 'author' => 'Rose Kusuma', 'publisher' => 'Kata Hati'],
        // ['id' => 30, 'title' => 'BERIBADAH TANPA HENTI: Panduan Beribadah Bagi Wanita Haid', 'author' => 'Irham Sya\'roni & Sawaun Amin', 'publisher' => 'Kata Hati'],
        // ['id' => 31, 'title' => 'BEST PRACTICE: Langkah Efektif Meningkatkan Kualitas Karakter Warga Sekolah', 'author' => 'Mohammad Saroni', 'publisher' => 'Ar-Ruzz Media'],
        // ['id' => 32, 'title' => 'Bill Gates: Cara Kaya Ala Pendiri Microsoft', 'author' => 'Dayu Pratyahara', 'publisher' => 'Buku Bijak'],
        // ['id' => 33, 'title' => 'Bisnis Modal 10 Jutaan: Inspirasi Bisnis dengan Modal Minimal Untung Maksimal', 'author' => 'Oppi Andini', 'publisher' => 'Garasi'],
        // ['id' => 34, 'title' => 'Budidaya Ayam Potong: Peluang Usaha Unggulan', 'author' => 'Saelindra', 'publisher' => 'Litera Media Creativa'],
        // ['id' => 35, 'title' => 'BRANDED SCHOOL: Membangun Sekolah Unggul Berbasis Peningkatan Mutu', 'author' => 'Barnawi & Mohammad Arifin', 'publisher' => 'Ar-Ruzz Media'],
        // ['id' => 36, 'title' => 'BUKU PANDUAN GURU HEBAT INDONESIA: Rahasia Menjadi Guru Hebat dengan Keahlian Public Speaking, Menulis Buku & Artikel di Media Massa', 'author' => 'Dr. Aminulloh Syarbini, M.Ag.', 'publisher' => 'Ar-Ruzz Media'],
        // ['id' => 37, 'title' => 'Buku Panduan Operator Komputer', 'author' => 'Litharia Mandavena Sari', 'publisher' => 'Lembaga Kajian Profesi'],
        // ['id' => 38, 'title' => 'BUKU PINTAR HAJI DAN UMRAH', 'author' => 'K.H. Imam Jazuli, M.A.', 'publisher' => 'Ar-Ruzz Media'],
        // ['id' => 39, 'title' => 'Buku Pintar Olahraga Sehat: Penyakit Bablas dengan Olahraga yang Pas', 'author' => 'Prof. Dr. dr. Anies, M.Kes, PKK', 'publisher' => 'Buku Bijak'],
        // ['id' => 40, 'title' => 'BUNG HATTA & PENDIDIKAN KARAKTER', 'author' => 'Dr. Silfia Hanani, M.Si., Susi Ratna Sari, M.Pd', 'publisher' => 'Ar-Ruzz Media'],
        // ['id' => 41, 'title' => 'CAHAYAMU TAK BISA KUTAWAR: Novel Biografi Mahfud MD', 'author' => 'Aguk Irawan MN', 'publisher' => 'Ar-Ruzz Media'],
        // ['id' => 42, 'title' => 'CANTIK DAN SEHAT DENGAN HERBAL: Aneka Racikan & Ramuan Rahasia Khusus Wanita', 'author' => 'Mudha Al-Lubna', 'publisher' => 'Kata Hati'],
        // ['id' => 43, 'title' => 'Cantik Luar Dalam ala Muslimah', 'author' => 'Qari\'ah Hamid, S.S', 'publisher' => 'Trans Idea Publishing'],
        // ['id' => 44, 'title' => 'CARA CEPAT BELAJAR BACA TULIS AL-QURAN UNTUK SMA-MA', 'author' => 'Abu Firly Bassam Taqiy', 'publisher' => 'Ar-Ruzz Media'],
        // ['id' => 45, 'title' => 'Cara Cerdas Budidaya Jahe: Panen Maksimal', 'author' => 'Keen Achroni', 'publisher' => 'Trans Idea Publishing'],
        // ['id' => 46, 'title' => 'CARA CERDAS MELEJITKAN IQ KREATIF ANAK', 'author' => 'Tuhana Taufiq Andrianto', 'publisher' => 'Kata Hati'],
        // ['id' => 47, 'title' => 'CHARACTER BUILDING : Optimalisasi Peran Pendidikan dalam Pengembangan Ilmu & Pembentukan Karakter Bangsa', 'author' => 'Ngainun Naim', 'publisher' => 'Ar-Ruzz Media'],
        // ['id' => 48, 'title' => 'Couple Book for Husband and Wife: Membangun Surga dalam Rumah Tangga', 'author' => 'Luluk Bambang Sulistyo & Nur Iswanti Hasani', 'publisher' => 'Trans Idea Publishing'],
        // ['id' => 49, 'title' => 'Cut Nyak Dien: Pejuang Wanita yang Tak Kenal Menyerah', 'author' => 'Arslan Mukhtar', 'publisher' => 'Edulitera'],
        // ['id' => 50, 'title' => 'DAUN DAHSYAT: Pencegah & Penyembuh Penyakit', 'author' => 'Tim Afin and Friends', 'publisher' => 'Kata Hati'],
        // ['id' => 51, 'title' => 'DESAIN PEMBELAJARAN BERBASIS PENDIDIKAN KARAKTER', 'author' => 'Asmaun Sahlan & Angga Teguh Prastyo', 'publisher' => 'Ar-Ruzz Media'],
        // ['id' => 52, 'title' => 'DESAIN PEMBELAJARAN PENDIDIKAN: Tata Rancang Pembelajaran Menuju Pencapaian Kompetensi', 'author' => 'Novan Ardi Wiyani, M.Pd.I', 'publisher' => 'Ar-Ruzz Media'],
        // ['id' => 53, 'title' => 'DIY Life Hacks: 99 Cara Bikin Hidup Lebih Mudah', 'author' => 'Darma Dwinov', 'publisher' => 'Trans Idea Publishing'],
        // ['id' => 54, 'title' => 'Don\'t Say "Go" but Say "Let\'s Go" Apa-apa Saja yang Harus dilakukan Manajer dan Supervisor', 'author' => 'Keen Achroni', 'publisher' => 'Trans Idea Publishing'],
        // ['id' => 55, 'title' => 'Ekspres Belajar Bahasa Arab', 'author' => 'Sigit Murdiantoro, S. Pd', 'publisher' => 'Trans Idea Publishing'],
        // ['id' => 56, 'title' => 'Enjoying Life with Hypnosis', 'author' => 'Eiroul BM', 'publisher' => 'Trans Idea Publishing'],
        // ['id' => 57, 'title' => 'From Fangirling to Something: Mengubah Hobi Menjadi Prestasi', 'author' => 'Tristanti Wahyuni', 'publisher' => 'Ar-Ruzz Media'],
        // ['id' => 58, 'title' => 'FULL DAY SCHOOL: Konsep, Manajemen, & Quality Control', 'author' => 'Jamal Ma’mur Asmani', 'publisher' => 'Ar-Ruzz Media'],
        // ['id' => 59, 'title' => 'Gagal Bukan Berarti Sia-Sia', 'author' => 'Teo Sutan', 'publisher' => 'Trans Idea Publishing'],
        // ['id' => 60, 'title' => 'Girl\'s Guide for Health and Beauty', 'author' => 'Karina Tyas', 'publisher' => 'Trans Idea Publishing'],
        // ['id' => 61, 'title' => 'GURU GOKIL ZAMAN NOW: Cara Unik Menemukan Kreativitas Tanpa Batas', 'author' => 'Asrul Right', 'publisher' => 'Ar-Ruzz Media'],
        // ['id' => 62, 'title' => 'GURU PROFESIONAL: Pedoman Kerja, Kualifikasi, & Kompetensi Guru', 'author' => 'Jamil Suprihatiningrum, M.Pd.Si', 'publisher' => 'Ar-Ruzz Media'],
        // ['id' => 63, 'title' => 'Cut Nyak Meutia: Pejuang Aceh yang Jelita dan Pemberani', 'author' => 'Ananda Mona', 'publisher' => 'Edulitera'],
        // ['id' => 64, 'title' => 'Hafalan Otodidak Percakapan Harian Bahasa Mandarin', 'author' => 'Thia R', 'publisher' => 'Trans Idea Publishing'],
        // ['id' => 65, 'title' => 'Handmade Bantal Unik dan Lucu dengan Bahan-Bahan Sederhana', 'author' => 'Muharini M.', 'publisher' => 'Lembaga Kajian Profesi'],
        // ['id' => 66, 'title' => 'Hijab Style For Teens: Dari Sekolah, Gaul, hingga Pesta', 'author' => 'Afin Murtie, Sanggar Rias Arsita', 'publisher' => 'Trans Idea Publishing'],
        // ['id' => 67, 'title' => 'Hipnosis: Seni Mengendalikan Pikiran', 'author' => 'Eiroul BM', 'publisher' => 'Trans Idea Publishing'],
        // ['id' => 68, 'title' => 'HYPNOTEACHING: Revolusi Gaya Mengajar untuk Melejitkan Prestasi Siswa', 'author' => 'Ali Akbar Navis, Spd. CHt, Cl.', 'publisher' => 'Ar-Ruzz Media'],
        // ['id' => 69, 'title' => 'HYPNOTEACHING: Seni Ajar Mengeksplorasi Otak Peserta Didik', 'author' => 'N. Yustisia', 'publisher' => 'Ar-Ruzz Media'],
        // ['id' => 70, 'title' => 'GAGALNYA PENDIDIKAN KARAKTER: Analisis dan Solusi Pengendalian Karakter Emas Anak Didik', 'author' => 'Mohammad Takdir Ilahi', 'publisher' => 'Ar-Ruzz Media'],
        // ['id' => 71, 'title' => 'Ilmu Kesehatan Reproduksi Remaja', 'author' => 'Dr. Andriani Dwi Susila', 'publisher' => 'Trans Idea Publishing'],
        // ['id' => 72, 'title' => 'Indonesia di Panggung Sejarah Dunia', 'author' => 'Mulyadi Kartanegara', 'publisher' => 'Edulitera'],
        // ['id' => 73, 'title' => 'Inspirasi Anak Cerdas', 'author' => 'Andi Yudha', 'publisher' => 'Kata Hati'],
        // ['id' => 74, 'title' => 'Islam dan Sains Modern', 'author' => 'Nasruddin Mahmud', 'publisher' => 'Ar-Ruzz Media'],
        // ['id' => 75, 'title' => 'Jelajah Dunia dengan Bahasa Inggris', 'author' => 'Dina Lestari', 'publisher' => 'Trans Idea Publishing'],
        // ['id' => 76, 'title' => 'Jenius dengan Matematika', 'author' => 'Aryo Nugroho', 'publisher' => 'Kata Hati'],
        // ['id' => 77, 'title' => 'Kajian Islam Kontemporer', 'author' => 'Prof. Dr. Ahmad Zaenuri', 'publisher' => 'Ar-Ruzz Media'],
        // ['id' => 78, 'title' => 'Karya Ilmiah: Langkah-Langkah Praktis Menulis Artikel dan Penelitian', 'author' => 'Hendra Wijaya', 'publisher' => 'Trans Idea Publishing'],
        // ['id' => 79, 'title' => 'Keajaiban Sedekah', 'author' => 'Ust. Hidayat', 'publisher' => 'Kata Hati'],
        // ['id' => 80, 'title' => 'Kepemimpinan dalam Perspektif Islam', 'author' => 'Dr. Fauzi Umar', 'publisher' => 'Ar-Ruzz Media'],
        // ['id' => 81, 'title' => 'Keteladanan Nabi dalam Manajemen Konflik', 'author' => 'Ust. Salim A. Fillah', 'publisher' => 'Edulitera'],
        // ['id' => 82, 'title' => 'Khasiat Madu untuk Kesehatan dan Kecantikan', 'author' => 'M. Nur Salim', 'publisher' => 'Kata Hati'],
        // ['id' => 83, 'title' => 'Kimia Asyik untuk SMA', 'author' => 'Siti Anisah', 'publisher' => 'Trans Idea Publishing'],
        // ['id' => 84, 'title' => 'Komik Sains: Fisika yang Menyenangkan', 'author' => 'Fahri Syukron', 'publisher' => 'Edulitera'],
        // ['id' => 85, 'title' => 'Kreatif dengan Desain Grafis', 'author' => 'Indra Mahardika', 'publisher' => 'Trans Idea Publishing'],
        // ['id' => 86, 'title' => 'Kupas Tuntas Grammar Bahasa Inggris', 'author' => 'Rizal Fakhri', 'publisher' => 'Trans Idea Publishing'],
        // ['id' => 87, 'title' => 'Laskar Pelangi: Inspirasi di Balik Layar', 'author' => 'Andrea Hirata', 'publisher' => 'Kata Hati'],
        // ['id' => 88, 'title' => 'Manajemen Keuangan Syariah', 'author' => 'Dr. H. Muzakir', 'publisher' => 'Ar-Ruzz Media'],
        // ['id' => 89, 'title' => 'Matematika Cepat Tanpa Ribet', 'author' => 'Arya Kusuma', 'publisher' => 'Trans Idea Publishing'],
        // ['id' => 90, 'title' => 'Membaca Cepat dengan Teknik SQ3R', 'author' => 'Lita Hartini', 'publisher' => 'Kata Hati'],
        // ['id' => 91, 'title' => 'Menjadi Guru Hebat', 'author' => 'Prof. Dr. Ahmad Zainal', 'publisher' => 'Ar-Ruzz Media'],
        // ['id' => 92, 'title' => 'Misteri Alam Semesta', 'author' => 'Astro Widya', 'publisher' => 'Trans Idea Publishing'],
        // ['id' => 93, 'title' => 'Motivasi Hidup dari Kisah Nabi', 'author' => 'Ust. Yusuf Mansur', 'publisher' => 'Kata Hati'],
        // ['id' => 94, 'title' => 'Nutrisi Cerdas untuk Kesehatan', 'author' => 'Dr. Laksmi Arti', 'publisher' => 'Trans Idea Publishing'],
        // ['id' => 95, 'title' => 'Pemrograman Python untuk Pemula', 'author' => 'Eka Kurniawan', 'publisher' => 'Trans Idea Publishing'],
        // ['id' => 96, 'title' => 'Pendidikan Karakter untuk Remaja', 'author' => 'Dr. Hidayat Ismail', 'publisher' => 'Ar-Ruzz Media'],
        // ['id' => 97, 'title' => 'Pengembangan Diri dengan NLP', 'author' => 'Lutfi Hakim', 'publisher' => 'Trans Idea Publishing'],
        // ['id' => 98, 'title' => 'Perempuan Hebat dalam Sejarah Islam', 'author' => 'Aisyah R. Yunus', 'publisher' => 'Edulitera'],
        // ['id' => 99, 'title' => 'Psikologi Pendidikan untuk Guru', 'author' => 'Dr. Asep Suryadi', 'publisher' => 'Ar-Ruzz Media'],
        // ['id' => 100, 'title' => 'Rahasia Sukses Belajar Online', 'author' => 'Rina Kusuma', 'publisher' => 'Trans Idea Publishing'],
    ];


    public function index(Request $request)
    {
        // Contoh Data Buku dan Query
        $books = $this->books;
        $query = $request->get('query');
        // Inisialisasi array untuk hasil perhitungan
        $results = [];
        
        // Tokenisasi dan Preprocessing Query
        // Jika query ada, lakukan preprocessing
        $processedBooks = [];
        $processedQuery = [];
        if ($query) {
            $processedQuery = TextPreprocessingHelper::preprocessText($query);
            
            foreach($books as $book){
                $processedBookTitle = TextPreprocessingHelper::preprocessText($book['title']);
                // Hitung Dice Similarity antara query dan deskripsi buku
                $diceSimilarity = DiceSimilarityHelper::calculateDiceSimilarity($processedQuery, $processedBookTitle);
                // if ($diceSimilarity > 0) {
                    $results[] = [
                        'id' => $book['id'],
                        'book_title' => $book['title'],
                        'dice_similarity' => $diceSimilarity
                    ];
                // }
                $tokens = TextPreprocessingHelper::tokenize($book['title']);
                $filteredTokens = TextPreprocessingHelper::filterTokens($tokens);
                $removeStopwords = TextPreprocessingHelper::removeStopwords($filteredTokens);
                $stemTokens = TextPreprocessingHelper::stemTokens($removeStopwords  );
                $processedBooks[] = [
                    'tokens' => implode(' ', array_map(fn($word) => '"' . $word . '"', $tokens)),
                    'filter_tokens' => implode(' ', array_map(fn($word) => '"' . $word . '"', $filteredTokens)),
                    'remove_stopwords' => implode(' ', array_map(fn($word) => '"' . $word . '"', $removeStopwords)),
                    'stem_tokens' => implode(' ', array_map(fn($word) => '"' . $word . '"', $stemTokens))
                ];
            }
        }
        
        // Hitung Confusion Matrix dan Metrik Evaluasi
        // Misalnya kita anggap prediksi berdasarkan threshold similarity > 0.3 dianggap relevan (1), lainnya dianggap tidak relevan (0)
        $predicted = array_map(function($result) {
            return $result['dice_similarity'] >= 0.3 ? $result['id'] : null;
        }, $results);
        $predicted = array_filter($predicted);

        // ambil buku yang relevan dari data buku berdasarkan query
        $actual = $this->getTrueResultsFromDatabase($processedQuery);

        // Hitung Confusion Matrix
        $confusionMatrix = DiceSimilarityHelper::calculateConfusionMatrixForDebug($predicted, $actual);
        
        // Hitung Precision, Recall, Accuracy
        $metrics = DiceSimilarityHelper::calculateMetrics(
            $confusionMatrix['TP'],
            $confusionMatrix['FP'],
            $confusionMatrix['FN'],
            $confusionMatrix['TN']
        );
        
        // Urutkan hasil berdasarkan nilai similarity
        usort($results, function($a, $b) {
            return $b['dice_similarity'] <=> $a['dice_similarity'];
        });

        return view('dice-similarity', compact('books', 'query', 'processedQuery', 'processedBooks', 'results', 'confusionMatrix', 'metrics'));
    }

    private function getTrueResultsFromDatabase($query)
    {
        $keywords = $query;
        $books = $this->books;
        // Mencari buku relevan yang judulnya mengandung salah satu kata kunci
        $relevantBooks = [];
        foreach ($books as $book) {
            foreach ($keywords as $keyword) {
                if (stripos($book['title'], $keyword) !== false) { // Cek apakah keyword ada di dalam judul
                    $relevantBooks[] = $book['id']; // Tambahkan ID buku yang relevan
                    break; // Jika sudah ditemukan, tidak perlu lanjutkan untuk keyword lainnya
                }
            }
        }

        return $relevantBooks; // Mengembalikan array ID buku yang relevan
    }

    // $tokenize = TextPreprocessingHelper::tokenize($book['title']);
    //             $filterTokens = TextPreprocessingHelper::filterTokens($tokenize);
    //             $removeStopwords = TextPreprocessingHelper::removeStopwords($filterTokens);
    //             $stemTokens = TextPreprocessingHelper::stemTokens($removeStopwords);

    //             $Q1 = '19 KIAT SUKSES MEMBANGKITKAN MOTIVASI BELAJAR';
    //             $Q2 = 'KIAT MEMBANGKITKAN MOTIVASI BELAJAR';
    //             $Q3 = 'TEKNIK BERKEBUN UNTUK PEMULA';

    //             $queryToken1 = TextPreprocessingHelper::tokenize($Q1);
    //             $filterTokensQuery1 = TextPreprocessingHelper::filterTokens($queryToken1);
    //             $removeStopwordsQuery1 = TextPreprocessingHelper::removeStopwords($filterTokensQuery1);
    //             $stemTokensQuery1 = TextPreprocessingHelper::stemTokens($removeStopwordsQuery1);

    //             $queryToken2 = TextPreprocessingHelper::tokenize($Q2);
    //             $filterTokensQuery2 = TextPreprocessingHelper::filterTokens($queryToken2);
    //             $removeStopwordsQuery2 = TextPreprocessingHelper::removeStopwords($filterTokensQuery2);
    //             $stemTokensQuery2 = TextPreprocessingHelper::stemTokens($removeStopwordsQuery2);

    //             $queryToken3 = TextPreprocessingHelper::tokenize($Q3);
    //             $filterTokensQuery3 = TextPreprocessingHelper::filterTokens($queryToken3);
    //             $removeStopwordsQuery3 = TextPreprocessingHelper::removeStopwords($filterTokensQuery3);
    //             $stemTokensQuery3 = TextPreprocessingHelper::stemTokens($removeStopwordsQuery3);

    //             // Simpan hasil debug
    //             $debugResults[] = [
    //                 'original_title' => $book['title'],
    //                 'tokenize_title' => $tokenize,
    //                 'filter_token_title' => $filterTokens,
    //                 'removeStopwords_title' => $removeStopwords,
    //                 'stemTokens_title' => $stemTokens,
    //             ];

    //             $debugQueryResults1[] = [
    //                 'original_query_1' => $Q1,
    //                 'tokenize_query_1' => $queryToken1,
    //                 'filter_token_quer_1' => $filterTokensQuery1,
    //                 'removeStopwords_query_1' => $removeStopwordsQuery1,
    //                 'stemTokens_query_1' => $stemTokensQuery1,
    //             ];
    //             $debugQueryResults2[] = [
    //                 'original_query_2' => $Q2,
    //                 'tokenize_query_2' => $queryToken2,
    //                 'filter_token_query_2' => $filterTokensQuery2,
    //                 'removeStopwords_query_2' => $removeStopwordsQuery2,
    //                 'stemTokens_query_2' => $stemTokensQuery2,
    //             ];
    //             $debugQueryResults3[] = [
    //                 'original_query_3' => $Q3,
    //                 'tokenize_query_3' => $queryToken3,
    //                 'filter_token_query_3' => $filterTokensQuery3,
    //                 'removeStopwords_query_3' => $removeStopwordsQuery3,
    //                 'stemTokens_query_3' => $stemTokensQuery3,
    //             ];

    //             // Simpan hasil ke dalam $results (untuk digunakan lebih lanjut)
    //             $results[] = [
    //                 'id' => $book['id'],
    //                 'book_title' => $book['title'],
    //             ];
    //         }

    //         // Tampilkan semua hasil debug setelah iterasi selesai
    //         dd($debugQueryResults1, $debugQueryResults2, $debugQueryResults3 );

}
