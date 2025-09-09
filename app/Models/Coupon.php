<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Coupon extends Model
{
    /** @use HasFactory<\Database\Factories\CouponFactory> */
    use HasFactory;

    protected $fillable = [
        'name', 'code', 'description', 'type', 'value', 'minimum_amount',
        'maximum_discount', 'usage_limit', 'usage_limit_per_customer', 'used_count',
        'starts_at', 'expires_at', 'applicable_products', 'excluded_products',
        'applicable_categories', 'excluded_categories', 'applicable_brands', 'excluded_brands',
        'applicable_customers', 'excluded_customers', 'customer_groups', 'first_order_only',
        'minimum_quantity', 'conditions', 'status', 'is_public', 'source', 'tags',
        'attributes', 'created_by', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'decimal:2',
            'minimum_amount' => 'decimal:2',
            'maximum_discount' => 'decimal:2',
            'usage_limit' => 'integer',
            'usage_limit_per_customer' => 'integer',
            'used_count' => 'integer',
            'minimum_quantity' => 'integer',
            'first_order_only' => 'boolean',
            'is_public' => 'boolean',
            'starts_at' => 'datetime',
            'expires_at' => 'datetime',
            'applicable_products' => 'json',
            'excluded_products' => 'json',
            'applicable_categories' => 'json',
            'excluded_categories' => 'json',
            'applicable_brands' => 'json',
            'excluded_brands' => 'json',
            'applicable_customers' => 'json',
            'excluded_customers' => 'json',
            'customer_groups' => 'json',
            'conditions' => 'json',
            'tags' => 'json',
            'attributes' => 'json',
        ];
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (self $model) {
            if (empty($model->code)) {
                $model->code = strtoupper(Str::random(8));
            }
            if (empty($model->status)) {
                $model->status = 'active';
            }
        });
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    public function scopeValid(Builder $query): Builder
    {
        return $query->where('status', 'active')
                    ->where('starts_at', '<=', now())
                    ->where(function ($q) {
                        $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
                    });
    }

    public function scopePublic(Builder $query): Builder
    {
        return $query->where('is_public', true);
    }

    public function scopeByCode(Builder $query, string $code): Builder
    {
        return $query->where('code', strtoupper($code));
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isValid(): bool
    {
        return $this->isActive() && 
               $this->starts_at <= now() && 
               (!$this->expires_at || $this->expires_at > now()) &&
               (!$this->usage_limit || $this->used_count < $this->usage_limit);
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function hasUsageLeft(): bool
    {
        return !$this->usage_limit || $this->used_count < $this->usage_limit;
    }

    public function isValidForCart(Cart $cart): bool
    {
        if (!$this->isValid()) {
            return false;
        }

        if ($this->minimum_amount && $cart->subtotal < $this->minimum_amount) {
            return false;
        }

        if ($this->minimum_quantity && $cart->getTotalItemsCount() < $this->minimum_quantity) {
            return false;
        }

        if ($this->first_order_only && $cart->user && $cart->user->orders()->exists()) {
            return false;
        }

        return true;
    }

    public function calculateDiscountForCart(Cart $cart): float
    {
        if (!$this->isValidForCart($cart)) {
            return 0;
        }

        $discount = 0;

        if ($this->type === 'percentage') {
            $discount = ($cart->subtotal * $this->value) / 100;
        } elseif ($this->type === 'fixed') {
            $discount = $this->value;
        }

        if ($this->maximum_discount && $discount > $this->maximum_discount) {
            $discount = $this->maximum_discount;
        }

        return min($discount, $cart->subtotal);
    }

    public function incrementUsage(): bool
    {
        return $this->increment('used_count');
    }

    public function decrementUsage(): bool
    {
        return $this->decrement('used_count');
    }

    public function getFormattedValue(): string
    {
        if ($this->type === 'percentage') {
            return $this->value . '%';
        }
        return '$' . number_format($this->value, 2);
    }

    public function getUsagePercentage(): float
    {
        if (!$this->usage_limit) {
            return 0;
        }
        return ($this->used_count / $this->usage_limit) * 100;
    }

    public function getRemainingUses(): int
    {
        if (!$this->usage_limit) {
            return PHP_INT_MAX;
        }
        return max(0, $this->usage_limit - $this->used_count);
    }
}