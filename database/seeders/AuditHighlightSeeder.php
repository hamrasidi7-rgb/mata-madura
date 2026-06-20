<?php

namespace Database\Seeders;

use App\Models\AuditHighlight;
use Illuminate\Database\Seeder;

class AuditHighlightSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['label' => 'Total Paket RUP Teraudit', 'value' => '3.450', 'order' => 1],
            ['label' => 'Total Pagu Dianalisis',    'value' => 'Rp 1,2 T', 'order' => 2],
            ['label' => 'Tahun Anggaran',           'value' => 'TA 2026',  'order' => 3],
        ];

        foreach ($rows as $row) {
            AuditHighlight::updateOrCreate(
                ['label' => $row['label']],
                array_merge($row, ['is_active' => true])
            );
        }
    }
}
