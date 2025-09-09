<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
    <title>Products - {{ config('app.name') }}</title>
</head>
<body class="min-h-screen bg-gray-50 dark:bg-gray-900">
    @include('partials.header')
    
    <main class="container mx-auto px-4 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Products</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Discover our amazing collection</p>
        </div>

        <!-- Filters and Search -->
        <div class="mb-8 rounded-lg bg-white p-6 shadow-sm dark:bg-gray-800">
            <form method="GET" action="{{ route('products.index') }}" class="space-y-4">
                <div class="grid gap-4 md:grid-cols-4">
                    <!-- Search -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Search</label>
                        <input 
                            type="text" 
                            id="search"
                            name="search" 
                            value="{{ request('search') }}"
                            placeholder="Search products..."
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                        >
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category</label>
                        <select 
                            id="category"
                            name="category" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                        >
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Brand Filter -->
                    <div>
                        <label for="brand" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Brand</label>
                        <select 
                            id="brand"
                            name="brand" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                        >
                            <option value="">All Brands</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->slug }}" {{ request('brand') === $brand->slug ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sort -->
                    <div>
                        <label for="sort" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sort By</label>
                        <select 
                            id="sort"
                            name="sort" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                        >
                            <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Name A-Z</option>
                            <option value="price" {{ request('sort') === 'price' ? 'selected' : '' }}>Price Low to High</option>
                            <option value="created" {{ request('sort') === 'created' ? 'selected' : '' }}>Newest First</option>
                        </select>
                    </div>
                </div>

                <!-- Price Range -->
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label for="min_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Min Price (LKR)</label>
                        <input 
                            type="number" 
                            id="min_price"
                            name="min_price" 
                            value="{{ request('min_price') }}"
                            placeholder="0"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                        >
                    </div>
                    <div>
                        <label for="max_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Max Price (LKR)</label>
                        <input 
                            type="number" 
                            id="max_price"
                            name="max_price" 
                            value="{{ request('max_price') }}"
                            placeholder="1000000"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                        >
                    </div>
                </div>

                <div class="flex gap-2">
                    <button 
                        type="submit"
                        class="rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        Apply Filters
                    </button>
                    <a 
                        href="{{ route('products.index') }}"
                        class="rounded-md bg-gray-200 px-4 py-2 text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500"
                    >
                        Clear
                    </a>
                </div>
            </form>
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
                            <button 
                                onclick="toggleWishlist({{ $product->id }})"
                                class="absolute right-2 top-2 rounded-full bg-white p-2 shadow-md transition-colors hover:bg-red-50 dark:bg-gray-800 dark:hover:bg-red-900"
                                id="wishlist-btn-{{ $product->id }}"
                            >
                                <svg class="h-5 w-5 text-gray-400 hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </button>

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
                                @if($product->brand)
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $product->brand->name }}</p>
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
                <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">No products found</h3>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Try adjusting your filters or search terms.</p>
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
                    // Show success message
                    showNotification('Product added to cart!', 'success');
                    // Update cart count in header if it exists
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
                    // Update wishlist button visual state
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
            // Simple notification system - can be enhanced with a proper notification library
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