<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Supplier extends Model
{
    /** @use HasFactory<\Database\Factories\SupplierFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'code',
        'email',
        'phone',
        'website',
        'description',
        'contact_person',
        'contact_email',
        'contact_phone',
        'address',
        'city',
        'state',
        'postal_code',
        'country',
        'tax_number',
        'business_license',
        'credit_limit',
        'payment_terms',
        'payment_method',
        'bank_name',
        'bank_account',
        'bank_routing',
        'status',
        'rating',
        'tags',
        'attributes',
        'notes',
        'last_order_date',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'credit_limit' => 'decimal:2',
            'payment_terms' => 'integer',
            'rating' => 'decimal:1',
            'tags' => 'json',
            'attributes' => 'json',
            'last_order_date' => 'datetime',
        ];
    }

    /**
     * Boot the model.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (self $model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
            if (empty($model->code)) {
                $model->code = 'SUP-' . strtoupper(Str::random(6));
            }
        });
    }

    /**
     * Get the inventory records for this supplier.
     */
    public function inventories(): HasMany
    {
        return $this->hasMany(Inventory::class);
    }

    /**
     * Get the products supplied by this supplier.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'supplier_id');
    }

    /**
     * Scope a query to only include active suppliers.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include suppliers with high ratings.
     */
    public function scopeHighRated(Builder $query, float $minRating = 4.0): Builder
    {
        return $query->where('rating', '>=', $minRating);
    }

    /**
     * Scope a query to filter by country.
     */
    public function scopeFromCountry(Builder $query, string $country): Builder
    {
        return $query->where('country', $country);
    }

    /**
     * Scope a query to search suppliers by name, code, or email.
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('contact_person', 'like', "%{$search}%");
        });
    }

    /**
     * Check if the supplier is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Check if the supplier has a high rating.
     */
    public function hasHighRating(float $threshold = 4.0): bool
    {
        return $this->rating >= $threshold;
    }

    /**
     * Get the supplier's full address.
     */
    public function getFullAddress(): string
    {
        $address = [];
        
        if ($this->address) {
            $address[] = $this->address;
        }
        if ($this->city) {
            $address[] = $this->city;
        }
        if ($this->state) {
            $address[] = $this->state;
        }
        if ($this->postal_code) {
            $address[] = $this->postal_code;
        }
        if ($this->country) {
            $address[] = $this->country;
        }
        
        return implode(', ', $address);
    }

    /**
     * Get the primary contact information.
     */
    public function getPrimaryContact(): array
    {
        return [
            'name' => $this->contact_person ?? $this->name,
            'email' => $this->contact_email ?? $this->email,
            'phone' => $this->contact_phone ?? $this->phone,
        ];
    }

    /**
     * Get the total number of products from this supplier.
     */
    public function getProductsCount(): int
    {
        return $this->inventories()->count();
    }

    /**
     * Get the total inventory value from this supplier.
     */
    public function getTotalInventoryValue(): float
    {
        return $this->inventories()
                   ->selectRaw('SUM(quantity_on_hand * cost_price) as total_value')
                   ->value('total_value') ?? 0;
    }

    /**
     * Update the supplier's rating.
     */
    public function updateRating(float $rating): bool
    {
        return $this->update(['rating' => max(0, min(5, $rating))]);
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Add a tag to the supplier.
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
     * Remove a tag from the supplier.
     */
    public function removeTag(string $tag): bool
    {
        $tags = $this->tags ?? [];
        $tags = array_values(array_filter($tags, fn($t) => $t !== $tag));
        return $this->update(['tags' => $tags]);
    }

    /**
     * Check if the supplier has a specific tag.
     */
    public function hasTag(string $tag): bool
    {
        return in_array($tag, $this->tags ?? []);
    }
}
