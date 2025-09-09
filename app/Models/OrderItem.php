<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    /** @use HasFactory<\Database\Factories\OrderItemFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'product_sku',
        'product_description',
        'product_image',
        'unit_price',
        'compare_price',
        'cost_price',
        'quantity',
        'line_total',
        'discount_amount',
        'tax_amount',
        'final_total',
        'product_options',
        'fulfillment_status',
        'quantity_shipped',
        'quantity_returned',
        'shipped_at',
        'returned_at',
        'return_reason',
        'refund_amount',
        'refunded_at',
        'attributes',
        'notes',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'unit_price' => 'decimal:2',
            'compare_price' => 'decimal:2',
            'cost_price' => 'decimal:2',
            'line_total' => 'decimal:2',
            'discount_amount' => 'decimal:2',
            'tax_amount' => 'decimal:2',
            'final_total' => 'decimal:2',
            'refund_amount' => 'decimal:2',
            'quantity' => 'integer',
            'quantity_shipped' => 'integer',
            'quantity_returned' => 'integer',
            'product_options' => 'json',
            'attributes' => 'json',
            'shipped_at' => 'datetime',
            'returned_at' => 'datetime',
            'refunded_at' => 'datetime',
        ];
    }

    /**
     * Boot the model.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (self $model) {
            $model->calculateTotals();
        });

        static::updating(function (self $model) {
            if ($model->isDirty(['quantity', 'unit_price', 'discount_amount', 'tax_amount'])) {
                $model->calculateTotals();
            }
        });
    }

    /**
     * Get the order that owns this item.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the product associated with this order item.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Scope a query to only include shipped items.
     */
    public function scopeShipped(Builder $query): Builder
    {
        return $query->where('fulfillment_status', 'shipped');
    }

    /**
     * Scope a query to only include delivered items.
     */
    public function scopeDelivered(Builder $query): Builder
    {
        return $query->where('fulfillment_status', 'delivered');
    }

    /**
     * Scope a query to only include returned items.
     */
    public function scopeReturned(Builder $query): Builder
    {
        return $query->where('quantity_returned', '>', 0);
    }

    /**
     * Scope a query to only include refunded items.
     */
    public function scopeRefunded(Builder $query): Builder
    {
        return $query->whereNotNull('refunded_at');
    }

    /**
     * Check if the item is shipped.
     */
    public function isShipped(): bool
    {
        return $this->fulfillment_status === 'shipped';
    }

    /**
     * Check if the item is delivered.
     */
    public function isDelivered(): bool
    {
        return $this->fulfillment_status === 'delivered';
    }

    /**
     * Check if the item is returned.
     */
    public function isReturned(): bool
    {
        return $this->quantity_returned > 0;
    }

    /**
     * Check if the item is refunded.
     */
    public function isRefunded(): bool
    {
        return !is_null($this->refunded_at);
    }

    /**
     * Get the remaining quantity to ship.
     */
    public function getRemainingToShip(): int
    {
        return max(0, $this->quantity - $this->quantity_shipped);
    }

    /**
     * Get the net quantity (shipped minus returned).
     */
    public function getNetQuantity(): int
    {
        return $this->quantity_shipped - $this->quantity_returned;
    }

    /**
     * Get the formatted unit price.
     */
    public function getFormattedUnitPrice(): string
    {
        return '$' . number_format($this->unit_price, 2);
    }

    /**
     * Get the formatted line total.
     */
    public function getFormattedLineTotal(): string
    {
        return '$' . number_format($this->line_total, 2);
    }

    /**
     * Get the formatted final total.
     */
    public function getFormattedFinalTotal(): string
    {
        return '$' . number_format($this->final_total, 2);
    }

    /**
     * Calculate the discount percentage.
     */
    public function getDiscountPercentage(): float
    {
        if ($this->line_total == 0) {
            return 0;
        }
        return round(($this->discount_amount / $this->line_total) * 100, 2);
    }

    /**
     * Calculate totals for this order item.
     */
    public function calculateTotals(): void
    {
        $this->line_total = $this->quantity * $this->unit_price;
        $this->final_total = $this->line_total - $this->discount_amount + $this->tax_amount;
    }

    /**
     * Ship a quantity of this item.
     */
    public function ship(int $quantity = null): bool
    {
        $quantityToShip = $quantity ?? $this->getRemainingToShip();
        
        if ($quantityToShip > $this->getRemainingToShip()) {
            return false;
        }

        $this->quantity_shipped += $quantityToShip;
        
        if ($this->quantity_shipped >= $this->quantity) {
            $this->fulfillment_status = 'shipped';
        } else {
            $this->fulfillment_status = 'partially_shipped';
        }
        
        $this->shipped_at = now();
        
        return $this->save();
    }

    /**
     * Return a quantity of this item.
     */
    public function returnItem(int $quantity, string $reason = null): bool
    {
        if ($quantity > $this->quantity_shipped - $this->quantity_returned) {
            return false;
        }

        $this->quantity_returned += $quantity;
        $this->returned_at = now();
        
        if ($reason) {
            $this->return_reason = $reason;
        }
        
        return $this->save();
    }

    /**
     * Refund this item.
     */
    public function refund(float $amount = null): bool
    {
        $this->refund_amount = $amount ?? $this->final_total;
        $this->refunded_at = now();
        
        return $this->save();
    }

    /**
     * Get the product image URL.
     */
    public function getImageUrl(): string
    {
        if ($this->product_image) {
            return asset('storage/' . $this->product_image);
        }
        
        return $this->product?->getImageUrl() ?? asset('images/product-placeholder.png');
    }
}