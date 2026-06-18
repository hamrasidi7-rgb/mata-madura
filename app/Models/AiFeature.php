<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiFeature extends Model
{
    protected $fillable = [
        'title', 'description', 'icon', 'route_or_url', 'sort_order', 'is_active',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    /** Resolusi tujuan tautan: named route bila ada, jika tidak anggap URL/“#”. */
    public function getLinkAttribute(): string
    {
        if (! $this->route_or_url) {
            return '#';
        }
        return \Route::has($this->route_or_url)
            ? route($this->route_or_url)
            : $this->route_or_url;
    }
}
