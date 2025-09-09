<div>
    <flux:header>
        <flux:heading size="xl">{{ __('User Management') }}</flux:heading>
        <flux:subheading>{{ __('Manage system users and their roles') }}</flux:subheading>
        
        <x-slot:actions>
            <flux:button variant="primary" wire:click="$set('showCreateModal', true)">
                {{ __('Add User') }}
            </flux:button>
        </x-slot:actions>
    </flux:header>

    <div class="space-y-6">
        <!-- Filters -->
        <div class="flex items-center gap-4">
            <flux:input 
                wire:model.live.debounce.300ms="search" 
                placeholder="{{ __('Search users...') }}"
                class="flex-1"
            />
        </div>

        <!-- Users Table -->
        <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-zinc-50 dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                {{ __('User') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                {{ __('Email') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                {{ __('Roles') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                {{ __('Status') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                {{ __('Joined') }}
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                {{ __('Actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @forelse($this->users as $user)
                            <tr wire:key="user-{{ $user->id }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <flux:profile 
                                            :name="$user->name"
                                            :initials="$user->initials()"
                                            size="sm"
                                        />
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-zinc-900 dark:text-zinc-100">
                                                {{ $user->name }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-zinc-900 dark:text-zinc-100">{{ $user->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($user->roles as $role)
                                            <flux:badge variant="outline" size="sm">
                                                {{ $role->name }}
                                            </flux:badge>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <flux:badge 
                                        :variant="$user->email_verified_at ? 'success' : 'warning'"
                                        size="sm"
                                    >
                                        {{ $user->email_verified_at ? __('Active') : __('Pending') }}
                                    </flux:badge>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">
                                    {{ $user->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2">
                                        <flux:button 
                                            variant="subtle" 
                                            size="sm"
                                            wire:click="edit({{ $user->id }})"
                                        >
                                            {{ __('Edit') }}
                                        </flux:button>
                                        @if($user->id !== auth()->id())
                                            <flux:button 
                                                variant="danger" 
                                                size="sm"
                                                wire:click="delete({{ $user->id }})"
                                                wire:confirm="{{ __('Are you sure you want to delete this user?') }}"
                                            >
                                                {{ __('Delete') }}
                                            </flux:button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-zinc-500 dark:text-zinc-400">
                                    {{ __('No users found') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($this->users->hasPages())
            <div class="flex justify-center">
                {{ $this->users->links() }}
            </div>
        @endif
    </div>
</div>
