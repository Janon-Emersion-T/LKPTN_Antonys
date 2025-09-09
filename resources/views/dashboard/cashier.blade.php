<!-- Cashier Dashboard -->
@php
    // Get today's statistics for cashier
    $todayOrders = \App\Models\Order::whereDate('created_at', today())->count() ?? 0;
    $todaySales = \App\Models\Order::whereDate('created_at', today())->sum('total_amount') ?? 0;
    $myTransactions = \App\Models\Order::where('created_by', auth()->id())->whereDate('created_at', today())->count() ?? 0;
    $myTransactionTotal = \App\Models\Order::where('created_by', auth()->id())->whereDate('created_at', today())->sum('total_amount') ?? 0;
@endphp

<!-- Today's Stats -->
<div class="grid gap-4 md:grid-cols-4">
    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
        <div class="flex items-center">
            <flux:icon name="shopping-cart" class="h-8 w-8 text-blue-600" />
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Today's Orders</p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($todayOrders) }}</p>
            </div>
        </div>
    </div>

    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
        <div class="flex items-center">
            <flux:icon name="currency-dollar" class="h-8 w-8 text-green-600" />
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Today's Sales</p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">LKR {{ number_format($todaySales, 2) }}</p>
            </div>
        </div>
    </div>

    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
        <div class="flex items-center">
            <flux:icon name="user" class="h-8 w-8 text-purple-600" />
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">My Transactions</p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($myTransactions) }}</p>
            </div>
        </div>
    </div>

    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
        <div class="flex items-center">
            <flux:icon name="banknotes" class="h-8 w-8 text-yellow-600" />
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">My Sales</p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">LKR {{ number_format($myTransactionTotal, 2) }}</p>
            </div>
        </div>
    </div>
</div>

<!-- POS Actions -->
<div class="grid gap-6 lg:grid-cols-3">
    <!-- New Sale -->
    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
        <div class="text-center">
            <div class="mx-auto h-20 w-20 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                <flux:icon name="shopping-cart" class="h-10 w-10 text-blue-600 dark:text-blue-400" />
            </div>
            <h3 class="mt-4 text-lg font-semibold text-gray-900 dark:text-white">New Sale</h3>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Start a new point of sale transaction</p>
            <flux:button href="#" wire:navigate class="mt-4 w-full">
                Start New Sale
            </flux:button>
        </div>
    </div>

    <!-- Product Search -->
    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
        <div class="text-center">
            <div class="mx-auto h-20 w-20 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                <flux:icon name="magnifying-glass" class="h-10 w-10 text-green-600 dark:text-green-400" />
            </div>
            <h3 class="mt-4 text-lg font-semibold text-gray-900 dark:text-white">Product Search</h3>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Search products by name, SKU or barcode</p>
            <flux:button href="#" wire:navigate class="mt-4 w-full" variant="outline">
                Search Products
            </flux:button>
        </div>
    </div>

    <!-- Transaction History -->
    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
        <div class="text-center">
            <div class="mx-auto h-20 w-20 rounded-full bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                <flux:icon name="clock" class="h-10 w-10 text-purple-600 dark:text-purple-400" />
            </div>
            <h3 class="mt-4 text-lg font-semibold text-gray-900 dark:text-white">Transaction History</h3>
            <p class="mt-2 text-gray-600 dark:text-gray-400">View previous transactions and receipts</p>
            <flux:button href="#" wire:navigate class="mt-4 w-full" variant="outline">
                View History
            </flux:button>
        </div>
    </div>
</div>

<!-- Recent Transactions -->
<div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Transactions</h3>
        <flux:button href="#" wire:navigate size="sm" variant="outline">View All</flux:button>
    </div>
    
    <div class="overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 dark:bg-zinc-800">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Transaction ID</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Customer</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Items</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Time</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                <!-- Example transaction rows -->
                <tr>
                    <td class="px-4 py-4 text-sm font-medium text-gray-900 dark:text-white">#POS-001</td>
                    <td class="px-4 py-4 text-sm text-gray-600 dark:text-gray-400">Walk-in Customer</td>
                    <td class="px-4 py-4 text-sm text-gray-600 dark:text-gray-400">3 items</td>
                    <td class="px-4 py-4 text-sm font-medium text-gray-900 dark:text-white">LKR 45,500.00</td>
                    <td class="px-4 py-4 text-sm text-gray-600 dark:text-gray-400">{{ now()->subMinutes(30)->format('H:i A') }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-4 text-sm font-medium text-gray-900 dark:text-white">#POS-002</td>
                    <td class="px-4 py-4 text-sm text-gray-600 dark:text-gray-400">John Doe</td>
                    <td class="px-4 py-4 text-sm text-gray-600 dark:text-gray-400">1 item</td>
                    <td class="px-4 py-4 text-sm font-medium text-gray-900 dark:text-white">LKR 12,300.00</td>
                    <td class="px-4 py-4 text-sm text-gray-600 dark:text-gray-400">{{ now()->subHour()->format('H:i A') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Quick Tools -->
<div class="grid gap-6 lg:grid-cols-2">
    <!-- Payment Methods -->
    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Payment Methods</h3>
        <div class="grid gap-3 sm:grid-cols-2">
            <div class="flex items-center p-3 bg-gray-50 rounded-lg dark:bg-zinc-800">
                <flux:icon name="banknotes" class="h-6 w-6 text-green-600" />
                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-white">Cash</span>
            </div>
            <div class="flex items-center p-3 bg-gray-50 rounded-lg dark:bg-zinc-800">
                <flux:icon name="credit-card" class="h-6 w-6 text-blue-600" />
                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-white">Card</span>
            </div>
            <div class="flex items-center p-3 bg-gray-50 rounded-lg dark:bg-zinc-800">
                <flux:icon name="device-phone-mobile" class="h-6 w-6 text-purple-600" />
                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-white">Mobile Pay</span>
            </div>
            <div class="flex items-center p-3 bg-gray-50 rounded-lg dark:bg-zinc-800">
                <flux:icon name="gift" class="h-6 w-6 text-yellow-600" />
                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-white">Store Credit</span>
            </div>
        </div>
    </div>

    <!-- Shift Information -->
    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Shift Information</h3>
        <div class="space-y-3">
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600 dark:text-gray-400">Shift Started:</span>
                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ now()->startOfDay()->format('H:i A') }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600 dark:text-gray-400">Hours Worked:</span>
                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ now()->diffInHours(now()->startOfDay()) }}h {{ now()->diffInMinutes(now()->startOfDay()) % 60 }}m</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600 dark:text-gray-400">Transactions:</span>
                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $myTransactions }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600 dark:text-gray-400">Total Sales:</span>
                <span class="text-sm font-medium text-gray-900 dark:text-white">LKR {{ number_format($myTransactionTotal, 2) }}</span>
            </div>
            <div class="pt-3 border-t border-gray-200 dark:border-gray-700">
                <flux:button href="#" wire:navigate class="w-full" variant="outline" size="sm">
                    End Shift Report
                </flux:button>
            </div>
        </div>
    </div>
</div>