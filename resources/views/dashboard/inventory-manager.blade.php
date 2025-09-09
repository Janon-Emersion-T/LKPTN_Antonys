<!-- Inventory Manager Dashboard -->
@php
    // Get inventory statistics
    $totalProducts = \App\Models\Product::count();
    $lowStockProducts = \App\Models\Product::where('inventory_quantity', '<=', 10)->count();
    $outOfStockProducts = \App\Models\Product::where('inventory_quantity', 0)->count();
    $totalStockValue = \App\Models\Product::selectRaw('SUM(inventory_quantity * price) as total_value')->first()->total_value ?? 0;
    $recentlyUpdated = \App\Models\Product::where('updated_at', '>=', now()->subDays(7))->count();
@endphp

<!-- Inventory Stats -->
<div class="grid gap-4 md:grid-cols-5">
    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
        <div class="flex items-center">
            <flux:icon name="cube" class="h-8 w-8 text-blue-600" />
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Products</p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($totalProducts) }}</p>
            </div>
        </div>
    </div>

    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
        <div class="flex items-center">
            <flux:icon name="exclamation-triangle" class="h-8 w-8 text-yellow-600" />
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Low Stock</p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($lowStockProducts) }}</p>
            </div>
        </div>
    </div>

    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
        <div class="flex items-center">
            <flux:icon name="x-circle" class="h-8 w-8 text-red-600" />
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Out of Stock</p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($outOfStockProducts) }}</p>
            </div>
        </div>
    </div>

    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
        <div class="flex items-center">
            <flux:icon name="currency-dollar" class="h-8 w-8 text-green-600" />
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Stock Value</p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">LKR {{ number_format($totalStockValue, 0) }}</p>
            </div>
        </div>
    </div>

    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
        <div class="flex items-center">
            <flux:icon name="arrow-path" class="h-8 w-8 text-purple-600" />
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Recent Updates</p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($recentlyUpdated) }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid gap-6 lg:grid-cols-4">
    <!-- Stock Management -->
    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
        <div class="text-center">
            <div class="mx-auto h-16 w-16 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                <flux:icon name="plus" class="h-8 w-8 text-blue-600 dark:text-blue-400" />
            </div>
            <h3 class="mt-4 text-lg font-semibold text-gray-900 dark:text-white">Add Stock</h3>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Update product quantities</p>
            <flux:button href="#" wire:navigate class="mt-4 w-full" size="sm">
                Update Stock
            </flux:button>
        </div>
    </div>

    <!-- Stock Alerts -->
    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
        <div class="text-center">
            <div class="mx-auto h-16 w-16 rounded-full bg-yellow-100 dark:bg-yellow-900/30 flex items-center justify-center">
                <flux:icon name="bell" class="h-8 w-8 text-yellow-600 dark:text-yellow-400" />
            </div>
            <h3 class="mt-4 text-lg font-semibold text-gray-900 dark:text-white">Stock Alerts</h3>
            <p class="mt-2 text-gray-600 dark:text-gray-400">View low stock items</p>
            <flux:button href="#" wire:navigate class="mt-4 w-full" size="sm" variant="outline">
                View Alerts ({{ $lowStockProducts }})
            </flux:button>
        </div>
    </div>

    <!-- Purchase Orders -->
    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
        <div class="text-center">
            <div class="mx-auto h-16 w-16 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                <flux:icon name="shopping-bag" class="h-8 w-8 text-green-600 dark:text-green-400" />
            </div>
            <h3 class="mt-4 text-lg font-semibold text-gray-900 dark:text-white">Purchase Orders</h3>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Manage supplier orders</p>
            <flux:button href="#" wire:navigate class="mt-4 w-full" size="sm" variant="outline">
                Manage Orders
            </flux:button>
        </div>
    </div>

    <!-- Reports -->
    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
        <div class="text-center">
            <div class="mx-auto h-16 w-16 rounded-full bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                <flux:icon name="chart-bar" class="h-8 w-8 text-purple-600 dark:text-purple-400" />
            </div>
            <h3 class="mt-4 text-lg font-semibold text-gray-900 dark:text-white">Reports</h3>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Inventory reports</p>
            <flux:button href="#" wire:navigate class="mt-4 w-full" size="sm" variant="outline">
                Generate Report
            </flux:button>
        </div>
    </div>
</div>

