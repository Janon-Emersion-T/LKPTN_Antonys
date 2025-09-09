<!-- Enhanced Navigation Styles -->
<style>
    /* Hide scrollbar for mobile navigation */
    .nav-scroll::-webkit-scrollbar {
        display: none;
    }
    .nav-scroll {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    
    /* Smooth scroll behavior */
    .nav-scroll {
        scroll-behavior: smooth;
    }
    
    /* Active nav item indicator */
    .nav-item.active {
        color: #2563eb;
        position: relative;
    }
    
    .nav-item.active::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 50%;
        transform: translateX(-50%);
        width: 20px;
        height: 2px;
        background: #2563eb;
        border-radius: 1px;
    }
    
    /* Mobile nav touch optimization */
    @media (max-width: 768px) {
        .nav-item {
            min-width: 80px;
            text-align: center;
        }
    }
</style>

<header class="sticky top-0 z-40 bg-white shadow-sm dark:bg-gray-800">
    <div class="w-full">
        <!-- Top Bar -->
        <div class="border-b border-gray-200 py-2 dark:border-gray-700 px-4 sm:px-6 lg:px-8 xl:px-40">
            <div class="flex items-center justify-between text-xs sm:text-sm">
                <div class="flex items-center space-x-2 sm:space-x-4">
                    <span class="text-gray-600 dark:text-gray-400 hidden sm:inline-flex items-center">
                        <svg class="inline h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        {{ env('GLOBALS.CONTACT.PHONE_NUMBER') }}
                    </span>
                    <span class="text-gray-600 dark:text-gray-400 hidden md:inline-flex items-center">
                        <svg class="inline h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        {{ env('GLOBALS.CONTACT.EMAIL') }}
                    </span>
                </div>
                <div class="flex items-center space-x-2 sm:space-x-4">
                    <span id="current-time" class="text-gray-900 font-medium"></span>
                </div>
                <div class="flex items-center space-x-2 sm:space-x-4">
                    @auth
                        @if(auth()->user()->isCustomer())
                            <a href="{{ route('customer.dashboard') }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400">
                                My Account
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400">
                                Admin Panel
                            </a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-gray-700 dark:text-gray-400">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400">
                            Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Main Header -->
        <div class="flex items-center justify-between py-2 px-4 sm:px-6 lg:px-8 xl:px-40">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <img src="{{asset('images/logo.png')}}" alt="{{ env('GLOBALS_COMPANY_NAME') }} Logo" class="h-12 sm:h-16 md:h-20 lg:h-24 w-auto">
                    <span class="text-lg sm:text-xl md:text-2xl font-bold text-blue-600 dark:text-blue-400 hidden sm:block">{{env('GLOBALS_COMPANY_NAME')}}</span>
                </a>
            </div>

            <!-- Search Bar -->
            <div class="hidden flex-1 max-w-lg mx-4 sm:mx-6 md:mx-8 md:block">
                <form method="GET" action="{{ route('shop.index') }}" class="relative">
                    <input 
                        type="text" 
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search products..."
                        class="w-full rounded-lg border border-gray-300 py-2 pl-4 pr-10 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    >
                    <!-- Hidden fields for shop filters -->
                    <input type="hidden" name="category" value="">
                    <input type="hidden" name="brand" value="">
                    <input type="hidden" name="price_min" value="">
                    <input type="hidden" name="price_max" value="">
                    <input type="hidden" name="sort" value="">
                    <button 
                        type="submit"
                        class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </form>
            </div>

            <!-- Header Actions -->
            <div class="flex items-center space-x-4">
                @auth
                    @if(auth()->user()->isCustomer())
                        <!-- Wishlist -->
                        <a href="{{ route('customer.wishlist') }}" class="relative p-2 text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            <span class="absolute -right-1 -top-1 rounded-full bg-red-500 px-1.5 py-0.5 text-xs text-white" data-wishlist-count>0</span>
                        </a>
                    @endif
                @endauth

                <!-- Cart -->
                <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.3 2.7M7 13l-1.3 2.7M7 13h10M17 21a2 2 0 100-4 2 2 0 000 4zM9 21a2 2 0 100-4 2 2 0 000 4z"></path>
                    </svg>
                    <span class="absolute -right-1 -top-1 rounded-full bg-blue-500 px-1.5 py-0.5 text-xs text-white" data-cart-count>0</span>
                </a>
            </div>
        </div>

        <!-- Main Navigation Menu -->
        <nav class="border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Desktop Navigation -->
                <div class="hidden md:block">
                    <div class="flex items-center justify-between py-4">
                        <!-- Breadcrumb -->
                        <ol class="flex items-center space-x-2">
                            <li>
                                <a href="{{ route('home') }}" class="flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 transition-colors duration-200">
                                    <svg class="flex-shrink-0 h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                                    </svg>
                                    Home
                                </a>
                            </li>
                            
                            @if(!request()->routeIs('home'))
                                <li class="flex items-center">
                                    <svg class="flex-shrink-0 h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    
                                    @if(request()->routeIs('shop.*'))
                                        <a href="{{ route('shop.index') }}" class="ml-2 text-sm font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">Shop</a>
                                    @elseif(request()->routeIs('categories.*'))
                                        <a href="{{ route('categories.index') }}" class="ml-2 text-sm font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">Categories</a>
                                    @elseif(request()->routeIs('brands.*'))
                                        <a href="{{ route('brands.index') }}" class="ml-2 text-sm font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">Brands</a>
                                    @elseif(request()->routeIs('cart.*'))
                                        <span class="ml-2 text-sm font-medium text-gray-900 dark:text-white">Cart</span>
                                    @elseif(request()->routeIs('customer.*'))
                                        <span class="ml-2 text-sm font-medium text-gray-900 dark:text-white">My Account</span>
                                    @endif
                                </li>
                            @endif
                        </ol>
                        
                        <!-- Main Navigation Links -->
                        <div class="flex items-center space-x-6">
                            <a href="{{ route('shop.index') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400 transition-colors duration-200 {{ request()->routeIs('shop.*') ? 'text-blue-600 dark:text-blue-400' : '' }}">
                                Shop
                            </a>
                            <a href="{{ route('categories.index') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400 transition-colors duration-200 {{ request()->routeIs('categories.*') ? 'text-blue-600 dark:text-blue-400' : '' }}">
                                Categories
                            </a>
                            <a href="{{ route('brands.index') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400 transition-colors duration-200 {{ request()->routeIs('brands.*') ? 'text-blue-600 dark:text-blue-400' : '' }}">
                                Brands
                            </a>
                            <a href="{{ route('shop.index') }}?sort=price_low_to_high" class="text-sm font-medium text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 transition-colors duration-200">
                                Special Offers
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Mobile Navigation -->
                <div class="md:hidden">
                    <!-- Mobile Header with Hamburger -->
                    <div class="flex items-center justify-between py-3">
                        <!-- Breadcrumb Path -->
                        <ol class="flex items-center space-x-1 text-sm">
                            <li>
                                <a href="{{ route('home') }}" class="flex items-center text-gray-500 hover:text-blue-600 dark:text-gray-400">
                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                                    </svg>
                                </a>
                            </li>
                            
                            @if(!request()->routeIs('home'))
                                <li class="flex items-center">
                                    <svg class="h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    
                                    @if(request()->routeIs('shop.*'))
                                        <span class="ml-1 text-gray-900 dark:text-white font-medium">Shop</span>
                                    @elseif(request()->routeIs('categories.*'))
                                        <span class="ml-1 text-gray-900 dark:text-white font-medium">Categories</span>
                                    @elseif(request()->routeIs('brands.*'))
                                        <span class="ml-1 text-gray-900 dark:text-white font-medium">Brands</span>
                                    @elseif(request()->routeIs('cart.*'))
                                        <span class="ml-1 text-gray-900 dark:text-white font-medium">Cart</span>
                                    @elseif(request()->routeIs('customer.*'))
                                        <span class="ml-1 text-gray-900 dark:text-white font-medium">My Account</span>
                                    @endif
                                </li>
                            @endif
                        </ol>
                        
                        <!-- Mobile Menu Toggle -->
                        <button 
                            onclick="toggleNavigation()"
                            class="p-2 text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400"
                            aria-label="Toggle navigation menu"
                        >
                            <svg id="menu-icon" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                            <svg id="close-icon" class="h-5 w-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Mobile Navigation Menu -->
                    <div id="mobile-nav" class="hidden border-t border-gray-200 dark:border-gray-600 py-3">
                        <div class="space-y-1">
                            <a href="{{ route('shop.index') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 dark:text-gray-300 dark:hover:text-blue-400 dark:hover:bg-blue-900/30 rounded-lg transition-colors duration-200 {{ request()->routeIs('shop.*') ? 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300' : '' }}">
                                <svg class="h-4 w-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                Shop
                            </a>
                            <a href="{{ route('categories.index') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 dark:text-gray-300 dark:hover:text-blue-400 dark:hover:bg-blue-900/30 rounded-lg transition-colors duration-200 {{ request()->routeIs('categories.*') ? 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300' : '' }}">
                                <svg class="h-4 w-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                Categories
                            </a>
                            <a href="{{ route('brands.index') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 dark:text-gray-300 dark:hover:text-blue-400 dark:hover:bg-blue-900/30 rounded-lg transition-colors duration-200 {{ request()->routeIs('brands.*') ? 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300' : '' }}">
                                <svg class="h-4 w-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                Brands
                            </a>
                            <a href="{{ route('shop.index') }}?sort=price_low_to_high" class="flex items-center px-3 py-2 text-sm font-medium text-red-600 hover:text-red-700 hover:bg-red-50 dark:text-red-400 dark:hover:text-red-300 dark:hover:bg-red-900/30 rounded-lg transition-colors duration-200">
                                <svg class="h-4 w-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                                Special Offers
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

    </div>
