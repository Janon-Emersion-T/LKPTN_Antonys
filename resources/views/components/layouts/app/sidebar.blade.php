<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">
                @php
                    $user = auth()->user();
                    $userRoles = $user->roles->pluck('name')->toArray();
                @endphp
                
                <flux:navlist.group :heading="__('Platform')" class="grid">
                    <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                </flux:navlist.group>

                @if(in_array('super-admin', $userRoles) || in_array('admin', $userRoles))
                    <!-- Super Admin / Admin Menu -->
                    <flux:navlist.group :heading="__('Administration')" class="grid">
                        <flux:navlist.item icon="users" :href="route('dashboard.users')" :current="request()->routeIs('dashboard.users')" wire:navigate>{{ __('User Management') }}</flux:navlist.item>
                        <flux:navlist.item icon="envelope" :href="route('dashboard.contacts')" :current="request()->routeIs('dashboard.contacts')" wire:navigate>{{ __('Contact Management') }}</flux:navlist.item>
                        <flux:navlist.item icon="cog-6-tooth" :href="route('dashboard.settings')" :current="request()->routeIs('dashboard.settings')" wire:navigate>{{ __('System Settings') }}</flux:navlist.item>
                        <flux:navlist.item icon="chart-bar" :href="route('dashboard.analytics')" :current="request()->routeIs('dashboard.analytics')" wire:navigate>{{ __('Analytics & Reports') }}</flux:navlist.item>
                        <flux:navlist.item icon="shield-check" :href="route('dashboard.roles')" :current="request()->routeIs('dashboard.roles')" wire:navigate>{{ __('Roles & Permissions') }}</flux:navlist.item>
                    </flux:navlist.group>
                    
                    <flux:navlist.group :heading="__('Point of Sale')" class="grid">
                        <flux:navlist.item icon="calculator" :href="route('pos')" :current="request()->routeIs('pos')" target="_blank">{{ __('POS Terminal') }}</flux:navlist.item>
                        <flux:navlist.item icon="document-text" :href="route('pos.transactions')" :current="request()->routeIs('pos.transactions')" wire:navigate>{{ __('Transactions') }}</flux:navlist.item>
                    </flux:navlist.group>
                    
                    <flux:navlist.group :heading="__('Inventory')" class="grid">
                        <flux:navlist.item icon="cube" :href="route('dashboard.products')" :current="request()->routeIs('dashboard.products')" wire:navigate>{{ __('Products') }}</flux:navlist.item>
                        <flux:navlist.item icon="tag" :href="route('dashboard.categories')" :current="request()->routeIs('dashboard.categories')" wire:navigate>{{ __('Categories') }}</flux:navlist.item>
                        <flux:navlist.item icon="building-storefront" :href="route('dashboard.brands')" :current="request()->routeIs('dashboard.brands')" wire:navigate>{{ __('Brands') }}</flux:navlist.item>
                    </flux:navlist.group>
                @endif

                @if(in_array('manager', $userRoles) && !in_array('super-admin', $userRoles) && !in_array('admin', $userRoles))
                    <!-- Manager Menu -->
                    <flux:navlist.group :heading="__('Management')" class="grid">
                        <flux:navlist.item icon="chart-bar" :href="route('dashboard.analytics')" :current="request()->routeIs('dashboard.analytics')" wire:navigate>{{ __('Analytics & Reports') }}</flux:navlist.item>
                        <flux:navlist.item icon="document-text" :href="route('pos.transactions')" :current="request()->routeIs('pos.transactions')" wire:navigate>{{ __('Transactions') }}</flux:navlist.item>
                    </flux:navlist.group>
                @endif

                @if(in_array('cashier', $userRoles) && !in_array('super-admin', $userRoles) && !in_array('admin', $userRoles))
                    <!-- Cashier Menu -->
                    <flux:navlist.group :heading="__('Point of Sale')" class="grid">
                        <flux:navlist.item icon="calculator" :href="route('pos')" :current="request()->routeIs('pos')" target="_blank">{{ __('POS Terminal') }}</flux:navlist.item>
                        <flux:navlist.item icon="document-text" :href="route('pos.transactions')" :current="request()->routeIs('pos.transactions')" wire:navigate>{{ __('Transactions') }}</flux:navlist.item>
                    </flux:navlist.group>
                @endif

                @if(in_array('inventory-manager', $userRoles))
                    <!-- Inventory Manager Menu -->
                    <flux:navlist.group :heading="__('Inventory Management')" class="grid">
                        <flux:navlist.item icon="cube" href="#" wire:navigate>{{ __('Stock Management') }}</flux:navlist.item>
                        <flux:navlist.item icon="exclamation-triangle" href="#" wire:navigate>{{ __('Stock Alerts') }}</flux:navlist.item>
                        <flux:navlist.item icon="shopping-bag" href="#" wire:navigate>{{ __('Purchase Orders') }}</flux:navlist.item>
                        <flux:navlist.item icon="chart-bar" href="#" wire:navigate>{{ __('Inventory Reports') }}</flux:navlist.item>
                        <flux:navlist.item icon="truck" href="#" wire:navigate>{{ __('Suppliers') }}</flux:navlist.item>
                    </flux:navlist.group>
                @endif

                @if(in_array('sales-representative', $userRoles))
                    <!-- Sales Representative Menu -->
                    <flux:navlist.group :heading="__('Sales & CRM')" class="grid">
                        <flux:navlist.item icon="user-group" href="#" wire:navigate>{{ __('My Customers') }}</flux:navlist.item>
                        <flux:navlist.item icon="phone" href="#" wire:navigate>{{ __('Call List') }}</flux:navlist.item>
                        <flux:navlist.item icon="document-text" href="#" wire:navigate>{{ __('Quotes & Proposals') }}</flux:navlist.item>
                        <flux:navlist.item icon="envelope" href="#" wire:navigate>{{ __('Email Campaigns') }}</flux:navlist.item>
                        <flux:navlist.item icon="chart-line" href="#" wire:navigate>{{ __('Sales Pipeline') }}</flux:navlist.item>
                    </flux:navlist.group>
                @endif

                @if(in_array('customer-support', $userRoles))
                    <!-- Customer Support Menu -->
                    <flux:navlist.group :heading="__('Customer Support')" class="grid">
                        <flux:navlist.item icon="inbox" href="#" wire:navigate>{{ __('Ticket Queue') }}</flux:navlist.item>
                        <flux:navlist.item icon="chat-bubble-left-right" href="#" wire:navigate>{{ __('Live Chat') }}</flux:navlist.item>
                        <flux:navlist.item icon="phone" href="#" wire:navigate>{{ __('Call Center') }}</flux:navlist.item>
                        <flux:navlist.item icon="book-open" href="#" wire:navigate>{{ __('Knowledge Base') }}</flux:navlist.item>
                    </flux:navlist.group>
                @endif

                <!-- Common Menu Items -->
                <flux:navlist.group :heading="__('General')" class="grid">
                    <flux:navlist.item icon="globe-alt" :href="route('home')" target="_blank">{{ __('View Storefront') }}</flux:navlist.item>
                    <flux:navlist.item icon="cog-6-tooth" :href="route('settings.profile')" :current="request()->routeIs('settings.*')" wire:navigate>{{ __('Settings') }}</flux:navlist.item>
                </flux:navlist.group>
            </flux:navlist>

            <flux:spacer />

            

            <!-- Desktop User Menu -->
            <flux:dropdown class="hidden lg:block" position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon:trailing="chevrons-up-down"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts
    </body>
</html>
