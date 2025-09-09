<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inventory extends Model
{
    /** @use HasFactory<\Database\Factories\InventoryFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'product_id',
        'supplier_id',
        'quantity_on_hand',
        'quantity_available',
        'quantity_reserved',
        'quantity_incoming',
        'reorder_level',
        'reorder_quantity',
        'cost_price',
        'average_cost',
        'location',
        'bin_location',
        'status',
        'attributes',
        'notes',
        'last_counted_at',
        'last_counted_by',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'quantity_on_hand' => 'integer',
            'quantity_available' => 'integer',
            'quantity_reserved' => 'integer',
            'quantity_incoming' => 'integer',
            'reorder_level' => 'integer',
            'reorder_quantity' => 'integer',
            'cost_price' => 'decimal:2',
            'average_cost' => 'decimal:2',
            'attributes' => 'json',
            'last_counted_at' => 'datetime',
        ];
    }

    /**
     * Get the product that this inventory record belongs to.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the supplier for this inventory.
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Get the user who last counted this inventory.
     */
    public function lastCountedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'last_counted_by');
    }

    /**
     * Scope a query to only include low stock items.
     */
    public function scopeLowStock(Builder $query): Builder
    {
        return $query->whereColumn('quantity_on_hand', '<=', 'reorder_level');
    }

    /**
     * Scope a query to only include out of stock items.
     */
    public function scopeOutOfStock(Builder $query): Builder
    {
        return $query->where('quantity_on_hand', '<=', 0);
    }

    /**
     * Scope a query to only include items in stock.
     */
    public function scopeInStock(Builder $query): Builder
    {
        return $query->where('quantity_on_hand', '>', 0);
    }

    /**
     * Scope a query to filter by location.
     */
    public function scopeAtLocation(Builder $query, string $location): Builder
    {
        return $query->where('location', $location);
    }

    /**
     * Scope a query to filter by status.
     */
    public function scopeWithStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }

    /**
     * Check if this item is low stock.
     */
    public function isLowStock(): bool
    {
        return $this->quantity_on_hand <= $this->reorder_level;
    }

    /**
     * Check if this item is out of stock.
     */
    public function isOutOfStock(): bool
    {
        return $this->quantity_on_hand <= 0;
    }

    /**
     * Check if this item is in stock.
     */
    public function isInStock(): bool
    {
        return $this->quantity_on_hand > 0;
    }

    /**
     * Get the available quantity (on hand minus reserved).
     */
    public function getAvailableQuantity(): int
    {
        return max(0, $this->quantity_on_hand - $this->quantity_reserved);
    }

    /**
     * Reserve quantity for an order.
     */
    public function reserveQuantity(int $quantity): bool
    {
        if ($this->getAvailableQuantity() < $quantity) {
            return false;
        }

        $this->quantity_reserved += $quantity;
        $this->quantity_available = $this->getAvailableQuantity();
        
        return $this->save();
    }

    /**
     * Release reserved quantity.
     */
    public function releaseReservedQuantity(int $quantity): bool
    {
        $this->quantity_reserved = max(0, $this->quantity_reserved - $quantity);
        $this->quantity_available = $this->getAvailableQuantity();
        
        return $this->save();
    }

    /**
     * Adjust inventory quantity.
     */
    public function adjustQuantity(int $adjustment, string $reason = null, User $user = null): bool
    {
        $this->quantity_on_hand += $adjustment;
        $this->quantity_available = $this->getAvailableQuantity();
        
        if ($user) {
            $this->last_counted_by = $user->id;
            $this->last_counted_at = now();
        }
        
        if ($reason) {
            $this->notes = ($this->notes ? $this->notes . "\n" : '') . 
                          now()->format('Y-m-d H:i:s') . ': ' . $reason;
        }
        
        return $this->save();
    }

    /**
     * Set the inventory count.
     */
    public function setQuantity(int $quantity, string $reason = null, User $user = null): bool
    {
        $adjustment = $quantity - $this->quantity_on_hand;
        return $this->adjustQuantity($adjustment, $reason, $user);
    }

    /**
     * Get the stock status as a string.
     */
    public function getStockStatus(): string
    {
        if ($this->isOutOfStock()) {
            return 'out_of_stock';
        }
        
        if ($this->isLowStock()) {
            return 'low_stock';
        }
        
        return 'in_stock';
    }

    /**
     * Calculate the inventory value.
     */
    public function getInventoryValue(): float
    {
        return $this->quantity_on_hand * $this->cost_price;
    }

    /**
     * Update the average cost.
     */
    public function updateAverageCost(float $newCost, int $quantityAdded): bool
    {
        $currentValue = $this->quantity_on_hand * $this->average_cost;
        $newValue = $quantityAdded * $newCost;
        $totalQuantity = $this->quantity_on_hand + $quantityAdded;
        
        if ($totalQuantity > 0) {
            $this->average_cost = ($currentValue + $newValue) / $totalQuantity;
        }
        
        return $this->save();
    }
}
