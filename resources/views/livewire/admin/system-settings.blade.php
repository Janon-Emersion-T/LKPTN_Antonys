<div>
    <flux:header>
        <flux:heading size="xl">{{ __('System Settings') }}</flux:heading>
        <flux:subheading>{{ __('Configure system-wide settings and preferences') }}</flux:subheading>
    </flux:header>

    <div class="space-y-6">
        @if (session('success'))
            <flux:callout variant="success">
                {{ session('success') }}
            </flux:callout>
        @endif

        <form wire:submit.prevent="save" class="space-y-6">
            <!-- General Settings -->
            <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
                <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100 mb-4">
                    {{ __('General Settings') }}
                </h3>
                
                <div class="space-y-4">
                    <flux:field>
                        <flux:label>{{ __('Site Name') }}</flux:label>
                        <flux:input 
                            wire:model="siteName" 
                            placeholder="{{ __('Enter site name') }}"
                        />
                        <flux:error name="siteName" />
                    </flux:field>

                    <flux:field>
                        <flux:label>{{ __('Site Description') }}</flux:label>
                        <flux:textarea 
                            wire:model="siteDescription" 
                            placeholder="{{ __('Enter site description') }}"
                            rows="3"
                        />
                        <flux:error name="siteDescription" />
                    </flux:field>
                </div>
            </div>

            <!-- System Options -->
            <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
                <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100 mb-4">
                    {{ __('System Options') }}
                </h3>
                
                <div class="space-y-4">
                    <flux:field>
                        <div class="flex items-center justify-between">
                            <div>
                                <flux:label>{{ __('Maintenance Mode') }}</flux:label>
                                <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                    {{ __('Put the site in maintenance mode') }}
                                </div>
                            </div>
                            <flux:switch wire:model="maintenanceMode" />
                        </div>
                    </flux:field>

                    <flux:field>
                        <div class="flex items-center justify-between">
                            <div>
                                <flux:label>{{ __('Allow Registration') }}</flux:label>
                                <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                    {{ __('Allow new users to register') }}
                                </div>
                            </div>
                            <flux:switch wire:model="allowRegistration" />
                        </div>
                    </flux:field>
                </div>
            </div>

            <!-- Email Settings -->
            <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
                <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100 mb-4">
                    {{ __('Email Settings') }}
                </h3>
                
                <div class="space-y-4">
                    <flux:field>
                        <flux:label>{{ __('From Email') }}</flux:label>
                        <flux:input 
                            type="email"
                            value="{{ config('mail.from.address') }}"
                            disabled
                        />
                        <div class="text-sm text-zinc-500 dark:text-zinc-400">
                            {{ __('Configured in environment variables') }}
                        </div>
                    </flux:field>

                    <flux:field>
                        <flux:label>{{ __('From Name') }}</flux:label>
                        <flux:input 
                            value="{{ config('mail.from.name') }}"
                            disabled
                        />
                        <div class="text-sm text-zinc-500 dark:text-zinc-400">
                            {{ __('Configured in environment variables') }}
                        </div>
                    </flux:field>
                </div>
            </div>

            <div class="flex justify-end">
                <flux:button type="submit" variant="primary">
                    {{ __('Save Settings') }}
                </flux:button>
            </div>
        </form>
    </div>
</div>
