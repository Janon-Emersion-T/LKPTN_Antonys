<x-layouts.customer.app :title="__('Order Details')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <flux:button :href="route('customer.orders')" variant="ghost" size="sm" wire:navigate>
                    <flux:icon.arrow-left class="mr-1 h-4 w-4" />
                    Back to Orders
                </flux:button>
                <flux:heading size="xl" class="mt-2">Order #{{ $order->order_number }}</flux:heading>
                <flux:text class="text-neutral-600 dark:text-neutral-400">
                    Placed on {{ $order->created_at->format('M j, Y \a\t g:i A') }}
                </flux:text>
            </div>
            <div>
                @php
                    $statusColors = [
                        'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                        'processing' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                        'shipped' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
                        'delivered' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                        'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
                    ];
                @endphp
                <flux:badge size="lg" class="{{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                    {{ ucfirst($order->status) }}
                </flux:badge>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <!-- Order Items -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Items List -->
                <div class="rounded-xl border border-neutral-200 bg-white shadow-sm dark:border-neutral-700 dark:bg-zinc-900">
                    <div class="border-b border-neutral-100 p-6 dark:border-neutral-800">
                        <flux:heading size="lg">Order Items</flux:heading>
                        <flux:text class="text-neutral-600 dark:text-neutral-400">
                            {{ $order->items->count() }} {{ Str::plural('item', $order->items->count()) }}
                        </flux:text>
                    </div>
                    
                    <div class="divide-y divide-neutral-100 dark:divide-neutral-800">
                        @foreach($order->items as $item)
                            <div class="p-6">
                                <div class="flex gap-4">
                                    <!-- Product Image -->
                                    <div class="flex-shrink-0">
                                        @if($item->product && $item->product->images->first())
                                            <img 
                                                src="{{ asset('storage/' . $item->product->images->first()->image_path) }}" 
                                                alt="{{ $item->product->name }}"
                                                class="h-20 w-20 rounded-lg object-cover"
                                            >
                                        @else
                                            <div class="flex h-20 w-20 items-center justify-center rounded-lg bg-neutral-100 dark:bg-neutral-800">
                                                <flux:icon.photo class="h-8 w-8 text-neutral-400" />
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Product Details -->
                                    <div class="flex-1">
                                        <flux:heading size="sm">
                                            @if($item->product)
                                                <a href="{{ route('products.show', $item->product->slug) }}" 
                                                   class="hover:text-blue-600 dark:hover:text-blue-400">
                                                    {{ $item->product->name }}
                                                </a>
                                            @else
                                                {{ $item->product_name }}
                                            @endif
                                        </flux:heading>
                                        
                                        @if($item->product && $item->product->brand)
                                            <flux:text class="text-sm text-neutral-600 dark:text-neutral-400">
                                                {{ $item->product->brand->name }}
                                            </flux:text>
                                        @endif

                                        <div class="mt-2 flex items-center gap-4">
                                            <flux:text class="text-sm">
                                                Quantity: <span class="font-medium">{{ $item->quantity }}</span>
                                            </flux:text>
                                            <flux:text class="text-sm">
                                                Price: <span class="font-medium">LKR {{ number_format($item->unit_price, 2) }}</span>
                                            </flux:text>
                                        </div>

                                        <!-- Item Options (if any) -->
                                        @if($item->product_options && count($item->product_options) > 0)
                                            <div class="mt-2">
                                                <flux:text class="text-sm text-neutral-600 dark:text-neutral-400">
                                                    Options: {{ implode(', ', $item->product_options) }}
                                                </flux:text>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Item Total -->
                                    <div class="text-right">
                                        <flux:text class="font-medium">
                                            LKR {{ number_format($item->quantity * $item->unit_price, 2) }}
                                        </flux:text>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Order Timeline -->
                <div class="rounded-xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-zinc-900">
                    <flux:heading size="lg" class="mb-4">Order Timeline</flux:heading>
                    
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-green-100 dark:bg-green-900">
                                <flux:icon.check class="h-4 w-4 text-green-600 dark:text-green-400" />
                            </div>
                            <div>
                                <flux:text class="font-medium">Order Placed</flux:text>
                                <flux:text class="text-sm text-neutral-600 dark:text-neutral-400">
                                    {{ $order->created_at->format('M j, Y \a\t g:i A') }}
                                </flux:text>
                            </div>
                        </div>

                        @if($order->status !== 'cancelled')
                            <div class="flex items-center gap-3">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full {{ in_array($order->status, ['processing', 'shipped', 'delivered']) ? 'bg-green-100 dark:bg-green-900' : 'bg-neutral-100 dark:bg-neutral-800' }}">
                                    <flux:icon.check class="h-4 w-4 {{ in_array($order->status, ['processing', 'shipped', 'delivered']) ? 'text-green-600 dark:text-green-400' : 'text-neutral-400' }}" />
                                </div>
                                <div>
                                    <flux:text class="font-medium">Processing</flux:text>
                                    <flux:text class="text-sm text-neutral-600 dark:text-neutral-400">
                                        Your order is being processed
                                    </flux:text>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full {{ in_array($order->status, ['shipped', 'delivered']) ? 'bg-green-100 dark:bg-green-900' : 'bg-neutral-100 dark:bg-neutral-800' }}">
                                    <flux:icon.check class="h-4 w-4 {{ in_array($order->status, ['shipped', 'delivered']) ? 'text-green-600 dark:text-green-400' : 'text-neutral-400' }}" />
                                </div>
                                <div>
                                    <flux:text class="font-medium">Shipped</flux:text>
                                    <flux:text class="text-sm text-neutral-600 dark:text-neutral-400">
                                        Your order is on its way
                                    </flux:text>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full {{ $order->status === 'delivered' ? 'bg-green-100 dark:bg-green-900' : 'bg-neutral-100 dark:bg-neutral-800' }}">
                                    <flux:icon.check class="h-4 w-4 {{ $order->status === 'delivered' ? 'text-green-600 dark:text-green-400' : 'text-neutral-400' }}" />
                                </div>
                                <div>
                                    <flux:text class="font-medium">Delivered</flux:text>
                                    <flux:text class="text-sm text-neutral-600 dark:text-neutral-400">
                                        Your order has been delivered
                                    </flux:text>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center gap-3">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-red-100 dark:bg-red-900">
                                    <flux:icon.x-mark class="h-4 w-4 text-red-600 dark:text-red-400" />
                                </div>
                                <div>
                                    <flux:text class="font-medium">Order Cancelled</flux:text>
                                    <flux:text class="text-sm text-neutral-600 dark:text-neutral-400">
                                        {{ $order->cancelled_at?->format('M j, Y \a\t g:i A') }}
                                    </flux:text>
                                    @if($order->cancellation_reason)
                                        <flux:text class="text-sm text-neutral-600 dark:text-neutral-400">
                                            Reason: {{ $order->cancellation_reason }}
                                        </flux:text>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Order Summary Sidebar -->
            <div class="space-y-6">
                <!-- Order Summary -->
                <div class="rounded-xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-zinc-900">
                    <flux:heading size="lg" class="mb-4">Order Summary</flux:heading>
                    
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <flux:text>Subtotal</flux:text>
                            <flux:text>LKR {{ number_format($order->subtotal_amount, 2) }}</flux:text>
                        </div>
                        
                        @if($order->tax_amount > 0)
                            <div class="flex items-center justify-between">
                                <flux:text>Tax</flux:text>
                                <flux:text>LKR {{ number_format($order->tax_amount, 2) }}</flux:text>
                            </div>
                        @endif
                        
                        <div class="flex items-center justify-between">
                            <flux:text>Shipping</flux:text>
                            <flux:text>
                                @if($order->shipping_amount > 0)
                                    LKR {{ number_format($order->shipping_amount, 2) }}
                                @else
                                    Free
                                @endif
                            </flux:text>
                        </div>
                        
                        @if($order->discount_amount > 0)
                            <div class="flex items-center justify-between text-green-600 dark:text-green-400">
                                <flux:text>Discount</flux:text>
                                <flux:text>-LKR {{ number_format($order->discount_amount, 2) }}</flux:text>
                            </div>
                        @endif
                        
                        <div class="border-t border-neutral-100 pt-3 dark:border-neutral-800">
                            <div class="flex items-center justify-between">
                                <flux:text class="font-medium">Total</flux:text>
                                <flux:text class="font-medium">LKR {{ number_format($order->total_amount, 2) }}</flux:text>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shipping Address -->
                @if($order->shippingAddress)
                    <div class="rounded-xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-zinc-900">
                        <flux:heading size="lg" class="mb-4">Shipping Address</flux:heading>
                        
                        <div class="text-sm space-y-1">
                            <div class="font-medium">{{ $order->shippingAddress->recipient_name }}</div>
                            <div>{{ $order->shippingAddress->address_line_1 }}</div>
                            @if($order->shippingAddress->address_line_2)
                                <div>{{ $order->shippingAddress->address_line_2 }}</div>
                            @endif
                            <div>{{ $order->shippingAddress->city }}, {{ $order->shippingAddress->state }}</div>
                            <div>{{ $order->shippingAddress->postal_code }}</div>
                            <div>{{ $order->shippingAddress->country }}</div>
                            @if($order->shippingAddress->phone_number)
                                <div class="pt-2">{{ $order->shippingAddress->phone_number }}</div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Actions -->
                <div class="rounded-xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-zinc-900">
                    <flux:heading size="lg" class="mb-4">Actions</flux:heading>
                    
                    <div class="space-y-3">
                        @if($order->status === 'pending')
                            <flux:button 
                                variant="outline" 
                                class="w-full"
                                x-data
                                x-on:click="
                                    if(confirm('Are you sure you want to cancel this order?')) {
                                        fetch('{{ route('customer.orders.cancel', $order) }}', {
                                            method: 'POST',
                                            headers: {
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                            }
                                        }).then(() => window.location.reload());
                                    }
                                "
                            >
                                Cancel Order
                            </flux:button>
                        @endif
                        
                        <flux:button 
                            variant="ghost" 
                            class="w-full"
                            onclick="window.print()"
                        >
                            Print Order
                        </flux:button>
                        
                        <flux:button 
                            :href="route('customer.orders')" 
                            variant="ghost" 
                            class="w-full"
                            wire:navigate
                        >
                            Back to Orders
                        </flux:button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.customer.app>