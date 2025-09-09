<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
    <title>Brands - {{ config('app.name') }}</title>
    <meta name="description" content="Browse all brands at {{ config('app.name') }}. Find products from Dell, HP, Lenovo, ASUS, Acer, Apple and more leading technology brands.">
</head>
<body class="min-h-screen bg-gray-50 dark:bg-gray-900">
    @include('partials.header')
    
    <main class="container mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <nav class="mb-8 text-sm">
            <ol class="flex space-x-2 text-gray-600 dark:text-gray-400">
                <li><a href="{{ route('home') }}" class="hover:text-blue-600">Home</a></li>
                <li>/</li>
                <li class="text-gray-900 dark:text-white">Brands</li>
            </ol>
        </nav>

        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Our Brands</h1>
            <p class="text-gray-600 dark:text-gray-400">Explore products from leading technology brands we partner with</p>
        </div>

        <!-- Brands Grid -->
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @php
                $brands = \App\Models\Brand::where('is_active', true)
                    ->whereHas('products', function($query) {
                        $query->where('status', 'published');
                    })
                    ->withCount(['products' => function($query) {
                        $query->where('status', 'published');
                    }])
                    ->orderBy('name')
                    ->get();
            @endphp
            
            @foreach($brands as $brand)
                <div class="group overflow-hidden rounded-lg bg-white shadow-sm transition-shadow hover:shadow-md dark:bg-gray-800">
                    <!-- Brand Header -->
                    <div class="relative h-32 overflow-hidden">
                        <div class="flex h-full w-full items-center justify-center bg-white dark:bg-gray-700 p-6">
                            @if($brand->hasLogo())
                                <img 
                                    src="{{ $brand->getLogoUrl() }}" 
                                    alt="{{ $brand->name }} logo"
                                    class="max-h-full max-w-full object-contain transition-transform group-hover:scale-105"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                >
                                <div class="hidden h-full w-full items-center justify-center">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-gray-600 dark:text-gray-300">
                                            {{ $brand->name }}
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-lg border-2 border-dashed border-blue-200 dark:border-blue-600">
                                    <div class="text-center">
                                        <div class="text-xl font-bold text-blue-700 dark:text-blue-300 mb-1">
                                            {{ $brand->name }}
                                        </div>
                                        <div class="text-xs text-blue-600 dark:text-blue-400 bg-blue-100 dark:bg-blue-900/40 px-2 py-1 rounded-full">
                                            {{ $brand->products_count }} {{ Str::plural('product', $brand->products_count) }}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Hover Overlay -->
                        <div class="absolute inset-0 bg-black bg-opacity-10 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg"></div>
                        
                        @if(!$brand->hasLogo())
                            <!-- Upload Logo Hint -->
                            @auth
                                @if(auth()->user()->hasRole(['super-admin', 'admin']))
                                    <div class="absolute bottom-2 left-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-blue-600 text-white shadow-sm">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                            </svg>
                                            Add Logo
                                        </span>
                                    </div>
                                @endif
                            @endauth
                        @endif
                        
                        <!-- Brand Website Link -->
                        @if($brand->website)
                            <div class="absolute top-2 right-2">
                                <a href="{{ $brand->website }}" target="_blank" rel="noopener noreferrer" 
                                   class="inline-flex items-center justify-center w-8 h-8 bg-white dark:bg-gray-800 rounded-full shadow-md hover:shadow-lg transition-all opacity-0 group-hover:opacity-100">
                                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Brand Info -->
                    <div class="p-6">
                        <div class="mb-2">
                            <h3 class="font-semibold text-gray-900 dark:text-white text-lg">
                                <a href="{{ route('brands.show', $brand->slug) }}" class="hover:text-blue-600 dark:hover:text-blue-400">
                                    {{ $brand->name }}
                                </a>
                            </h3>
                        </div>

                        @if($brand->description)
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-2">
                                {{ $brand->description }}
                            </p>
                        @endif

                        <!-- Product Count and Price Range -->
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm text-blue-600 dark:text-blue-400 font-medium">
                                {{ $brand->products_count }} {{ Str::plural('product', $brand->products_count) }}
                            </span>
                            @php
                                $priceRange = $brand->products()
                                    ->where('status', 'published')
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
                            href="{{ route('brands.show', $brand->slug) }}"
                            class="block w-full rounded-md bg-blue-600 px-4 py-2 text-center text-white transition-colors hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                            Browse {{ $brand->name }}
                        </a>

                        <!-- Product Categories for Brand -->
                        @php
                            $brandCategories = \App\Models\Category::whereHas('products', function($query) use ($brand) {
                                $query->where('brand_id', $brand->id)
                                      ->where('status', 'published');
                            })->where('is_active', true)->limit(3)->get();
                        @endphp
                        
                        @if($brandCategories->count() > 0)
                            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600">
                                <div class="text-xs text-gray-500 dark:text-gray-400 mb-2">Available in:</div>
                                <div class="flex flex-wrap gap-1">
                                    @foreach($brandCategories as $category)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                            {{ $category->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Featured Products Preview -->
                        @php
                            $featuredProducts = $brand->products()
                                ->where('status', 'published')
                                ->where('inventory_quantity', '>', 0)
                                ->limit(2)
                                ->get();
                        @endphp
                        
                        @if($featuredProducts->count() > 0)
                            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600">
                                <div class="text-xs text-gray-500 dark:text-gray-400 mb-2">Featured Products:</div>
                                <div class="space-y-1">
                                    @foreach($featuredProducts as $product)
                                        <div class="flex items-center justify-between">
                                            <a href="{{ route('products.show', $product->slug) }}" class="text-xs text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 truncate mr-2">
                                                {{ Str::limit($product->name, 25) }}
                                            </a>
                                            <span class="text-xs font-medium text-blue-600 dark:text-blue-400">
                                                LKR {{ number_format($product->price, 0) }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        @if($brands->count() === 0)
            <!-- No Brands Found -->
            <div class="rounded-lg bg-white p-12 text-center shadow-sm dark:bg-gray-800">
                <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">No brands available</h3>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Brands will appear here when they are added to the system.</p>
            </div>
        @endif
    </main>

    @include('partials.footer')
</body>
</html>