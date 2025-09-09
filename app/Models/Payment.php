<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Payment extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentFactory> */
    use HasFactory;

    protected $fillable = [
        'order_id', 'user_id', 'customer_id', 'payment_id', 'transaction_id',
        'reference_number', 'amount', 'currency', 'status', 'type', 'method',
        'gateway', 'gateway_payment_id', 'payment_method_token', 'last_four',
        'card_brand', 'card_type', 'expiry_month', 'expiry_year', 'processing_fee',
        'net_amount', 'processor_response', 'processor_message', 'authorization_code',
        'authorized_amount', 'captured_amount', 'authorized_at', 'captured_at',
        'refunded_amount', 'refund_reason', 'refunded_at', 'refunded_by',
        'failure_code', 'failure_message', 'failed_at', 'billing_address',
        'terminal_id', 'receipt_number', 'cashier_id', 'gateway_response',
        'attributes', 'ip_address', 'user_agent', 'notes', 'risk_level',
        'risk_score', 'fraud_details', 'processed_at',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'processing_fee' => 'decimal:2',
            'net_amount' => 'decimal:2',
            'authorized_amount' => 'decimal:2',
            'captured_amount' => 'decimal:2',
            'refunded_amount' => 'decimal:2',
            'risk_score' => 'decimal:2',
            'billing_address' => 'json',
            'gateway_response' => 'json',
            'attributes' => 'json',
            'fraud_details' => 'json',
            'authorized_at' => 'datetime',
            'captured_at' => 'datetime',
            'refunded_at' => 'datetime',
            'failed_at' => 'datetime',
            'processed_at' => 'datetime',
        ];
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (self $model) {
            if (empty($model->payment_id)) {
                $model->payment_id = 'PAY-' . strtoupper(Str::random(12));
            }
        });
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function cashier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }

    public function refundedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'refunded_by');
    }

    public function scopeSuccessful(Builder $query): Builder
    {
        return $query->where('status', 'completed');
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    public function scopeFailed(Builder $query): Builder
    {
        return $query->where('status', 'failed');
    }

    public function scopeRefunded(Builder $query): Builder
    {
        return $query->where('status', 'refunded');
    }

    public function scopeByMethod(Builder $query, string $method): Builder
    {
        return $query->where('method', $method);
    }

    public function scopeByGateway(Builder $query, string $gateway): Builder
    {
        return $query->where('gateway', $gateway);
    }

    public function isSuccessful(): bool
    {
        return $this->status === 'completed';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }

    public function isRefunded(): bool
    {
        return $this->status === 'refunded';
    }

    public function getFormattedAmount(): string
    {
        return '$' . number_format($this->amount, 2);
    }

    public function getMaskedCardNumber(): string
    {
        return $this->last_four ? '**** **** **** ' . $this->last_four : '';
    }

    public function getCardDisplay(): string
    {
        $parts = [];
        if ($this->card_brand) {
            $parts[] = ucfirst($this->card_brand);
        }
        if ($this->last_four) {
            $parts[] = '****' . $this->last_four;
        }
        return implode(' ', $parts);
    }

    public function refund(float $amount = null, string $reason = null, User $refundedBy = null): bool
    {
        $refundAmount = $amount ?? $this->amount;
        
        return $this->update([
            'status' => 'refunded',
            'refunded_amount' => $refundAmount,
            'refund_reason' => $reason,
            'refunded_at' => now(),
            'refunded_by' => $refundedBy?->id,
        ]);
    }

    public function fail(string $reason = null, string $code = null): bool
    {
        return $this->update([
            'status' => 'failed',
            'failure_message' => $reason,
            'failure_code' => $code,
            'failed_at' => now(),
        ]);
    }

    public function complete(): bool
    {
        return $this->update([
            'status' => 'completed',
            'processed_at' => now(),
        ]);
    }

    public function isHighRisk(): bool
    {
        return $this->risk_level === 'high' || $this->risk_score >= 75;
    }

    public function getRiskLevel(): string
    {
        if ($this->risk_score >= 75) {
            return 'high';
        }
        if ($this->risk_score >= 50) {
            return 'medium';
        }
        return 'low';
    }
}
