<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    /**
     * Get the customer profile associated with this user
     */
    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class);
    }

    /**
     * Get the orders placed by this user
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the carts belonging to this user
     */
    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Get the payments made by this user
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get the wishlist items for this user
     */
    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * Check if user is a customer
     */
    public function isCustomer(): bool
    {
        return $this->hasRole('customer');
    }

    /**
     * Check if user is staff (has any role except customer)
     */
    public function isStaff(): bool
    {
        return $this->hasAnyRole(['super-admin', 'admin', 'manager', 'cashier', 'sales-representative', 'inventory-manager', 'customer-support']);
    }

    /**
     * Get the appropriate dashboard route based on user role
     */
    public function getDashboardRoute(): string
    {
        if ($this->isCustomer()) {
            return route('customer.dashboard');
        }

        return route('dashboard');
    }
}
