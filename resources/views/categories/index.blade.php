<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
    <title>Product Categories - {{ config('app.name') }}</title>
    <meta name="description" content="Browse all product categories at {{ config('app.name') }}. Find laptops, desktops, gaming PCs, accessories and more.">
</head>
<body class="min-h-screen bg-gray-50 dark:bg-gray-900">
    @include('partials.header')
    
    <main class="container mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <nav class="mb-8 text-sm">
            <ol class="flex space-x-2 text-gray-600 dark:text-gray-400">
                <li><a href="{{ route('home') }}" class="hover:text-blue-600">Home</a></li>
                <li>/</li>
                <li class="text-gray-900 dark:text-white">Categories</li>
            </ol>
        </nav>

        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Product Categories</h1>
            <p class="text-gray-600 dark:text-gray-400">Explore our complete range of computer products organized by category</p>
        </div>

        <!-- Categories Grid -->
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @php
                $categories = \App\Models\Category::where('is_active', true)
                    ->withCount('products')
                    ->orderBy('name')
                    ->get();
            @endphp
            
            @foreach($categories as $category)
                <div class="group overflow-hidden rounded-lg bg-white shadow-sm transition-shadow hover:shadow-md dark:bg-gray-800">
                    <!-- Category Header -->
                    <div class="relative h-32 overflow-hidden">
                        @if($category->products->first() && $category->products->first()->images->first())
                            <img 
                                src="{{ asset('storage/' . $category->products->first()->images->first()->image_path) }}" 
                                alt="{{ $category->name }}"
                                class="h-full w-full object-cover transition-transform group-hover:scale-105"
                            >
                        @else
                            <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-blue-500 to-purple-600">
                                <div class="text-center text-white">
                                    <div class="text-4xl mb-2">
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
                                </div>
                            </div>
                        @endif
                        
                        <!-- Overlay -->
                        <div class="absolute inset-0 bg-black bg-opacity-20 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </div>

                    <!-- Category Info -->
                    <div class="p-6">
                        <div class="mb-2">
                            <h3 class="font-semibold text-gray-900 dark:text-white text-lg">
                                <a href="{{ route('categories.show', $category->slug) }}" class="hover:text-blue-600 dark:hover:text-blue-400">
                                    {{ $category->name }}
                                </a>
                            </h3>
                        </div>

                        @if($category->description)
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-2">
                                {{ $category->description }}
                            </p>
                        @endif

                        <!-- Product Count and Price Range -->
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm text-blue-600 dark:text-blue-400 font-medium">
                                {{ $category->products_count }} {{ Str::plural('product', $category->products_count) }}
                            </span>
                            @php
                                $priceRange = $category->products()
                                    ->where('status', 'active')
                                    ->where('inventory_quantity', '>', 0)
                                    ->selectRaw('MIN(price) as min_price, MAX(price) as max_price')
                                    ->first();
                            @endphp
                            @if($priceRange && $priceRange->min_price)
                                <span class="text-sm text-gray-600 dark:text-gray-400">
                                    From LKR {{ number_format($priceRange->min_price, 0) }}
                                </span>
                            @endif
                        </div>

                        <!-- Browse Button -->
                        <a 
                            href="{{ route('categories.show', $category->slug) }}"
                            class="block w-full rounded-md bg-blue-600 px-4 py-2 text-center text-white transition-colors hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                            Browse {{ $category->name }}
                        </a>

                        <!-- Featured Brands in Category -->
                        @php
                            $categoryBrands = \App\Models\Brand::whereHas('products', function($query) use ($category) {
                                $query->where('category_id', $category->id)
                                      ->where('status', 'active');
                            })->where('is_active', true)->limit(3)->get();
                        @endphp
                        
                        @if($categoryBrands->count() > 0)
                            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600">
                                <div class="text-xs text-gray-500 dark:text-gray-400 mb-2">Featured Brands:</div>
                                <div class="flex flex-wrap gap-1">
                                    @foreach($categoryBrands as $brand)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                            {{ $brand->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        @if($categories->count() === 0)
            <!-- No Categories Found -->
            <div class="rounded-lg bg-white p-12 text-center shadow-sm dark:bg-gray-800">
                <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">No categories available</h3>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Categories will appear here when they are added to the system.</p>
            </div>
        @endif
    </main>

    @include('partials.footer')
</body>
</html>