<?php

namespace Database\Seeders;

use App\Models\Aspirasi;
use Illuminate\Database\Seeder;

class AspirasiSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['title' => 'Jalan Pragaan rusak berat belum diperbaiki',       'location' => 'Pragaan',        'color' => 'green',  'similar_count' => 17, 'submitted_at' => now()->subMinutes(3)],
            ['title' => 'Sampah Pasar Anom menumpuk berhari-hari',          'location' => 'Sumenep Kota',   'color' => 'yellow', 'similar_count' => 23, 'submitted_at' => now()->subMinutes(12)],
            ['title' => 'Lampu jalan sepanjang Kalianget mati total',        'location' => 'Kalianget',      'color' => 'blue',   'similar_count' => 8,  'submitted_at' => now()->subMinutes(28)],
            ['title' => 'Saluran irigasi sawah Bluto tersumbat',             'location' => 'Bluto',          'color' => 'yellow', 'similar_count' => 11, 'submitted_at' => now()->subHours(1)],
            ['title' => 'Jembatan Arjasa retak, warga minta segera diperbaiki', 'location' => 'Arjasa',     'color' => 'red',    'similar_count' => 31, 'submitted_at' => now()->subHours(2)],
            ['title' => 'Air PDAM Batang-Batang mati 3 hari berturut',      'location' => 'Batang-Batang',  'color' => 'blue',   'similar_count' => 45, 'submitted_at' => now()->subHours(3)],
            ['title' => 'Atap SDN Pasongsongan 2 bocor saat hujan',         'location' => 'Pasongsongan',   'color' => 'green',  'similar_count' => 7,  'submitted_at' => now()->subHours(5)],
            ['title' => 'Pasar Lenteng butuh renovasi mendesak',             'location' => 'Lenteng',        'color' => 'yellow', 'similar_count' => 19, 'submitted_at' => now()->subHours(8)],
            ['title' => 'Jalan desa Gapura berlubang besar',                 'location' => 'Gapura',         'color' => 'green',  'similar_count' => 14, 'submitted_at' => now()->subHours(9)],
        ];

        foreach ($items as $item) {
            Aspirasi::updateOrCreate(
                ['title' => $item['title']],
                array_merge($item, ['is_active' => true])
            );
        }
    }
}
