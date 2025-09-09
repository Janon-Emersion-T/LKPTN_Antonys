<!-- Customer Support Dashboard -->
@php
    // Get customer support statistics
    $totalTickets = 0; // Would be from tickets table
    $openTickets = 0; // Would be from tickets table
    $resolvedToday = 0; // Would be from tickets table
    $avgResponseTime = '2.5 hrs'; // Example
    $totalCustomers = \App\Models\User::whereHas('roles', function($q) {
        $q->where('name', 'customer');
    })->count();
@endphp

<!-- Support Metrics -->
<div class="grid gap-4 md:grid-cols-5">
    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
        <div class="flex items-center">
            <flux:icon name="ticket" class="h-8 w-8 text-blue-600" />
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Tickets</p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($totalTickets) }}</p>
            </div>
        </div>
    </div>

    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
        <div class="flex items-center">
            <flux:icon name="exclamation-circle" class="h-8 w-8 text-yellow-600" />
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Open Tickets</p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($openTickets) }}</p>
            </div>
        </div>
    </div>

    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
        <div class="flex items-center">
            <flux:icon name="check-circle" class="h-8 w-8 text-green-600" />
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Resolved Today</p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($resolvedToday) }}</p>
            </div>
        </div>
    </div>

    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
        <div class="flex items-center">
            <flux:icon name="clock" class="h-8 w-8 text-purple-600" />
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Avg Response</p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $avgResponseTime }}</p>
            </div>
        </div>
    </div>

    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
        <div class="flex items-center">
            <flux:icon name="user-group" class="h-8 w-8 text-indigo-600" />
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Customers</p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($totalCustomers) }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Support Tools -->
<div class="grid gap-6 lg:grid-cols-4">
    <div class="rounded-xl border border-neutral-200 bg-white p-6 text-center dark:border-neutral-700 dark:bg-zinc-900">
        <flux:icon name="inbox" class="mx-auto h-12 w-12 text-blue-600" />
        <h3 class="mt-4 text-lg font-semibold text-gray-900 dark:text-white">Ticket Queue</h3>
        <p class="mt-2 text-gray-600 dark:text-gray-400">Manage support tickets</p>
        <flux:button href="#" wire:navigate class="mt-4 w-full">
            View Tickets ({{ $openTickets }})
        </flux:button>
    </div>

    <div class="rounded-xl border border-neutral-200 bg-white p-6 text-center dark:border-neutral-700 dark:bg-zinc-900">
        <flux:icon name="chat-bubble-left-right" class="mx-auto h-12 w-12 text-green-600" />
        <h3 class="mt-4 text-lg font-semibold text-gray-900 dark:text-white">Live Chat</h3>
        <p class="mt-2 text-gray-600 dark:text-gray-400">Real-time customer support</p>
        <flux:button href="#" wire:navigate class="mt-4 w-full" variant="outline">
            Start Chat
        </flux:button>
    </div>

    <div class="rounded-xl border border-neutral-200 bg-white p-6 text-center dark:border-neutral-700 dark:bg-zinc-900">
        <flux:icon name="book-open" class="mx-auto h-12 w-12 text-purple-600" />
        <h3 class="mt-4 text-lg font-semibold text-gray-900 dark:text-white">Knowledge Base</h3>
        <p class="mt-2 text-gray-600 dark:text-gray-400">Access help articles and FAQs</p>
        <flux:button href="#" wire:navigate class="mt-4 w-full" variant="outline">
            Browse Articles
        </flux:button>
    </div>

    <div class="rounded-xl border border-neutral-200 bg-white p-6 text-center dark:border-neutral-700 dark:bg-zinc-900">
        <flux:icon name="phone" class="mx-auto h-12 w-12 text-yellow-600" />
        <h3 class="mt-4 text-lg font-semibold text-gray-900 dark:text-white">Customer Calls</h3>
        <p class="mt-2 text-gray-600 dark:text-gray-400">Handle phone support</p>
        <flux:button href="#" wire:navigate class="mt-4 w-full" variant="outline">
            Call Center
        </flux:button>
    </div>
</div>

<!-- Recent Tickets -->
<div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Tickets</h3>
        <flux:button href="#" wire:navigate size="sm" variant="outline">View All</flux:button>
    </div>
    
    <div class="space-y-4">
        <!-- Example ticket entries -->
        <div class="flex items-center justify-between p-4 bg-red-50 border border-red-200 rounded-lg dark:bg-red-900/20 dark:border-red-800">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <flux:icon name="exclamation-circle" class="h-5 w-5 text-red-600" />
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-900 dark:text-red-200">Urgent: Payment Gateway Error</p>
                    <p class="text-xs text-red-700 dark:text-red-300">Customer: john@example.com • #TICKET-001</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-xs text-red-600 dark:text-red-400">5 min ago</p>
                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300">
                    High Priority
                </span>
            </div>
        </div>

        <div class="flex items-center justify-between p-4 bg-yellow-50 border border-yellow-200 rounded-lg dark:bg-yellow-900/20 dark:border-yellow-800">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <flux:icon name="question-mark-circle" class="h-5 w-5 text-yellow-600" />
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-yellow-900 dark:text-yellow-200">Product Information Request</p>
                    <p class="text-xs text-yellow-700 dark:text-yellow-300">Customer: jane@example.com • #TICKET-002</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-xs text-yellow-600 dark:text-yellow-400">1 hour ago</p>
                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300">
                    Normal
                </span>
            </div>
        </div>

        <div class="flex items-center justify-between p-4 bg-green-50 border border-green-200 rounded-lg dark:bg-green-900/20 dark:border-green-800">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <flux:icon name="check-circle" class="h-5 w-5 text-green-600" />
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-900 dark:text-green-200">Shipping Inquiry - Resolved</p>
                    <p class="text-xs text-green-700 dark:text-green-300">Customer: mike@example.com • #TICKET-003</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-xs text-green-600 dark:text-green-400">2 hours ago</p>
                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300">
                    Resolved
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Performance & Resources -->
<div class="grid gap-6 lg:grid-cols-2">
    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Performance Metrics</h3>
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600 dark:text-gray-400">Tickets Resolved Today</span>
                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $resolvedToday }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600 dark:text-gray-400">Average Resolution Time</span>
                <span class="text-sm font-medium text-gray-900 dark:text-white">4.2 hours</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600 dark:text-gray-400">Customer Satisfaction</span>
                <span class="text-sm font-medium text-green-600 dark:text-green-400">96%</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600 dark:text-gray-400">First Contact Resolution</span>
                <span class="text-sm font-medium text-blue-600 dark:text-blue-400">78%</span>
            </div>
        </div>
    </div>

    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Resources</h3>
        <div class="space-y-3">
            <flux:button href="#" wire:navigate class="w-full justify-start" size="sm">
                <flux:icon name="document-text" class="h-4 w-4 mr-2" />
                Common Issues Guide
            </flux:button>
            <flux:button href="#" wire:navigate class="w-full justify-start" size="sm" variant="outline">
                <flux:icon name="phone" class="h-4 w-4 mr-2" />
                Escalation Contacts
            </flux:button>
            <flux:button href="#" wire:navigate class="w-full justify-start" size="sm" variant="outline">
                <flux:icon name="cog-6-tooth" class="h-4 w-4 mr-2" />
                System Status
            </flux:button>
            <flux:button href="#" wire:navigate class="w-full justify-start" size="sm" variant="outline">
                <flux:icon name="chart-bar" class="h-4 w-4 mr-2" />
                Support Analytics
            </flux:button>
        </div>
    </div>
</div>