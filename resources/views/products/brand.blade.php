<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
    <title>{{ $metaTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
</head>
<body class="min-h-screen bg-gray-50 dark:bg-gray-900">
    @include('partials.header')
    
    <main class="container mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <nav class="mb-8 text-sm">
            <ol class="flex space-x-2 text-gray-600 dark:text-gray-400">
                <li><a href="{{ route('home') }}" class="hover:text-blue-600">Home</a></li>
                <li>/</li>
                <li><a href="{{ route('products.index') }}" class="hover:text-blue-600">Products</a></li>
                <li>/</li>
                <li class="text-gray-900 dark:text-white">{{ $brand->name }}</li>
            </ol>
        </nav>

        <!-- Brand Header -->
        <div class="mb-8 rounded-lg bg-white p-8 shadow-sm dark:bg-gray-800">
            <div class="flex items-center space-x-6">
                @if($brand->logo)
                    <img 
                        src="{{ asset('storage/' . $brand->logo) }}" 
                        alt="{{ $brand->name }}"
                        class="h-16 w-16 object-contain"
                    >
                @endif
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $brand->name }}</h1>
                    @if($brand->description)
                        <p class="mt-2 text-gray-600 dark:text-gray-400">{{ $brand->description }}</p>
                    @endif
                    <div class="mt-4">
                        <span class="text-sm text-gray-500">{{ $products->total() }} {{ Str::plural('product', $products->total()) }} found</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        @if($products->count() > 0)
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach($products as $product)
                    <div class="group overflow-hidden rounded-lg bg-white shadow-sm transition-shadow hover:shadow-md dark:bg-gray-800">
                        <!-- Product Image -->
                        <div class="relative aspect-square overflow-hidden">
                            @if($product->images->first())
                                <img 
                                    src="{{ asset('storage/' . $product->images->first()->image_path) }}" 
                                    alt="{{ $product->name }}"
                                    class="h-full w-full object-cover transition-transform group-hover:scale-105"
                                >
                            @else
                                <div class="flex h-full w-full items-center justify-center bg-gray-100 dark:bg-gray-700">
                                    <svg class="h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif

                            <!-- Wishlist Button -->
                            @auth
                                @if(auth()->user()->isCustomer())
                                    <button 
                                        onclick="toggleWishlist({{ $product->id }})"
                                        class="absolute right-2 top-2 rounded-full bg-white p-2 shadow-md transition-colors hover:bg-red-50 dark:bg-gray-800 dark:hover:bg-red-900"
                                        id="wishlist-btn-{{ $product->id }}"
                                    >
                                        <svg class="h-5 w-5 text-gray-400 hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                    </button>
                                @endif
                            @endauth

                            <!-- Stock Badge -->
                            @if($product->inventory_quantity <= 0)
                                <div class="absolute left-2 top-2">
                                    <span class="inline-flex rounded-full bg-red-100 px-2 py-1 text-xs font-semibold text-red-800">
                                        Out of Stock
                                    </span>
                                </div>
                            @elseif($product->inventory_quantity <= 10)
                                <div class="absolute left-2 top-2">
                                    <span class="inline-flex rounded-full bg-yellow-100 px-2 py-1 text-xs font-semibold text-yellow-800">
                                        Low Stock
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Product Info -->
                        <div class="p-4">
                            <div class="mb-2">
                                <h3 class="font-medium text-gray-900 dark:text-white">
                                    <a href="{{ route('products.show', $product->slug) }}" class="hover:text-blue-600 dark:hover:text-blue-400">
                                        {{ $product->name }}
                                    </a>
                                </h3>
                                @if($product->category)
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $product->category->name }}</p>
                                @endif
                            </div>

                            <!-- Price -->
                            <div class="mb-3">
                                <span class="text-lg font-bold text-gray-900 dark:text-white">
                                    LKR {{ number_format($product->price, 2) }}
                                </span>
                                @if($product->compare_price && $product->compare_price > $product->price)
                                    <span class="ml-2 text-sm text-gray-500 line-through">
                                        LKR {{ number_format($product->compare_price, 2) }}
                                    </span>
                                @endif
                            </div>

                            <!-- Add to Cart Button -->
                            @if($product->inventory_quantity > 0)
                                <button 
                                    onclick="addToCart({{ $product->id }})"
                                    class="w-full rounded-md bg-blue-600 px-4 py-2 text-white transition-colors hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                >
                                    Add to Cart
                                </button>
                            @else
                                <button 
                                    disabled
                                    class="w-full cursor-not-allowed rounded-md bg-gray-300 px-4 py-2 text-gray-500"
                                >
                                    Out of Stock
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
                <div class="mt-8 flex justify-center">
                    {{ $products->links() }}
                </div>
            @endif
        @else
            <!-- No Products Found -->
            <div class="rounded-lg bg-white p-12 text-center shadow-sm dark:bg-gray-800">
                <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m14 0v5a2 2 0 01-2 2H6a2 2 0 01-2 2v-5m14 0H6m0 0l3-3m-3 3l3 3m8-6l3-3m-3 3l3 3"></path>
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">No products found for this brand</h3>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Check out other brands or browse all products.</p>
                <a href="{{ route('products.index') }}" class="mt-4 inline-block rounded-md bg-blue-600 px-6 py-2 text-white hover:bg-blue-700">
                    Browse All Products
                </a>
            </div>
        @endif
    </main>

    @include('partials.footer')

    <script>
        // Add to Cart functionality
        async function addToCart(productId) {
            try {
                const response = await fetch('{{ route('cart.add') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: 1
                    })
                });

                const data = await response.json();
                
                if (data.success) {
                    showNotification('Product added to cart!', 'success');
                    updateCartCount(data.cart_count);
                } else {
                    showNotification(data.message || 'Failed to add product to cart', 'error');
                }
            } catch (error) {
                showNotification('An error occurred. Please try again.', 'error');
            }
        }

        // Wishlist functionality
        async function toggleWishlist(productId) {
            @guest
                alert('Please login to add items to wishlist');
                return;
            @endguest

            try {
                const response = await fetch('{{ route('customer.wishlist.add') }}', {
                    method: 'POST',
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
                    showNotification('Added to wishlist!', 'success');
                    const btn = document.getElementById(`wishlist-btn-${productId}`);
                    if (btn) {
                        btn.querySelector('svg').classList.add('text-red-500');
                    }
                } else {
                    showNotification(data.message || 'Failed to add to wishlist', 'error');
                }
            } catch (error) {
                showNotification('An error occurred. Please try again.', 'error');
            }
        }

        // Utility functions
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

        function updateCartCount(count) {
            const cartCountElements = document.querySelectorAll('[data-cart-count]');
            cartCountElements.forEach(el => {
                el.textContent = count;
            });
        }
    </script>
</body>
</html>