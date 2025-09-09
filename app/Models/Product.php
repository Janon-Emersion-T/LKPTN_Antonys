<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
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
        'short_description',
        'sku',
        'barcode',
        'price',
        'compare_price',
        'cost_price',
        'track_inventory',
        'inventory_quantity',
        'low_stock_threshold',
        'weight',
        'dimensions',
        'status',
        'requires_shipping',
        'is_digital',
        'attributes',
        'meta_data',
        'featured_image',
        'category_id',
        'brand_id',
        'published_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'compare_price' => 'decimal:2',
            'cost_price' => 'decimal:2',
            'weight' => 'decimal:2',
            'track_inventory' => 'boolean',
            'requires_shipping' => 'boolean',
            'is_digital' => 'boolean',
            'inventory_quantity' => 'integer',
            'low_stock_threshold' => 'integer',
            'dimensions' => 'json',
            'attributes' => 'json',
            'meta_data' => 'json',
            'published_at' => 'datetime',
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
            if (empty($model->sku)) {
                $model->sku = strtoupper(Str::random(8));
            }
        });
    }

    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the brand that owns the product.
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get the product images.
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    /**
     * Get the primary product image.
     */
    public function primaryImage(): HasOne
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    /**
     * Get the inventory record for this product.
     */
    public function inventory(): HasOne
    {
        return $this->hasOne(Inventory::class);
    }

    /**
     * Get the order items for this product.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the cart items for this product.
     */
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Scope a query to only include published products.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')
                    ->where('published_at', '<=', now());
    }

    /**
     * Scope a query to only include active products.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->whereIn('status', ['published', 'active']);
    }

    /**
     * Scope a query to only include draft products.
     */
    public function scopeDraft(Builder $query): Builder
    {
        return $query->where('status', 'draft');
    }

    /**
     * Scope a query to only include featured products.
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('attributes->featured', true);
    }

    /**
     * Scope a query to only include products on sale.
     */
    public function scopeOnSale(Builder $query): Builder
    {
        return $query->whereNotNull('compare_price')
                    ->whereColumn('price', '<', 'compare_price');
    }

    /**
     * Scope a query to only include products in stock.
     */
    public function scopeInStock(Builder $query): Builder
    {
        return $query->where(function ($query) {
            $query->where('track_inventory', false)
                  ->orWhere(function ($subQuery) {
                      $subQuery->where('track_inventory', true)
                               ->where('inventory_quantity', '>', 0);
                  });
        });
    }

    /**
     * Scope a query to only include products out of stock.
     */
    public function scopeOutOfStock(Builder $query): Builder
    {
        return $query->where('track_inventory', true)
                    ->where('inventory_quantity', '<=', 0);
    }

    /**
     * Scope a query to only include products with low stock.
     */
    public function scopeLowStock(Builder $query): Builder
    {
        return $query->where('track_inventory', true)
                    ->whereColumn('inventory_quantity', '<=', 'low_stock_threshold');
    }

    /**
     * Scope a query to search products by name, description, or SKU.
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('barcode', 'like', "%{$search}%");
        });
    }

    /**
     * Scope a query to filter products by price range.
     */
    public function scopePriceRange(Builder $query, float $min = null, float $max = null): Builder
    {
        if ($min !== null) {
            $query->where('price', '>=', $min);
        }
        if ($max !== null) {
            $query->where('price', '<=', $max);
        }
        return $query;
    }

    /**
     * Check if the product is published.
     */
    public function isPublished(): bool
    {
        return $this->status === 'published' && 
               $this->published_at && 
               $this->published_at->isPast();
    }

    /**
     * Check if the product is on sale.
     */
    public function isOnSale(): bool
    {
        return $this->compare_price && $this->price < $this->compare_price;
    }

    /**
     * Check if the product is in stock.
     */
    public function isInStock(): bool
    {
        if (!$this->track_inventory) {
            return true;
        }
        return $this->inventory_quantity > 0;
    }

    /**
     * Check if the product has low stock.
     */
    public function hasLowStock(): bool
    {
        if (!$this->track_inventory) {
            return false;
        }
        return $this->inventory_quantity <= $this->low_stock_threshold;
    }

    /**
     * Check if the product is digital.
     */
    public function isDigital(): bool
    {
        return $this->is_digital;
    }

    /**
     * Check if the product requires shipping.
     */
    public function requiresShipping(): bool
    {
        return $this->requires_shipping;
    }

    /**
     * Get the discount percentage if on sale.
     */
    public function getDiscountPercentage(): float
    {
        if (!$this->isOnSale()) {
            return 0;
        }
        return round(($this->compare_price - $this->price) / $this->compare_price * 100);
    }

    /**
     * Get the savings amount if on sale.
     */
    public function getSavingsAmount(): float
    {
        if (!$this->isOnSale()) {
            return 0;
        }
        return $this->compare_price - $this->price;
    }

    /**
     * Get the primary image URL or a default placeholder.
     */
    public function getImageUrl(): string
    {
        if ($this->featured_image) {
            return asset('storage/' . $this->featured_image);
        }
        if ($this->primaryImage) {
            return asset('storage/' . $this->primaryImage->image_path);
        }
        // Return a simple SVG placeholder instead of a missing file
        return 'data:image/svg+xml;base64,' . base64_encode('<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><rect width="100" height="100" fill="#f3f4f6"/><text x="50%" y="50%" text-anchor="middle" dy=".3em" fill="#9ca3af">No Image</text></svg>');
    }

    /**
     * Get all image URLs.
     */
    public function getImageUrls(): array
    {
        $urls = [];
        
        if ($this->featured_image) {
            $urls[] = asset('storage/' . $this->featured_image);
        }
        
        foreach ($this->images as $image) {
            $urls[] = asset('storage/' . $image->image_path);
        }
        
        return array_unique($urls);
    }

    /**
     * Get the product's stock status as a string.
     */
    public function getStockStatus(): string
    {
        if (!$this->track_inventory) {
            return 'available';
        }
        
        if ($this->inventory_quantity <= 0) {
            return 'out_of_stock';
        }
        
        if ($this->hasLowStock()) {
            return 'low_stock';
        }
        
        return 'in_stock';
    }

    /**
     * Get formatted price.
     */
    public function getFormattedPrice(): string
    {
        return '$' . number_format($this->price, 2);
    }

    /**
     * Get formatted compare price.
     */
    public function getFormattedComparePrice(): string
    {
        return $this->compare_price ? '$' . number_format($this->compare_price, 2) : '';
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Publish the product.
     */
    public function publish(): bool
    {
        return $this->update([
            'status' => 'published',
            'published_at' => now(),
        ]);
    }

    /**
     * Unpublish the product.
     */
    public function unpublish(): bool
    {
        return $this->update([
            'status' => 'draft',
            'published_at' => null,
        ]);
    }
}
