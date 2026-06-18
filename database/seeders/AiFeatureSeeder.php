<?php

namespace Database\Seeders;

use App\Models\AiFeature;
use Illuminate\Database\Seeder;

class AiFeatureSeeder extends Seeder
{
    public function run(): void
    {
        $features = [
            [
                'title'        => 'Analisis Tren',
                'description'  => 'AI merangkum berita pekan ini menjadi satu artikel analisa singkat.',
                'icon'         => 'chart',
                'route_or_url' => '#',
                'sort_order'   => 1,
            ],
            [
                'title'        => 'Profil Tokoh',
                'description'  => 'Telusuri rekam jejak tokoh Madura yang sedang jadi sorotan berita.',
                'icon'         => 'person',
                'route_or_url' => '#',
                'sort_order'   => 2,
            ],
        ];

        foreach ($features as $f) {
            AiFeature::updateOrCreate(['title' => $f['title']], $f + ['is_active' => true]);
        }
    }
}
