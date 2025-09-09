<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
    <title>Checkout - {{ config('app.name') }}</title>
</head>
<body class="min-h-screen bg-gray-50 dark:bg-gray-900">
    @include('partials.header')
    
    <main class="container mx-auto px-4 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Checkout</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Complete your order</p>
        </div>

        <div class="grid gap-8 lg:grid-cols-3">
            <!-- Checkout Form -->
            <div class="lg:col-span-2">
                <form id="checkout-form" class="space-y-6">
                    @csrf
                    
                    <!-- Customer Information -->
                    <div class="rounded-lg bg-white p-6 shadow-sm dark:bg-gray-800">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Customer Information</h2>
                        
                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label for="customer_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Full Name *</label>
                                <input 
                                    type="text" 
                                    id="customer_name" 
                                    name="customer_name" 
                                    value="{{ auth()->check() ? auth()->user()->name : '' }}"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                >
                            </div>
                            
                            <div>
                                <label for="customer_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone Number *</label>
                                <input 
                                    type="tel" 
                                    id="customer_phone" 
                                    name="customer_phone" 
                                    value="{{ auth()->check() ? auth()->user()->phone : '' }}"
                                    placeholder="+94771234567"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                >
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <label for="customer_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email Address</label>
                            <input 
                                type="email" 
                                id="customer_email" 
                                name="customer_email" 
                                value="{{ auth()->check() ? auth()->user()->email : '' }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                            >
                        </div>
                    </div>

                    <!-- Shipping Address -->
                    <div class="rounded-lg bg-white p-6 shadow-sm dark:bg-gray-800">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Shipping Address</h2>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="shipping_address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Full Address *</label>
                                <textarea 
                                    id="shipping_address" 
                                    name="shipping_address" 
                                    rows="3" 
                                    placeholder="Enter your complete address including street, city, postal code"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                >{{ auth()->check() && auth()->user()->address_line_1 ? auth()->user()->address_line_1 . (auth()->user()->address_line_2 ? ', ' . auth()->user()->address_line_2 : '') . (auth()->user()->city ? ', ' . auth()->user()->city : '') . (auth()->user()->postal_code ? ', ' . auth()->user()->postal_code : '') : '' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Special Instructions -->
                    <div class="rounded-lg bg-white p-6 shadow-sm dark:bg-gray-800">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Special Instructions</h2>
                        
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Order Notes (Optional)</label>
                            <textarea 
                                id="notes" 
                                name="notes" 
                                rows="3" 
                                placeholder="Any special instructions for delivery..."
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                            ></textarea>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="rounded-lg bg-white p-6 shadow-sm dark:bg-gray-800">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Payment Method</h2>
                        
                        <div class="space-y-4">
                            <div class="rounded-lg border border-green-200 bg-green-50 p-4 dark:border-green-800 dark:bg-green-900/20">
                                <div class="flex items-center">
                                    <input 
                                        id="whatsapp" 
                                        name="payment_method" 
                                        type="radio" 
                                        value="whatsapp" 
                                        checked
                                        class="h-4 w-4 text-green-600 focus:ring-green-500"
                                    >
                                    <label for="whatsapp" class="ml-3 block text-sm font-medium text-green-800 dark:text-green-200">
                                        WhatsApp Order (Recommended)
                                    </label>
                                </div>
                                <p class="mt-2 text-sm text-green-600 dark:text-green-300">
                                    Your order details will be sent via WhatsApp for confirmation and payment instructions.
                                </p>
                            </div>
                            
                            <div class="rounded-lg border border-gray-200 bg-gray-50 p-4 opacity-50 dark:border-gray-700 dark:bg-gray-800">
                                <div class="flex items-center">
                                    <input 
                                        id="online" 
                                        name="payment_method" 
                                        type="radio" 
                                        value="online" 
                                        disabled
                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500"
                                    >
                                    <label for="online" class="ml-3 block text-sm font-medium text-gray-500">
                                        Online Payment (Coming Soon)
                                    </label>
                                </div>
                                <p class="mt-2 text-sm text-gray-500">
                                    Credit/Debit card and bank transfer options will be available soon.
                                </p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="sticky top-8 rounded-lg bg-white p-6 shadow-sm dark:bg-gray-800">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white">Order Summary</h2>
                    
                    <!-- Cart Items -->
                    <div class="mt-6 space-y-4 max-h-64 overflow-y-auto">
                        @foreach($cart->items as $item)
                            <div class="flex gap-3">
                                <div class="flex-shrink-0">
                                    @if($item->product && $item->product->images->first())
                                        <img 
                                            src="{{ asset('storage/' . $item->product->images->first()->image_path) }}" 
                                            alt="{{ $item->product->name }}"
                                            class="h-12 w-12 rounded object-cover"
                                        >
                                    @else
                                        <div class="flex h-12 w-12 items-center justify-center rounded bg-gray-100 dark:bg-gray-700">
                                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                        {{ $item->product_name }}
                                    </p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        Qty: {{ $item->quantity }} × LKR {{ number_format($item->unit_price, 2) }}
                                    </p>
                                </div>
                                <div class="flex-shrink-0">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                                        LKR {{ number_format($item->quantity * $item->unit_price, 2) }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Order Totals -->
                    <div class="mt-6 border-t border-gray-200 pt-6 space-y-3 dark:border-gray-700">
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Subtotal</span>
                            <span class="text-gray-900 dark:text-white">LKR {{ number_format($cart->subtotal, 2) }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Shipping</span>
                            <span class="text-gray-900 dark:text-white">
                                @if($cart->shipping_amount > 0)
                                    LKR {{ number_format($cart->shipping_amount, 2) }}
                                @else
                                    <span class="text-green-600">Free</span>
                                @endif
                            </span>
                        </div>
                        
                        <div class="border-t border-gray-200 pt-3 dark:border-gray-700">
                            <div class="flex justify-between text-lg font-medium">
                                <span class="text-gray-900 dark:text-white">Total</span>
                                <span class="text-gray-900 dark:text-white">LKR {{ number_format($cart->total_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Place Order Button -->
                    <div class="mt-6">
                        <button 
                            onclick="placeOrder()" 
                            id="place-order-btn"
                            class="w-full rounded-md bg-green-600 px-6 py-3 text-white font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500"
                        >
                            <span class="flex items-center justify-center">
                                <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                                Complete Order via WhatsApp
                            </span>
                        </button>
                    </div>

                    <div class="mt-4 text-center">
                        <p class="text-xs text-gray-500">
                            By placing your order, you agree to our Terms of Service
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('partials.footer')

    <script>
        async function placeOrder() {
            const form = document.getElementById('checkout-form');
            const btn = document.getElementById('place-order-btn');
            
            // Basic form validation
            const requiredFields = ['customer_name', 'customer_phone', 'shipping_address'];
            let isValid = true;
            
            requiredFields.forEach(field => {
                const input = document.getElementById(field);
                if (!input.value.trim()) {
                    input.classList.add('border-red-500');
                    isValid = false;
                } else {
                    input.classList.remove('border-red-500');
                }
            });
            
            if (!isValid) {
                showNotification('Please fill in all required fields', 'error');
                return;
            }
            
            // Disable button and show loading state
            btn.disabled = true;
            btn.innerHTML = '<span class="flex items-center justify-center"><svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Processing...</span>';
            
            try {
                const formData = new FormData(form);
                const data = Object.fromEntries(formData);
                
                const response = await fetch('{{ route('checkout.whatsapp') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();
                
                if (result.success) {
                    showNotification('Order prepared! Redirecting to WhatsApp...', 'success');
                    
                    // Open WhatsApp in a new window/tab
                    window.open(result.whatsapp_url, '_blank');
                    
                    // Redirect to home page after a short delay
                    setTimeout(() => {
                        window.location.href = '{{ route('home') }}';
                    }, 2000);
                } else {
                    showNotification(result.message || 'Failed to place order', 'error');
                    btn.disabled = false;
                    btn.innerHTML = '<span class="flex items-center justify-center"><svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>Complete Order via WhatsApp</span>';
                }
            } catch (error) {
                showNotification('An error occurred. Please try again.', 'error');
                btn.disabled = false;
                btn.innerHTML = '<span class="flex items-center justify-center"><svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>Complete Order via WhatsApp</span>';
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
    </script>
</body>
</html>