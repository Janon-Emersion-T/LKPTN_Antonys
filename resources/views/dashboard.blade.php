<x-layouts.app :title="__('Dashboard')">
    @php
        $user = auth()->user();
        $userRoles = $user->roles->pluck('name')->toArray();
        $primaryRole = $userRoles[0] ?? 'customer';
    @endphp

    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Welcome Header -->
        <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                        Welcome back, {{ $user->name }}!
                    </h1>
                    <p class="mt-1 text-gray-600 dark:text-gray-400">
                        {{ ucfirst(str_replace('-', ' ', $primaryRole)) }} Dashboard
                    </p>
                </div>
                <div class="text-right">
                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ now()->format('F j, Y') }}</div>
                    <div class="text-xs text-gray-400 dark:text-gray-500">{{ now()->format('l, g:i A') }}</div>
                </div>
            </div>
        </div>

        @if(in_array('super-admin', $userRoles) || in_array('admin', $userRoles))
            <!-- Super Admin / Admin Dashboard -->
            @include('dashboard.super-admin')
        @elseif(in_array('manager', $userRoles))
            <!-- Manager Dashboard -->
            @include('dashboard.manager')
        @elseif(in_array('cashier', $userRoles))
            <!-- Cashier Dashboard -->
            @include('dashboard.cashier')
        @elseif(in_array('inventory-manager', $userRoles))
            <!-- Inventory Manager Dashboard -->
            @include('dashboard.inventory-manager')
        @elseif(in_array('sales-representative', $userRoles))
            <!-- Sales Representative Dashboard -->
            @include('dashboard.sales-representative')
        @elseif(in_array('customer-support', $userRoles))
            <!-- Customer Support Dashboard -->
            @include('dashboard.customer-support')
        @else
            <!-- Default Dashboard for Unknown Roles -->
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div class="rounded-xl border border-neutral-200 bg-white p-6 text-center dark:border-neutral-700 dark:bg-zinc-900">
                    <flux:icon name="user" class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" />
                    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Profile</h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">Manage your account settings</p>
                    <flux:button class="mt-4" href="{{ route('settings.profile') }}" wire:navigate>
                        View Profile
                    </flux:button>
                </div>
                
                <div class="rounded-xl border border-neutral-200 bg-white p-6 text-center dark:border-neutral-700 dark:bg-zinc-900">
                    <flux:icon name="cog-6-tooth" class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" />
                    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Settings</h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">Configure your preferences</p>
                    <flux:button class="mt-4" href="{{ route('settings.profile') }}" wire:navigate>
                        Open Settings
                    </flux:button>
                </div>
                
                <div class="rounded-xl border border-neutral-200 bg-white p-6 text-center dark:border-neutral-700 dark:bg-zinc-900">
                    <flux:icon name="question-mark-circle" class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" />
                    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Help</h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">Get support and documentation</p>
                    <flux:button class="mt-4" href="#" wire:navigate>
                        Get Help
                    </flux:button>
                </div>
            </div>
        @endif
    </div>
</x-layouts.app>