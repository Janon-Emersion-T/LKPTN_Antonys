<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Customer extends Model
{
    /** @use HasFactory<\Database\Factories\CustomerFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id', 'customer_number', 'first_name', 'last_name', 'email', 'phone',
        'date_of_birth', 'gender', 'company_name', 'job_title', 'tax_number',
        'addresses', 'default_billing_address', 'default_shipping_address',
        'status', 'type', 'group', 'accepts_marketing', 'accepts_sms',
        'marketing_preferences', 'preferred_language', 'total_orders', 'total_spent',
        'average_order_value', 'last_order_date', 'first_order_date', 'loyalty_points',
        'loyalty_tier', 'store_credit', 'notes', 'tags', 'credit_limit',
        'payment_terms', 'source', 'referrer', 'utm_parameters', 'email_verified_at',
        'phone_verified_at', 'verification_token', 'terms_accepted_at', 'privacy_accepted_at',
        'consents', 'attributes', 'preferences', 'last_login_at', 'last_activity_at',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'accepts_marketing' => 'boolean',
            'accepts_sms' => 'boolean',
            'total_orders' => 'integer',
            'total_spent' => 'decimal:2',
            'average_order_value' => 'decimal:2',
            'loyalty_points' => 'integer',
            'store_credit' => 'decimal:2',
            'credit_limit' => 'decimal:2',
            'payment_terms' => 'integer',
            'addresses' => 'json',
            'default_billing_address' => 'json',
            'default_shipping_address' => 'json',
            'marketing_preferences' => 'json',
            'utm_parameters' => 'json',
            'consents' => 'json',
            'attributes' => 'json',
            'preferences' => 'json',
            'tags' => 'json',
            'last_order_date' => 'datetime',
            'first_order_date' => 'datetime',
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
            'terms_accepted_at' => 'datetime',
            'privacy_accepted_at' => 'datetime',
            'last_login_at' => 'datetime',
            'last_activity_at' => 'datetime',
        ];
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (self $model) {
            if (empty($model->customer_number)) {
                $model->customer_number = 'CUS-' . strtoupper(Str::random(8));
            }
            if (empty($model->status)) {
                $model->status = 'active';
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    public function scopeVip(Builder $query): Builder
    {
        return $query->where('type', 'vip');
    }

    public function scopeByGroup(Builder $query, string $group): Builder
    {
        return $query->where('group', $group);
    }

    public function scopeAcceptsMarketing(Builder $query): Builder
    {
        return $query->where('accepts_marketing', true);
    }

    public function scopeHighValue(Builder $query, float $threshold = 1000): Builder
    {
        return $query->where('total_spent', '>=', $threshold);
    }

    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function ($query) use ($search) {
            $query->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('customer_number', 'like', "%{$search}%")
                  ->orWhere('company_name', 'like', "%{$search}%");
        });
    }

    public function getFullName(): string
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    public function getDisplayName(): string
    {
        $name = $this->getFullName();
        return $name ?: $this->email ?: $this->customer_number;
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isVip(): bool
    {
        return $this->type === 'vip';
    }

    public function acceptsMarketing(): bool
    {
        return $this->accepts_marketing;
    }

    public function acceptsSms(): bool
    {
        return $this->accepts_sms;
    }

    public function isEmailVerified(): bool
    {
        return !is_null($this->email_verified_at);
    }

    public function isPhoneVerified(): bool
    {
        return !is_null($this->phone_verified_at);
    }

    public function hasAcceptedTerms(): bool
    {
        return !is_null($this->terms_accepted_at);
    }

    public function hasAcceptedPrivacy(): bool
    {
        return !is_null($this->privacy_accepted_at);
    }

    public function getFormattedTotalSpent(): string
    {
        return '$' . number_format($this->total_spent, 2);
    }

    public function getFormattedAverageOrderValue(): string
    {
        return '$' . number_format($this->average_order_value, 2);
    }

    public function getAge(): int
    {
        return $this->date_of_birth ? $this->date_of_birth->age : 0;
    }

    public function getLoyaltyTier(): string
    {
        return $this->loyalty_tier ?: 'bronze';
    }

    public function addLoyaltyPoints(int $points): bool
    {
        $this->loyalty_points += $points;
        $this->updateLoyaltyTier();
        return $this->save();
    }

    public function subtractLoyaltyPoints(int $points): bool
    {
        $this->loyalty_points = max(0, $this->loyalty_points - $points);
        $this->updateLoyaltyTier();
        return $this->save();
    }

    protected function updateLoyaltyTier(): void
    {
        if ($this->loyalty_points >= 10000) {
            $this->loyalty_tier = 'platinum';
        } elseif ($this->loyalty_points >= 5000) {
            $this->loyalty_tier = 'gold';
        } elseif ($this->loyalty_points >= 1000) {
            $this->loyalty_tier = 'silver';
        } else {
            $this->loyalty_tier = 'bronze';
        }
    }

    public function addStoreCredit(float $amount): bool
    {
        $this->store_credit += $amount;
        return $this->save();
    }

    public function useStoreCredit(float $amount): bool
    {
        if ($this->store_credit < $amount) {
            return false;
        }
        $this->store_credit -= $amount;
        return $this->save();
    }

    public function updateOrderStats(): void
    {
        $orders = $this->orders()->where('status', 'completed');
        
        $this->total_orders = $orders->count();
        $this->total_spent = $orders->sum('total_amount');
        
        if ($this->total_orders > 0) {
            $this->average_order_value = $this->total_spent / $this->total_orders;
        }
        
        $this->first_order_date = $orders->min('created_at');
        $this->last_order_date = $orders->max('created_at');
        
        $this->save();
    }

    public function addTag(string $tag): bool
    {
        $tags = $this->tags ?? [];
        if (!in_array($tag, $tags)) {
            $tags[] = $tag;
            return $this->update(['tags' => $tags]);
        }
        return true;
    }

    public function removeTag(string $tag): bool
    {
        $tags = $this->tags ?? [];
        $tags = array_values(array_filter($tags, fn($t) => $t !== $tag));
        return $this->update(['tags' => $tags]);
    }

    public function hasTag(string $tag): bool
    {
        return in_array($tag, $this->tags ?? []);
    }

    public function getInitials(): string
    {
        $firstName = $this->first_name ? substr($this->first_name, 0, 1) : '';
        $lastName = $this->last_name ? substr($this->last_name, 0, 1) : '';
        return strtoupper($firstName . $lastName);
    }

    public function getRouteKeyName(): string
    {
        return 'customer_number';
    }
}