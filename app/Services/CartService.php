<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CartService
{
    protected $cart;

    public function __construct()
    {
        $this->initializeCart();
    }

    /**
     * Initialize cart based on user authentication
     */
    protected function initializeCart(): void
    {
        if (auth()->check()) {
            // For authenticated users, get or create database cart
            $this->cart = Cart::firstOrCreate([
                'user_id' => auth()->id(),
                'status' => 'active'
            ], [
                'session_id' => Session::getId(),
                'type' => 'web',
                'expires_at' => now()->addDays(30),
            ]);
        } else {
            // For guests, use session
            $sessionId = Session::getId();
            $this->cart = Cart::firstOrCreate([
                'session_id' => $sessionId,
                'user_id' => null,
                'status' => 'active'
            ], [
                'type' => 'web',
                'expires_at' => now()->addDays(7),
            ]);
        }
    }

    /**
     * Add item to cart
     */
    public function addItem(int $productId, int $quantity = 1, array $options = []): bool
    {
        // Load product with optimized query to avoid N+1
        $product = Product::with('images:id,product_id,image_path,is_primary')
            ->select('id', 'name', 'sku', 'price', 'status', 'inventory_quantity', 'track_inventory')
            ->find($productId);
        
        if (!$product || !in_array($product->status, ['published', 'active'])) {
            return false;
        }

        // Check inventory only if tracking is enabled
        if ($product->track_inventory && $quantity > $product->inventory_quantity) {
            return false;
        }

        // Check if item already exists in cart with optimized query
        $cartItem = $this->cart->items()
            ->select('id', 'product_id', 'quantity')
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            // Update quantity
            $newQuantity = $cartItem->quantity + $quantity;
            if ($product->track_inventory && $newQuantity > $product->inventory_quantity) {
                return false; // Not enough stock
            }
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            // Get primary image efficiently
            $primaryImage = $product->images->where('is_primary', true)->first();
            $imageUrl = $primaryImage?->image_path ?? $product->images->first()?->image_path;
            
            // Create new cart item
            CartItem::create([
                'cart_id' => $this->cart->id,
                'product_id' => $productId,
                'product_name' => $product->name,
                'product_sku' => $product->sku,
                'product_image' => $imageUrl,
                'unit_price' => $product->price,
                'quantity' => $quantity,
                'product_options' => $options,
                'status' => 'active',
            ]);
        }

        // Update cart totals efficiently
        $this->updateCartTotalsOptimized();
        return true;
    }

    /**
     * Update item quantity
     */
    public function updateItem(int $productId, int $quantity): bool
    {
        if ($quantity <= 0) {
            return $this->removeItem($productId);
        }

        $cartItem = $this->cart->items()->where('product_id', $productId)->first();
        
        if (!$cartItem) {
            return false;
        }

        $product = $cartItem->product;
        if ($quantity > $product->inventory_quantity) {
            return false;
        }

        $cartItem->update(['quantity' => $quantity]);
        $this->updateCartTotals();
        
        return true;
    }

    /**
     * Remove item from cart
     */
    public function removeItem(int $productId): bool
    {
        $removed = $this->cart->items()->where('product_id', $productId)->delete();
        
        if ($removed) {
            $this->updateCartTotals();
            return true;
        }
        
        return false;
    }

    /**
     * Clear entire cart
     */
    public function clear(): void
    {
        $this->cart->items()->delete();
        $this->updateCartTotals();
    }

    /**
     * Get cart items
     */
    public function getItems()
    {
        return $this->cart->items()->with(['product', 'product.images'])->get();
    }

    /**
     * Get cart item count
     */
    public function getItemCount(): int
    {
        return $this->cart->items()->sum('quantity');
    }

    /**
     * Get cart subtotal
     */
    public function getSubtotal(): float
    {
        return $this->cart->subtotal ?? 0;
    }

    /**
     * Get cart total
     */
    public function getTotal(): float
    {
        return $this->cart->total_amount ?? 0;
    }

    /**
     * Check if product is in cart
     */
    public function hasProduct(int $productId): bool
    {
        return $this->cart->items()->where('product_id', $productId)->exists();
    }

    /**
     * Get cart for checkout
     */
    public function getCart(): Cart
    {
        return $this->cart->fresh()->load(['items', 'items.product']);
    }

    /**
     * Update cart totals
     */
    protected function updateCartTotals(): void
    {
        $items = $this->cart->items()->with('product')->get();
        
        $subtotal = $items->sum(function ($item) {
            return $item->quantity * $item->unit_price;
        });
        
        $taxAmount = $subtotal * 0.0; // No tax for now
        $shippingAmount = $this->calculateShipping($subtotal);
        $total = $subtotal + $taxAmount + $shippingAmount;

        $this->cart->update([
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'shipping_amount' => $shippingAmount,
            'total_amount' => $total,
        ]);
    }

    /**
     * Update cart totals efficiently (optimized version)
     */
    protected function updateCartTotalsOptimized(): void
    {
        // Use raw SQL for better performance
        $cartData = $this->cart->items()
            ->selectRaw('SUM(quantity * unit_price) as subtotal, SUM(quantity) as item_count')
            ->first();
        
        $subtotal = $cartData->subtotal ?? 0;
        
        $taxAmount = $subtotal * 0.0; // No tax for now
        $shippingAmount = $this->calculateShipping($subtotal);
        $total = $subtotal + $taxAmount + $shippingAmount;

        $this->cart->update([
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'shipping_amount' => $shippingAmount,
            'total_amount' => $total,
        ]);
    }

    /**
     * Calculate shipping cost
     */
    protected function calculateShipping(float $subtotal): float
    {
        // Free shipping over 50000 LKR
        if ($subtotal >= 50000) {
            return 0;
        }
        
        // Flat rate shipping
        return 1500;
    }

    /**
     * Merge guest cart with user cart after login
     */
    public function mergeGuestCart(string $guestSessionId): void
    {
        if (!auth()->check()) {
            return;
        }

        $guestCart = Cart::where('session_id', $guestSessionId)
                         ->where('user_id', null)
                         ->where('status', 'active')
                         ->first();

        if (!$guestCart || $guestCart->items->isEmpty()) {
            return;
        }

        // Get or create user cart
        $userCart = Cart::firstOrCreate([
            'user_id' => auth()->id(),
            'status' => 'active'
        ], [
            'session_id' => Session::getId(),
            'type' => 'web',
            'expires_at' => now()->addDays(30),
        ]);

        // Merge items
        foreach ($guestCart->items as $guestItem) {
            $existingItem = $userCart->items()->where('product_id', $guestItem->product_id)->first();
            
            if ($existingItem) {
                $existingItem->update([
                    'quantity' => $existingItem->quantity + $guestItem->quantity
                ]);
            } else {
                CartItem::create([
                    'cart_id' => $userCart->id,
                    'product_id' => $guestItem->product_id,
                    'product_name' => $guestItem->product_name,
                    'product_sku' => $guestItem->product_sku,
                    'product_image' => $guestItem->product_image,
                    'unit_price' => $guestItem->unit_price,
                    'quantity' => $guestItem->quantity,
                    'product_options' => $guestItem->product_options,
                    'status' => 'active',
                ]);
            }
        }

        // Delete guest cart
        $guestCart->delete();

        // Update current cart reference
        $this->cart = $userCart;
        $this->updateCartTotals();
    }
}
