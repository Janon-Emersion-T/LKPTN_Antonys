
<div>
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Product Management</h1>
                <p class="text-gray-600 dark:text-gray-400">Manage your product inventory</p>
            </div>
            <div class="flex space-x-2">
                <!-- Bulk Barcode Print Form -->
                <form method="POST" action="{{ route('dashboard.barcodes.bulk-print') }}" target="_blank" id="bulk-barcode-form" class="hidden">
                    @csrf
                    <input type="hidden" name="quantity" value="1" id="bulk-quantity">
                </form>
                
                <flux:button 
                    onclick="printBulkBarcodes()" 
                    variant="outline" 
                    icon="printer"
                    class="text-blue-600 hover:text-blue-700"
                    title="Print all barcodes for products with barcodes">
                    Print All Barcodes
                </flux:button>
                
                <flux:button wire:click="openCreateModal" variant="filled" icon="plus">
                    Add Product
                </flux:button>
            </div>
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
                    <flux:icon name="x-circle" class="h-5 w-5 text-red-600 dark:text-red-400" />
                    <p class="ml-3 text-red-800 dark:text-red-200">{{ session('error') }}</p>
                </div>
            </div>
        @endif
        
        <!-- Filters -->
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
            <div class="grid gap-4 md:grid-cols-5">
                <div>
                    <flux:input 
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search products..."
                        icon="magnifying-glass"
                    />
                </div>
                <div>
                    <flux:select wire:model.live="filterStatus">
                        <option value="all">All Status</option>
                        <option value="published">Published</option>
                        <option value="draft">Draft</option>
                        <option value="archived">Archived</option>
                    </flux:select>
                </div>
                <div>
                    <flux:select wire:model.live="filterCategory">
                        <option value="">All Categories</option>
                        @foreach($this->categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </flux:select>
                </div>
                <div>
                    <flux:select wire:model.live="filterBrand">
                        <option value="">All Brands</option>
                        @foreach($this->brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </flux:select>
                </div>
                <div class="flex justify-end">
                    <flux:button wire:click="$set('search', '')" variant="outline" size="sm">
                        Clear Filters
                    </flux:button>
                </div>
            </div>
        </div>
        
        <!-- Products Table -->
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-neutral-200 dark:border-neutral-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-zinc-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                <button wire:click="sortBy('name')" class="group inline-flex items-center">
                                    Product
                                    <flux:icon name="chevron-up-down" class="ml-1 h-4 w-4" />
                                </button>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Category
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Brand
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                <button wire:click="sortBy('price')" class="group inline-flex items-center">
                                    Price
                                    <flux:icon name="chevron-up-down" class="ml-1 h-4 w-4" />
                                </button>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Stock
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
                        @forelse($this->products as $product)
                            <tr wire:key="product-{{ $product->id }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0">
                                            <img class="h-10 w-10 rounded-lg object-cover" src="{{ $product->getImageUrl() }}" alt="{{ $product->name }}" />
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $product->name }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">SKU: {{ $product->sku }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    {{ $product->category?->name ?? 'No Category' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    {{ $product->brand?->name ?? 'No Brand' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    LKR {{ number_format($product->price, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($product->track_inventory)
                                        <div class="flex items-center">
                                            <span class="text-sm text-gray-900 dark:text-white">{{ $product->inventory_quantity }}</span>
                                            @if($product->hasLowStock())
                                                <flux:icon name="exclamation-triangle" class="ml-2 h-4 w-4 text-yellow-500" />
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Not tracked</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusColors = [
                                            'published' => 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300',
                                            'draft' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-300',
                                            'archived' => 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-300'
                                        ];
                                    @endphp
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$product->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst($product->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <flux:button wire:click="openEditModal({{ $product->id }})" size="sm" variant="outline" icon="pencil">
                                            Edit
                                        </flux:button>
                                        
                                        @if($product->barcode)
                                            <a href="{{ route('dashboard.barcodes.print-single', ['product' => $product->id, 'quantity' => 1]) }}" 
                                               target="_blank" 
                                               class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-zinc-800 dark:border-zinc-700 dark:text-gray-300 dark:hover:bg-zinc-700">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H7a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                                                </svg>
                                                Barcode
                                            </a>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1.5 text-xs text-gray-400 dark:text-gray-500" title="No barcode available">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18 18M5.636 5.636L6 6"></path>
                                                </svg>
                                                No Barcode
                                            </span>
                                        @endif
                                        
                                        <flux:button 
                                            wire:click="deleteProduct({{ $product->id }})" 
                                            wire:confirm="Are you sure you want to delete this product? This action cannot be undone."
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
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <flux:icon name="cube" class="h-12 w-12 text-gray-400 mb-4" />
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No products found</h3>
                                        <p class="text-gray-500 dark:text-gray-400 mb-4">Get started by creating your first product.</p>
                                        <flux:button wire:click="openCreateModal" variant="filled" icon="plus">
                                            Add Product
                                        </flux:button>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($this->products->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $this->products->links() }}
                </div>
            @endif
        </div>
    </div>
    
    <!-- Create/Edit Modal -->
    <flux:modal wire:model="showingModal" class="space-y-6">
        <div>
            <flux:heading size="lg">
                {{ $editingProduct ? 'Edit Product' : 'Create Product' }}
            </flux:heading>
            <flux:subheading>
                {{ $editingProduct ? 'Update product information' : 'Add a new product to your inventory' }}
            </flux:subheading>
        </div>
        
        <form wire:submit="save" class="space-y-6">
            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <flux:field>
                        <flux:label>Product Name</flux:label>
                        <flux:input wire:model="name" placeholder="Enter product name" required />
                        <flux:error name="name" />
                    </flux:field>
                </div>
                
                <div>
                    <flux:field>
                        <flux:label>SKU</flux:label>
                        <flux:input wire:model="sku" placeholder="Enter SKU" required />
                        <flux:error name="sku" />
                    </flux:field>
                </div>
                
                <div>
                    <flux:field>
                        <flux:label>Price (LKR)</flux:label>
                        <flux:input wire:model="price" type="number" step="0.01" placeholder="0.00" required />
                        <flux:error name="price" />
                    </flux:field>
                </div>
                
                <div>
                    <flux:field>
                        <flux:label>Compare Price (LKR)</flux:label>
                        <flux:input wire:model="compare_price" type="number" step="0.01" placeholder="0.00" />
                        <flux:error name="compare_price" />
                    </flux:field>
                </div>
                
                <div>
                    <flux:field>
                        <flux:label>Cost Price (LKR)</flux:label>
                        <flux:input wire:model="cost_price" type="number" step="0.01" placeholder="0.00" />
                        <flux:error name="cost_price" />
                    </flux:field>
                </div>
                
                <div>
                    <flux:field>
                        <flux:label>Barcode</flux:label>
                        <flux:input wire:model="barcode" placeholder="Enter barcode" />
                        <flux:error name="barcode" />
                    </flux:field>
                </div>
                
                <div>
                    <flux:field>
                        <flux:label>Category</flux:label>
                        <flux:select wire:model="category_id">
                            <option value="">Select Category</option>
                            @foreach($this->categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </flux:select>
                        <flux:error name="category_id" />
                    </flux:field>
                </div>
                
                <div>
                    <flux:field>
                        <flux:label>Brand</flux:label>
                        <flux:select wire:model="brand_id">
                            <option value="">Select Brand</option>
                            @foreach($this->brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </flux:select>
                        <flux:error name="brand_id" />
                    </flux:field>
                </div>
                
                <div>
                    <flux:field>
                        <flux:label>Status</flux:label>
                        <flux:select wire:model="status" required>
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                            <option value="archived">Archived</option>
                        </flux:select>
                        <flux:error name="status" />
                    </flux:field>
                </div>
                
                <div>
                    <flux:field>
                        <flux:label>Weight (kg)</flux:label>
                        <flux:input wire:model="weight" type="number" step="0.01" placeholder="0.00" />
                        <flux:error name="weight" />
                    </flux:field>
                </div>
                
                <div>
                    <flux:field>
                        <flux:label>Inventory Quantity</flux:label>
                        <flux:input wire:model="inventory_quantity" type="number" placeholder="0" required />
                        <flux:error name="inventory_quantity" />
                    </flux:field>
                </div>
                
                <div>
                    <flux:field>
                        <flux:label>Low Stock Threshold</flux:label>
                        <flux:input wire:model="low_stock_threshold" type="number" placeholder="5" required />
                        <flux:error name="low_stock_threshold" />
                    </flux:field>
                </div>
            </div>
            
            <div>
                <flux:field>
                    <flux:label>Short Description</flux:label>
                    <flux:textarea wire:model="short_description" placeholder="Brief product description" />
                    <flux:error name="short_description" />
                </flux:field>
            </div>
            
            <div>
                <flux:field>
                    <flux:label>Description</flux:label>
                    <flux:textarea wire:model="description" placeholder="Detailed product description" rows="4" />
                    <flux:error name="description" />
                </flux:field>
            </div>
            
            <div>
                <flux:field>
                    <flux:label>Featured Image</flux:label>
                    <flux:input wire:model="featured_image" type="file" accept="image/*" />
                    <flux:error name="featured_image" />
                    @if($editingProduct && $editingProduct->featured_image)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $editingProduct->featured_image) }}" alt="Current featured image" class="h-20 w-20 object-cover rounded">
                        </div>
                    @endif
                </flux:field>
            </div>
            
            <div class="grid gap-4 md:grid-cols-3">
                <div>
                    <flux:checkbox wire:model="track_inventory">Track Inventory</flux:checkbox>
                </div>
                <div>
                    <flux:checkbox wire:model="requires_shipping">Requires Shipping</flux:checkbox>
                </div>
                <div>
                    <flux:checkbox wire:model="is_digital">Digital Product</flux:checkbox>
                </div>
            </div>
            
            <div class="flex justify-between">
                <flux:button type="button" wire:click="closeModal" variant="outline">
                    Cancel
                </flux:button>
                <flux:button type="submit" variant="filled">
                    {{ $editingProduct ? 'Update Product' : 'Create Product' }}
                </flux:button>
            </div>
        </form>
    </flux:modal>
    </div>
</div>

<script>
    function printBulkBarcodes() {
        // Get all products with barcodes from the current page
        const products = @json($this->products->pluck('id', 'barcode')->filter()->keys());
        
        if (products.length === 0) {
            alert('No products with barcodes found on this page.');
            return;
        }
        
        const quantity = prompt('How many labels per product?', '1');
        if (quantity === null || quantity === '' || isNaN(quantity) || parseInt(quantity) < 1) {
            return;
        }
        
        // Add product IDs to form
        const form = document.getElementById('bulk-barcode-form');
        
        // Clear existing product inputs
        const existingInputs = form.querySelectorAll('input[name="products[]"]');
        existingInputs.forEach(input => input.remove());
        
        // Add new product inputs
        products.forEach(productId => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'products[]';
            input.value = productId;
            form.appendChild(input);
        });
        
        // Set quantity
        document.getElementById('bulk-quantity').value = quantity;
        
        // Submit form
        form.submit();
    }
</script>
