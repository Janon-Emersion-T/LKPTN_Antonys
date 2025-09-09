<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    /** @use HasFactory<\Database\Factories\CartFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'session_id',
        'status',
        'subtotal',
        'tax_amount',
        'shipping_amount',
        'discount_amount',
        'total_amount',
        'currency',
        'coupon_id',
        'coupon_code',
        'coupon_discount',
        'shipping_address',
        'shipping_method',
        'shipping_cost',
        'type',
        'source',
        'attributes',
        'notes',
        'last_activity_at',
        'abandoned_at',
        'converted_at',
        'expires_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'tax_amount' => 'decimal:2',
            'shipping_amount' => 'decimal:2',
            'discount_amount' => 'decimal:2',
            'total_amount' => 'decimal:2',
            'shipping_cost' => 'decimal:2',
            'coupon_discount' => 'decimal:2',
            'shipping_address' => 'json',
            'attributes' => 'json',
            'last_activity_at' => 'datetime',
            'abandoned_at' => 'datetime',
            'converted_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }

    /**
     * Boot the model.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (self $model) {
            if (empty($model->currency)) {
                $model->currency = 'USD';
            }
            if (empty($model->status)) {
                $model->status = 'active';
            }
            if (empty($model->type)) {
                $model->type = 'shopping';
            }
            $model->last_activity_at = now();
            
            // Set expiration date (default 30 days)
            if (empty($model->expires_at)) {
                $model->expires_at = now()->addDays(30);
            }
        });

        static::updating(function (self $model) {
            $model->last_activity_at = now();
        });
    }

    /**
     * Get the user that owns this cart.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the coupon applied to this cart.
     */
    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    /**
     * Get the cart items.
     */
    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Scope a query to only include active carts.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include abandoned carts.
     */
    public function scopeAbandoned(Builder $query): Builder
    {
        return $query->where('status', 'abandoned');
    }

    /**
     * Scope a query to only include converted carts.
     */
    public function scopeConverted(Builder $query): Builder
    {
        return $query->where('status', 'converted');
    }

    /**
     * Scope a query to only include expired carts.
     */
    public function scopeExpired(Builder $query): Builder
    {
        return $query->where('expires_at', '<', now());
    }

    /**
     * Scope a query to filter by cart type.
     */
    public function scopeOfType(Builder $query, string $type): Builder
    {
        return $query->where('type', $type);
    }

    /**
     * Scope a query for shopping carts.
     */
    public function scopeShopping(Builder $query): Builder
    {
        return $query->where('type', 'shopping');
    }

    /**
     * Scope a query for wishlist carts.
     */
    public function scopeWishlist(Builder $query): Builder
    {
        return $query->where('type', 'wishlist');
    }

    /**
     * Check if the cart is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Check if the cart is abandoned.
     */
    public function isAbandoned(): bool
    {
        return $this->status === 'abandoned';
    }

    /**
     * Check if the cart is converted.
     */
    public function isConverted(): bool
    {
        return $this->status === 'converted';
    }

    /**
     * Check if the cart is expired.
     */
    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    /**
     * Check if the cart is empty.
     */
    public function isEmpty(): bool
    {
        return $this->items()->count() === 0;
    }

    /**
     * Get the total number of items in the cart.
     */
    public function getTotalItemsCount(): int
    {
        return $this->items()->sum('quantity');
    }

    /**
     * Get the total number of unique products in the cart.
     */
    public function getUniqueItemsCount(): int
    {
        return $this->items()->count();
    }

    /**
     * Get the formatted cart total.
     */
    public function getFormattedTotal(): string
    {
        return '$' . number_format($this->total_amount, 2);
    }

    /**
     * Get the formatted subtotal.
     */
    public function getFormattedSubtotal(): string
    {
        return '$' . number_format($this->subtotal, 2);
    }

    /**
     * Add a product to the cart.
     */
    public function addProduct(Product $product, int $quantity = 1, array $options = []): CartItem
    {
        $existingItem = $this->items()
            ->where('product_id', $product->id)
            ->where('variant_id', $options['variant_id'] ?? null)
            ->first();

        if ($existingItem) {
            $existingItem->quantity += $quantity;
            $existingItem->calculateTotals();
            $existingItem->save();
            $item = $existingItem;
        } else {
            $item = $this->items()->create([
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_sku' => $product->sku,
                'product_image' => $product->featured_image ?? $product->primaryImage?->image_path,
                'unit_price' => $product->price,
                'compare_price' => $product->compare_price,
                'quantity' => $quantity,
                'product_options' => $options,
                'variant_id' => $options['variant_id'] ?? null,
                'status' => 'active',
                'added_at' => now(),
            ]);
        }

        $this->calculateTotals();
        $this->save();

        return $item;
    }

    /**
     * Remove a product from the cart.
     */
    public function removeProduct(Product $product, string $variantId = null): bool
    {
        $item = $this->items()
            ->where('product_id', $product->id)
            ->where('variant_id', $variantId)
            ->first();

        if ($item) {
            $item->delete();
            $this->calculateTotals();
            $this->save();
            return true;
        }

        return false;
    }

    /**
     * Update the quantity of a cart item.
     */
    public function updateQuantity(CartItem $item, int $quantity): bool
    {
        if ($quantity <= 0) {
            return $item->delete();
        }

        $item->quantity = $quantity;
        $item->calculateTotals();
        $item->save();

        $this->calculateTotals();
        $this->save();

        return true;
    }

    /**
     * Clear all items from the cart.
     */
    public function clear(): bool
    {
        $this->items()->delete();
        $this->calculateTotals();
        return $this->save();
    }

    /**
     * Apply a coupon to the cart.
     */
    public function applyCoupon(Coupon $coupon): bool
    {
        if (!$coupon->isValidForCart($this)) {
            return false;
        }

        $this->coupon_id = $coupon->id;
        $this->coupon_code = $coupon->code;
        $this->coupon_discount = $coupon->calculateDiscountForCart($this);
        
        $this->calculateTotals();
        return $this->save();
    }

    /**
     * Remove coupon from the cart.
     */
    public function removeCoupon(): bool
    {
        $this->coupon_id = null;
        $this->coupon_code = null;
        $this->coupon_discount = 0;
        
        $this->calculateTotals();
        return $this->save();
    }

    /**
     * Mark cart as abandoned.
     */
    public function abandon(): bool
    {
        return $this->update([
            'status' => 'abandoned',
            'abandoned_at' => now(),
        ]);
    }

    /**
     * Convert cart to order.
     */
    public function convert(): bool
    {
        return $this->update([
            'status' => 'converted',
            'converted_at' => now(),
        ]);
    }

    /**
     * Restore abandoned cart.
     */
    public function restore(): bool
    {
        return $this->update([
            'status' => 'active',
            'abandoned_at' => null,
        ]);
    }

    /**
     * Calculate cart totals.
     */
    public function calculateTotals(): void
    {
        $this->subtotal = $this->items()->sum('final_total');
        $this->discount_amount = $this->items()->sum('discount_amount') + ($this->coupon_discount ?? 0);
        // Tax and shipping would be calculated based on business rules
        $this->total_amount = $this->subtotal + $this->tax_amount + $this->shipping_amount - $this->discount_amount;
    }

    /**
     * Check if cart has any items requiring shipping.
     */
    public function requiresShipping(): bool
    {
        return $this->items()->whereHas('product', function ($query) {
            $query->where('requires_shipping', true);
        })->exists();
    }

    /**
     * Get cart weight for shipping calculations.
     */
    public function getTotalWeight(): float
    {
        return $this->items()->with('product')->get()->sum(function ($item) {
            return ($item->product->weight ?? 0) * $item->quantity;
        });
    }

    /**
     * Extend cart expiration.
     */
    public function extend(int $days = 30): bool
    {
        return $this->update([
            'expires_at' => now()->addDays($days),
        ]);
    }
}