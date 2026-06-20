<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aspirasi extends Model
{
    protected $table = 'aspirasi';

    protected $fillable = ['title', 'location', 'color', 'status', 'similar_count', 'submitted_at', 'is_active'];

    protected $casts = [
        'is_active'    => 'boolean',
        'submitted_at' => 'datetime',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->latest('submitted_at');
    }

    public function getTimeAgoAttribute(): string
    {
        $mins = (int) now()->diffInMinutes($this->submitted_at);
        if ($mins < 60)  return $mins . ' menit lalu';
        if ($mins < 1440) return floor($mins / 60) . ' jam lalu';
        return floor($mins / 1440) . ' hari lalu';
    }
}
