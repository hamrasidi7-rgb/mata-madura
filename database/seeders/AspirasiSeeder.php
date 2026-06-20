<?php

namespace Database\Seeders;

use App\Models\Aspirasi;
use Illuminate\Database\Seeder;

class AspirasiSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['title' => 'Jalan rusak di Desa Pinggir Papas',       'location' => 'Pragaan',        'color' => 'green',  'status' => 'baru',        'similar_count' => 17, 'submitted_at' => now()->subMinutes(4)],
            ['title' => 'Lampu jalan mati Kec. Kota',              'location' => 'Sumenep Kota',   'color' => 'yellow', 'status' => 'ditanggapi',  'similar_count' => 23, 'submitted_at' => now()->subMinutes(12)],
            ['title' => 'Sampah menumpuk Pasar Anom',              'location' => 'Sumenep Kota',   'color' => 'blue',   'status' => 'baru',        'similar_count' => 8,  'submitted_at' => now()->subHours(1)],
            ['title' => 'Saluran irigasi sawah Bluto tersumbat',   'location' => 'Bluto',          'color' => 'yellow', 'status' => 'baru',        'similar_count' => 11, 'submitted_at' => now()->subHours(2)],
            ['title' => 'Jembatan Arjasa retak, perlu perbaikan',  'location' => 'Arjasa',         'color' => 'red',    'status' => 'ditanggapi',  'similar_count' => 31, 'submitted_at' => now()->subHours(3)],
            ['title' => 'Air PDAM Batang-Batang mati 3 hari',      'location' => 'Batang-Batang',  'color' => 'blue',   'status' => 'selesai',     'similar_count' => 45, 'submitted_at' => now()->subHours(5)],
            ['title' => 'Atap SDN Pasongsongan 2 bocor',           'location' => 'Pasongsongan',   'color' => 'green',  'status' => 'baru',        'similar_count' => 7,  'submitted_at' => now()->subHours(6)],
            ['title' => 'Pasar Lenteng butuh renovasi',            'location' => 'Lenteng',        'color' => 'yellow', 'status' => 'ditanggapi',  'similar_count' => 19, 'submitted_at' => now()->subHours(8)],
            ['title' => 'Jalan desa Gapura berlubang besar',       'location' => 'Gapura',         'color' => 'green',  'status' => 'baru',        'similar_count' => 14, 'submitted_at' => now()->subHours(9)],
        ];

        foreach ($items as $item) {
            Aspirasi::updateOrCreate(
                ['title' => $item['title']],
                array_merge($item, [
                    'is_active'         => true,
                    'moderation_status' => 'approved',
                    'moderated_at'      => now(),
                ])
            );
        }
    }
}
