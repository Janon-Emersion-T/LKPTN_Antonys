<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Carbon\Carbon;

class News extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'news_category_id',
        'status',
        'is_featured',
        'published_at',
        'meta_data',
        'views_count'
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'published_at' => 'datetime',
            'meta_data' => 'array',
            'views_count' => 'integer',
        ];
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($news) {
            if (empty($news->slug)) {
                $news->slug = Str::slug($news->title);
            }
            if ($news->status === 'published' && !$news->published_at) {
                $news->published_at = now();
            }
        });

        static::updating(function ($news) {
            if ($news->isDirty('title') && empty($news->slug)) {
                $news->slug = Str::slug($news->title);
            }
            if ($news->isDirty('status') && $news->status === 'published' && !$news->published_at) {
                $news->published_at = now();
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(NewsCategory::class, 'news_category_id');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeRecent($query, $limit = 5)
    {
        return $query->orderBy('published_at', 'desc')->limit($limit);
    }

    public function getReadingTimeAttribute(): int
    {
        $wordsPerMinute = 200;
        $words = str_word_count(strip_tags($this->content));
        return max(1, ceil($words / $wordsPerMinute));
    }

    public function getFormattedDateAttribute(): string
    {
        return $this->published_at ? $this->published_at->format('M d, Y') : '';
    }

    public function incrementViews(): void
    {
        $this->increment('views_count');
    }
}
