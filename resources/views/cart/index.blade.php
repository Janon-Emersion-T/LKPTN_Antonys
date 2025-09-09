<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
    <title>Shopping Cart - {{ config('app.name') }}</title>
</head>
<body class="min-h-screen bg-gray-50 dark:bg-gray-900">
    @include('partials.header')
    
    <main class="container mx-auto px-4 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Shopping Cart</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Review your items before checkout</p>
        </div>

        <div class="grid gap-8 lg:grid-cols-3">
            <!-- Cart Items -->
            <div class="lg:col-span-2">
                @if($items->count() > 0)
                    <div class="space-y-4">
                        @foreach($items as $item)
                            <div class="rounded-lg bg-white p-6 shadow-sm dark:bg-gray-800" data-item-id="{{ $item->id }}">
                                <div class="flex gap-4">
                                    <!-- Product Image -->
                                    <div class="flex-shrink-0">
                                        @if($item->product && $item->product->images->first())
                                            <img 
                                                src="{{ asset('storage/' . $item->product->images->first()->image_path) }}" 
                                                alt="{{ $item->product->name }}"
                                                class="h-24 w-24 rounded-lg object-cover"
                                            >
                                        @else
                                            <div class="flex h-24 w-24 items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-700">
                                                <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Product Details -->
                                    <div class="flex-1">
                                        <div class="flex justify-between">
                                            <div>
                                                <h3 class="font-medium text-gray-900 dark:text-white">
                                                    @if($item->product)
                                                        <a href="{{ route('products.show', $item->product->slug) }}" class="hover:text-blue-600 dark:hover:text-blue-400">
                                                            {{ $item->product->name }}
                                                        </a>
                                                    @else
                                                        {{ $item->product_name }}
                                                    @endif
                                                </h3>
                                                @if($item->product && $item->product->brand)
                                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $item->product->brand->name }}</p>
                                                @endif
                                                <p class="text-sm text-gray-600 dark:text-gray-400">SKU: {{ $item->product_sku ?? 'N/A' }}</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="font-medium text-gray-900 dark:text-white">
                                                    LKR {{ number_format($item->unit_price, 2) }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="mt-4 flex items-center justify-between">
                                            <!-- Quantity Controls -->
                                            <div class="flex items-center space-x-2">
                                                <label class="text-sm text-gray-600 dark:text-gray-400">Qty:</label>
                                                <div class="flex items-center border border-gray-300 rounded-md dark:border-gray-600">
                                                    <button 
                                                        onclick="updateQuantity({{ $item->product_id }}, {{ max(1, $item->quantity - 1) }})"
                                                        class="px-3 py-1 hover:bg-gray-100 dark:hover:bg-gray-700"
                                                        {{ $item->quantity <= 1 ? 'disabled' : '' }}
                                                    >
                                                        -
                                                    </button>
                                                    <input 
                                                        type="number" 
                                                        value="{{ $item->quantity }}" 
                                                        min="1" 
                                                        max="{{ $item->product ? $item->product->inventory_quantity : 99 }}"
                                                        class="w-16 border-0 bg-transparent py-1 text-center focus:ring-0 dark:text-white"
                                                        onchange="updateQuantity({{ $item->product_id }}, this.value)"
                                                    >
                                                    <button 
                                                        onclick="updateQuantity({{ $item->product_id }}, {{ $item->quantity + 1 }})"
                                                        class="px-3 py-1 hover:bg-gray-100 dark:hover:bg-gray-700"
                                                        {{ $item->product && $item->quantity >= $item->product->inventory_quantity ? 'disabled' : '' }}
                                                    >
                                                        +
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="flex items-center space-x-4">
                                                <!-- Item Total -->
                                                <p class="font-medium text-gray-900 dark:text-white">
                                                    LKR {{ number_format($item->quantity * $item->unit_price, 2) }}
                                                </p>

                                                <!-- Remove Button -->
                                                <button 
                                                    onclick="removeFromCart({{ $item->product_id }})"
                                                    class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300"
                                                >
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Cart Actions -->
                    <div class="mt-6 flex justify-between">
                        <a 
                            href="{{ route('shop.index') }}" 
                            class="rounded-md bg-gray-200 px-6 py-2 text-gray-700 hover:bg-gray-300 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500"
                        >
                            Continue Shopping
                        </a>
                        <button 
                            onclick="clearCart()"
                            class="rounded-md bg-red-600 px-6 py-2 text-white hover:bg-red-700"
                        >
                            Clear Cart
                        </button>
                    </div>
                @else
                    <!-- Empty Cart -->
                    <div class="rounded-lg bg-white p-12 text-center shadow-sm dark:bg-gray-800">
                        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.3 2.7M7 13l-1.3 2.7M7 13h10M17 21a2 2 0 100-4 2 2 0 000 4zM9 21a2 2 0 100-4 2 2 0 000 4z"></path>
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Your cart is empty</h3>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">Start shopping to add items to your cart.</p>
                        <a 
                            href="{{ route('shop.index') }}" 
                            class="mt-6 inline-block rounded-md bg-blue-600 px-6 py-2 text-white hover:bg-blue-700"
                        >
                            Browse Products
                        </a>
                    </div>
                @endif
            </div>

            <!-- Order Summary -->
            @if($items->count() > 0)
                <div class="lg:col-span-1">
                    <div class="sticky top-8 rounded-lg bg-white p-6 shadow-sm dark:bg-gray-800">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white">Order Summary</h2>
                        
                        <div class="mt-6 space-y-4">
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Subtotal ({{ $itemCount }} items)</span>
                                <span class="text-gray-900 dark:text-white">LKR {{ number_format($subtotal, 2) }}</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Shipping</span>
                                <span class="text-gray-900 dark:text-white">
                                    @if($subtotal >= 50000)
                                        <span class="text-green-600">Free</span>
                                    @else
                                        LKR 1,500.00
                                    @endif
                                </span>
                            </div>
                            
                            @if($subtotal < 50000)
                                <div class="text-sm text-green-600">
                                    Add LKR {{ number_format(50000 - $subtotal, 2) }} more for free shipping!
                                </div>
                            @endif
                            
                            <div class="border-t border-gray-200 pt-4 dark:border-gray-700">
                                <div class="flex justify-between text-lg font-medium">
                                    <span class="text-gray-900 dark:text-white">Total</span>
                                    <span class="text-gray-900 dark:text-white">LKR {{ number_format($total, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <a 
                                href="{{ route('checkout') }}" 
                                class="block w-full rounded-md bg-blue-600 px-6 py-3 text-center text-white hover:bg-blue-700"
                            >
                                Proceed to Checkout
                            </a>
                        </div>

                        <div class="mt-4 text-center">
                            <p class="text-xs text-gray-500">
                                Secure checkout powered by SSL encryption
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </main>

    @include('partials.footer')

    <script>
        // Update quantity
        async function updateQuantity(productId, quantity) {
            if (quantity < 1) return;
            
            try {
                const response = await fetch('{{ route('cart.update') }}', {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: parseInt(quantity)
                    })
                });

                const data = await response.json();
                
                if (data.success) {
                    // Reload the page to update totals
                    location.reload();
                } else {
                    showNotification(data.message || 'Failed to update quantity', 'error');
                }
            } catch (error) {
                showNotification('An error occurred. Please try again.', 'error');
            }
        }

        // Remove from cart
        async function removeFromCart(productId) {
            if (!confirm('Are you sure you want to remove this item?')) return;
            
            try {
                const response = await fetch('{{ route('cart.remove') }}', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: productId
                    })
                });

                const data = await response.json();
                
                if (data.success) {
                    location.reload();
                } else {
                    showNotification(data.message || 'Failed to remove item', 'error');
                }
            } catch (error) {
                showNotification('An error occurred. Please try again.', 'error');
            }
        }

        // Clear cart
        async function clearCart() {
            if (!confirm('Are you sure you want to clear your entire cart?')) return;
            
            try {
                const response = await fetch('{{ route('cart.clear') }}', {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                const data = await response.json();
                
                if (data.success) {
                    location.reload();
                } else {
                    showNotification(data.message || 'Failed to clear cart', 'error');
                }
            } catch (error) {
                showNotification('An error occurred. Please try again.', 'error');
            }
        }

        // Utility function for notifications
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 rounded-lg px-6 py-3 text-white shadow-lg transition-opacity ${
                type === 'success' ? 'bg-green-500' : 'bg-red-500'
            }`;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.opacity = '0';
                setTimeout(() => document.body.removeChild(notification), 300);
            }, 3000);
        }
    </script>
</body>
</html>