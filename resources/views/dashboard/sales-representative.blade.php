<!-- Sales Representative Dashboard -->
@php
    // Get sales representative statistics
    $myCustomers = \App\Models\User::whereHas('roles', function($q) {
        $q->where('name', 'customer');
    })->count();
    $myOrders = \App\Models\Order::whereDate('created_at', today())->count() ?? 0;
    $myRevenue = \App\Models\Order::whereDate('created_at', today())->sum('total_amount') ?? 0;
    $weeklyTarget = 500000; // Example weekly target
    $weeklyProgress = \App\Models\Order::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sum('total_amount') ?? 0;
@endphp

<!-- Sales Performance -->
<div class="grid gap-4 md:grid-cols-4">
    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
        <div class="flex items-center">
            <flux:icon name="user-group" class="h-8 w-8 text-blue-600" />
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">My Customers</p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($myCustomers) }}</p>
            </div>
        </div>
    </div>

    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
        <div class="flex items-center">
            <flux:icon name="shopping-bag" class="h-8 w-8 text-green-600" />
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Today's Orders</p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($myOrders) }}</p>
            </div>
        </div>
    </div>

    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
        <div class="flex items-center">
            <flux:icon name="currency-dollar" class="h-8 w-8 text-yellow-600" />
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Today's Revenue</p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">LKR {{ number_format($myRevenue, 2) }}</p>
            </div>
        </div>
    </div>

    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
        <div class="flex items-center">
            <flux:icon name="chart-bar" class="h-8 w-8 text-purple-600" />
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Weekly Target</p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format(($weeklyProgress/$weeklyTarget)*100, 1) }}%</p>
            </div>
        </div>
    </div>
</div>

<!-- Sales Tools -->
<div class="grid gap-6 lg:grid-cols-3">
    <div class="rounded-xl border border-neutral-200 bg-white p-6 text-center dark:border-neutral-700 dark:bg-zinc-900">
        <flux:icon name="phone" class="mx-auto h-12 w-12 text-blue-600" />
        <h3 class="mt-4 text-lg font-semibold text-gray-900 dark:text-white">Customer Calls</h3>
        <p class="mt-2 text-gray-600 dark:text-gray-400">Follow up with leads and customers</p>
        <flux:button href="#" wire:navigate class="mt-4 w-full">
            Call List
        </flux:button>
    </div>

    <div class="rounded-xl border border-neutral-200 bg-white p-6 text-center dark:border-neutral-700 dark:bg-zinc-900">
        <flux:icon name="envelope" class="mx-auto h-12 w-12 text-green-600" />
        <h3 class="mt-4 text-lg font-semibold text-gray-900 dark:text-white">Email Campaigns</h3>
        <p class="mt-2 text-gray-600 dark:text-gray-400">Send promotional emails to customers</p>
        <flux:button href="#" wire:navigate class="mt-4 w-full" variant="outline">
            Create Campaign
        </flux:button>
    </div>

    <div class="rounded-xl border border-neutral-200 bg-white p-6 text-center dark:border-neutral-700 dark:bg-zinc-900">
        <flux:icon name="document-text" class="mx-auto h-12 w-12 text-purple-600" />
        <h3 class="mt-4 text-lg font-semibold text-gray-900 dark:text-white">Quotes & Proposals</h3>
        <p class="mt-2 text-gray-600 dark:text-gray-400">Manage customer quotes and proposals</p>
        <flux:button href="#" wire:navigate class="mt-4 w-full" variant="outline">
            Create Quote
        </flux:button>
    </div>
</div>

<!-- Sales Pipeline -->
<div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Sales Pipeline</h3>
    <div class="grid gap-4 md:grid-cols-4">
        <div class="text-center">
            <div class="bg-blue-100 dark:bg-blue-900/30 rounded-lg p-4">
                <flux:icon name="eye" class="mx-auto h-8 w-8 text-blue-600 dark:text-blue-400 mb-2" />
                <p class="text-sm font-medium text-gray-900 dark:text-white">Leads</p>
                <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">24</p>
            </div>
        </div>
        <div class="text-center">
            <div class="bg-yellow-100 dark:bg-yellow-900/30 rounded-lg p-4">
                <flux:icon name="chat-bubble-left-right" class="mx-auto h-8 w-8 text-yellow-600 dark:text-yellow-400 mb-2" />
                <p class="text-sm font-medium text-gray-900 dark:text-white">Contacted</p>
                <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">18</p>
            </div>
        </div>
        <div class="text-center">
            <div class="bg-purple-100 dark:bg-purple-900/30 rounded-lg p-4">
                <flux:icon name="document-text" class="mx-auto h-8 w-8 text-purple-600 dark:text-purple-400 mb-2" />
                <p class="text-sm font-medium text-gray-900 dark:text-white">Quoted</p>
                <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">12</p>
            </div>
        </div>
        <div class="text-center">
            <div class="bg-green-100 dark:bg-green-900/30 rounded-lg p-4">
                <flux:icon name="check-circle" class="mx-auto h-8 w-8 text-green-600 dark:text-green-400 mb-2" />
                <p class="text-sm font-medium text-gray-900 dark:text-white">Closed</p>
                <p class="text-2xl font-bold text-green-600 dark:text-green-400">8</p>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities -->
<div class="grid gap-6 lg:grid-cols-2">
    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Recent Activities</h3>
        <div class="space-y-4">
            <div class="flex items-start">
                <flux:icon name="phone" class="h-5 w-5 text-blue-600 mt-0.5" />
                <div class="ml-3 flex-1">
                    <p class="text-sm text-gray-900 dark:text-white">Called John Doe regarding laptop inquiry</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">2 hours ago</p>
                </div>
            </div>
            <div class="flex items-start">
                <flux:icon name="envelope" class="h-5 w-5 text-green-600 mt-0.5" />
                <div class="ml-3 flex-1">
                    <p class="text-sm text-gray-900 dark:text-white">Sent quote to ABC Company</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">4 hours ago</p>
                </div>
            </div>
            <div class="flex items-start">
                <flux:icon name="check-circle" class="h-5 w-5 text-purple-600 mt-0.5" />
                <div class="ml-3 flex-1">
                    <p class="text-sm text-gray-900 dark:text-white">Closed deal with XYZ Corp</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Yesterday</p>
                </div>
            </div>
        </div>
    </div>

    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Top Customers</h3>
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-900 dark:text-white">John Smith</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Last order: 2 days ago</p>
                </div>
                <div class="text-right">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">LKR 125,000</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Total spent</p>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-900 dark:text-white">ABC Company</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Last order: 1 week ago</p>
                </div>
                <div class="text-right">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">LKR 450,000</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Total spent</p>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-900 dark:text-white">Jane Doe</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Last order: 3 days ago</p>
                </div>
                <div class="text-right">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">LKR 85,500</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Total spent</p>
                </div>
            </div>
        </div>
    </div>
</div>