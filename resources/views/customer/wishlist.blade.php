<x-layouts.customer.app :title="__('My Wishlist')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <flux:heading size="xl">My Wishlist</flux:heading>
                <flux:text class="text-neutral-600 dark:text-neutral-400">
                    {{ $wishlistItems->count() }} {{ Str::plural('item', $wishlistItems->count()) }} saved
                </flux:text>
            </div>
            @if($wishlistItems->count() > 0)
                <flux:button 
                    variant="ghost" 
                    size="sm"
                    x-data
                    x-on:click="
                        if(confirm('Are you sure you want to clear your entire wishlist?')) {
                            fetch('{{ route('customer.wishlist.clear') }}', {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            }).then(() => window.location.reload());
                        }
                    "
                >
                    Clear Wishlist
                </flux:button>
            @endif
        </div>

        <!-- Wishlist Items -->
        @if($wishlistItems->count() > 0)
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach($wishlistItems as $item)
                    <div class="rounded-xl border border-neutral-200 bg-white shadow-sm dark:border-neutral-700 dark:bg-zinc-900">
                        <!-- Product Image -->
                        <div class="aspect-square overflow-hidden rounded-t-xl">
                            @if($item->product->images->first())
                                <img 
                                    src="{{ asset('storage/' . $item->product->images->first()->image_path) }}" 
                                    alt="{{ $item->product->name }}"
                                    class="h-full w-full object-cover transition-transform hover:scale-105"
                                >
                            @else
                                <div class="flex h-full w-full items-center justify-center bg-neutral-100 dark:bg-neutral-800">
                                    <flux:icon.photo class="h-16 w-16 text-neutral-400" />
                                </div>
                            @endif
                        </div>

                        <!-- Product Info -->
                        <div class="p-4">
                            <div class="mb-2">
                                <flux:heading size="sm" class="line-clamp-2">
                                    <a href="{{ route('products.show', $item->product->slug) }}" 
                                       class="hover:text-blue-600 dark:hover:text-blue-400">
                                        {{ $item->product->name }}
                                    </a>
                                </flux:heading>
                                @if($item->product->brand)
                                    <flux:text class="text-sm text-neutral-600 dark:text-neutral-400">
                                        {{ $item->product->brand->name }}
                                    </flux:text>
                                @endif
                            </div>

                            <!-- Price -->
                            <div class="mb-4">
                                <flux:text class="text-lg font-semibold">
                                    LKR {{ number_format($item->product->price, 2) }}
                                </flux:text>
                                @if($item->product->compare_price && $item->product->compare_price > $item->product->price)
                                    <flux:text class="text-sm text-neutral-500 line-through">
                                        LKR {{ number_format($item->product->compare_price, 2) }}
                                    </flux:text>
                                @endif
                            </div>

                            <!-- Stock Status -->
                            <div class="mb-4">
                                @if($item->product->inventory_quantity > 0)
                                    <flux:badge size="sm" class="bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        In Stock ({{ $item->product->inventory_quantity }})
                                    </flux:badge>
                                @else
                                    <flux:badge size="sm" class="bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                        Out of Stock
                                    </flux:badge>
                                @endif
                            </div>

                            <!-- Actions -->
                            <div class="flex gap-2">
                                @if($item->product->inventory_quantity > 0)
                                    <flux:button 
                                        size="sm" 
                                        class="flex-1"
                                        x-data
                                        x-on:click="
                                            fetch('{{ route('cart.add') }}', {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                },
                                                body: JSON.stringify({
                                                    product_id: {{ $item->product->id }},
                                                    quantity: 1
                                                })
                                            }).then(response => response.json())
                                              .then(data => {
                                                  if(data.success) {
                                                      alert('Added to cart successfully!');
                                                  }
                                              });
                                        "
                                    >
                                        <flux:icon.shopping-cart class="mr-1 h-4 w-4" />
                                        Add to Cart
                                    </flux:button>
                                @else
                                    <flux:button size="sm" class="flex-1" disabled>
                                        Out of Stock
                                    </flux:button>
                                @endif

                                <flux:button 
                                    variant="ghost" 
                                    size="sm"
                                    x-data
                                    x-on:click="
                                        fetch('{{ route('customer.wishlist.remove') }}', {
                                            method: 'DELETE',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                            },
                                            body: JSON.stringify({
                                                product_id: {{ $item->product->id }}
                                            })
                                        }).then(() => window.location.reload());
                                    "
                                    title="Remove from wishlist"
                                >
                                    <flux:icon.trash class="h-4 w-4" />
                                </flux:button>
                            </div>
                        </div>

                        <!-- Added Date -->
                        <div class="border-t border-neutral-100 px-4 py-2 dark:border-neutral-800">
                            <flux:text class="text-xs text-neutral-500">
                                Added {{ $item->created_at->diffForHumans() }}
                            </flux:text>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="rounded-xl border border-neutral-200 bg-white p-12 text-center shadow-sm dark:border-neutral-700 dark:bg-zinc-900">
                <flux:icon.heart class="mx-auto h-16 w-16 text-neutral-400" />
                <flux:heading size="lg" class="mt-4">Your wishlist is empty</flux:heading>
                <flux:text class="mt-2 text-neutral-600 dark:text-neutral-400">
                    Save items you love to your wishlist and shop them later.
                </flux:text>
                <flux:button :href="route('products.index')" class="mt-6" wire:navigate>
                    <flux:icon.squares-plus class="mr-2 h-4 w-4" />
                    Browse Products
                </flux:button>
            </div>
        @endif

        @if($wishlistItems->count() > 0)
            <!-- Suggestions -->
            <div class="rounded-xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-zinc-900">
                <div class="flex items-center justify-between mb-4">
                    <flux:heading size="sm">You might also like</flux:heading>
                    <flux:button :href="route('products.index')" variant="ghost" size="sm" wire:navigate>
                        View All Products
                        <flux:icon.arrow-right class="ml-1 h-4 w-4" />
                    </flux:button>
                </div>
                <flux:text class="text-neutral-600 dark:text-neutral-400">
                    Discover more products similar to your wishlist items.
                </flux:text>
            </div>
        @endif
    </div>
</x-layouts.customer.app>