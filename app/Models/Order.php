<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'order_number',
        'user_id',
        'customer_id',
        'type',
        'channel',
        'status',
        'payment_status',
        'fulfillment_status',
        'customer_email',
        'customer_phone',
        'customer_name',
        'subtotal',
        'tax_amount',
        'shipping_amount',
        'discount_amount',
        'total_amount',
        'currency',
        'shipping_address',
        'billing_address',
        'shipping_method',
        'shipping_cost',
        'tracking_number',
        'shipped_at',
        'delivered_at',
        'coupon_id',
        'coupon_code',
        'coupon_discount',
        'cashier_id',
        'terminal_id',
        'receipt_number',
        'attributes',
        'notes',
        'admin_notes',
        'tags',
        'confirmed_at',
        'cancelled_at',
        'refunded_at',
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
            'billing_address' => 'json',
            'attributes' => 'json',
            'tags' => 'json',
            'shipped_at' => 'datetime',
            'delivered_at' => 'datetime',
            'confirmed_at' => 'datetime',
            'cancelled_at' => 'datetime',
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
            if (empty($model->order_number)) {
                $model->order_number = static::generateOrderNumber();
            }
            if (empty($model->currency)) {
                $model->currency = 'USD';
            }
        });
    }

    /**
     * Generate a unique order number.
     */
    public static function generateOrderNumber(): string
    {
        do {
            $orderNumber = 'ORD-' . date('Y') . '-' . strtoupper(Str::random(8));
        } while (static::where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }

    /**
     * Get the user that placed the order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the customer profile.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the coupon applied to this order.
     */
    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    /**
     * Get the cashier who processed the order.
     */
    public function cashier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }

    /**
     * Get the POS terminal where this order was processed.
     */
    public function terminal(): BelongsTo
    {
        return $this->belongsTo(PosTerminal::class, 'terminal_id');
    }

    /**
     * Get the POS session this order belongs to.
     */
    public function session(): BelongsTo
    {
        return $this->belongsTo(PosSession::class, 'session_id');
    }

    /**
     * Get the order items.
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the payments for this order.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Scope a query to only include orders with a specific status.
     */
    public function scopeWithStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to only include pending orders.
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include confirmed orders.
     */
    public function scopeConfirmed(Builder $query): Builder
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Scope a query to only include processing orders.
     */
    public function scopeProcessing(Builder $query): Builder
    {
        return $query->where('status', 'processing');
    }

    /**
     * Scope a query to only include shipped orders.
     */
    public function scopeShipped(Builder $query): Builder
    {
        return $query->where('status', 'shipped');
    }

    /**
     * Scope a query to only include delivered orders.
     */
    public function scopeDelivered(Builder $query): Builder
    {
        return $query->where('status', 'delivered');
    }

    /**
     * Scope a query to only include completed orders.
     */
    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope a query to only include cancelled orders.
     */
    public function scopeCancelled(Builder $query): Builder
    {
        return $query->where('status', 'cancelled');
    }

    /**
     * Scope a query to only include refunded orders.
     */
    public function scopeRefunded(Builder $query): Builder
    {
        return $query->where('status', 'refunded');
    }

    /**
     * Scope a query to filter by payment status.
     */
    public function scopePaymentStatus(Builder $query, string $status): Builder
    {
        return $query->where('payment_status', $status);
    }

    /**
     * Scope a query to only include paid orders.
     */
    public function scopePaid(Builder $query): Builder
    {
        return $query->where('payment_status', 'paid');
    }

    /**
     * Scope a query to only include unpaid orders.
     */
    public function scopeUnpaid(Builder $query): Builder
    {
        return $query->whereIn('payment_status', ['pending', 'unpaid']);
    }

    /**
     * Scope a query to filter by order type.
     */
    public function scopeOfType(Builder $query, string $type): Builder
    {
        return $query->where('type', $type);
    }

    /**
     * Scope a query to only include online orders.
     */
    public function scopeOnline(Builder $query): Builder
    {
        return $query->where('type', 'online');
    }

    /**
     * Scope a query to only include POS orders.
     */
    public function scopePos(Builder $query): Builder
    {
        return $query->where('type', 'pos');
    }

    /**
     * Scope a query to search orders by order number, customer name, or email.
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function ($query) use ($search) {
            $query->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%");
        });
    }

    /**
     * Scope a query to filter orders by date range.
     */
    public function scopeDateRange(Builder $query, string $start = null, string $end = null): Builder
    {
        if ($start) {
            $query->whereDate('created_at', '>=', $start);
        }
        if ($end) {
            $query->whereDate('created_at', '<=', $end);
        }
        return $query;
    }

    /**
     * Check if the order is pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if the order is confirmed.
     */
    public function isConfirmed(): bool
    {
        return $this->status === 'confirmed';
    }

    /**
     * Check if the order is processing.
     */
    public function isProcessing(): bool
    {
        return $this->status === 'processing';
    }

    /**
     * Check if the order is shipped.
     */
    public function isShipped(): bool
    {
        return $this->status === 'shipped';
    }

    /**
     * Check if the order is delivered.
     */
    public function isDelivered(): bool
    {
        return $this->status === 'delivered';
    }

    /**
     * Check if the order is completed.
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Check if the order is cancelled.
     */
    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    /**
     * Check if the order is refunded.
     */
    public function isRefunded(): bool
    {
        return $this->status === 'refunded';
    }

    /**
     * Check if the order is paid.
     */
    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    /**
     * Check if the order is from POS.
     */
    public function isPos(): bool
    {
        return $this->type === 'pos';
    }

    /**
     * Check if the order is online.
     */
    public function isOnline(): bool
    {
        return $this->type === 'online';
    }

    /**
     * Get the total number of items in the order.
     */
    public function getTotalItemsCount(): int
    {
        return $this->items()->sum('quantity');
    }

    /**
     * Get the order's formatted total.
     */
    public function getFormattedTotal(): string
    {
        return '$' . number_format($this->total_amount, 2);
    }

    /**
     * Get the order's formatted subtotal.
     */
    public function getFormattedSubtotal(): string
    {
        return '$' . number_format($this->subtotal, 2);
    }

    /**
     * Confirm the order.
     */
    public function confirm(): bool
    {
        return $this->update([
            'status' => 'confirmed',
            'confirmed_at' => now(),
        ]);
    }

    /**
     * Cancel the order.
     */
    public function cancel(string $reason = null): bool
    {
        $updated = $this->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);

        if ($reason) {
            $this->update([
                'admin_notes' => ($this->admin_notes ? $this->admin_notes . "\n" : '') . 
                               'Cancelled: ' . $reason
            ]);
        }

        return $updated;
    }

    /**
     * Mark the order as shipped.
     */
    public function ship(string $trackingNumber = null): bool
    {
        $data = [
            'status' => 'shipped',
            'fulfillment_status' => 'shipped',
            'shipped_at' => now(),
        ];

        if ($trackingNumber) {
            $data['tracking_number'] = $trackingNumber;
        }

        return $this->update($data);
    }

    /**
     * Mark the order as delivered.
     */
    public function deliver(): bool
    {
        return $this->update([
            'status' => 'delivered',
            'fulfillment_status' => 'delivered',
            'delivered_at' => now(),
        ]);
    }

    /**
     * Complete the order.
     */
    public function complete(): bool
    {
        return $this->update([
            'status' => 'completed',
        ]);
    }

    /**
     * Refund the order.
     */
    public function refund(string $reason = null): bool
    {
        $updated = $this->update([
            'status' => 'refunded',
            'payment_status' => 'refunded',
            'refunded_at' => now(),
        ]);

        if ($reason) {
            $this->update([
                'admin_notes' => ($this->admin_notes ? $this->admin_notes . "\n" : '') . 
                               'Refunded: ' . $reason
            ]);
        }

        return $updated;
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'order_number';
    }

    /**
     * Add a tag to the order.
     */
    public function addTag(string $tag): bool
    {
        $tags = $this->tags ?? [];
        if (!in_array($tag, $tags)) {
            $tags[] = $tag;
            return $this->update(['tags' => $tags]);
        }
        return true;
    }

    /**
     * Remove a tag from the order.
     */
    public function removeTag(string $tag): bool
    {
        $tags = $this->tags ?? [];
        $tags = array_values(array_filter($tags, fn($t) => $t !== $tag));
        return $this->update(['tags' => $tags]);
    }

    /**
     * Check if the order has a specific tag.
     */
    public function hasTag(string $tag): bool
    {
        return in_array($tag, $this->tags ?? []);
    }

    /**
     * Calculate order totals.
     */
    public function calculateTotals(): void
    {
        $this->subtotal = $this->items()->sum('line_total');
        $this->discount_amount = $this->items()->sum('discount_amount') + ($this->coupon_discount ?? 0);
        // Tax and shipping would typically be calculated based on business rules
        $this->total_amount = $this->subtotal + $this->tax_amount + $this->shipping_amount - $this->discount_amount;
    }
}