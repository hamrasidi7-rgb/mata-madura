<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Article extends Model
{
    protected $fillable = [
        'category_id', 'title', 'slug', 'deck', 'body', 'image_path',
        'image_caption', 'author', 'author_name', 'author_photo', 'read_minutes', 'is_trending',
        'is_featured', 'published_at', 'views',
    ];

    protected $casts = [
        'is_trending'  => 'boolean',
        'is_featured'  => 'boolean',
        'published_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::saving(function (Article $article) {
            if (empty($article->slug)) {
                $article->slug = static::uniqueSlug($article->title, $article->id);
            }
        });
    }

    protected static function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i    = 1;

        while (
            static::where('slug', $slug)
                  ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                  ->exists()
        ) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getAuthorPhotoUrlAttribute(): string
    {
        if ($this->author_photo) {
            return Storage::url($this->author_photo);
        }
        $name = urlencode($this->author_name ?: $this->author ?: 'Redaksi');
        return "https://ui-avatars.com/api/?name={$name}&size=128&background=9c6644&color=ffffff&bold=true&format=svg";
    }

    public function getStatusAttribute(): string
    {
        return $this->published_at ? 'published' : 'draft';
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
