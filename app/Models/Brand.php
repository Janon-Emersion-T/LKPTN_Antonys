<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Brand extends Model
{
    /** @use HasFactory<\Database\Factories\BrandFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'logo',
        'website',
        'is_active',
        'meta_data',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'meta_data' => 'json',
        ];
    }

    /**
     * Boot the model.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (self $model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

    /**
     * Get all products for this brand.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Scope a query to only include active brands.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include brands that have products.
     */
    public function scopeHasProducts(Builder $query): Builder
    {
        return $query->whereHas('products');
    }

    /**
     * Scope a query to only include brands with published products.
     */
    public function scopeHasPublishedProducts(Builder $query): Builder
    {
        return $query->whereHas('products', function ($query) {
            $query->where('status', 'published');
        });
    }

    /**
     * Get the total number of products for this brand.
     */
    public function getProductsCountAttribute(): int
    {
        return $this->products()->count();
    }

    /**
     * Get the total number of published products for this brand.
     */
    public function getPublishedProductsCountAttribute(): int
    {
        return $this->products()->where('status', 'published')->count();
    }

    /**
     * Check if the brand has a logo.
     */
    public function hasLogo(): bool
    {
        return !empty($this->logo);
    }

    /**
     * Get the logo URL or a default placeholder.
     */
    public function getLogoUrl(): string
    {
        if ($this->hasLogo()) {
            return asset('storage/' . $this->logo);
        }

        // Return a simple SVG placeholder instead of a missing file
        return 'data:image/svg+xml;base64,' . base64_encode('<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><rect width="100" height="100" fill="#f3f4f6"/><text x="50%" y="50%" text-anchor="middle" dy=".3em" fill="#9ca3af">No Logo</text></svg>');
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
