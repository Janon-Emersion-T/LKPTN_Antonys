
<div>
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Category Management</h1>
                <p class="text-gray-600 dark:text-gray-400">Organize your product categories</p>
            </div>
            <flux:button wire:click="openCreateModal" variant="filled" icon="plus">
                Add Category
            </flux:button>
        </div>
        
        <!-- Flash Messages -->
        @if (session('message'))
            <div class="rounded-lg bg-green-50 border border-green-200 p-4 dark:bg-green-900/20 dark:border-green-700">
                <div class="flex items-center">
                    <flux:icon name="check-circle" class="h-5 w-5 text-green-600 dark:text-green-400" />
                    <p class="ml-3 text-green-800 dark:text-green-200">{{ session('message') }}</p>
                </div>
            </div>
        @endif
        
        @if (session('error'))
            <div class="rounded-lg bg-red-50 border border-red-200 p-4 dark:bg-red-900/20 dark:border-red-700">
                <div class="flex items-center">
                    <flux:icon name="exclamation-circle" class="h-5 w-5 text-red-600 dark:text-red-400" />
                    <p class="ml-3 text-red-800 dark:text-red-200">{{ session('error') }}</p>
                </div>
            </div>
        @endif
        
        <!-- Filters -->
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
            <div class="grid gap-4 md:grid-cols-3">
                <div>
                    <flux:input 
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search categories..."
                        icon="magnifying-glass"
                    />
                </div>
                <div>
                    <flux:select wire:model.live="filterStatus">
                        <option value="all">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </flux:select>
                </div>
                <div class="flex justify-end">
                    <flux:button wire:click="$set('search', '')" variant="outline" size="sm">
                        Clear Filters
                    </flux:button>
                </div>
            </div>
        </div>
        
        <!-- Categories Table -->
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-neutral-200 dark:border-neutral-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-zinc-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                <button wire:click="sortBy('name')" class="group inline-flex items-center">
                                    Category Name
                                    <flux:icon name="chevron-up-down" class="ml-1 h-4 w-4" />
                                </button>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Parent Category
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Products Count
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                <button wire:click="sortBy('sort_order')" class="group inline-flex items-center">
                                    Sort Order
                                    <flux:icon name="chevron-up-down" class="ml-1 h-4 w-4" />
                                </button>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-zinc-900 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($this->categories as $category)
                            <tr wire:key="category-{{ $category->id }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $category->name }}</div>
                                            @if($category->description)
                                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ Str::limit($category->description, 50) }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    {{ $category->parent?->name ?? 'Root Category' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    {{ $category->products_count ?? 0 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    {{ $category->sort_order ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button wire:click="toggleStatus({{ $category->id }})" class="inline-flex items-center">
                                        @if($category->is_active)
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300">
                                                Active
                                            </span>
                                        @else
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-300">
                                                Inactive
                                            </span>
                                        @endif
                                    </button>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <flux:button wire:click="openEditModal({{ $category->id }})" size="sm" variant="outline" icon="pencil">
                                            Edit
                                        </flux:button>
                                        <flux:button 
                                            wire:click="deleteCategory({{ $category->id }})" 
                                            wire:confirm="Are you sure you want to delete this category?"
                                            size="sm" 
                                            variant="outline" 
                                            icon="trash"
                                            class="text-red-600 hover:text-red-700">
                                            Delete
                                        </flux:button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <flux:icon name="tag" class="h-12 w-12 text-gray-400 mb-4" />
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No categories found</h3>
                                        <p class="text-gray-500 dark:text-gray-400 mb-4">Get started by creating your first category.</p>
                                        <flux:button wire:click="openCreateModal" variant="filled" icon="plus">
                                            Add Category
                                        </flux:button>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($this->categories->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $this->categories->links() }}
                </div>
            @endif
        </div>
    </div>
    
    <!-- Create/Edit Modal -->
    <flux:modal wire:model="showingModal" class="space-y-6">
        <div>
            <flux:heading size="lg">
                {{ $editingCategory ? 'Edit Category' : 'Create Category' }}
            </flux:heading>
            <flux:subheading>
                {{ $editingCategory ? 'Update category information' : 'Add a new product category' }}
            </flux:subheading>
        </div>
        
        <form wire:submit="save" class="space-y-6">
            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <flux:field>
                        <flux:label>Category Name</flux:label>
                        <flux:input wire:model="name" placeholder="Enter category name" required />
                        <flux:error name="name" />
                    </flux:field>
                </div>
                
                <div>
                    <flux:field>
                        <flux:label>Parent Category</flux:label>
                        <flux:select wire:model="parent_id">
                            <option value="">Root Category</option>
                            @foreach($this->parentCategories as $parent)
                                <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                            @endforeach
                        </flux:select>
                        <flux:error name="parent_id" />
                    </flux:field>
                </div>
                
                <div>
                    <flux:field>
                        <flux:label>Sort Order</flux:label>
                        <flux:input wire:model="sort_order" type="number" placeholder="0" />
                        <flux:error name="sort_order" />
                    </flux:field>
                </div>
                
                <div class="flex items-center">
                    <flux:checkbox wire:model="is_active">Active</flux:checkbox>
                </div>
            </div>
            
            <div>
                <flux:field>
                    <flux:label>Description</flux:label>
                    <flux:textarea wire:model="description" placeholder="Category description (optional)" rows="3" />
                    <flux:error name="description" />
                </flux:field>
            </div>
            
            <div>
                <flux:field>
                    <flux:label>Category Image</flux:label>
                    <flux:input wire:model="image" type="file" accept="image/*" />
                    <flux:error name="image" />
                    @if($editingCategory && $editingCategory->image)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $editingCategory->image) }}" alt="Current category image" class="h-20 w-20 object-cover rounded">
                        </div>
                    @endif
                </flux:field>
            </div>
            
            <div class="flex justify-between">
                <flux:button type="button" wire:click="closeModal" variant="outline">
                    Cancel
                </flux:button>
                <flux:button type="submit" variant="filled">
                    {{ $editingCategory ? 'Update Category' : 'Create Category' }}
                </flux:button>
            </div>
        </form>
    </flux:modal>
    </div>
</div>
