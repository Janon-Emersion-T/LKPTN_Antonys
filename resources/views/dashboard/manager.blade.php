<!-- Manager Dashboard -->
@php
    // Get manager statistics
    $totalStaff = \App\Models\User::whereHas('roles', function($q) {
        $q->whereIn('name', ['cashier', 'sales-representative', 'inventory-manager', 'customer-support']);
    })->count();
    $todayOrders = \App\Models\Order::whereDate('created_at', today())->count() ?? 0;
    $todaySales = \App\Models\Order::whereDate('created_at', today())->sum('total_amount') ?? 0;
    $totalCustomers = \App\Models\User::whereHas('roles', function($q) {
        $q->where('name', 'customer');
    })->count();
    $lowStockProducts = \App\Models\Product::where('inventory_quantity', '<=', 10)->count();
@endphp

<!-- Manager Overview -->
<div class="grid gap-4 md:grid-cols-5">
    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
        <div class="flex items-center">
            <flux:icon name="users" class="h-8 w-8 text-blue-600" />
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Staff Members</p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($totalStaff) }}</p>
            </div>
        </div>
    </div>

    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
        <div class="flex items-center">
            <flux:icon name="shopping-cart" class="h-8 w-8 text-green-600" />
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Today's Orders</p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($todayOrders) }}</p>
            </div>
        </div>
    </div>

    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
        <div class="flex items-center">
            <flux:icon name="currency-dollar" class="h-8 w-8 text-yellow-600" />
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Today's Sales</p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">LKR {{ number_format($todaySales, 2) }}</p>
            </div>
        </div>
    </div>

    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
        <div class="flex items-center">
            <flux:icon name="user-group" class="h-8 w-8 text-purple-600" />
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Customers</p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($totalCustomers) }}</p>
            </div>
        </div>
    </div>

    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
        <div class="flex items-center">
            <flux:icon name="exclamation-triangle" class="h-8 w-8 text-red-600" />
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Low Stock Items</p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($lowStockProducts) }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Management Tools -->
<div class="grid gap-6 lg:grid-cols-4">
    <div class="rounded-xl border border-neutral-200 bg-white p-6 text-center dark:border-neutral-700 dark:bg-zinc-900">
        <flux:icon name="users" class="mx-auto h-12 w-12 text-blue-600" />
        <h3 class="mt-4 text-lg font-semibold text-gray-900 dark:text-white">Staff Management</h3>
        <p class="mt-2 text-gray-600 dark:text-gray-400">Manage staff schedules and performance</p>
        <flux:button href="#" wire:navigate class="mt-4 w-full">
            Manage Staff
        </flux:button>
    </div>

    <div class="rounded-xl border border-neutral-200 bg-white p-6 text-center dark:border-neutral-700 dark:bg-zinc-900">
        <flux:icon name="chart-bar" class="mx-auto h-12 w-12 text-green-600" />
        <h3 class="mt-4 text-lg font-semibold text-gray-900 dark:text-white">Sales Reports</h3>
        <p class="mt-2 text-gray-600 dark:text-gray-400">View detailed sales analytics</p>
        <flux:button href="#" wire:navigate class="mt-4 w-full" variant="outline">
            View Reports
        </flux:button>
    </div>

    <div class="rounded-xl border border-neutral-200 bg-white p-6 text-center dark:border-neutral-700 dark:bg-zinc-900">
        <flux:icon name="cube" class="mx-auto h-12 w-12 text-purple-600" />
        <h3 class="mt-4 text-lg font-semibold text-gray-900 dark:text-white">Inventory Overview</h3>
        <p class="mt-2 text-gray-600 dark:text-gray-400">Monitor stock levels and alerts</p>
        <flux:button href="#" wire:navigate class="mt-4 w-full" variant="outline">
            View Inventory
        </flux:button>
    </div>

    <div class="rounded-xl border border-neutral-200 bg-white p-6 text-center dark:border-neutral-700 dark:bg-zinc-900">
        <flux:icon name="user-group" class="mx-auto h-12 w-12 text-yellow-600" />
        <h3 class="mt-4 text-lg font-semibold text-gray-900 dark:text-white">Customer Insights</h3>
        <p class="mt-2 text-gray-600 dark:text-gray-400">Customer analytics and behavior</p>
        <flux:button href="#" wire:navigate class="mt-4 w-full" variant="outline">
            View Insights
        </flux:button>
    </div>
</div>

<!-- Performance Metrics -->
<div class="grid gap-6 lg:grid-cols-2">
    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Team Performance</h3>
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600 dark:text-gray-400">Cashiers Active Today</span>
                <span class="text-sm font-medium text-gray-900 dark:text-white">3/4</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600 dark:text-gray-400">Sales Representatives</span>
                <span class="text-sm font-medium text-gray-900 dark:text-white">2/3</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600 dark:text-gray-400">Customer Support</span>
                <span class="text-sm font-medium text-gray-900 dark:text-white">1/2</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600 dark:text-gray-400">Inventory Managers</span>
                <span class="text-sm font-medium text-gray-900 dark:text-white">1/1</span>
            </div>
        </div>
    </div>

    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Key Metrics</h3>
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600 dark:text-gray-400">Average Order Value</span>
                <span class="text-sm font-medium text-gray-900 dark:text-white">LKR 125,500</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600 dark:text-gray-400">Customer Satisfaction</span>
                <span class="text-sm font-medium text-green-600 dark:text-green-400">94%</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600 dark:text-gray-400">Stock Turnover Rate</span>
                <span class="text-sm font-medium text-blue-600 dark:text-blue-400">85%</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600 dark:text-gray-400">Monthly Growth</span>
                <span class="text-sm font-medium text-green-600 dark:text-green-400">+12.5%</span>
            </div>
        </div>
    </div>
</div>