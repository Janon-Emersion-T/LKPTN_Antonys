<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TechHub - Premium Computer Store</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <!-- Header Navigation -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <!-- Top Bar -->
            <div class="border-b border-gray-200 py-2">
                <div class="flex justify-between items-center text-sm">
                    <div class="flex items-center gap-6 text-gray-600">
                        <span>📞 +94 11 234 5678</span>
                        <span>📧 info@techhub.lk</span>
                    </div>
                    <div class="flex items-center gap-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800">My Account</a>
                            <a href="#" class="text-gray-600 hover:text-gray-800">Wishlist (0)</a>
                        @else
                            <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800">Login</a>
                            <a href="{{ route('register') }}" class="text-gray-600 hover:text-gray-800">Register</a>
                        @endauth
                        <div class="relative">
                            <a href="#" class="flex items-center gap-1 text-gray-600 hover:text-gray-800">
                                🛒 Cart (<span class="font-semibold">0</span>)
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Main Navigation -->
            <div class="py-4">
                <div class="flex items-center justify-between">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <h1 class="text-2xl font-bold text-blue-600">TechHub</h1>
                        <span class="text-sm text-gray-500 ml-2">Premium Computer Store</span>
                    </div>
                    
                    <!-- Search Bar -->
                    <div class="flex-1 max-w-xl mx-8">
                        <div class="relative">
                            <input type="text" 
                                   placeholder="Search for laptops, desktops, accessories..."
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <button class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                🔍
                            </button>
                        </div>
                    </div>
                    
                    <!-- Contact Info -->
                    <div class="hidden lg:block text-right">
                        <div class="text-sm text-gray-600">Need Help?</div>
                        <div class="font-semibold text-blue-600">+94 11 234 5678</div>
                    </div>
                </div>
                
                <!-- Navigation Menu -->
                <nav class="mt-4 border-t border-gray-200 pt-4">
                    <div class="flex items-center gap-8">
                        <a href="/" class="text-blue-600 font-semibold">Home</a>
                        <div class="relative group">
                            <a href="#" class="flex items-center gap-1 text-gray-700 hover:text-blue-600 font-medium">
                                Categories <span class="text-xs">▼</span>
                            </a>
                            <!-- Categories Dropdown -->
                            <div class="absolute top-full left-0 w-64 bg-white shadow-lg rounded-md opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-40">
                                <div class="p-4">
                                    <a href="#" class="block py-2 text-gray-700 hover:text-blue-600">💻 Laptops</a>
                                    <a href="#" class="block py-2 text-gray-700 hover:text-blue-600">🖥️ Desktops</a>
                                    <a href="#" class="block py-2 text-gray-700 hover:text-blue-600">🎮 Gaming</a>
                                    <a href="#" class="block py-2 text-gray-700 hover:text-blue-600">⌨️ Accessories</a>
                                    <a href="#" class="block py-2 text-gray-700 hover:text-blue-600">🔧 Components</a>
                                </div>
                            </div>
                        </div>
                        <div class="relative group">
                            <a href="#" class="flex items-center gap-1 text-gray-700 hover:text-blue-600 font-medium">
                                Brands <span class="text-xs">▼</span>
                            </a>
                            <!-- Brands Dropdown -->
                            <div class="absolute top-full left-0 w-64 bg-white shadow-lg rounded-md opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-40">
                                <div class="p-4 grid grid-cols-2 gap-2">
                                    <a href="#" class="block py-2 text-gray-700 hover:text-blue-600">Dell</a>
                                    <a href="#" class="block py-2 text-gray-700 hover:text-blue-600">HP</a>
                                    <a href="#" class="block py-2 text-gray-700 hover:text-blue-600">Lenovo</a>
                                    <a href="#" class="block py-2 text-gray-700 hover:text-blue-600">ASUS</a>
                                    <a href="#" class="block py-2 text-gray-700 hover:text-blue-600">Acer</a>
                                    <a href="#" class="block py-2 text-gray-700 hover:text-blue-600">Apple</a>
                                </div>
                            </div>
                        </div>
                        <a href="#" class="text-gray-700 hover:text-blue-600 font-medium">Special Offers</a>
                        <a href="#" class="text-gray-700 hover:text-blue-600 font-medium">Support</a>
                        <a href="#" class="text-gray-700 hover:text-blue-600 font-medium">Contact</a>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <!-- Hero Section with Slider -->
    <section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white">
        <div class="container mx-auto px-4 py-16">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-4xl lg:text-5xl font-bold mb-6">Latest Technology at Your Fingertips</h1>
                    <p class="text-xl mb-8 text-blue-100">Discover premium laptops, desktops, and accessories from leading brands. Competitive prices, genuine products, and expert support.</p>
                    <div class="flex gap-4">
                        <button class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                            Shop Now
                        </button>
                        <button class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition-colors">
                            View Offers
                        </button>
                    </div>
                </div>
                <div class="text-center">
                    <img src="https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=600&h=400&fit=crop" 
                         alt="Latest Laptop" 
                         class="rounded-lg shadow-2xl max-w-full">
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Shop by Category</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Find exactly what you're looking for from our comprehensive range of computer products and accessories.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Category Cards -->
                <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 group cursor-pointer">
                    <div class="p-6 text-center">
                        <div class="text-4xl mb-4 group-hover:scale-110 transition-transform duration-300">💻</div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Laptops</h3>
                        <p class="text-gray-600 text-sm mb-4">Gaming, Business, Ultrabooks</p>
                        <div class="text-blue-600 font-medium">From LKR 45,000</div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 group cursor-pointer">
                    <div class="p-6 text-center">
                        <div class="text-4xl mb-4 group-hover:scale-110 transition-transform duration-300">🖥️</div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Desktops</h3>
                        <p class="text-gray-600 text-sm mb-4">Complete PC Sets</p>
                        <div class="text-blue-600 font-medium">From LKR 35,000</div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 group cursor-pointer">
                    <div class="p-6 text-center">
                        <div class="text-4xl mb-4 group-hover:scale-110 transition-transform duration-300">🎮</div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Gaming</h3>
                        <p class="text-gray-600 text-sm mb-4">High Performance Systems</p>
                        <div class="text-blue-600 font-medium">From LKR 85,000</div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 group cursor-pointer">
                    <div class="p-6 text-center">
                        <div class="text-4xl mb-4 group-hover:scale-110 transition-transform duration-300">⌨️</div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Accessories</h3>
                        <p class="text-gray-600 text-sm mb-4">Keyboards, Mice, Headsets</p>
                        <div class="text-blue-600 font-medium">From LKR 1,500</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Latest Laptops</h2>
                    <p class="text-gray-600">Discover our newest arrivals and bestsellers</p>
                </div>
                <a href="#" class="text-blue-600 hover:text-blue-800 font-medium flex items-center gap-2">
                    View All <span>→</span>
                </a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Product Cards -->
                <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 group">
                    <div class="relative overflow-hidden rounded-t-lg">
                        <img src="https://images.unsplash.com/photo-1525547719571-a2d4ac8945e2?w=300&h=200&fit=crop" 
                             alt="Laptop" 
                             class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                        <div class="absolute top-2 left-2">
                            <span class="bg-red-500 text-white text-xs px-2 py-1 rounded">New</span>
                        </div>
                        <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <button class="bg-white p-2 rounded-full shadow-md hover:bg-gray-50">❤️</button>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-800 mb-2">Dell Inspiron 15 3000</h3>
                        <p class="text-sm text-gray-600 mb-3">Intel Core i5, 8GB RAM, 256GB SSD</p>
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-lg font-bold text-blue-600">LKR 125,000</span>
                                <span class="text-sm text-gray-400 line-through ml-2">LKR 140,000</span>
                            </div>
                            <div class="text-sm text-green-600">✅ In Stock</div>
                        </div>
                        <button class="w-full mt-4 bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition-colors">
                            Add to Cart
                        </button>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 group">
                    <div class="relative overflow-hidden rounded-t-lg">
                        <img src="https://images.unsplash.com/photo-1541807084-5c52b6b3adef?w=300&h=200&fit=crop" 
                             alt="Gaming Laptop" 
                             class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                        <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <button class="bg-white p-2 rounded-full shadow-md hover:bg-gray-50">❤️</button>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-800 mb-2">ASUS ROG Strix G15</h3>
                        <p class="text-sm text-gray-600 mb-3">AMD Ryzen 7, 16GB RAM, RTX 3060</p>
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-lg font-bold text-blue-600">LKR 285,000</span>
                            </div>
                            <div class="text-sm text-green-600">✅ In Stock</div>
                        </div>
                        <button class="w-full mt-4 bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition-colors">
                            Add to Cart
                        </button>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 group">
                    <div class="relative overflow-hidden rounded-t-lg">
                        <img src="https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=300&h=200&fit=crop" 
                             alt="MacBook" 
                             class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                        <div class="absolute top-2 left-2">
                            <span class="bg-blue-500 text-white text-xs px-2 py-1 rounded">Popular</span>
                        </div>
                        <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <button class="bg-white p-2 rounded-full shadow-md hover:bg-gray-50">❤️</button>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-800 mb-2">MacBook Air M2</h3>
                        <p class="text-sm text-gray-600 mb-3">Apple M2 Chip, 8GB RAM, 256GB SSD</p>
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-lg font-bold text-blue-600">LKR 385,000</span>
                            </div>
                            <div class="text-sm text-green-600">✅ In Stock</div>
                        </div>
                        <button class="w-full mt-4 bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition-colors">
                            Add to Cart
                        </button>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 group">
                    <div class="relative overflow-hidden rounded-t-lg">
                        <img src="https://images.unsplash.com/photo-1593642702821-c8da6771f0c6?w=300&h=200&fit=crop" 
                             alt="Business Laptop" 
                             class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                        <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <button class="bg-white p-2 rounded-full shadow-md hover:bg-gray-50">❤️</button>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-800 mb-2">Lenovo ThinkPad E14</h3>
                        <p class="text-sm text-gray-600 mb-3">Intel Core i7, 16GB RAM, 512GB SSD</p>
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-lg font-bold text-blue-600">LKR 195,000</span>
                                <span class="text-sm text-gray-400 line-through ml-2">LKR 210,000</span>
                            </div>
                            <div class="text-sm text-green-600">✅ In Stock</div>
                        </div>
                        <button class="w-full mt-4 bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition-colors">
                            Add to Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Gaming Section -->
    <section class="py-16 bg-gray-900 text-white">
        <div class="container mx-auto px-4">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl lg:text-4xl font-bold mb-6">ROG Gaming Series</h2>
                    <p class="text-gray-300 text-lg mb-8">Experience ultimate gaming performance with ASUS Republic of Gamers series. Built for enthusiasts who demand the best.</p>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center gap-3">
                            <span class="text-red-500">✓</span>
                            <span>Latest NVIDIA RTX Graphics</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="text-red-500">✓</span>
                            <span>High-refresh displays up to 240Hz</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="text-red-500">✓</span>
                            <span>Advanced cooling technology</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="text-red-500">✓</span>
                            <span>RGB lighting customization</span>
                        </li>
                    </ul>
                    <button class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors">
                        Explore Gaming PCs
                    </button>
                </div>
                <div class="text-center">
                    <img src="https://images.unsplash.com/photo-1593640408182-31c70c8268f5?w=600&h=400&fit=crop" 
                         alt="Gaming Setup" 
                         class="rounded-lg shadow-2xl">
                </div>
            </div>
        </div>
    </section>

    <!-- News & Updates -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Latest News & Updates</h2>
                <p class="text-gray-600">Stay informed about the latest technology trends and product launches</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-6">
                <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <img src="https://images.unsplash.com/photo-1518717758536-85ae29035b6d?w=400&h=200&fit=crop" 
                         alt="Tech News" 
                         class="w-full h-48 object-cover">
                    <div class="p-6">
                        <span class="text-sm text-blue-600 font-medium">Technology</span>
                        <h3 class="text-lg font-semibold text-gray-800 mt-2 mb-3">Apple Announces New MacBook Pro with M3 Chip</h3>
                        <p class="text-gray-600 text-sm mb-4">Revolutionary performance improvements and enhanced battery life in the latest MacBook Pro series...</p>
                        <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Read More →</a>
                    </div>
                </article>
                
                <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <img src="https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=400&h=200&fit=crop" 
                         alt="Gaming News" 
                         class="w-full h-48 object-cover">
                    <div class="p-6">
                        <span class="text-sm text-blue-600 font-medium">Gaming</span>
                        <h3 class="text-lg font-semibold text-gray-800 mt-2 mb-3">NVIDIA RTX 4080 Super Now Available</h3>
                        <p class="text-gray-600 text-sm mb-4">Enhanced gaming performance with improved ray tracing capabilities and better price point...</p>
                        <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Read More →</a>
                    </div>
                </article>
                
                <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <img src="https://images.unsplash.com/photo-1531297484001-80022131f5a1?w=400&h=200&fit=crop" 
                         alt="Business News" 
                         class="w-full h-48 object-cover">
                    <div class="p-6">
                        <span class="text-sm text-blue-600 font-medium">Business</span>
                        <h3 class="text-lg font-semibold text-gray-800 mt-2 mb-3">Remote Work Technology Trends 2024</h3>
                        <p class="text-gray-600 text-sm mb-4">Essential tech tools and setups that are shaping the future of remote work productivity...</p>
                        <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Read More →</a>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <!-- Brand Partners -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Our Brand Partners</h2>
                <p class="text-gray-600">Authorized dealers for leading technology brands</p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6 items-center">
                <div class="flex justify-center items-center h-20 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                    <span class="font-bold text-gray-600">Dell</span>
                </div>
                <div class="flex justify-center items-center h-20 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                    <span class="font-bold text-gray-600">HP</span>
                </div>
                <div class="flex justify-center items-center h-20 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                    <span class="font-bold text-gray-600">Lenovo</span>
                </div>
                <div class="flex justify-center items-center h-20 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                    <span class="font-bold text-gray-600">ASUS</span>
                </div>
                <div class="flex justify-center items-center h-20 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                    <span class="font-bold text-gray-600">Acer</span>
                </div>
                <div class="flex justify-center items-center h-20 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                    <span class="font-bold text-gray-600">Apple</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="container mx-auto px-4 py-12">
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div>
                    <h3 class="text-xl font-bold mb-6">TechHub</h3>
                    <p class="text-gray-300 mb-4">Your trusted partner for premium computer hardware and technology solutions in Sri Lanka.</p>
                    <div class="space-y-2">
                        <p class="text-sm">📍 No. 123, Galle Road, Colombo 03</p>
                        <p class="text-sm">📞 +94 11 234 5678</p>
                        <p class="text-sm">📧 info@techhub.lk</p>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h4 class="font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-gray-300">
                        <li><a href="#" class="hover:text-white">About Us</a></li>
                        <li><a href="#" class="hover:text-white">Contact</a></li>
                        <li><a href="#" class="hover:text-white">Warranty</a></li>
                        <li><a href="#" class="hover:text-white">Shipping Info</a></li>
                        <li><a href="#" class="hover:text-white">Return Policy</a></li>
                    </ul>
                </div>
                
                <!-- Categories -->
                <div>
                    <h4 class="font-semibold mb-4">Categories</h4>
                    <ul class="space-y-2 text-gray-300">
                        <li><a href="#" class="hover:text-white">Laptops</a></li>
                        <li><a href="#" class="hover:text-white">Desktops</a></li>
                        <li><a href="#" class="hover:text-white">Gaming PCs</a></li>
                        <li><a href="#" class="hover:text-white">Accessories</a></li>
                        <li><a href="#" class="hover:text-white">Components</a></li>
                    </ul>
                </div>
                
                <!-- Customer Support -->
                <div>
                    <h4 class="font-semibold mb-4">Customer Support</h4>
                    <ul class="space-y-2 text-gray-300">
                        <li><a href="#" class="hover:text-white">Help Center</a></li>
                        <li><a href="#" class="hover:text-white">Track Order</a></li>
                        <li><a href="#" class="hover:text-white">Technical Support</a></li>
                        <li><a href="#" class="hover:text-white">Bulk Orders</a></li>
                        <li><a href="#" class="hover:text-white">Business Solutions</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p class="text-gray-300">&copy; 2024 TechHub. All rights reserved. | Privacy Policy | Terms & Conditions</p>
            </div>
        </div>
    </footer>
</body>
</html>