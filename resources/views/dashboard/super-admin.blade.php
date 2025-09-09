<!-- Super Admin Dashboard -->
@php
    // Get statistics for super admin
    $totalUsers = \App\Models\User::count();
    $totalProducts = \App\Models\Product::count();
    $totalOrders = \App\Models\Order::count() ?? 0;
    $todaySales = \App\Models\Order::whereDate('created_at', today())->sum('total_amount') ?? 0;
    $lowStockProducts = \App\Models\Product::where('inventory_quantity', '<=', 10)->count();
    $activeCategories = \App\Models\Category::where('is_active', true)->count();
    $activeBrands = \App\Models\Brand::where('is_active', true)->count();
@endphp

<!-- Quick Stats -->
<div class="grid gap-4 md:grid-cols-4">
    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
        <div class="flex items-center">
            <flux:icon name="users" class="h-8 w-8 text-blue-600" />
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Users</p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($totalUsers) }}</p>
            </div>
        </div>
    </div>

    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
        <div class="flex items-center">
            <flux:icon name="cube" class="h-8 w-8 text-green-600" />
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Products</p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($totalProducts) }}</p>
            </div>
        </div>
    </div>

    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
        <div class="flex items-center">
            <flux:icon name="shopping-bag" class="h-8 w-8 text-purple-600" />
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Orders</p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($totalOrders) }}</p>
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
</div>

<!-- Management Actions -->
<div class="grid gap-6 lg:grid-cols-2">
    <!-- System Management -->
    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">System Management</h3>
        <div class="grid gap-4 sm:grid-cols-2">
            <flux:button href="#" wire:navigate class="justify-start">
                <flux:icon name="users" class="h-5 w-5 mr-2" />
                User Management
            </flux:button>
            <flux:button href="#" wire:navigate class="justify-start" variant="outline">
                <flux:icon name="cog-6-tooth" class="h-5 w-5 mr-2" />
                System Settings
            </flux:button>
            <flux:button href="#" wire:navigate class="justify-start" variant="outline">
                <flux:icon name="shield-check" class="h-5 w-5 mr-2" />
                Roles & Permissions
            </flux:button>
            <flux:button href="#" wire:navigate class="justify-start" variant="outline">
                <flux:icon name="chart-bar" class="h-5 w-5 mr-2" />
                Analytics
            </flux:button>
        </div>
    </div>

    <!-- Product Management -->
    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Product Management</h3>
        <div class="grid gap-4 sm:grid-cols-2">
            <flux:button href="{{ route('dashboard.products') }}" wire:navigate class="justify-start">
                <flux:icon name="cube" class="h-5 w-5 mr-2" />
                Products ({{ $totalProducts }})
            </flux:button>
            <flux:button href="{{ route('dashboard.categories') }}" wire:navigate class="justify-start" variant="outline">
                <flux:icon name="tag" class="h-5 w-5 mr-2" />
                Categories ({{ $activeCategories }})
            </flux:button>
            <flux:button href="{{ route('dashboard.brands') }}" wire:navigate class="justify-start" variant="outline">
                <flux:icon name="building-storefront" class="h-5 w-5 mr-2" />
                Brands ({{ $activeBrands }})
            </flux:button>
            <flux:button href="{{ route('dashboard.products', ['filterStatus' => 'low_stock']) }}" wire:navigate class="justify-start" variant="outline">
                <flux:icon name="exclamation-triangle" class="h-5 w-5 mr-2" />
                Low Stock ({{ $lowStockProducts }})
            </flux:button>
        </div>
    </div>
</div>

<!-- Recent Activity & Alerts -->
<div class="grid gap-6 lg:grid-cols-2">
    <!-- Alerts -->
    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">System Alerts</h3>
        <div class="space-y-3">
            @if($lowStockProducts > 0)
                <div class="flex items-center p-3 bg-yellow-50 border border-yellow-200 rounded-lg dark:bg-yellow-900/20 dark:border-yellow-700">
                    <flux:icon name="exclamation-triangle" class="h-5 w-5 text-yellow-600 dark:text-yellow-400" />
                    <div class="ml-3">
                        <p class="text-sm font-medium text-yellow-800 dark:text-yellow-200">Low Stock Alert</p>
                        <p class="text-xs text-yellow-600 dark:text-yellow-300">{{ $lowStockProducts }} products are running low on stock</p>
                    </div>
                </div>
            @endif
            
            <div class="flex items-center p-3 bg-green-50 border border-green-200 rounded-lg dark:bg-green-900/20 dark:border-green-700">
                <flux:icon name="check-circle" class="h-5 w-5 text-green-600 dark:text-green-400" />
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800 dark:text-green-200">System Status</p>
                    <p class="text-xs text-green-600 dark:text-green-300">All systems operational</p>
                </div>
            </div>
            
            <div class="flex items-center p-3 bg-blue-50 border border-blue-200 rounded-lg dark:bg-blue-900/20 dark:border-blue-700">
                <flux:icon name="information-circle" class="h-5 w-5 text-blue-600 dark:text-blue-400" />
                <div class="ml-3">
                    <p class="text-sm font-medium text-blue-800 dark:text-blue-200">Backup Status</p>
                    <p class="text-xs text-blue-600 dark:text-blue-300">Last backup: {{ now()->subHours(2)->diffForHumans() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Actions</h3>
        <div class="space-y-3">
            <flux:button href="{{ route('dashboard.products') }}" wire:navigate class="w-full justify-start" size="sm">
                <flux:icon name="plus" class="h-4 w-4 mr-2" />
                Add New Product
            </flux:button>
            <flux:button href="#" wire:navigate class="w-full justify-start" size="sm" variant="outline">
                <flux:icon name="user-plus" class="h-4 w-4 mr-2" />
                Add New User
            </flux:button>
            <flux:button href="#" wire:navigate class="w-full justify-start" size="sm" variant="outline">
                <flux:icon name="document-text" class="h-4 w-4 mr-2" />
                Generate Report
            </flux:button>
            <flux:button href="#" wire:navigate class="w-full justify-start" size="sm" variant="outline">
                <flux:icon name="arrow-down-tray" class="h-4 w-4 mr-2" />
                Export Data
            </flux:button>
            <flux:button href="{{ route('home') }}" target="_blank" class="w-full justify-start" size="sm" variant="outline">
                <flux:icon name="globe-alt" class="h-4 w-4 mr-2" />
                View Storefront
            </flux:button>
        </div>
    </div>
</div>