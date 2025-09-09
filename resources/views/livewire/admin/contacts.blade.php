<div>
    <flux:header>
        <flux:heading size="xl">{{ __('Contact Management') }}</flux:heading>
        <flux:subheading>{{ __('Manage customer inquiries and support requests') }}</flux:subheading>
    </flux:header>

    <div class="space-y-6">
        <!-- Filters -->
        <div class="flex items-center gap-4">
            <flux:input 
                wire:model.live.debounce.300ms="search" 
                placeholder="{{ __('Search contacts...') }}"
                class="flex-1"
            />
            <flux:select wire:model.live="statusFilter" placeholder="All Status">
                <option value="">All Status</option>
                <option value="pending">Pending</option>
                <option value="replied">Replied</option>
                <option value="closed">Closed</option>
            </flux:select>
        </div>

        <!-- Contacts Table -->
        <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-zinc-50 dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                {{ __('Contact') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                {{ __('Subject') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                {{ __('Status') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                {{ __('Date') }}
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                {{ __('Actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @forelse($this->contacts as $contact)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <div class="text-sm font-medium text-zinc-900 dark:text-zinc-100">
                                            {{ $contact->name }}
                                        </div>
                                        <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                            {{ $contact->email }}
                                        </div>
                                        @if($contact->phone)
                                            <div class="text-xs text-zinc-400">
                                                {{ $contact->phone }}
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-zinc-900 dark:text-zinc-100 max-w-xs truncate">
                                        {{ $contact->subject }}
                                    </div>
                                    <div class="text-xs text-zinc-500 dark:text-zinc-400 max-w-xs truncate">
                                        {{ Str::limit($contact->message, 50) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <flux:badge 
                                        :color="$contact->status === 'pending' ? 'amber' : ($contact->status === 'replied' ? 'emerald' : 'zinc')"
                                        size="sm"
                                    >
                                        {{ ucfirst($contact->status) }}
                                    </flux:badge>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-zinc-900 dark:text-zinc-100">
                                        {{ $contact->created_at->format('M j, Y') }}
                                    </div>
                                    <div class="text-xs text-zinc-500 dark:text-zinc-400">
                                        {{ $contact->created_at->format('g:i A') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2">
                                        <flux:button 
                                            size="sm" 
                                            variant="ghost"
                                            wire:click="viewContact({{ $contact->id }})"
                                        >
                                            View
                                        </flux:button>
                                        
                                        @if($contact->status === 'pending')
                                            <flux:button 
                                                size="sm" 
                                                variant="primary"
                                                wire:click="updateStatus({{ $contact->id }}, 'replied')"
                                            >
                                                Mark Replied
                                            </flux:button>
                                        @elseif($contact->status === 'replied')
                                            <flux:button 
                                                size="sm" 
                                                variant="ghost"
                                                wire:click="updateStatus({{ $contact->id }}, 'closed')"
                                            >
                                                Close
                                            </flux:button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-zinc-500 dark:text-zinc-400">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 mb-4 text-zinc-300 dark:text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                        </svg>
                                        <p class="text-lg font-medium">No contacts found</p>
                                        <p class="text-sm">{{ $search ? 'Try adjusting your search.' : 'Contact messages will appear here.' }}</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($this->contacts->hasPages())
                <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-700">
                    {{ $this->contacts->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Contact Detail Modal -->
    @if($showModal && $selectedContact)
        <flux:modal wire:model="showModal" class="max-w-4xl">
            <div class="space-y-6">
                <!-- Header -->
                <div>
                    <flux:heading size="lg">Contact Details</flux:heading>
                </div>

                <!-- Contact Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <flux:field>
                            <flux:label>Name</flux:label>
                            <flux:input value="{{ $selectedContact->name }}" readonly />
                        </flux:field>
                    </div>
                    <div>
                        <flux:field>
                            <flux:label>Email</flux:label>
                            <flux:input value="{{ $selectedContact->email }}" readonly />
                        </flux:field>
                    </div>
                    @if($selectedContact->phone)
                    <div>
                        <flux:field>
                            <flux:label>Phone</flux:label>
                            <flux:input value="{{ $selectedContact->phone }}" readonly />
                        </flux:field>
                    </div>
                    @endif
                    <div>
                        <flux:field>
                            <flux:label>Status</flux:label>
                            <flux:badge 
                                :color="$selectedContact->status === 'pending' ? 'amber' : ($selectedContact->status === 'replied' ? 'emerald' : 'zinc')"
                            >
                                {{ ucfirst($selectedContact->status) }}
                            </flux:badge>
                        </flux:field>
                    </div>
                </div>

                <!-- Subject & Message -->
                <div>
                    <flux:field>
                        <flux:label>Subject</flux:label>
                        <flux:input value="{{ $selectedContact->subject }}" readonly />
                    </flux:field>
                </div>

                <div>
                    <flux:field>
                        <flux:label>Message</flux:label>
                        <flux:textarea readonly rows="4">{{ $selectedContact->message }}</flux:textarea>
                    </flux:field>
                </div>

                <!-- Metadata -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                    <div>
                        <flux:field>
                            <flux:label>Submitted At</flux:label>
                            <flux:input value="{{ $selectedContact->created_at->format('F j, Y at g:i A') }}" readonly />
                        </flux:field>
                    </div>
                    @if($selectedContact->replied_at)
                    <div>
                        <flux:field>
                            <flux:label>Replied At</flux:label>
                            <flux:input value="{{ $selectedContact->replied_at->format('F j, Y at g:i A') }}" readonly />
                        </flux:field>
                    </div>
                    @endif
                </div>

                @if($selectedContact->repliedBy)
                <div>
                    <flux:field>
                        <flux:label>Replied By</flux:label>
                        <flux:input value="{{ $selectedContact->repliedBy->name }}" readonly />
                    </flux:field>
                </div>
                @endif

                <!-- Admin Reply Section -->
                <div class="pt-4 border-t border-zinc-200 dark:border-zinc-700">
                    <flux:field>
                        <flux:label>Admin Reply</flux:label>
                        <flux:textarea 
                            wire:model="adminReply" 
                            rows="4" 
                            placeholder="Type your reply here..."
                        ></flux:textarea>
                    </flux:field>
                </div>

                <!-- Footer Actions -->
                <div class="flex gap-2 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                    <flux:spacer />
                    <flux:button variant="ghost" wire:click="closeModal">Close</flux:button>
                    <flux:button variant="primary" wire:click="saveReply">Save Reply</flux:button>
                </div>
            </div>
        </flux:modal>
    @endif
</div>
