<div>
    <flux:header>
        <div class="flex justify-between items-center">
            <div>
                <flux:heading size="xl">{{ __('POS Analytics & Reporting') }}</flux:heading>
                <flux:subheading>{{ __('Comprehensive sales analytics and performance metrics') }}</flux:subheading>
            </div>
            <flux:button 
                wire:click="exportAnalytics" 
                wire:loading.attr="disabled"
                wire:target="exportAnalytics"
                variant="primary"
                class="flex items-center gap-2"
            >
                <span wire:loading.remove wire:target="exportAnalytics">
                    <flux:icon name="arrow-down-tray" class="w-4 h-4" />
                </span>
                <span wire:loading wire:target="exportAnalytics">
                    <flux:icon name="arrow-path" class="w-4 h-4 animate-spin" />
                </span>
                {{ __('Export Report') }}
            </flux:button>
        </div>
    </flux:header>

    <div class="space-y-6">
        <!-- Filters -->
        <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <flux:field>
                        <flux:label>{{ __('Date Range') }}</flux:label>
                        <flux:select wire:model.live="dateRange">
                            <option value="today">{{ __('Today') }}</option>
                            <option value="7days">{{ __('Last 7 Days') }}</option>
                            <option value="30days">{{ __('Last 30 Days') }}</option>
                            <option value="90days">{{ __('Last 90 Days') }}</option>
                            <option value="1year">{{ __('Last Year') }}</option>
                        </flux:select>
                    </flux:field>
                </div>
                <div>
                    <flux:field>
                        <flux:label>{{ __('Terminal') }}</flux:label>
                        <flux:select wire:model.live="selectedTerminal">
                            <option value="all">{{ __('All Terminals') }}</option>
                            @foreach($this->terminals as $terminal)
                                <option value="{{ $terminal->id }}">{{ $terminal->name }}</option>
                            @endforeach
                        </flux:select>
                    </flux:field>
                </div>
                <div>
                    <flux:field>
                        <flux:label>{{ __('Compare to') }}</flux:label>
                        <flux:select wire:model.live="comparisonPeriod">
                            <option value="previous">{{ __('Previous Period') }}</option>
                        </flux:select>
                    </flux:field>
                </div>
            </div>
        </div>

        <!-- POS Key Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">
                            ${{ number_format($this->posStats['current']['total_sales'], 2) }}
                        </div>
                        <div class="text-sm text-zinc-500 dark:text-zinc-400">
                            {{ __('Total Sales') }}
                        </div>
                        @if($this->posStats['growth']['total_sales'] != 0)
                            <div class="text-xs mt-1 {{ $this->posStats['growth']['total_sales'] >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                {{ $this->posStats['growth']['total_sales'] >= 0 ? '+' : '' }}{{ $this->posStats['growth']['total_sales'] }}%
                            </div>
                        @endif
                    </div>
                    <div class="p-3 bg-emerald-100 dark:bg-emerald-900/50 rounded-lg">
                        <flux:icon name="currency-dollar" class="w-6 h-6 text-emerald-600 dark:text-emerald-400" />
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">
                            {{ number_format($this->posStats['current']['total_transactions']) }}
                        </div>
                        <div class="text-sm text-zinc-500 dark:text-zinc-400">
                            {{ __('Transactions') }}
                        </div>
                        @if($this->posStats['growth']['total_transactions'] != 0)
                            <div class="text-xs mt-1 {{ $this->posStats['growth']['total_transactions'] >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                {{ $this->posStats['growth']['total_transactions'] >= 0 ? '+' : '' }}{{ $this->posStats['growth']['total_transactions'] }}%
                            </div>
                        @endif
                    </div>
                    <div class="p-3 bg-blue-100 dark:bg-blue-900/50 rounded-lg">
                        <flux:icon name="receipt-percent" class="w-6 h-6 text-blue-600 dark:text-blue-400" />
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">
                            ${{ number_format($this->posStats['current']['avg_transaction'], 2) }}
                        </div>
                        <div class="text-sm text-zinc-500 dark:text-zinc-400">
                            {{ __('Avg Transaction') }}
                        </div>
                        @if($this->posStats['growth']['avg_transaction'] != 0)
                            <div class="text-xs mt-1 {{ $this->posStats['growth']['avg_transaction'] >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                {{ $this->posStats['growth']['avg_transaction'] >= 0 ? '+' : '' }}{{ $this->posStats['growth']['avg_transaction'] }}%
                            </div>
                        @endif
                    </div>
                    <div class="p-3 bg-purple-100 dark:bg-purple-900/50 rounded-lg">
                        <flux:icon name="chart-bar" class="w-6 h-6 text-purple-600 dark:text-purple-400" />
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">
                            {{ number_format($this->posStats['current']['total_items_sold']) }}
                        </div>
                        <div class="text-sm text-zinc-500 dark:text-zinc-400">
                            {{ __('Items Sold') }}
                        </div>
                        @if($this->posStats['growth']['total_items_sold'] != 0)
                            <div class="text-xs mt-1 {{ $this->posStats['growth']['total_items_sold'] >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                {{ $this->posStats['growth']['total_items_sold'] >= 0 ? '+' : '' }}{{ $this->posStats['growth']['total_items_sold'] }}%
                            </div>
                        @endif
                    </div>
                    <div class="p-3 bg-orange-100 dark:bg-orange-900/50 rounded-lg">
                        <flux:icon name="cube" class="w-6 h-6 text-orange-600 dark:text-orange-400" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Methods & Hourly Stats -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Payment Methods Breakdown -->
            <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700">
                <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                    <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100">
                        {{ __('Payment Methods') }}
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @forelse($this->paymentMethodStats as $method => $stats)
                            @php
                                $total = collect($this->paymentMethodStats)->sum('amount');
                                $percentage = $total > 0 ? ($stats['amount'] / $total) * 100 : 0;
                            @endphp
                            <div wire:key="payment-method-{{ $method }}" class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-3 h-3 rounded-full {{ $method === 'cash' ? 'bg-green-500' : ($method === 'card' ? 'bg-blue-500' : 'bg-purple-500') }}"></div>
                                    <div>
                                        <div class="text-sm font-medium text-zinc-900 dark:text-zinc-100">
                                            {{ ucfirst($method) }}
                                        </div>
                                        <div class="text-xs text-zinc-500 dark:text-zinc-400">
                                            {{ $stats['count'] }} {{ __('transactions') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm font-medium text-zinc-900 dark:text-zinc-100">
                                        ${{ number_format($stats['amount'], 2) }}
                                    </div>
                                    <div class="text-xs text-zinc-500 dark:text-zinc-400">
                                        {{ number_format($percentage, 1) }}%
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-sm text-zinc-500 dark:text-zinc-400 text-center py-4">
                                {{ __('No payment data available') }}
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Hourly Sales Pattern -->
            <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700">
                <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                    <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100">
                        {{ __('Hourly Sales Pattern') }}
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-2">
                        @php
                            $maxSales = collect($this->hourlyStats)->max('sales');
                        @endphp
                        @for($hour = 0; $hour < 24; $hour++)
                            @php
                                $hourData = $this->hourlyStats[$hour] ?? ['transactions' => 0, 'sales' => 0];
                                $barWidth = $maxSales > 0 ? ($hourData['sales'] / $maxSales) * 100 : 0;
                            @endphp
                            <div class="flex items-center gap-3">
                                <div class="w-12 text-xs text-zinc-500 dark:text-zinc-400">
                                    {{ str_pad($hour, 2, '0') }}:00
                                </div>
                                <div class="flex-1 bg-zinc-100 dark:bg-zinc-800 rounded-full h-4 relative">
                                    @if($barWidth > 0)
                                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-full rounded-full transition-all duration-300"
                                             style="width: {{ $barWidth }}%"></div>
                                    @endif
                                </div>
                                <div class="w-16 text-xs text-right text-zinc-500 dark:text-zinc-400">
                                    ${{ number_format($hourData['sales'], 0) }}
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Products & Terminal Performance -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Top Selling Products -->
            <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700">
                <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                    <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100">
                        {{ __('Top Selling Products') }}
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @forelse($this->topProducts as $index => $product)
                            <div wire:key="top-product-{{ $index }}" class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-zinc-100 dark:bg-zinc-800 rounded-lg flex items-center justify-center text-xs font-medium text-zinc-600 dark:text-zinc-400">
                                    {{ $index + 1 }}
                                </div>
                                <div class="flex-1">
                                    <div class="text-sm font-medium text-zinc-900 dark:text-zinc-100">
                                        {{ $product->name }}
                                    </div>
                                    <div class="text-xs text-zinc-500 dark:text-zinc-400">
                                        {{ $product->total_quantity }} {{ __('sold') }} • ${{ number_format($product->price, 2) }} {{ __('each') }}
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm font-medium text-zinc-900 dark:text-zinc-100">
                                        ${{ number_format($product->total_revenue, 2) }}
                                    </div>
                                    <div class="text-xs text-zinc-500 dark:text-zinc-400">
                                        {{ __('revenue') }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-sm text-zinc-500 dark:text-zinc-400 text-center py-4">
                                {{ __('No product data available') }}
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Terminal Performance -->
            <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700">
                <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                    <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100">
                        {{ __('Terminal Performance') }}
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @forelse($this->terminalStats as $index => $terminal)
                            <div wire:key="terminal-{{ $index }}" class="flex items-center gap-3">
                                <div class="p-2 bg-blue-100 dark:bg-blue-900/50 rounded-lg">
                                    <flux:icon name="computer-desktop" class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                                </div>
                                <div class="flex-1">
                                    <div class="text-sm font-medium text-zinc-900 dark:text-zinc-100">
                                        {{ $terminal['terminal_name'] }}
                                    </div>
                                    <div class="text-xs text-zinc-500 dark:text-zinc-400">
                                        {{ $terminal['transactions'] }} {{ __('transactions') }} • ${{ number_format($terminal['avg_transaction'], 2) }} {{ __('avg') }}
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm font-medium text-zinc-900 dark:text-zinc-100">
                                        ${{ number_format($terminal['sales'], 2) }}
                                    </div>
                                    <div class="text-xs text-zinc-500 dark:text-zinc-400">
                                        {{ __('total sales') }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-sm text-zinc-500 dark:text-zinc-400 text-center py-4">
                                {{ __('No terminal data available') }}
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- System Stats (Existing) -->
        <div class="border-t border-zinc-200 dark:border-zinc-700 pt-6">
            <div class="mb-6">
                <h2 class="text-lg font-medium text-zinc-900 dark:text-zinc-100">{{ __('System Overview') }}</h2>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('General system statistics and recent activity') }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
                    <div class="flex items-center">
                        <div class="flex-1">
                            <div class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">
                                {{ number_format($this->stats['totalUsers']) }}
                            </div>
                            <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                {{ __('Total Users') }}
                            </div>
                        </div>
                        <div class="p-3 bg-blue-100 dark:bg-blue-900/50 rounded-lg">
                            <flux:icon name="users" class="w-6 h-6 text-blue-600 dark:text-blue-400" />
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
                    <div class="flex items-center">
                        <div class="flex-1">
                            <div class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">
                                {{ number_format($this->stats['totalProducts']) }}
                            </div>
                            <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                {{ __('Total Products') }}
                            </div>
                        </div>
                        <div class="p-3 bg-green-100 dark:bg-green-900/50 rounded-lg">
                            <flux:icon name="cube" class="w-6 h-6 text-green-600 dark:text-green-400" />
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
                    <div class="flex items-center">
                        <div class="flex-1">
                            <div class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">
                                {{ number_format($this->stats['totalCategories']) }}
                            </div>
                            <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                {{ __('Total Categories') }}
                            </div>
                        </div>
                        <div class="p-3 bg-purple-100 dark:bg-purple-900/50 rounded-lg">
                            <flux:icon name="tag" class="w-6 h-6 text-purple-600 dark:text-purple-400" />
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
                    <div class="flex items-center">
                        <div class="flex-1">
                            <div class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">
                                {{ number_format($this->stats['totalBrands']) }}
                            </div>
                            <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                {{ __('Total Brands') }}
                            </div>
                        </div>
                        <div class="p-3 bg-orange-100 dark:bg-orange-900/50 rounded-lg">
                            <flux:icon name="building-storefront" class="w-6 h-6 text-orange-600 dark:text-orange-400" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Users -->
                <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700">
                    <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                        <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100">
                            {{ __('Recent Users') }}
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @forelse($this->stats['recentUsers'] as $user)
                                <div wire:key="recent-user-{{ $user->id }}" class="flex items-center gap-3">
                                    <flux:profile 
                                        :name="$user->name"
                                        :initials="$user->initials()"
                                        size="sm"
                                    />
                                    <div class="flex-1">
                                        <div class="text-sm font-medium text-zinc-900 dark:text-zinc-100">
                                            {{ $user->name }}
                                        </div>
                                        <div class="text-xs text-zinc-500 dark:text-zinc-400">
                                            {{ $user->email }}
                                        </div>
                                    </div>
                                    <div class="text-xs text-zinc-500 dark:text-zinc-400">
                                        {{ $user->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            @empty
                                <div class="text-sm text-zinc-500 dark:text-zinc-400 text-center py-4">
                                    {{ __('No recent users') }}
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Recent Products -->
                <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700">
                    <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                        <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100">
                            {{ __('Recent Products') }}
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @forelse($this->stats['recentProducts'] as $product)
                                <div wire:key="recent-product-{{ $product->id }}" class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-zinc-100 dark:bg-zinc-800 rounded-lg flex items-center justify-center">
                                        <flux:icon name="cube" class="w-5 h-5 text-zinc-600 dark:text-zinc-400" />
                                    </div>
                                    <div class="flex-1">
                                        <div class="text-sm font-medium text-zinc-900 dark:text-zinc-100">
                                            {{ $product->name }}
                                        </div>
                                        <div class="text-xs text-zinc-500 dark:text-zinc-400">
                                            {{ $product->category?->name }} • {{ $product->brand?->name }}
                                        </div>
                                    </div>
                                    <div class="text-xs text-zinc-500 dark:text-zinc-400">
                                        {{ $product->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            @empty
                                <div class="text-sm text-zinc-500 dark:text-zinc-400 text-center py-4">
                                    {{ __('No recent products') }}
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
