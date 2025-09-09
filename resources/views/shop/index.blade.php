<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
    <title>Shop - {{ config('app.name') }}</title>
    <meta name="description" content="Shop all products at {{ config('app.name') }}. Find laptops, desktops, gaming PCs, accessories with advanced filtering options.">
</head>
<body class="min-h-screen bg-gray-50 dark:bg-gray-900">
    @include('partials.header')
    
    <main class="container mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <nav class="mb-8 text-sm">
            <ol class="flex space-x-2 text-gray-600 dark:text-gray-400">
                <li><a href="{{ route('home') }}" class="hover:text-blue-600">Home</a></li>
                <li>/</li>
                <li class="text-gray-900 dark:text-white">Shop</li>
            </ol>
        </nav>

        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Shop All Products</h1>
            <p class="text-gray-600 dark:text-gray-400">Discover our complete collection of technology products with advanced filtering</p>
        </div>

        <div class="grid gap-8 lg:grid-cols-4">
            <!-- Sidebar Filters -->
            <div class="lg:col-span-1">
                <div class="rounded-lg bg-white p-6 shadow-sm dark:bg-gray-800 sticky top-8">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Filters</h2>
                    
                    <form method="GET" action="{{ route('shop.index') }}" id="filterForm">
                        <!-- Search -->
                        <div class="mb-6">
                            <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Search</label>
                            <input 
                                type="text" 
                                id="search"
                                name="search" 
                                value="{{ request('search') }}"
                                placeholder="Search products..."
                                class="w-full rounded-md border border-gray-300 px-3 py-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500"
                            >
                        </div>

                        <!-- Categories -->
                        <div class="mb-6">
                            <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category</label>
                            <select 
                                id="category"
                                name="category" 
                                class="w-full rounded-md border border-gray-300 px-3 py-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500"
                            >
                                <option value="">All Categories</option>
                                @php
                                    $categories = \App\Models\Category::where('is_active', true)->orderBy('name')->get();
                                @endphp
                                @foreach($categories as $category)
                                    <option value="{{ $category->slug }}" {{ request('category') === $category->slug ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Brands -->
                        <div class="mb-6">
                            <label for="brand" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Brand</label>
                            <select 
                                id="brand"
                                name="brand" 
                                class="w-full rounded-md border border-gray-300 px-3 py-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500"
                            >
                                <option value="">All Brands</option>
                                @php
                                    $brands = \App\Models\Brand::where('is_active', true)->orderBy('name')->get();
                                @endphp
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->slug }}" {{ request('brand') === $brand->slug ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Price Range -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Price Range (LKR)</label>
                            <div class="grid grid-cols-2 gap-2">
                                <input 
                                    type="number" 
                                    name="price_min" 
                                    value="{{ request('price_min') }}"
                                    placeholder="Min"
                                    class="rounded-md border border-gray-300 px-3 py-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500"
                                >
                                <input 
                                    type="number" 
                                    name="price_max" 
                                    value="{{ request('price_max') }}"
                                    placeholder="Max"
                                    class="rounded-md border border-gray-300 px-3 py-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500"
                                >
                            </div>
                        </div>

                        <!-- Availability -->
                        <div class="mb-6">
                            <label class="flex items-center">
                                <input 
                                    type="checkbox" 
                                    name="in_stock" 
                                    value="1" 
                                    {{ request('in_stock') ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700"
                                >
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">In Stock Only</span>
                            </label>
                        </div>

                        <!-- Sort By -->
                        <div class="mb-6">
                            <label for="sort" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sort By</label>
                            <select 
                                id="sort"
                                name="sort" 
                                class="w-full rounded-md border border-gray-300 px-3 py-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500"
                            >
                                <option value="">Default</option>
                                <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Name A-Z</option>
                                <option value="name_desc" {{ request('sort') === 'name_desc' ? 'selected' : '' }}>Name Z-A</option>
                                <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price Low-High</option>
                                <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price High-Low</option>
                                <option value="created_desc" {{ request('sort') === 'created_desc' ? 'selected' : '' }}>Newest First</option>
                            </select>
                        </div>

                        <!-- Apply Filters Button -->
                        <div class="flex gap-2">
                            <button 
                                type="submit" 
                                class="flex-1 rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                                Apply Filters
                            </button>
                            <a 
                                href="{{ route('shop.index') }}" 
                                class="rounded-md bg-gray-300 px-4 py-2 text-gray-700 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 dark:bg-gray-600 dark:text-gray-300 dark:hover:bg-gray-500"
                            >
                                Clear
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="lg:col-span-3">
                @php
                    // Build the query with filters
                    $query = \App\Models\Product::where('status', 'published');
                    
                    // Apply filters
                    if (request('search')) {
                        $searchTerm = request('search');
                        $query->where(function($q) use ($searchTerm) {
                            $q->where('name', 'like', '%' . $searchTerm . '%')
                              ->orWhere('description', 'like', '%' . $searchTerm . '%')
                              ->orWhere('short_description', 'like', '%' . $searchTerm . '%')
                              ->orWhere('sku', 'like', '%' . $searchTerm . '%');
                        });
                    }
                    
                    if (request('category')) {
                        $query->whereHas('category', function($q) {
                            $q->where('slug', request('category'));
                        });
                    }
                    
                    if (request('brand')) {
                        $query->whereHas('brand', function($q) {
                            $q->where('slug', request('brand'));
                        });
                    }
                    
                    if (request('price_min')) {
                        $query->where('price', '>=', request('price_min'));
                    }
                    
                    if (request('price_max')) {
                        $query->where('price', '<=', request('price_max'));
                    }
                    
                    if (request('in_stock')) {
                        $query->where(function($q) {
                            $q->where('track_inventory', false)
                              ->orWhere(function($subQuery) {
                                  $subQuery->where('track_inventory', true)
                                           ->where('inventory_quantity', '>', 0);
                              });
                        });
                    }
                    
                    // Apply sorting
                    switch (request('sort')) {
                        case 'name_asc':
                            $query->orderBy('name', 'asc');
                            break;
                        case 'name_desc':
                            $query->orderBy('name', 'desc');
                            break;
                        case 'price_asc':
                            $query->orderBy('price', 'asc');
                            break;
                        case 'price_desc':
                            $query->orderBy('price', 'desc');
                            break;
                        case 'created_desc':
                            $query->orderBy('created_at', 'desc');
                            break;
                        default:
                            $query->orderBy('name', 'asc');
                    }
                    
                    $products = $query->with(['brand', 'category'])->paginate(12);
                    $totalProducts = $query->count();
                @endphp

                <!-- Results Header -->
                <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <p class="text-gray-600 dark:text-gray-400">
                            Showing {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} of {{ $products->total() }} products
                        </p>
                    </div>
                    
                    <!-- Mobile Filter Toggle -->
                    <button 
                        onclick="toggleMobileFilters()"
                        class="lg:hidden rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
                    >
                        Filters
                    </button>
                </div>

                @if($products->count() > 0)
                    <!-- Products Grid -->
                    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3">
                        @foreach($products as $product)
                            <div class="group overflow-hidden rounded-lg bg-white shadow-sm transition-shadow hover:shadow-md dark:bg-gray-800">
                                <!-- Product Image -->
                                <div class="relative aspect-square overflow-hidden">
                                    <img 
                                        src="{{ $product->getImageUrl() }}" 
                                        alt="{{ $product->name }}"
                                        class="h-full w-full object-cover transition-transform group-hover:scale-105"
                                        onerror="this.src='{{ $product->getImageUrl() }}'"
                                    >

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
                                    @if(!$product->isInStock())
                                        <div class="absolute left-2 top-2">
                                            <span class="inline-flex rounded-full bg-red-100 px-2 py-1 text-xs font-semibold text-red-800 dark:bg-red-900 dark:text-red-200">
                                                Out of Stock
                                            </span>
                                        </div>
                                    @elseif($product->hasLowStock())
                                        <div class="absolute left-2 top-2">
                                            <span class="inline-flex rounded-full bg-yellow-100 px-2 py-1 text-xs font-semibold text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
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
                                        @if($product->category)
                                            <p class="text-sm text-blue-600 dark:text-blue-400">{{ $product->category->name }}</p>
                                        @endif
                                    </div>

                                    <!-- Price -->
                                    <div class="mb-3">
                                        <div class="flex items-center gap-2">
                                            <span class="text-lg font-bold text-gray-900 dark:text-white">
                                                LKR {{ number_format($product->price, 2) }}
                                            </span>
                                            @if($product->isOnSale())
                                                <span class="text-sm text-gray-500 line-through dark:text-gray-400">
                                                    LKR {{ number_format($product->compare_price, 2) }}
                                                </span>
                                                <span class="rounded-full bg-red-100 px-2 py-1 text-xs font-semibold text-red-800 dark:bg-red-900 dark:text-red-200">
                                                    {{ $product->getDiscountPercentage() }}% OFF
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Add to Cart Button -->
                                    @if($product->isInStock())
                                        <button 
                                            onclick="addToCart({{ $product->id }})"
                                            class="w-full rounded-md bg-blue-600 px-4 py-2 text-white transition-colors hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        >
                                            Add to Cart
                                        </button>
                                    @else
                                        <button 
                                            disabled
                                            class="w-full cursor-not-allowed rounded-md bg-gray-300 px-4 py-2 text-gray-500 dark:bg-gray-600 dark:text-gray-400"
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
                            {{ $products->appends(request()->query())->links() }}
                        </div>
                    @endif
                @else
                    <!-- No Products Found -->
                    <div class="rounded-lg bg-white p-12 text-center shadow-sm dark:bg-gray-800">
                        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m14 0v5a2 2 0 01-2 2H6a2 2 0 01-2 2v-5m14 0H6m0 0l3-3m-3 3l3 3m8-6l3-3m-3 3l3 3"></path>
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">No products found</h3>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">Try adjusting your search criteria or browse all products.</p>
                        <a href="{{ route('shop.index') }}" class="mt-4 inline-block rounded-md bg-blue-600 px-6 py-2 text-white hover:bg-blue-700">
                            Browse All Products
                        </a>
                    </div>
                @endif
            </div>
        </div>
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

        function toggleMobileFilters() {
            // Implementation for mobile filter toggle would go here
            alert('Mobile filters functionality would be implemented here');
        }

        // Auto-submit form on select changes for better UX
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('filterForm');
            const selects = form.querySelectorAll('select');
            const checkboxes = form.querySelectorAll('input[type="checkbox"]');
            
            selects.forEach(select => {
                select.addEventListener('change', () => form.submit());
            });
            
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', () => form.submit());
            });
        });
    </script>
</body>
</html>