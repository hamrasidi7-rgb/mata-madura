<?php

namespace Database\Seeders;

use App\Models\BudgetItem;
use Illuminate\Database\Seeder;

class BudgetItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['label' => 'Infrastruktur', 'icon' => 'road',      'amount' => 2_400_000_000_000, 'sort_order' => 1],
            ['label' => 'Pendidikan',    'icon' => 'book',      'amount' => 1_850_000_000_000, 'sort_order' => 2],
            ['label' => 'Kesehatan',     'icon' => 'heart',     'amount' => 1_200_000_000_000, 'sort_order' => 3],
            ['label' => 'Sosial',        'icon' => 'users',     'amount' =>   780_000_000_000, 'sort_order' => 4],
        ];

        foreach ($items as $i) {
            BudgetItem::updateOrCreate(['label' => $i['label']], $i + ['is_active' => true]);
        }
    }
}
