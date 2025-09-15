<div>
    <flux:header>
        <flux:heading size="xl">{{ __('User Management') }}</flux:heading>
        <flux:subheading>{{ __('Manage system users and their roles') }}</flux:subheading>
        
        <x-slot:actions>
            <flux:button variant="primary" wire:click="create">
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

    <!-- Create User Modal -->
    <flux:modal wire:model="showCreateModal" class="max-w-md">
        <div class="p-6">
            <flux:heading size="lg" class="mb-6">{{ __('Create New User') }}</flux:heading>

            <form wire:submit.prevent="save">
                <div class="space-y-4">
                    <flux:field>
                        <flux:label>{{ __('Name') }}</flux:label>
                        <flux:input wire:model="name" />
                        <flux:error name="name" />
                    </flux:field>

                    <flux:field>
                        <flux:label>{{ __('Email') }}</flux:label>
                        <flux:input type="email" wire:model="email" />
                        <flux:error name="email" />
                    </flux:field>

                    <flux:field>
                        <flux:label>{{ __('Role') }}</flux:label>
                        <flux:select wire:model="role">
                            <option value="customer">{{ __('Customer') }}</option>
                            <option value="admin">{{ __('Admin') }}</option>
                            <option value="super-admin">{{ __('Super Admin') }}</option>
                        </flux:select>
                        <flux:error name="role" />
                    </flux:field>

                    <flux:field>
                        <flux:label>{{ __('Password') }}</flux:label>
                        <flux:input type="password" wire:model="password" />
                        <flux:error name="password" />
                    </flux:field>

                    <flux:field>
                        <flux:label>{{ __('Confirm Password') }}</flux:label>
                        <flux:input type="password" wire:model="password_confirmation" />
                        <flux:error name="password_confirmation" />
                    </flux:field>
                </div>

                <div class="flex justify-end space-x-2 mt-6">
                    <flux:button variant="ghost" wire:click="closeModal">
                        {{ __('Cancel') }}
                    </flux:button>
                    <flux:button type="submit" variant="primary">
                        {{ __('Create User') }}
                    </flux:button>
                </div>
            </form>
        </div>
    </flux:modal>

    <!-- Edit User Modal -->
    <flux:modal wire:model="showEditModal" class="max-w-md">
        <div class="p-6">
            <flux:heading size="lg" class="mb-6">{{ __('Edit User') }}</flux:heading>

            <form wire:submit.prevent="save">
                <div class="space-y-4">
                    <flux:field>
                        <flux:label>{{ __('Name') }}</flux:label>
                        <flux:input wire:model="name" />
                        <flux:error name="name" />
                    </flux:field>

                    <flux:field>
                        <flux:label>{{ __('Email') }}</flux:label>
                        <flux:input type="email" wire:model="email" />
                        <flux:error name="email" />
                    </flux:field>

                    <flux:field>
                        <flux:label>{{ __('Role') }}</flux:label>
                        <flux:select wire:model="role">
                            <option value="customer">{{ __('Customer') }}</option>
                            <option value="admin">{{ __('Admin') }}</option>
                            <option value="super-admin">{{ __('Super Admin') }}</option>
                        </flux:select>
                        <flux:error name="role" />
                    </flux:field>

                    <flux:field>
                        <flux:label>{{ __('New Password (leave blank to keep current)') }}</flux:label>
                        <flux:input type="password" wire:model="password" />
                        <flux:error name="password" />
                    </flux:field>

                    <flux:field>
                        <flux:label>{{ __('Confirm New Password') }}</flux:label>
                        <flux:input type="password" wire:model="password_confirmation" />
                        <flux:error name="password_confirmation" />
                    </flux:field>
                </div>

                <div class="flex justify-end space-x-2 mt-6">
                    <flux:button variant="ghost" wire:click="closeModal">
                        {{ __('Cancel') }}
                    </flux:button>
                    <flux:button type="submit" variant="primary">
                        {{ __('Update User') }}
                    </flux:button>
                </div>
            </form>
        </div>
    </flux:modal>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="fixed top-4 right-4 z-50 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="fixed top-4 right-4 z-50 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg">
            {{ session('error') }}
        </div>
    @endif
</div>
