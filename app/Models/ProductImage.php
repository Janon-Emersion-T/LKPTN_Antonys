<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Model
{
    /** @use HasFactory<\Database\Factories\ProductImageFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'product_id',
        'image_path',
        'alt_text',
        'sort_order',
        'is_primary',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_primary' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * Boot the model.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (self $model) {
            if (is_null($model->sort_order)) {
                $model->sort_order = static::where('product_id', $model->product_id)->max('sort_order') + 1;
            }
        });

        static::saving(function (self $model) {
            // Ensure only one primary image per product
            if ($model->is_primary && $model->isDirty('is_primary')) {
                static::where('product_id', $model->product_id)
                     ->where('id', '!=', $model->id)
                     ->update(['is_primary' => false]);
            }
        });
    }

    /**
     * Get the product that owns this image.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Scope a query to only include primary images.
     */
    public function scopePrimary(Builder $query): Builder
    {
        return $query->where('is_primary', true);
    }

    /**
     * Scope a query to only include secondary images.
     */
    public function scopeSecondary(Builder $query): Builder
    {
        return $query->where('is_primary', false);
    }

    /**
     * Scope a query to order images by sort order.
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order');
    }

    /**
     * Get the full URL for this image.
     */
    public function getUrl(): string
    {
        return asset('storage/' . $this->image_path);
    }

    /**
     * Check if this image is the primary image.
     */
    public function isPrimary(): bool
    {
        return $this->is_primary;
    }

    /**
     * Make this image the primary image.
     */
    public function makePrimary(): bool
    {
        return $this->update(['is_primary' => true]);
    }

    /**
     * Remove primary status from this image.
     */
    public function removePrimaryStatus(): bool
    {
        return $this->update(['is_primary' => false]);
    }

    /**
     * Get the alt text or generate from product name.
     */
    public function getAltText(): string
    {
        if (!empty($this->alt_text)) {
            return $this->alt_text;
        }

        return $this->product->name ?? 'Product Image';
    }

    /**
     * Move this image up in the sort order.
     */
    public function moveUp(): bool
    {
        $previousImage = static::where('product_id', $this->product_id)
            ->where('sort_order', '<', $this->sort_order)
            ->orderBy('sort_order', 'desc')
            ->first();

        if ($previousImage) {
            $tempOrder = $this->sort_order;
            $this->sort_order = $previousImage->sort_order;
            $previousImage->sort_order = $tempOrder;

            return $this->save() && $previousImage->save();
        }

        return false;
    }

    /**
     * Move this image down in the sort order.
     */
    public function moveDown(): bool
    {
        $nextImage = static::where('product_id', $this->product_id)
            ->where('sort_order', '>', $this->sort_order)
            ->orderBy('sort_order')
            ->first();

        if ($nextImage) {
            $tempOrder = $this->sort_order;
            $this->sort_order = $nextImage->sort_order;
            $nextImage->sort_order = $tempOrder;

            return $this->save() && $nextImage->save();
        }

        return false;
    }
}
