<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
    <title>TechHub - Premium Computer Store</title>
    <meta name="description" content="Your trusted partner for premium computer hardware and technology solutions in Sri Lanka. Latest laptops, desktops, gaming PCs and accessories.">
</head>
<body class="min-h-screen bg-gray-50 dark:bg-gray-900">
    @include('partials.header')
    
    <!-- Hero Section -->
    @include('homepartials.hero')
    {{-- <section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white">
        <div class="container mx-auto px-4 py-16">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-4xl lg:text-5xl font-bold mb-6">Latest Technology at Your Fingertips</h1>
                    <p class="text-xl mb-8 text-blue-100">Discover premium laptops, desktops, and accessories from leading brands. Competitive prices, genuine products, and expert support.</p>
                    <div class="flex gap-4">
                        <a href="{{ route('products.index') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                            Shop Now
                        </a>
                        <a href="{{ route('products.index', ['sort' => 'price_asc']) }}" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition-colors">
                            View Offers
                        </a>
                    </div>
                </div>
                <div class="text-center">
                    <img src="https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=600&h=400&fit=crop" 
                         alt="Latest Laptop" 
                         class="rounded-lg shadow-2xl max-w-full">
                </div>
            </div>
        </div>
    </section> --}}
    @include('homepartials.laptop')
    @include('homepartials.jbl')
    @include('homepartials.pay')
    @include('homepartials.blog')
    @include('homepartials.bag')
    @include('homepartials.map')

    <!-- Categories Section -->
    {{-- <section class="py-16 bg-gray-50 dark:bg-gray-800">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 dark:text-white mb-4">Shop by Category</h2>
                <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">Find exactly what you're looking for from our comprehensive range of computer products and accessories.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @php
                    $categories = \App\Models\Category::where('is_active', true)->orderBy('name')->get();
                @endphp
                @foreach($categories as $category)
                    <a href="{{ route('categories.show', $category->slug) }}" class="bg-white dark:bg-gray-700 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 group cursor-pointer">
                        <div class="p-6 text-center">
                            <div class="text-4xl mb-4 group-hover:scale-110 transition-transform duration-300">
                                @switch($category->name)
                                    @case('Laptops')
                                        💻
                                        @break
                                    @case('Desktops')
                                        🖥️
                                        @break
                                    @case('Gaming')
                                        🎮
                                        @break
                                    @case('Accessories')
                                        ⌨️
                                        @break
                                    @case('Components')
                                        🔧
                                        @break
                                    @default
                                        🖱️
                                @endswitch
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">{{ $category->name }}</h3>
                            @if($category->description)
                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">{{ $category->description }}</p>
                            @endif
                            <div class="text-blue-600 dark:text-blue-400 font-medium">
                                {{ $category->products()->count() }} Products
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section> --}}

    <!-- Featured Products -->
    {{-- <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800 dark:text-white mb-2">Featured Products</h2>
                    <p class="text-gray-600 dark:text-gray-400">Discover our newest arrivals and bestsellers</p>
                </div>
                <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 font-medium flex items-center gap-2">
                    View All <span>→</span>
                </a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @php
                    $featuredProducts = \App\Models\Product::where('status', 'active')
                        ->where('inventory_quantity', '>', 0)
                        ->inRandomOrder()
                        ->limit(4)
                        ->get();
                @endphp
                @foreach($featuredProducts as $product)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 group">
                        <div class="relative overflow-hidden rounded-t-lg">
                            @if($product->images->first())
                                <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-48 bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                                    <svg class="h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                            
                            @auth
                                @if(auth()->user()->isCustomer())
                                    <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <button onclick="toggleWishlist({{ $product->id }})" class="bg-white dark:bg-gray-800 p-2 rounded-full shadow-md hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <svg class="h-5 w-5 text-gray-400 hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                @endif
                            @endauth

                            @if($product->inventory_quantity <= 0)
                                <div class="absolute top-2 left-2">
                                    <span class="bg-red-500 text-white text-xs px-2 py-1 rounded">Out of Stock</span>
                                </div>
                            @elseif($product->inventory_quantity <= 10)
                                <div class="absolute top-2 left-2">
                                    <span class="bg-yellow-500 text-white text-xs px-2 py-1 rounded">Low Stock</span>
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <a href="{{ route('products.show', $product->slug) }}" class="block">
                                <h3 class="font-semibold text-gray-800 dark:text-white mb-2 hover:text-blue-600 dark:hover:text-blue-400">{{ $product->name }}</h3>
                            </a>
                            @if($product->brand)
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">{{ $product->brand->name }}</p>
                            @endif
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <span class="text-lg font-bold text-blue-600 dark:text-blue-400">LKR {{ number_format($product->price, 2) }}</span>
                                    @if($product->compare_price && $product->compare_price > $product->price)
                                        <span class="text-sm text-gray-400 line-through ml-2">LKR {{ number_format($product->compare_price, 2) }}</span>
                                    @endif
                                </div>
                                @if($product->inventory_quantity > 0)
                                    <div class="text-sm text-green-600">✅ In Stock</div>
                                @else
                                    <div class="text-sm text-red-600">❌ Out of Stock</div>
                                @endif
                            </div>
                            
                            @if($product->inventory_quantity > 0)
                                <button onclick="addToCart({{ $product->id }})" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition-colors">
                                    Add to Cart
                                </button>
                            @else
                                <button disabled class="w-full bg-gray-300 text-gray-500 py-2 rounded-md cursor-not-allowed">
                                    Out of Stock
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section> --}}

    <!-- Brand Partners -->
    {{-- <section class="py-12 bg-gray-50 dark:bg-gray-800">
        <div class="container mx-auto px-4">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">Our Brand Partners</h2>
                <p class="text-gray-600 dark:text-gray-400">Authorized dealers for leading technology brands</p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6 items-center">
                @php
                    $brands = \App\Models\Brand::where('is_active', true)->orderBy('name')->get();
                @endphp
                @foreach($brands as $brand)
                    <a href="{{ route('brands.show', $brand->slug) }}" class="flex justify-center items-center h-20 bg-white dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors group">
                        @if($brand->logo)
                            <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}" class="max-h-12 max-w-full object-contain">
                        @else
                            <span class="font-bold text-gray-600 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400">{{ $brand->name }}</span>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
    </section> --}}

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
                } else {
                    showNotification(data.message || 'Failed to add to wishlist', 'error');
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

        function updateCartCount(count) {
            const cartCountElements = document.querySelectorAll('[data-cart-count]');
            cartCountElements.forEach(el => {
                el.textContent = count;
            });
        }
    </script>
</body>
</html>