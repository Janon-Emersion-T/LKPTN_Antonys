<x-layouts.customer.app :title="__('Customer Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
        <!-- Welcome Section -->
        <div class="rounded-xl border border-neutral-200 bg-gradient-to-r from-blue-50 to-indigo-50 p-6 dark:border-neutral-700 dark:from-blue-950 dark:to-indigo-950">
            <div class="flex items-center justify-between">
                <div>
                    <flux:heading size="lg" class="text-blue-900 dark:text-blue-100">
                        Welcome back, {{ $customer->name }}!
                    </flux:heading>
                    <flux:text class="mt-1 text-blue-700 dark:text-blue-300">
                        Here's what's happening with your account
                    </flux:text>
                </div>
                <div class="hidden sm:block">
                    <flux:icon.user-circle class="h-16 w-16 text-blue-600 dark:text-blue-400" />
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
            <!-- Total Orders -->
            <div class="rounded-xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-zinc-900">
                <div class="flex items-center justify-between">
                    <div>
                        <flux:text class="text-sm text-neutral-600 dark:text-neutral-400">Total Orders</flux:text>
                        <flux:heading size="xl" class="mt-1">{{ number_format($totalOrders) }}</flux:heading>
                    </div>
                    <div class="rounded-full bg-blue-100 p-3 dark:bg-blue-900">
                        <flux:icon.shopping-bag class="h-6 w-6 text-blue-600 dark:text-blue-400" />
                    </div>
                </div>
            </div>

            <!-- Pending Orders -->
            <div class="rounded-xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-zinc-900">
                <div class="flex items-center justify-between">
                    <div>
                        <flux:text class="text-sm text-neutral-600 dark:text-neutral-400">Pending Orders</flux:text>
                        <flux:heading size="xl" class="mt-1">{{ number_format($pendingOrders) }}</flux:heading>
                    </div>
                    <div class="rounded-full bg-orange-100 p-3 dark:bg-orange-900">
                        <flux:icon.clock class="h-6 w-6 text-orange-600 dark:text-orange-400" />
                    </div>
                </div>
            </div>

            <!-- Total Spent -->
            <div class="rounded-xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-zinc-900">
                <div class="flex items-center justify-between">
                    <div>
                        <flux:text class="text-sm text-neutral-600 dark:text-neutral-400">Total Spent</flux:text>
                        <flux:heading size="xl" class="mt-1">LKR {{ number_format($totalSpent, 2) }}</flux:heading>
                    </div>
                    <div class="rounded-full bg-green-100 p-3 dark:bg-green-900">
                        <flux:icon.banknotes class="h-6 w-6 text-green-600 dark:text-green-400" />
                    </div>
                </div>
            </div>

            <!-- Wishlist Items -->
            <div class="rounded-xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-zinc-900">
                <div class="flex items-center justify-between">
                    <div>
                        <flux:text class="text-sm text-neutral-600 dark:text-neutral-400">Wishlist Items</flux:text>
                        <flux:heading size="xl" class="mt-1">{{ number_format($wishlistCount) }}</flux:heading>
                    </div>
                    <div class="rounded-full bg-pink-100 p-3 dark:bg-pink-900">
                        <flux:icon.heart class="h-6 w-6 text-pink-600 dark:text-pink-400" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="rounded-xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-zinc-900">
            <div class="flex items-center justify-between mb-4">
                <flux:heading size="lg">Recent Orders</flux:heading>
                <flux:button :href="route('customer.orders')" variant="ghost" size="sm" wire:navigate>
                    View All Orders
                    <flux:icon.arrow-right class="ml-1 h-4 w-4" />
                </flux:button>
            </div>

            @if($recentOrders->count() > 0)
                <div class="space-y-4">
                    @foreach($recentOrders as $order)
                        <div class="flex items-center justify-between border-b border-neutral-100 pb-4 last:border-b-0 dark:border-neutral-800">
                            <div class="flex-1">
                                <div class="flex items-center gap-3">
                                    <div>
                                        <flux:text class="font-medium">Order #{{ $order->order_number }}</flux:text>
                                        <flux:text class="text-sm text-neutral-600 dark:text-neutral-400">
                                            {{ $order->created_at->format('M j, Y') }} • {{ $order->items->count() }} items
                                        </flux:text>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <flux:text class="font-medium">LKR {{ number_format($order->total_amount, 2) }}</flux:text>
                                <div class="mt-1">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                            'processing' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                            'shipped' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
                                            'delivered' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                            'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
                                        ];
                                    @endphp
                                    <flux:badge size="sm" class="{{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst($order->status) }}
                                    </flux:badge>
                                </div>
                            </div>
                            <flux:button :href="route('customer.orders.show', $order)" size="sm" variant="ghost" wire:navigate>
                                <flux:icon.eye class="h-4 w-4" />
                            </flux:button>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <flux:icon.shopping-bag class="mx-auto h-12 w-12 text-neutral-400" />
                    <flux:heading size="sm" class="mt-2">No orders yet</flux:heading>
                    <flux:text class="text-neutral-600 dark:text-neutral-400">
                        Start shopping to see your orders here
                    </flux:text>
                    <flux:button :href="route('products.index')" class="mt-4" wire:navigate>
                        Browse Products
                    </flux:button>
                </div>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="grid gap-4 md:grid-cols-3">
            <flux:button :href="route('products.index')" variant="outline" class="p-6 h-auto" wire:navigate>
                <div class="flex flex-col items-center text-center">
                    <flux:icon.squares-plus class="h-8 w-8 mb-2" />
                    <flux:text class="font-medium">Browse Products</flux:text>
                    <flux:text class="text-sm text-neutral-600 dark:text-neutral-400">Discover new items</flux:text>
                </div>
            </flux:button>

            <flux:button :href="route('customer.wishlist')" variant="outline" class="p-6 h-auto" wire:navigate>
                <div class="flex flex-col items-center text-center">
                    <flux:icon.heart class="h-8 w-8 mb-2" />
                    <flux:text class="font-medium">My Wishlist</flux:text>
                    <flux:text class="text-sm text-neutral-600 dark:text-neutral-400">{{ $wishlistCount }} saved items</flux:text>
                </div>
            </flux:button>

            <flux:button :href="route('cart.index')" variant="outline" class="p-6 h-auto" wire:navigate>
                <div class="flex flex-col items-center text-center">
                    <flux:icon.shopping-cart class="h-8 w-8 mb-2" />
                    <flux:text class="font-medium">Shopping Cart</flux:text>
                    <flux:text class="text-sm text-neutral-600 dark:text-neutral-400">Review your cart</flux:text>
                </div>
            </flux:button>
        </div>
    </div>
</x-layouts.customer.app>