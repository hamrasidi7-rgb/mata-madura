<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    protected $fillable = [
        'category_id', 'title', 'slug', 'deck', 'body', 'image_path',
        'image_caption', 'author', 'read_minutes', 'is_trending',
        'is_featured', 'published_at',
    ];

    protected $casts = [
        'is_trending'  => 'boolean',
        'is_featured'  => 'boolean',
        'published_at' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /** "5 menit baca · 18 Jun 2026" */
    public function getMetaAttribute(): string
    {
        $date = optional($this->published_at)->translatedFormat('d M Y');
        return "{$this->read_minutes} menit baca · {$date}";
    }

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')
                     ->where('published_at', '<=', now())
                     ->latest('published_at');
    }
}
