<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
    <title>{{ $product->name }} - {{ config('app.name') }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    <meta name="keywords" content="{{ $metaKeywords }}">
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
                @if($product->category)
                    <li>/</li>
                    <li><a href="{{ route('categories.show', $product->category->slug) }}" class="hover:text-blue-600">{{ $product->category->name }}</a></li>
                @endif
                <li>/</li>
                <li class="text-gray-900 dark:text-white">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="grid gap-8 lg:grid-cols-2">
            <!-- Product Images -->
            <div class="space-y-4">
                <!-- Main Image -->
                <div class="aspect-square overflow-hidden rounded-lg bg-white shadow-sm">
                    @if($product->images->first())
                        <img 
                            id="main-image"
                            src="{{ asset('storage/' . $product->images->first()->image_path) }}" 
                            alt="{{ $product->name }}"
                            class="h-full w-full object-cover"
                        >
                    @else
                        <div class="flex h-full w-full items-center justify-center bg-gray-100 dark:bg-gray-800">
                            <svg class="h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Thumbnail Images -->
                @if($product->images->count() > 1)
                    <div class="flex space-x-2">
                        @foreach($product->images as $image)
                            <button 
                                onclick="changeMainImage('{{ asset('storage/' . $image->image_path) }}')"
                                class="aspect-square w-20 overflow-hidden rounded border-2 border-transparent hover:border-blue-500"
                            >
                                <img 
                                    src="{{ asset('storage/' . $image->image_path) }}" 
                                    alt="{{ $product->name }}"
                                    class="h-full w-full object-cover"
                                >
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Product Details -->
            <div class="space-y-6">
                <!-- Title and Brand -->
                <div>
                    @if($product->brand)
                        <p class="text-sm text-blue-600 dark:text-blue-400 font-medium">{{ $product->brand->name }}</p>
                    @endif
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $product->name }}</h1>
                    @if($product->category)
                        <p class="text-gray-600 dark:text-gray-400">{{ $product->category->name }}</p>
                    @endif
                </div>

                <!-- Rating and Reviews (placeholder) -->
                <div class="flex items-center space-x-2">
                    <div class="flex space-x-1">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        @endfor
                    </div>
                    <span class="text-sm text-gray-600 dark:text-gray-400">(4.5) 23 reviews</span>
                </div>

                <!-- Price -->
                <div class="space-y-2">
                    <div class="flex items-baseline space-x-3">
                        <span class="text-3xl font-bold text-gray-900 dark:text-white">
                            LKR {{ number_format($product->price, 2) }}
                        </span>
                        @if($product->compare_price && $product->compare_price > $product->price)
                            <span class="text-xl text-gray-500 line-through">
                                LKR {{ number_format($product->compare_price, 2) }}
                            </span>
                            <span class="rounded bg-red-100 px-2 py-1 text-sm font-medium text-red-800 dark:bg-red-900 dark:text-red-200">
                                {{ round((($product->compare_price - $product->price) / $product->compare_price) * 100) }}% OFF
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Stock Status -->
                <div>
                    @if($product->inventory_quantity > 0)
                        <div class="flex items-center space-x-2">
                            <span class="inline-flex h-3 w-3 rounded-full bg-green-400"></span>
                            <span class="text-sm text-green-600 dark:text-green-400 font-medium">
                                In Stock ({{ $product->inventory_quantity }} available)
                            </span>
                        </div>
                    @else
                        <div class="flex items-center space-x-2">
                            <span class="inline-flex h-3 w-3 rounded-full bg-red-400"></span>
                            <span class="text-sm text-red-600 dark:text-red-400 font-medium">Out of Stock</span>
                        </div>
                    @endif
                </div>

                <!-- Product SKU -->
                @if($product->sku)
                    <div>
                        <span class="text-sm text-gray-600 dark:text-gray-400">SKU: {{ $product->sku }}</span>
                    </div>
                @endif

                <!-- Quantity Selector and Add to Cart -->
                <div class="space-y-4">
                    @if($product->inventory_quantity > 0)
                        <div class="flex items-center space-x-4">
                            <label for="quantity" class="text-sm font-medium text-gray-900 dark:text-white">Quantity:</label>
                            <div class="flex items-center border border-gray-300 rounded-md dark:border-gray-600">
                                <button 
                                    type="button" 
                                    onclick="decrementQuantity()"
                                    class="px-3 py-1 hover:bg-gray-100 dark:hover:bg-gray-700"
                                >
                                    -
                                </button>
                                <input 
                                    type="number" 
                                    id="quantity" 
                                    value="1" 
                                    min="1" 
                                    max="{{ $product->inventory_quantity }}"
                                    class="w-16 border-0 bg-transparent py-1 text-center focus:ring-0 dark:text-white"
                                >
                                <button 
                                    type="button" 
                                    onclick="incrementQuantity()"
                                    class="px-3 py-1 hover:bg-gray-100 dark:hover:bg-gray-700"
                                >
                                    +
                                </button>
                            </div>
                        </div>

                        <div class="flex space-x-4">
                            <button 
                                onclick="addToCart({{ $product->id }})"
                                class="flex-1 rounded-md bg-blue-600 px-8 py-3 text-white font-medium transition-colors hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                                Add to Cart
                            </button>

                            @auth
                                @if(auth()->user()->isCustomer())
                                    <button 
                                        onclick="toggleWishlist({{ $product->id }})"
                                        class="rounded-md border border-gray-300 px-4 py-3 text-gray-700 transition-colors hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700"
                                        id="wishlist-btn-{{ $product->id }}"
                                    >
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                    </button>
                                @endif
                            @endauth
                        </div>
                    @else
                        <button 
                            disabled
                            class="w-full cursor-not-allowed rounded-md bg-gray-300 px-8 py-3 text-gray-500"
                        >
                            Out of Stock
                        </button>
                    @endif
                </div>

                <!-- Product Description -->
                @if($product->description)
                    <div class="prose max-w-none dark:prose-invert">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Description</h3>
                        <div class="text-gray-600 dark:text-gray-400">
                            {!! nl2br(e($product->description)) !!}
                        </div>
                    </div>
                @endif

                <!-- Product Specifications (if available) -->
                @if($product->specifications)
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Specifications</h3>
                        <div class="space-y-2 text-sm">
                            @foreach(json_decode($product->specifications, true) ?? [] as $spec => $value)
                                <div class="flex justify-between border-b border-gray-200 pb-2 dark:border-gray-700">
                                    <span class="font-medium text-gray-900 dark:text-white">{{ ucfirst($spec) }}:</span>
                                    <span class="text-gray-600 dark:text-gray-400">{{ $value }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
            <div class="mt-16">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-8">Related Products</h2>
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach($relatedProducts as $relatedProduct)
                        <div class="group overflow-hidden rounded-lg bg-white shadow-sm transition-shadow hover:shadow-md dark:bg-gray-800">
                            <!-- Product Image -->
                            <div class="relative aspect-square overflow-hidden">
                                @if($relatedProduct->images->first())
                                    <img 
                                        src="{{ asset('storage/' . $relatedProduct->images->first()->image_path) }}" 
                                        alt="{{ $relatedProduct->name }}"
                                        class="h-full w-full object-cover transition-transform group-hover:scale-105"
                                    >
                                @else
                                    <div class="flex h-full w-full items-center justify-center bg-gray-100 dark:bg-gray-700">
                                        <svg class="h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Product Info -->
                            <div class="p-4">
                                <div class="mb-2">
                                    <h3 class="font-medium text-gray-900 dark:text-white">
                                        <a href="{{ route('products.show', $relatedProduct->slug) }}" class="hover:text-blue-600 dark:hover:text-blue-400">
                                            {{ $relatedProduct->name }}
                                        </a>
                                    </h3>
                                    @if($relatedProduct->brand)
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $relatedProduct->brand->name }}</p>
                                    @endif
                                </div>

                                <!-- Price -->
                                <div class="mb-3">
                                    <span class="text-lg font-bold text-gray-900 dark:text-white">
                                        LKR {{ number_format($relatedProduct->price, 2) }}
                                    </span>
                                </div>

                                <!-- Add to Cart Button -->
                                @if($relatedProduct->inventory_quantity > 0)
                                    <button 
                                        onclick="addToCart({{ $relatedProduct->id }})"
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
            </div>
        @endif
    </main>

    @include('partials.footer')

    <script>
        function changeMainImage(imageSrc) {
            document.getElementById('main-image').src = imageSrc;
        }

        function incrementQuantity() {
            const input = document.getElementById('quantity');
            const max = parseInt(input.max);
            const current = parseInt(input.value);
            if (current < max) {
                input.value = current + 1;
            }
        }

        function decrementQuantity() {
            const input = document.getElementById('quantity');
            const current = parseInt(input.value);
            if (current > 1) {
                input.value = current - 1;
            }
        }

        // Add to Cart functionality
        async function addToCart(productId) {
            const quantity = document.getElementById('quantity') ? parseInt(document.getElementById('quantity').value) : 1;
            
            try {
                const response = await fetch('{{ route('cart.add') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: quantity
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