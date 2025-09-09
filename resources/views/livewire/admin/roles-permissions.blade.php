<div>
    <flux:header>
        <flux:heading size="xl">{{ __('Roles & Permissions') }}</flux:heading>
        <flux:subheading>{{ __('Manage user roles and permissions') }}</flux:subheading>
    </flux:header>

    <div class="space-y-6">
        <!-- Roles Section -->
        <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700">
            <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100">
                    {{ __('User Roles') }}
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($this->roles as $role)
                        <div wire:key="role-{{ $role->id }}" class="p-4 border border-zinc-200 dark:border-zinc-700 rounded-lg">
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="text-sm font-medium text-zinc-900 dark:text-zinc-100 capitalize">
                                    {{ str_replace('-', ' ', $role->name) }}
                                </h4>
                                <flux:badge variant="outline" size="sm">
                                    {{ $role->users_count }} {{ __('users') }}
                                </flux:badge>
                            </div>
                            
                            <div class="text-xs text-zinc-500 dark:text-zinc-400 mb-2">
                                {{ __('Permissions:') }}
                            </div>
                            
                            <div class="space-y-1 max-h-32 overflow-y-auto">
                                @forelse($role->permissions as $permission)
                                    <div class="text-xs text-zinc-600 dark:text-zinc-300">
                                        • {{ $permission->name }}
                                    </div>
                                @empty
                                    <div class="text-xs text-zinc-400 italic">
                                        {{ __('No specific permissions') }}
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- System Permissions Section -->
        <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700">
            <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100">
                    {{ __('System Permissions') }}
                </h3>
                <div class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                    {{ __('Available permissions in the system') }}
                </div>
            </div>
            <div class="p-6">
                @if($this->permissions->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
                        @foreach($this->permissions as $permission)
                            <div wire:key="permission-{{ $permission->id }}" class="flex items-center gap-2 p-2 text-sm text-zinc-600 dark:text-zinc-300">
                                <flux:icon name="shield-check" class="w-4 h-4 text-zinc-400" />
                                {{ $permission->name }}
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-zinc-500 dark:text-zinc-400">
                        {{ __('No permissions defined') }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Role Descriptions -->
        <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700">
            <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100">
                    {{ __('Role Descriptions') }}
                </h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-medium text-zinc-900 dark:text-zinc-100 mb-2">{{ __('Administrative Roles') }}</h4>
                            <div class="space-y-3 text-sm text-zinc-600 dark:text-zinc-300">
                                <div>
                                    <span class="font-medium">{{ __('Super Admin:') }}</span>
                                    {{ __('Full system access and control') }}
                                </div>
                                <div>
                                    <span class="font-medium">{{ __('Admin:') }}</span>
                                    {{ __('Administrative access to most features') }}
                                </div>
                                <div>
                                    <span class="font-medium">{{ __('Manager:') }}</span>
                                    {{ __('Management level access and reporting') }}
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h4 class="font-medium text-zinc-900 dark:text-zinc-100 mb-2">{{ __('Operational Roles') }}</h4>
                            <div class="space-y-3 text-sm text-zinc-600 dark:text-zinc-300">
                                <div>
                                    <span class="font-medium">{{ __('Cashier:') }}</span>
                                    {{ __('Point of sale and transaction processing') }}
                                </div>
                                <div>
                                    <span class="font-medium">{{ __('Inventory Manager:') }}</span>
                                    {{ __('Stock management and supplier relations') }}
                                </div>
                                <div>
                                    <span class="font-medium">{{ __('Sales Representative:') }}</span>
                                    {{ __('Customer relations and sales pipeline') }}
                                </div>
                                <div>
                                    <span class="font-medium">{{ __('Customer Support:') }}</span>
                                    {{ __('Customer service and support tickets') }}
                                </div>
                                <div>
                                    <span class="font-medium">{{ __('Customer:') }}</span>
                                    {{ __('End-user shopping and account access') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
