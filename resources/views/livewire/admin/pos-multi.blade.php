<div class="h-full flex flex-col bg-zinc-100 dark:bg-zinc-900">
    <!-- Transaction Tabs -->
    <div class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-4 py-2">
        <div class="flex items-center space-x-2 overflow-x-auto">
            @foreach($transactions as $transactionId => $transaction)
                <button 
                    wire:click="switchTransaction({{ $transactionId }})"
                    class="flex items-center space-x-2 px-4 py-2 rounded-lg text-sm font-medium whitespace-nowrap transition-colors {{ $activeTransactionId == $transactionId ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-zinc-100 text-zinc-700 dark:bg-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-600' }}"
                >
                    <span>Transaction {{ $transactionId }}</span>
                    @if(count($transaction['cart']) > 0)
                        <span class="bg-blue-500 text-white rounded-full px-2 py-0.5 text-xs">{{ collect($transaction['cart'])->sum('quantity') }}</span>
                    @endif
                    @if(count($transactions) > 1)
                        <button 
                            wire:click.stop="closeTransaction({{ $transactionId }})"
                            class="ml-2 text-zinc-500 hover:text-red-500 transition-colors"
                        >
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    @endif
                </button>
            @endforeach
            
            @if(count($transactions) < $maxTransactions)
                <button 
                    wire:click="addNewTransaction"
                    class="flex items-center space-x-2 px-4 py-2 rounded-lg text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 hover:bg-green-200 dark:hover:bg-green-800 transition-colors"
                >
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                    </svg>
                    <span>New Transaction</span>
                </button>
            @endif
        </div>
    </div>

    <!-- Main POS Interface -->
    <div class="flex-1 flex overflow-hidden">
        <!-- Products Panel -->
        <div class="flex-1 flex flex-col bg-white dark:bg-zinc-800 border-r border-zinc-200 dark:border-zinc-700">
            <!-- Search and Categories -->
            <div class="p-4 border-b border-zinc-200 dark:border-zinc-700">
                <div class="flex space-x-4 mb-4">
                    <div class="flex-1">
                        <input 
                            type="text"
                            wire:model.live.debounce.300ms="search"
                            placeholder="Search products..."
                            class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:text-white"
                        >
                    </div>
                    <div class="w-48">
                        <input 
                            type="text"
                            wire:model.live="barcodeInput"
                            wire:keydown.enter="scanBarcode"
                            placeholder="Scan barcode..."
                            class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 dark:bg-zinc-700 dark:text-white"
                            autofocus
                        >
                    </div>
                    <button 
                        wire:click="scanBarcode"
                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors"
                        title="Scan Barcode"
                    >
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Categories -->
                <div class="flex space-x-2 overflow-x-auto">
                    <button 
                        wire:click="selectCategory(null)"
                        class="px-3 py-1 text-sm rounded-full whitespace-nowrap {{ $selectedCategory === null ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-zinc-100 text-zinc-700 dark:bg-zinc-700 dark:text-zinc-300' }}"
                    >
                        All
                    </button>
                    @foreach($this->categories as $category)
                        <button 
                            wire:click="selectCategory({{ $category->id }})"
                            class="px-3 py-1 text-sm rounded-full whitespace-nowrap {{ $selectedCategory == $category->id ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-zinc-100 text-zinc-700 dark:bg-zinc-700 dark:text-zinc-300' }}"
                        >
                            {{ $category->name }}
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Products Grid -->
            <div class="flex-1 overflow-y-auto p-4">
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3">
                    @forelse($this->products as $product)
                        <div class="bg-zinc-50 dark:bg-zinc-700 rounded-lg p-3 cursor-pointer hover:bg-zinc-100 dark:hover:bg-zinc-600 transition-colors"
                             wire:click="addToCart({{ $product->id }})">
                            @if($product->featured_image)
                                <img src="{{ asset('storage/' . $product->featured_image) }}" alt="{{ $product->name }}" class="w-full h-20 object-cover rounded mb-2">
                            @else
                                <div class="w-full h-20 bg-zinc-200 dark:bg-zinc-600 rounded mb-2 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-zinc-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            @endif
                            <h4 class="font-medium text-sm text-zinc-900 dark:text-white mb-1 line-clamp-2">{{ $product->name }}</h4>
                            <p class="text-blue-600 dark:text-blue-400 font-semibold text-sm">LKR {{ number_format($product->price, 2) }}</p>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400">Stock: {{ $product->inventory_quantity }}</p>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12">
                            <svg class="w-12 h-12 mx-auto text-zinc-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <p class="text-zinc-500 dark:text-zinc-400">No products found</p>
                        </div>
                    @endforelse
                </div>
                
                <div class="mt-6">
                    {{ $this->products->links() }}
                </div>
            </div>
        </div>

        <!-- Cart Panel -->
        @php $activeTransaction = $this->getActiveTransaction(); @endphp
        <div class="w-80 bg-white dark:bg-zinc-800 flex flex-col">
            <!-- Cart Header -->
            <div class="p-4 border-b border-zinc-200 dark:border-zinc-700">
                <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">Transaction {{ $activeTransactionId }}</h3>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ count($activeTransaction['cart']) }} items</p>
            </div>

            <!-- Cart Items -->
            <div class="flex-1 overflow-y-auto p-4">
                @if(count($activeTransaction['cart']) > 0)
                    <div class="space-y-3">
                        @foreach($activeTransaction['cart'] as $item)
                            <div class="bg-zinc-50 dark:bg-zinc-700 rounded-lg p-3">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="font-medium text-sm text-zinc-900 dark:text-white flex-1">{{ $item['name'] }}</h4>
                                    <button 
                                        wire:click="removeFromCart({{ $item['product_id'] }})"
                                        class="text-red-500 hover:text-red-700 ml-2"
                                    >
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9zM4 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 012 0v4a1 1 0 11-2 0V9zm4 0a1 1 0 012 0v4a1 1 0 11-2 0V9z" clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <button 
                                            wire:click="updateQuantity({{ $item['product_id'] }}, {{ $item['quantity'] - 1 }})"
                                            class="w-6 h-6 bg-zinc-200 dark:bg-zinc-600 rounded text-zinc-700 dark:text-zinc-300 hover:bg-zinc-300 dark:hover:bg-zinc-500"
                                        >-</button>
                                        <span class="text-sm font-medium text-zinc-900 dark:text-white min-w-[2rem] text-center">{{ $item['quantity'] }}</span>
                                        <button 
                                            wire:click="updateQuantity({{ $item['product_id'] }}, {{ $item['quantity'] + 1 }})"
                                            class="w-6 h-6 bg-zinc-200 dark:bg-zinc-600 rounded text-zinc-700 dark:text-zinc-300 hover:bg-zinc-300 dark:hover:bg-zinc-500"
                                        >+</button>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-semibold text-zinc-900 dark:text-white">LKR {{ number_format($item['total'], 2) }}</p>
                                        <p class="text-xs text-zinc-500 dark:text-zinc-400">@ LKR {{ number_format($item['price'], 2) }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="w-12 h-12 mx-auto text-zinc-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 7.5M7 13h10M17 21a2 2 0 100-4 2 2 0 000 4zM9 21a2 2 0 100-4 2 2 0 000 4z"></path>
                        </svg>
                        <p class="text-zinc-500 dark:text-zinc-400">Cart is empty</p>
                        <p class="text-xs text-zinc-400 dark:text-zinc-500">Click on products to add them</p>
                    </div>
                @endif
            </div>

            <!-- Cart Footer -->
            <div class="border-t border-zinc-200 dark:border-zinc-700 p-4 space-y-4">
                <!-- Customer Info -->
                <div class="space-y-2">
                    <input 
                        type="text"
                        wire:model="transactions.{{ $activeTransactionId }}.customerName"
                        placeholder="Customer name (optional)"
                        class="w-full px-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:text-white"
                    >
                </div>

                <!-- Total -->
                <div class="bg-zinc-50 dark:bg-zinc-700 rounded-lg p-3">
                    <div class="flex justify-between items-center">
                        <span class="font-semibold text-zinc-900 dark:text-white">Total:</span>
                        <span class="text-xl font-bold text-blue-600 dark:text-blue-400">LKR {{ number_format($this->cartTotal, 2) }}</span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="space-y-2">
                    @if(count($activeTransaction['cart']) > 0)
                        <button 
                            wire:click="openPaymentModal"
                            class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-medium transition-colors"
                        >
                            Process Payment
                        </button>
                    @endif
                    
                    @if(count($activeTransaction['cart']) > 0)
                        <button 
                            wire:click="clearCart"
                            class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded-lg text-sm transition-colors"
                        >
                            Clear Cart
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Session Start Modal -->
    @if($showSessionModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white dark:bg-zinc-800 p-6 rounded-lg shadow-xl max-w-md w-full mx-4">
            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Start POS Session</h3>
            <form wire:submit.prevent="startSession">
                <div class="mb-4">
                    <label for="startingCash" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Starting Cash Amount (LKR)
                    </label>
                    <input 
                        type="number" 
                        id="startingCash"
                        wire:model="startingCash"
                        step="0.01"
                        min="0"
                        class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:text-white"
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
        <div class="bg-white dark:bg-zinc-800 p-6 rounded-lg shadow-xl max-w-lg w-full mx-4 max-h-[90vh] overflow-y-auto">
            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Process Payment - Transaction {{ $activeTransactionId }}</h3>
            
            <!-- Order Total -->
            <div class="mb-6 p-4 bg-zinc-50 dark:bg-zinc-700 rounded-lg">
                <div class="flex justify-between items-center">
                    <span class="text-lg font-medium text-zinc-700 dark:text-zinc-300">Total Amount:</span>
                    <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">LKR {{ number_format($this->cartTotal, 2) }}</span>
                </div>
                <div class="flex justify-between items-center mt-2">
                    <span class="text-sm text-zinc-600 dark:text-zinc-400">Remaining:</span>
                    <span class="text-lg font-semibold {{ $activeTransaction['remainingAmount'] > 0 ? 'text-red-600' : 'text-green-600' }}">
                        LKR {{ number_format($activeTransaction['remainingAmount'] ?? $this->cartTotal, 2) }}
                    </span>
                </div>
            </div>

            <!-- Add Payment Form -->
            <div class="mb-6 p-4 border border-zinc-200 dark:border-zinc-600 rounded-lg">
                <h4 class="text-md font-medium text-zinc-900 dark:text-white mb-3">Add Payment</h4>
                <div x-data="{ 
                    paymentMethod: 'cash', 
                    paymentAmount: {{ $activeTransaction['remainingAmount'] ?? $this->cartTotal }},
                    get remainingAmount() { return {{ $activeTransaction['remainingAmount'] ?? $this->cartTotal }}; },
                    get changeAmount() { 
                        return this.paymentMethod === 'cash' && this.paymentAmount > this.remainingAmount 
                            ? this.paymentAmount - this.remainingAmount 
                            : 0; 
                    }
                }">
                    <div class="grid grid-cols-2 gap-4 mb-3">
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Payment Method</label>
                            <select x-model="paymentMethod" class="w-full px-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:text-white">
                                <option value="cash">Cash</option>
                                <option value="card">Card</option>
                                <option value="mobile">Mobile Payment</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                <span x-show="paymentMethod === 'cash'">Cash Tendered (LKR)</span>
                                <span x-show="paymentMethod !== 'cash'">Amount (LKR)</span>
                            </label>
                            <input 
                                type="number" 
                                x-model="paymentAmount"
                                step="0.01"
                                min="0"
                                class="w-full px-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:text-white"
                            >
                        </div>
                    </div>
                    
                    <!-- Cash Balance Display -->
                    <div x-show="paymentMethod === 'cash' && changeAmount > 0" class="mb-3 p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded-lg">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-green-700 dark:text-green-300">Change Due:</span>
                            <span class="text-lg font-bold text-green-800 dark:text-green-200">LKR <span x-text="changeAmount.toFixed(2)"></span></span>
                        </div>
                    </div>
                    
                    <button 
                        type="button"
                        @click="$wire.addPayment(paymentMethod, parseFloat(paymentAmount))"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-md transition-colors text-sm"
                    >
                        Add Payment
                    </button>
                </div>
            </div>

            <!-- Current Payments List -->
            @if(count($activeTransaction['payments'] ?? []) > 0)
            <div class="mb-6">
                <h4 class="text-md font-medium text-zinc-900 dark:text-white mb-3">Current Payments</h4>
                <div class="space-y-2">
                    @foreach($activeTransaction['payments'] as $index => $payment)
                    <div class="flex items-center justify-between p-3 bg-zinc-50 dark:bg-zinc-700 rounded-lg">
                        <div>
                            <span class="font-medium text-zinc-900 dark:text-white">{{ ucfirst($payment['method']) }}</span>
                            <span class="text-zinc-600 dark:text-zinc-400 ml-2">LKR {{ number_format($payment['amount'], 2) }}</span>
                        </div>
                        <button 
                            wire:click="removePayment({{ $index }})"
                            class="text-red-500 hover:text-red-700"
                        >
                            Remove
                        </button>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Actions -->
            <div class="flex space-x-3">
                <button 
                    wire:click="$set('showPaymentModal', false)"
                    class="flex-1 bg-zinc-300 hover:bg-zinc-400 text-zinc-800 py-2 rounded-md transition-colors"
                >
                    Cancel
                </button>
                <button 
                    wire:click="processPayment"
                    class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2 rounded-md transition-colors"
                    @if(($activeTransaction['remainingAmount'] ?? $this->cartTotal) > 0) disabled @endif
                >
                    Complete Payment
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Receipt Print Modal -->
    @if($showReceiptModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4">
        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-xl w-full max-w-md max-h-[90vh] overflow-hidden">
            
            @if(!$showReceiptContent)
                <!-- Payment Success Message -->
                <div class="p-6 text-center">
                    <div class="mb-4">
                        <svg class="w-16 h-16 mx-auto text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-2">Payment Completed!</h3>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-6">Transaction processed successfully. Would you like to print a receipt?</p>
                    
                    <div class="flex space-x-3">
                        <button 
                            wire:click="skipReceipt"
                            class="flex-1 bg-zinc-300 hover:bg-zinc-400 text-zinc-800 py-2 px-4 rounded-md transition-colors text-sm"
                        >
                            Skip Receipt
                        </button>
                        <button 
                            wire:click="printReceipt"
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md transition-colors text-sm"
                        >
                            Print Receipt
                        </button>
                    </div>
                </div>
            @else
                <!-- Receipt Content -->
                <div class="flex flex-col h-full">
                    <!-- Receipt Header -->
                    <div class="p-4 border-b border-zinc-200 dark:border-zinc-600 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">Receipt Preview</h3>
                        <button wire:click="skipReceipt" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Scrollable Receipt Content -->
                    <div id="receiptContent" class="flex-1 overflow-y-auto p-6 bg-zinc-50 dark:bg-zinc-700" style="font-family: 'Courier New', monospace; font-size: 12px; line-height: 1.4;">
                        @if($receiptOrder)
                            @include('partials.receipt-content', ['order' => $receiptOrder, 'terminal' => $receiptOrder->terminal])
                        @endif
                    </div>
                    
                    <!-- Print Actions -->
                    <div class="p-4 border-t border-zinc-200 dark:border-zinc-600 bg-white dark:bg-zinc-800">
                        <div class="flex space-x-3">
                            <button 
                                wire:click="skipReceipt"
                                class="flex-1 bg-zinc-300 hover:bg-zinc-400 text-zinc-800 py-2 px-4 rounded-md transition-colors text-sm"
                            >
                                Close
                            </button>
                            <button 
                                wire:click="actuallyPrintReceipt"
                                class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-md transition-colors text-sm"
                            >
                                🖨️ Print Receipt
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Barcode Error Modal -->
    @if($showBarcodeError)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white dark:bg-zinc-800 p-6 rounded-lg shadow-xl max-w-md w-full mx-4">
            <div class="text-center">
                <div class="mb-4">
                    <svg class="w-16 h-16 mx-auto text-red-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-2">Barcode Scan Error</h3>
                <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-6">{{ $barcodeErrorMessage }}</p>
                
                <button 
                    wire:click="closeBarcodeError"
                    class="bg-red-600 hover:bg-red-700 text-white py-2 px-6 rounded-md transition-colors"
                >
                    Close
                </button>
            </div>
        </div>
    </div>
    @endif
</div>

<script>
    // Handle receipt printing
    document.addEventListener('livewire:init', function () {
        // Handle receipt content printing
        Livewire.on('printReceiptContent', function() {
            const receiptContent = document.getElementById('receiptContent');
            if (receiptContent) {
                const printWindow = window.open('', '_blank');
                printWindow.document.write(`
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <title>Receipt Print</title>
                        <style>
                            @media print {
                                @page { width: 80mm; margin: 0; }
                                body { margin: 0; padding: 0; }
                            }
                            body { font-family: 'Courier New', monospace; }
                        </style>
                    </head>
                    <body>
                        ${receiptContent.innerHTML}
                    </body>
                    </html>
                `);
                printWindow.document.close();
                printWindow.focus();
                setTimeout(() => {
                    printWindow.print();
                    printWindow.close();
                }, 500);
            }
        });
        
        // Handle barcode success notifications
        Livewire.on('barcode-success', function(data) {
            showNotification(data.message, 'success');
        });
        
        // Auto-hide barcode error after 3 seconds
        Livewire.on('auto-hide-barcode-error', function() {
            setTimeout(function() {
                @this.closeBarcodeError();
            }, 3000);
        });
    });
    
    // Success/Error notification system
    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 rounded-lg px-6 py-3 text-white shadow-lg transition-all duration-300 transform ${
            type === 'success' 
                ? 'bg-green-500 translate-x-0' 
                : 'bg-red-500 translate-x-0'
        }`;
        notification.innerHTML = `
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    ${type === 'success' 
                        ? '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>'
                        : '<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>'
                    }
                </svg>
                <span>${message}</span>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Slide in animation
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 10);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            notification.style.opacity = '0';
            setTimeout(() => {
                if (document.body.contains(notification)) {
                    document.body.removeChild(notification);
                }
            }, 300);
        }, 3000);
    }
    
    // Focus barcode input when page loads
    document.addEventListener('DOMContentLoaded', function() {
        const barcodeInput = document.querySelector('input[placeholder="Scan barcode..."]');
        if (barcodeInput) {
            barcodeInput.focus();
        }
    });
    
    // Keep barcode input focused for continuous scanning
    document.addEventListener('click', function(e) {
        // Only refocus if not clicking on an input or button
        if (!e.target.matches('input, button, select, textarea, [contenteditable]')) {
            const barcodeInput = document.querySelector('input[placeholder="Scan barcode..."]');
            if (barcodeInput) {
                barcodeInput.focus();
            }
        }
    });
</script>