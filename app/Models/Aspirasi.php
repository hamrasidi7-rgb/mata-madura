<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aspirasi extends Model
{
    protected $table = 'aspirasi';

    protected $fillable = [
        'title', 'location', 'color', 'status',
        'moderation_status', 'moderated_at', 'moderated_by', 'rejection_reason',
        'similar_count', 'submitted_at', 'is_active',
    ];

    protected $casts = [
        'is_active'    => 'boolean',
        'submitted_at' => 'datetime',
        'moderated_at' => 'datetime',
    ];

    /** Hanya approved + is_active yang tampil di homepage. */
    public function scopeActive($query)
    {
        return $query
            ->where('moderation_status', 'approved')
            ->where('is_active', true)
            ->latest('submitted_at');
    }

    public function moderatedBy()
    {
        return $this->belongsTo(User::class, 'moderated_by');
    }

    public function getTimeAgoAttribute(): string
    {
        $mins = (int) now()->diffInMinutes($this->submitted_at);
        if ($mins < 60)   return $mins . ' menit lalu';
        if ($mins < 1440) return floor($mins / 60) . ' jam lalu';
        return floor($mins / 1440) . ' hari lalu';
    }

    public function getModerationLabelAttribute(): string
    {
        return match ($this->moderation_status) {
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            default    => 'Menunggu',
        };
    }
}