</header>
<script>
    function updateTime() {
        const now = new Date();
        // Format: HH:MM:SS AM/PM
        const timeString = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        document.getElementById('current-time').textContent = timeString;
    }

    // Update immediately
    updateTime();
    // Update every second
    setInterval(updateTime, 1000);
</script>

<script>
    function toggleNavigation() {
        const nav = document.getElementById('mobile-nav');
        const menuIcon = document.getElementById('menu-icon');
        const closeIcon = document.getElementById('close-icon');
        
        nav.classList.toggle('hidden');
        menuIcon.classList.toggle('hidden');
        closeIcon.classList.toggle('hidden');
    }

    // Update cart count on page load
    document.addEventListener('DOMContentLoaded', async function() {
        try {
            // Update cart count
            const cartResponse = await fetch('/cart-count', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            if (cartResponse.ok) {
                const cartData = await cartResponse.json();
                updateCartCount(cartData.count || 0);
            }
        } catch (error) {
            console.log('Could not fetch cart count');
        }

        @auth
            @if(auth()->user()->isCustomer())
                try {
                    // Update wishlist count
                    const wishlistResponse = await fetch('{{ route('customer.api.wishlist-count') }}', {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    
                    if (wishlistResponse.ok) {
                        const wishlistData = await wishlistResponse.json();
                        updateWishlistCount(wishlistData.count || 0);
                    }
                } catch (error) {
                    console.log('Could not fetch wishlist count');
                }
            @endif
        @endauth
    });

    function updateCartCount(count) {
        const cartCountElements = document.querySelectorAll('[data-cart-count]');
        cartCountElements.forEach(el => {
            el.textContent = count;
            el.style.display = count > 0 ? 'inline' : 'none';
        });
    }

    function updateWishlistCount(count) {
        const wishlistCountElements = document.querySelectorAll('[data-wishlist-count]');
        wishlistCountElements.forEach(el => {
            el.textContent = count;
            el.style.display = count > 0 ? 'inline' : 'none';
        });
    }
</script>