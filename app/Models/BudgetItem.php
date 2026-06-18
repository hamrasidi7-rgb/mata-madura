<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetItem extends Model
{
    protected $fillable = ['label', 'icon', 'amount', 'sort_order', 'is_active'];

    protected $casts = [
        'amount'    => 'integer',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    /** "Rp 2,4 M" — format ringkas untuk banner. */
    public function getAmountShortAttribute(): string
    {
        $n = $this->amount;
        if ($n >= 1_000_000_000_000) return 'Rp ' . rtrim(rtrim(number_format($n / 1_000_000_000_000, 1, ',', '.'), '0'), ',') . ' T';
        if ($n >= 1_000_000_000)     return 'Rp ' . rtrim(rtrim(number_format($n / 1_000_000_000, 1, ',', '.'), '0'), ',') . ' M';
        if ($n >= 1_000_000)         return 'Rp ' . rtrim(rtrim(number_format($n / 1_000_000, 1, ',', '.'), '0'), ',') . ' Jt';
        return 'Rp ' . number_format($n, 0, ',', '.');
    }
}
