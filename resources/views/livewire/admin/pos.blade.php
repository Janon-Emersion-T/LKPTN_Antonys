<div class="min-h-screen bg-gray-100 dark:bg-gray-900">
    <!-- Session Start Modal -->
    @if($showSessionModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl max-w-md w-full mx-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Start POS Session</h3>
            <form wire:submit.prevent="startSession">
                <div class="mb-4">
                    <label for="startingCash" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Starting Cash Amount (LKR)
                    </label>
                    <input 
                        type="number" 
                        id="startingCash"
                        wire:model="startingCash"
                        step="0.01"
                        min="0"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                        placeholder="0.00"
                        required
                    >
                    @error('startingCash') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="flex justify-end">
                    <button 
                        type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md transition-colors"
                    >
                        Start Session
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Payment Modal -->
    @if($showPaymentModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl max-w-lg w-full mx-4 max-h-[90vh] overflow-y-auto">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Process Payment</h3>
            
            <!-- Order Total -->
            <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <div class="flex justify-between items-center">
                    <span class="text-lg font-medium text-gray-700 dark:text-gray-300">Total Amount:</span>
                    <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">LKR {{ number_format($this->cartTotal, 2) }}</span>
                </div>
                <div class="flex justify-between items-center mt-2">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Remaining:</span>
                    <span class="text-lg font-semibold {{ $remainingAmount > 0 ? 'text-red-600' : 'text-green-600' }}">
                        LKR {{ number_format($remainingAmount, 2) }}
                    </span>
                </div>
            </div>

            <!-- Add Payment Form -->
            <div class="mb-6 p-4 border border-gray-200 dark:border-gray-600 rounded-lg">
                <h4 class="text-md font-medium text-gray-900 dark:text-white mb-3">Add Payment</h4>
                <div x-data="{ paymentMethod: 'cash', paymentAmount: {{ $remainingAmount }} }">
                    <div class="grid grid-cols-2 gap-4 mb-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Payment Method</label>
                            <select x-model="paymentMethod" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="cash">Cash</option>
                                <option value="card">Card</option>
                                <option value="mobile">Mobile Payment</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Amount (LKR)</label>
                            <input 
                                type="number" 
                                x-model="paymentAmount"
                                step="0.01"
                                min="0"
                                max="{{ $remainingAmount }}"
                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                            >
                        </div>
                    </div>
                    <button 
                        type="button"
                        @click="$wire.addPayment(paymentMethod, parseFloat(paymentAmount))"
                        :disabled="paymentAmount <= 0 || paymentAmount > {{ $remainingAmount }}"
                        class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 text-white py-2 rounded-md transition-colors text-sm"
                    >
                        Add Payment
                    </button>
                </div>
            </div>

            <!-- Current Payments List -->
            @if(count($payments) > 0)
            <div class="mb-6">
                <h4 class="text-md font-medium text-gray-900 dark:text-white mb-3">Current Payments</h4>
                <div class="space-y-2">
                    @foreach($payments as $index => $payment)
                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <span class="px-2 py-1 text-xs bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full">
                                {{ ucfirst($payment['method']) }}
                            </span>
                            <span class="font-medium text-gray-900 dark:text-white">
                                LKR {{ number_format($payment['amount'], 2) }}
                            </span>
                        </div>
                        <button 
                            wire:click="removePayment({{ $index }})"
                            class="text-red-500 hover:text-red-700 text-sm"
                        >
                            Remove
                        </button>
                    </div>
                    @endforeach
                </div>
                <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-600">
                    <div class="flex justify-between font-semibold">
                        <span class="text-gray-700 dark:text-gray-300">Total Payments:</span>
                        <span class="text-gray-900 dark:text-white">LKR {{ number_format($this->totalPayments, 2) }}</span>
                    </div>
                </div>
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-2">
                <button 
                    type="button"
                    wire:click="$set('showPaymentModal', false)"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md transition-colors"
                >
                    Cancel
                </button>
                <button 
                    wire:click="processPayment"
                    :disabled="remainingAmount > 0"
                    class="bg-green-600 hover:bg-green-700 disabled:bg-gray-400 text-white px-6 py-2 rounded-md transition-colors"
                >
                    Complete Transaction
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Main POS Interface -->
    @if($session)
    <div class="flex h-screen">
        <!-- Products Panel -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <div class="bg-white dark:bg-gray-800 shadow-sm p-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">POS System</h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Terminal: {{ $terminal->name }} | Cashier: {{ auth()->user()->name }}
                        </p>
                    </div>
                    <div class="text-right">
                        <div class="text-sm text-gray-600 dark:text-gray-400">Session Started</div>
                        <div class="text-lg font-semibold text-gray-900 dark:text-white">
                            {{ $session->opened_at->format('H:i A') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search and Categories -->
            <div class="bg-white dark:bg-gray-800 p-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex flex-col sm:flex-row gap-4">
                    <!-- Search -->
                    <div class="flex-1">
                        <input 
                            type="text" 
                            wire:model.live.debounce.300ms="search"
                            placeholder="Search products..."
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                        >
                    </div>
                    
                    <!-- Categories -->
                    <div class="flex flex-wrap gap-2">
                        <button 
                            wire:click="selectCategory(null)"
                            class="px-3 py-2 text-sm rounded-md transition-colors {{ $selectedCategory === null ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600' }}"
                        >
                            All
                        </button>
                        @foreach($this->categories as $category)
                        <button 
                            wire:click="selectCategory({{ $category->id }})"
                            class="px-3 py-2 text-sm rounded-md transition-colors {{ $selectedCategory === $category->id ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600' }}"
                        >
                            {{ $category->name }}
                        </button>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="flex-1 overflow-auto p-4">
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
                    @foreach($this->products as $product)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-3 hover:shadow-md transition-shadow cursor-pointer"
                         wire:click="addToCart({{ $product->id }})">
                        <div class="aspect-square mb-2 bg-gray-100 dark:bg-gray-700 rounded-md flex items-center justify-center">
                            @if($product->featured_image)
                                <img src="{{ $product->getImageUrl() }}" alt="{{ $product->name }}" class="w-full h-full object-cover rounded-md">
                            @else
                                <div class="text-gray-400 text-2xl">📦</div>
                            @endif
                        </div>
                        <div class="text-sm font-medium text-gray-900 dark:text-white mb-1 line-clamp-2">
                            {{ $product->name }}
                        </div>
                        <div class="text-lg font-bold text-blue-600 dark:text-blue-400">
                            LKR {{ number_format($product->price, 2) }}
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            Stock: {{ $product->inventory_quantity }}
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $this->products->links() }}
                </div>
            </div>
        </div>

        <!-- Cart Panel -->
        <div class="w-80 bg-white dark:bg-gray-800 shadow-lg flex flex-col border-l border-gray-200 dark:border-gray-700">
            <!-- Cart Header -->
            <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Cart</h2>
                    <div class="text-sm text-gray-600 dark:text-gray-400">
                        {{ $this->cartItemCount }} item(s)
                    </div>
                </div>
            </div>

            <!-- Customer Info -->
            <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                <div class="space-y-2">
                    <input 
                        type="text" 
                        wire:model="customerName"
                        placeholder="Customer Name (Optional)"
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                    >
                    <input 
                        type="email" 
                        wire:model="customerEmail"
                        placeholder="Customer Email (Optional)"
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                    >
                    <input 
                        type="tel" 
                        wire:model="customerPhone"
                        placeholder="Customer Phone (Optional)"
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                    >
                </div>
            </div>

            <!-- Cart Items -->
            <div class="flex-1 overflow-auto">
                @forelse($cart as $item)
                <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $item['name'] }}</div>
                            <div class="text-sm text-blue-600 dark:text-blue-400">LKR {{ number_format($item['price'], 2) }}</div>
                        </div>
                        <button 
                            wire:click="removeFromCart({{ $item['product_id'] }})"
                            class="text-red-500 hover:text-red-700 ml-2"
                        >
                            ✕
                        </button>
                    </div>
                    <div class="flex items-center justify-between mt-2">
                        <div class="flex items-center space-x-2">
                            <button 
                                wire:click="updateQuantity({{ $item['product_id'] }}, {{ $item['quantity'] - 1 }})"
                                class="w-6 h-6 text-xs bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-300 dark:hover:bg-gray-500"
                                {{ $item['quantity'] <= 1 ? 'disabled' : '' }}
                            >
                                -
                            </button>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $item['quantity'] }}</span>
                            <button 
                                wire:click="updateQuantity({{ $item['product_id'] }}, {{ $item['quantity'] + 1 }})"
                                class="w-6 h-6 text-xs bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-300 dark:hover:bg-gray-500"
                            >
                                +
                            </button>
                        </div>
                        <div class="text-sm font-semibold text-gray-900 dark:text-white">
                            LKR {{ number_format($item['total'], 2) }}
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-8 text-center text-gray-500 dark:text-gray-400">
                    <div class="text-4xl mb-2">🛒</div>
                    <div>Cart is empty</div>
                    <div class="text-sm">Add products to get started</div>
                </div>
                @endforelse
            </div>

            <!-- Cart Total and Actions -->
            <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-lg font-semibold text-gray-900 dark:text-white">Total:</div>
                    <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                        LKR {{ number_format($this->cartTotal, 2) }}
                    </div>
                </div>
                
                <div class="space-y-2">
                    <button 
                        wire:click="openPaymentModal"
                        class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-md font-semibold transition-colors"
                        {{ empty($cart) ? 'disabled' : '' }}
                    >
                        Process Payment
                    </button>
                    <button 
                        wire:click="clearCart"
                        class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded-md transition-colors"
                        {{ empty($cart) ? 'disabled' : '' }}
                    >
                        Clear Cart
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Flash Messages -->
    <div class="fixed bottom-4 right-4 z-40">
        @if (session()->has('message'))
            <div class="bg-green-500 text-white px-6 py-3 rounded-md shadow-lg">
                {{ session('message') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="bg-red-500 text-white px-6 py-3 rounded-md shadow-lg">
                {{ session('error') }}
            </div>
        @endif
    </div>
</div>
