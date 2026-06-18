<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $cat = fn (string $name) => Category::where('name', $name)->value('id');

        $rows = [
            [
                'category' => 'Politik', 'author' => 'Hasan Basri', 'read_minutes' => 5,
                'image_path' => 'images/news/foto-utama.jpg', 'is_featured' => true, 'is_trending' => true,
                'title' => 'Bupati Sumenep Tinjau Kesiapan Infrastruktur Jelang Musim Hujan',
                'deck'  => 'Sejumlah titik rawan banjir di wilayah daratan dan kepulauan menjadi prioritas penanganan sebelum puncak penghujan.',
                'image_caption' => 'Bupati meninjau normalisasi saluran air di kawasan Kota Sumenep.',
            ],
            [
                'category' => 'Ekonomi', 'author' => 'Nurul Hidayah', 'read_minutes' => 4, 'is_trending' => true,
                'image_path' => 'images/news/ph-2.jpg',
                'title' => 'Harga Garam Rakyat Madura Menguat, Petambak Sumenep Optimistis',
                'deck'  => 'Permintaan industri yang naik dan cuaca kemarau yang stabil mendorong harga ke level tertinggi tahun ini.',
            ],
            [
                'category' => 'Budaya', 'author' => 'Ach. Fauzi', 'read_minutes' => 6, 'is_trending' => true,
                'image_path' => 'images/news/ph-3.jpg',
                'title' => 'Karapan Sapi Piala Presiden Kembali Digelar di Pamekasan',
                'deck'  => 'Tradisi adu pacu sapi paling bergengsi se-Madura kembali menyedot ribuan penonton.',
            ],
            [
                'category' => 'Daerah', 'author' => 'Imam Subhan', 'read_minutes' => 3, 'is_featured' => true,
                'image_path' => 'images/news/ph-7.jpg',
                'title' => 'Jembatan Penghubung Desa Terpencil di Sumenep Akhirnya Rampung',
                'deck'  => 'Warga tiga desa kini tak perlu memutar belasan kilometer setelah jembatan baru resmi dibuka.',
            ],
            [
                'category' => 'Pendidikan', 'author' => 'Laila Rahmawati', 'read_minutes' => 4,
                'image_path' => 'images/news/ph-8.jpg',
                'title' => 'Pelajar Madura Raih Medali di Olimpiade Sains Nasional',
                'deck'  => 'Prestasi membanggakan datang dari siswa madrasah yang menembus papan atas kompetisi nasional.',
            ],
            [
                'category' => 'Olahraga', 'author' => 'Bayu Pratama', 'read_minutes' => 3,
                'image_path' => 'images/news/ph-9.jpg',
                'title' => 'Klub Sepak Bola Madura Lolos ke Babak Final Liga Regional',
                'deck'  => 'Dukungan suporter fanatik mengantar tim kebanggaan pulau garam menembus laga puncak musim ini.',
            ],
        ];

        $body = "<p>Naskah lengkap berita akan ditempatkan di sini melalui editor admin. "
              . "Gunakan paragraf, subjudul, dan kutipan untuk membangun artikel gaya majalah.</p>";

        foreach ($rows as $i => $r) {
            Article::updateOrCreate(
                ['slug' => Str::slug($r['title'])],
                [
                    'category_id'   => $cat($r['category']),
                    'title'         => $r['title'],
                    'deck'          => $r['deck'],
                    'body'          => $body,
                    'image_path'    => $r['image_path'] ?? null,
                    'image_caption' => $r['image_caption'] ?? null,
                    'author'        => $r['author'],
                    'read_minutes'  => $r['read_minutes'],
                    'is_trending'   => $r['is_trending'] ?? false,
                    'is_featured'   => $r['is_featured'] ?? false,
                    'published_at'  => now()->subDays($i),
                ],
            );
        }
    }
}
