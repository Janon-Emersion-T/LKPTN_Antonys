<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PosTerminal extends Model
{
    protected $fillable = [
        'name',
        'identifier',
        'location',
        'ip_address',
        'mac_address',
        'is_active',
        'settings',
        'cash_drawer_limit',
        'accepts_cash',
        'accepts_cards',
        'accepts_mobile_payments',
        'receipt_printer_type',
        'receipt_footer_text',
        'assigned_user_id',
        'last_activity_at',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'accepts_cash' => 'boolean',
            'accepts_cards' => 'boolean',
            'accepts_mobile_payments' => 'boolean',
            'settings' => 'array',
            'cash_drawer_limit' => 'decimal:2',
            'last_activity_at' => 'datetime',
        ];
    }

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(PosSession::class, 'terminal_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'terminal_id');
    }

    public function getCurrentSession(): ?PosSession
    {
        return $this->sessions()->where('status', 'open')->first();
    }

    public function isOnline(): bool
    {
        return $this->last_activity_at && 
               $this->last_activity_at->diffInMinutes(now()) <= 5;
    }

    public function updateActivity(): void
    {
        $this->update(['last_activity_at' => now()]);
    }
}
