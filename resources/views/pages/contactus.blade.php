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
        {{-- Contact Page Component --}}
<div class="bg-gray-50 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

        {{-- Page Header --}}
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Contact Us</h1>
            <p class="text-lg text-blue-600 font-semibold">HOTLINE: {{env('GLOBALS.CONTACT.PHONE_NUMBER')}}</p>
        </div>

        {{-- Main Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            
            {{-- Left Column --}}
            <div class="space-y-8">
                {{-- Contact Info --}}
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Contact Details</h2>
                    <ul class="space-y-3 text-gray-700 text-sm">
                        <li><strong>Phone:</strong> <a href="tel:+{{env('GLOBALS.CONTACT.PHONE_NUMBER')}}" class="text-blue-600 hover:underline">+{{env('GLOBALS.CONTACT.PHONE_NUMBER')}}</a></li>
                        <li><strong>WhatsApp:</strong> <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', env('GLOBALS.CONTACT.WHATAPP_PHONE_NUMBER')) }}" target="_blank" class="text-blue-600 hover:underline">{{env('GLOBALS.CONTACT.WHATAPP_PHONE_NUMBER')}}</a></li>
                        <li><strong>Email:</strong> <a href="mailto:{{ env('GLOBALS.CONTACT.EMAIL')}}" class="text-blue-600 hover:underline">{{ env('GLOBALS.CONTACT.EMAIL')}}</a></li>
                        <li><strong>Address:</strong> 149/1 Jaffna-Kankesanturai Rd, Jaffna</li>
                    </ul>
                </div>

                {{-- Business Hours --}}
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Business Hours</h2>
                    <ul class="text-sm text-gray-700 space-y-2">
                        <li class="flex justify-between">
                            <span>Monday - Saturday:</span>
                            <span class="font-medium">{{env('GLOBALS.COMPANY_OPENING_HOURS')}}</span>
                        </li>
                    </ul>
                </div>

                {{-- Feedback --}}
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Feedback</h2>
                    <p class="text-sm text-gray-600">
                        Have questions about our services? Email us at 
                        <a href="mailto:{{ env('GLOBALS.CONTACT.EMAIL')}}" class="text-blue-600 hover:underline">{{ env('GLOBALS.CONTACT.EMAIL')}}</a>
                    </p>
                </div>
            </div>

            {{-- Right Column - Map --}}
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <iframe
                    src="{{ env('GLOBALS.MAP_IFRAME')}}"
                    width="100%"
                    height="600"
                    style="border:0;"
                    allowfullscreen
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>

        </div>

        {{-- Contact Form --}}
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6">
                <h2 class="text-3xl font-bold text-white mb-2">Send Us a Message</h2>
                <p class="text-blue-100">We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
            </div>
            
            <div class="p-8">
                {{-- Success Message --}}
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Error Messages --}}
                @if($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Please fix the following errors:</h3>
                                <ul class="mt-2 text-sm text-red-700">
                                    @foreach($errors->all() as $error)
                                        <li>• {{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Contact Form --}}
                <form method="POST" action="{{ route('contact.store') }}" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-semibold text-gray-700">Full Name <span class="text-red-500">*</span></label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                value="{{ old('name') }}"
                                required 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-3 focus:ring-blue-100 focus:border-blue-500 transition duration-200 @error('name') border-red-300 bg-red-50 @enderror"
                                placeholder="Enter your full name"
                            >
                            @error('name')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-semibold text-gray-700">Email Address <span class="text-red-500">*</span></label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                value="{{ old('email') }}"
                                required 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-3 focus:ring-blue-100 focus:border-blue-500 transition duration-200 @error('email') border-red-300 bg-red-50 @enderror"
                                placeholder="your@email.com"
                            >
                            @error('email')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="space-y-2">
                            <label for="phone" class="block text-sm font-semibold text-gray-700">Phone Number</label>
                            <input 
                                type="tel" 
                                id="phone" 
                                name="phone" 
                                value="{{ old('phone') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-3 focus:ring-blue-100 focus:border-blue-500 transition duration-200 @error('phone') border-red-300 bg-red-50 @enderror"
                                placeholder="+94 XX XXX XXXX"
                            >
                            @error('phone')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="space-y-2">
                            <label for="subject" class="block text-sm font-semibold text-gray-700">Subject <span class="text-red-500">*</span></label>
                            <input 
                                type="text" 
                                id="subject" 
                                name="subject" 
                                value="{{ old('subject') }}"
                                required 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-3 focus:ring-blue-100 focus:border-blue-500 transition duration-200 @error('subject') border-red-300 bg-red-50 @enderror"
                                placeholder="What is this regarding?"
                            >
                            @error('subject')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="space-y-2">
                        <label for="message" class="block text-sm font-semibold text-gray-700">Message <span class="text-red-500">*</span></label>
                        <textarea 
                            id="message" 
                            name="message" 
                            rows="5" 
                            required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-3 focus:ring-blue-100 focus:border-blue-500 transition duration-200 resize-none @error('message') border-red-300 bg-red-50 @enderror"
                            placeholder="Please provide details about your inquiry..."
                        >{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="flex items-center justify-between pt-4">
                        <p class="text-sm text-gray-600">
                            <span class="text-red-500">*</span> Required fields
                        </p>
                        <button 
                            type="submit" 
                            class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-8 rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200 focus:outline-none focus:ring-3 focus:ring-blue-100"
                        >
                            <span class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                Send Message
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.input-field {
    @apply w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent;
}
</style>

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