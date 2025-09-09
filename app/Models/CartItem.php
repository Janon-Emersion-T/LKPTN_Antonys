<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    /** @use HasFactory<\Database\Factories\CartItemFactory> */
    use HasFactory;

    protected $fillable = [
        'cart_id', 'product_id', 'product_name', 'product_sku', 'product_image',
        'unit_price', 'compare_price', 'discount_amount', 'quantity',
        'line_total', 'final_total', 'product_options', 'variant_id',
        'attributes', 'notes', 'status', 'added_at', 'last_updated_at',
    ];

    protected function casts(): array
    {
        return [
            'unit_price' => 'decimal:2',
            'compare_price' => 'decimal:2',
            'discount_amount' => 'decimal:2',
            'line_total' => 'decimal:2',
            'final_total' => 'decimal:2',
            'quantity' => 'integer',
            'product_options' => 'json',
            'attributes' => 'json',
            'added_at' => 'datetime',
            'last_updated_at' => 'datetime',
        ];
    }

    protected static function boot(): void
    {
        parent::boot();
        
        static::creating(function (self $model) {
            $model->calculateTotals();
            $model->added_at = now();
        });
        
        static::updating(function (self $model) {
            if ($model->isDirty(['quantity', 'unit_price', 'discount_amount'])) {
                $model->calculateTotals();
            }
            $model->last_updated_at = now();
        });
    }

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    public function calculateTotals(): void
    {
        $this->line_total = $this->quantity * $this->unit_price;
        $this->final_total = $this->line_total - $this->discount_amount;
    }

    public function getFormattedUnitPrice(): string
    {
        return '$' . number_format($this->unit_price, 2);
    }

    public function getFormattedLineTotal(): string
    {
        return '$' . number_format($this->line_total, 2);
    }

    public function getImageUrl(): string
    {
        if ($this->product_image) {
            return asset('storage/' . $this->product_image);
        }
        return $this->product?->getImageUrl() ?? asset('images/product-placeholder.png');
    }

    public function isOnSale(): bool
    {
        return $this->compare_price && $this->unit_price < $this->compare_price;
    }
}