<!-- Critical Alerts -->
@if($lowStockProducts > 0 || $outOfStockProducts > 0)
<div class="rounded-xl border border-red-200 bg-red-50 p-6 dark:border-red-800 dark:bg-red-900/20">
    <div class="flex items-start">
        <flux:icon name="exclamation-triangle" class="h-6 w-6 text-red-600 dark:text-red-400 mt-0.5" />
        <div class="ml-4 flex-1">
            <h3 class="text-lg font-semibold text-red-900 dark:text-red-200">Inventory Alerts</h3>
            <div class="mt-2 space-y-2">
                @if($outOfStockProducts > 0)
                    <p class="text-sm text-red-800 dark:text-red-300">
                        <span class="font-medium">{{ $outOfStockProducts }}</span> products are out of stock and need immediate restocking.
                    </p>
                @endif
                @if($lowStockProducts > 0)
                    <p class="text-sm text-red-800 dark:text-red-300">
                        <span class="font-medium">{{ $lowStockProducts }}</span> products are running low on inventory.
                    </p>
                @endif
            </div>
            <div class="mt-4 flex gap-3">
                @if($outOfStockProducts > 0)
                    <flux:button href="#" wire:navigate size="sm">
                        View Out of Stock
                    </flux:button>
                @endif
                @if($lowStockProducts > 0)
                    <flux:button href="#" wire:navigate size="sm" variant="outline">
                        View Low Stock
                    </flux:button>
                @endif
            </div>
        </div>
    </div>
</div>
@endif

<!-- Inventory Management -->
<div class="grid gap-6 lg:grid-cols-2">
    <!-- Recent Stock Movements -->
    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Stock Movements</h3>
            <flux:button href="#" wire:navigate size="sm" variant="outline">View All</flux:button>
        </div>
        
        <div class="space-y-4">
            <!-- Example stock movement entries -->
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg dark:bg-zinc-800">
                <div class="flex items-center">
                    <flux:icon name="plus" class="h-5 w-5 text-green-600" />
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Stock Added</p>
                        <p class="text-xs text-gray-600 dark:text-gray-400">Dell Inspiron 15 3000</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">+50</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ now()->subHours(2)->format('H:i A') }}</p>
                </div>
            </div>
            
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg dark:bg-zinc-800">
                <div class="flex items-center">
                    <flux:icon name="minus" class="h-5 w-5 text-red-600" />
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Sale</p>
                        <p class="text-xs text-gray-600 dark:text-gray-400">MacBook Air M2</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">-1</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ now()->subMinutes(30)->format('H:i A') }}</p>
                </div>
            </div>
            
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg dark:bg-zinc-800">
                <div class="flex items-center">
                    <flux:icon name="arrow-path" class="h-5 w-5 text-blue-600" />
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Adjustment</p>
                        <p class="text-xs text-gray-600 dark:text-gray-400">ASUS ROG Strix G15</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">-2</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ now()->subHours(1)->format('H:i A') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Products by Stock -->
    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Stock Levels</h3>
            <flux:button href="#" wire:navigate size="sm" variant="outline">View All</flux:button>
        </div>
        
        <div class="space-y-4">
            @php
                $stockProducts = \App\Models\Product::orderBy('inventory_quantity', 'asc')->limit(5)->get();
            @endphp
            @foreach($stockProducts as $product)
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $product->name }}</p>
                        <p class="text-xs text-gray-600 dark:text-gray-400">{{ $product->sku ?? 'N/A' }}</p>
                    </div>
                    <div class="flex items-center">
                        <div class="text-right mr-3">
                            <p class="text-sm font-medium 
                                @if($product->inventory_quantity <= 0) text-red-600 dark:text-red-400
                                @elseif($product->inventory_quantity <= 10) text-yellow-600 dark:text-yellow-400
                                @else text-green-600 dark:text-green-400 @endif">
                                {{ $product->inventory_quantity }}
                            </p>
                        </div>
                        @if($product->inventory_quantity <= 0)
                            <flux:icon name="x-circle" class="h-5 w-5 text-red-600" />
                        @elseif($product->inventory_quantity <= 10)
                            <flux:icon name="exclamation-triangle" class="h-5 w-5 text-yellow-600" />
                        @else
                            <flux:icon name="check-circle" class="h-5 w-5 text-green-600" />
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>