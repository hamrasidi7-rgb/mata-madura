<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $names = ['Politik', 'Daerah', 'Ekonomi', 'Pendidikan', 'Hukum', 'Olahraga', 'Budaya', 'Wisata'];

        foreach ($names as $i => $name) {
            Category::updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'sort_order' => $i, 'is_active' => true],
            );
        }
    }
}
