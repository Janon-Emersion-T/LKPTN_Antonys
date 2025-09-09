<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PosSession extends Model
{
    protected $fillable = [
        'terminal_id',
        'cashier_id',
        'starting_cash',
        'ending_cash',
        'expected_cash',
        'cash_difference',
        'transaction_count',
        'total_sales',
        'total_tax',
        'total_discounts',
        'payment_totals',
        'opened_at',
        'closed_at',
        'status',
        'opening_notes',
        'closing_notes',
        'requires_manager_approval',
        'approved_by',
        'approved_at',
    ];

    protected function casts(): array
    {
        return [
            'starting_cash' => 'decimal:2',
            'ending_cash' => 'decimal:2',
            'expected_cash' => 'decimal:2',
            'cash_difference' => 'decimal:2',
            'total_sales' => 'decimal:2',
            'total_tax' => 'decimal:2',
            'total_discounts' => 'decimal:2',
            'payment_totals' => 'array',
            'opened_at' => 'datetime',
            'closed_at' => 'datetime',
            'requires_manager_approval' => 'boolean',
            'approved_at' => 'datetime',
        ];
    }

    public function terminal(): BelongsTo
    {
        return $this->belongsTo(PosTerminal::class, 'terminal_id');
    }

    public function cashier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'session_id');
    }

    public function isOpen(): bool
    {
        return $this->status === 'open';
    }

    public function isClosed(): bool
    {
        return $this->status === 'closed';
    }

    public function calculateExpectedCash(): float
    {
        $cashPayments = $this->orders()
            ->whereHas('payments', function($query) {
                $query->where('payment_method', 'cash');
            })
            ->with('payments')
            ->get()
            ->sum(function($order) {
                return $order->payments->where('payment_method', 'cash')->sum('amount');
            });

        return $this->starting_cash + $cashPayments;
    }

    public function updateTotals(): void
    {
        $orders = $this->orders()->with('payments')->get();
        
        $this->update([
            'transaction_count' => $orders->count(),
            'total_sales' => $orders->sum('total_amount'),
            'total_tax' => $orders->sum('tax_amount'),
            'total_discounts' => $orders->sum('discount_amount'),
            'payment_totals' => $this->calculatePaymentTotals($orders),
            'expected_cash' => $this->calculateExpectedCash(),
        ]);
    }

    private function calculatePaymentTotals($orders): array
    {
        $totals = [];
        
        foreach ($orders as $order) {
            foreach ($order->payments as $payment) {
                $method = $payment->payment_method;
                $totals[$method] = ($totals[$method] ?? 0) + $payment->amount;
            }
        }
        
        return $totals;
    }
}
