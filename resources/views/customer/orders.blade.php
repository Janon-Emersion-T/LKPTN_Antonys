<x-layouts.customer.app :title="__('My Orders')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <flux:heading size="xl">My Orders</flux:heading>
                <flux:text class="text-neutral-600 dark:text-neutral-400">
                    Track and manage your orders
                </flux:text>
            </div>
        </div>

        <!-- Filters -->
        <div class="rounded-xl border border-neutral-200 bg-white p-4 shadow-sm dark:border-neutral-700 dark:bg-zinc-900">
            <form method="GET" action="{{ route('customer.orders') }}" class="flex items-center gap-4">
                <div class="flex-1">
                    <flux:select name="status" onchange="this.form.submit()">
                        @foreach($statuses as $value => $label)
                            <option value="{{ $value }}" {{ request('status', 'all') === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </flux:select>
                </div>
            </form>
        </div>

        <!-- Orders List -->
        <div class="rounded-xl border border-neutral-200 bg-white shadow-sm dark:border-neutral-700 dark:bg-zinc-900">
            @if($orders->count() > 0)
                <div class="divide-y divide-neutral-100 dark:divide-neutral-800">
                    @foreach($orders as $order)
                        <div class="p-6">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-4 mb-4">
                                        <div>
                                            <flux:heading size="sm">Order #{{ $order->order_number }}</flux:heading>
                                            <flux:text class="text-sm text-neutral-600 dark:text-neutral-400">
                                                Placed on {{ $order->created_at->format('M j, Y \a\t g:i A') }}
                                            </flux:text>
                                        </div>
                                        <div class="ml-auto">
                                            @php
                                                $statusColors = [
                                                    'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                                    'processing' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                                    'shipped' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
                                                    'delivered' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                                    'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
                                                ];
                                            @endphp
                                            <flux:badge class="{{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                                                {{ ucfirst($order->status) }}
                                            </flux:badge>
                                        </div>
                                    </div>

                                    <!-- Order Items Preview -->
                                    <div class="mb-4">
                                        <div class="flex items-center gap-4 mb-2">
                                            @foreach($order->items->take(3) as $item)
                                                <div class="flex items-center gap-2">
                                                    @if($item->product && $item->product->images->first())
                                                        <img src="{{ asset('storage/' . $item->product->images->first()->image_path) }}" 
                                                             alt="{{ $item->product->name }}" 
                                                             class="h-10 w-10 rounded object-cover">
                                                    @else
                                                        <div class="h-10 w-10 rounded bg-neutral-200 dark:bg-neutral-700"></div>
                                                    @endif
                                                    <div>
                                                        <flux:text class="text-sm font-medium">{{ $item->product_name ?? $item->product->name }}</flux:text>
                                                        <flux:text class="text-xs text-neutral-600 dark:text-neutral-400">
                                                            Qty: {{ $item->quantity }}
                                                        </flux:text>
                                                    </div>
                                                </div>
                                            @endforeach
                                            @if($order->items->count() > 3)
                                                <flux:text class="text-sm text-neutral-600 dark:text-neutral-400">
                                                    +{{ $order->items->count() - 3 }} more items
                                                </flux:text>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Order Summary -->
                                    <div class="flex items-center justify-between text-sm">
                                        <flux:text class="text-neutral-600 dark:text-neutral-400">
                                            {{ $order->items->count() }} items • Total: 
                                            <span class="font-medium text-neutral-900 dark:text-neutral-100">
                                                LKR {{ number_format($order->total_amount, 2) }}
                                            </span>
                                        </flux:text>
                                    </div>
                                </div>

                                <div class="ml-6 flex flex-col gap-2">
                                    <flux:button :href="route('customer.orders.show', $order)" size="sm" wire:navigate>
                                        View Details
                                    </flux:button>
                                    
                                    @if($order->status === 'pending')
                                        <flux:button 
                                            variant="ghost" 
                                            size="sm"
                                            x-data
                                            x-on:click="
                                                if(confirm('Are you sure you want to cancel this order?')) {
                                                    fetch('{{ route('customer.orders.cancel', $order) }}', {
                                                        method: 'POST',
                                                        headers: {
                                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                            'Content-Type': 'application/json',
                                                        },
                                                    }).then(() => window.location.reload());
                                                }
                                            "
                                        >
                                            Cancel Order
                                        </flux:button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($orders->hasPages())
                    <div class="border-t border-neutral-100 p-4 dark:border-neutral-800">
                        {{ $orders->links() }}
                    </div>
                @endif
            @else
                <div class="p-12 text-center">
                    <flux:icon.shopping-bag class="mx-auto h-16 w-16 text-neutral-400" />
                    <flux:heading size="lg" class="mt-4">No orders found</flux:heading>
                    <flux:text class="mt-2 text-neutral-600 dark:text-neutral-400">
                        You haven't placed any orders yet.
                    </flux:text>
                    <flux:button :href="route('products.index')" class="mt-4" wire:navigate>
                        Start Shopping
                    </flux:button>
                </div>
            @endif
        </div>
    </div>
</x-layouts.customer.app>