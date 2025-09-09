{{-- Product Showcase Section --}}
<section class="py-8 px-4 sm:px-6 lg:px-8 bg-gray-50">
    <div class="max-w-7xl mx-auto">
        @if(!$laptopData['hasLaptops'])
            {{-- No Laptops Available Message --}}
            <div class="flex flex-col items-center justify-center py-16">
                <div class="text-center">
                    <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <h2 class="text-2xl font-bold text-gray-600 mb-2">No Laptops Available</h2>
                    <p class="text-gray-500">{{ $laptopData['message'] }}</p>
                </div>
            </div>
        @else
            <div class="flex flex-col lg:flex-row gap-8">
                {{-- Main Product Section --}}
                <div class="flex-1">
                    {{-- Category Tabs --}}
                    <div class="mb-6">
                        <div class="flex flex-wrap items-center justify-between border-b border-gray-200">
                            <div class="flex flex-wrap gap-2 mb-4 lg:mb-0">
                                <h2 class="tab-btn active px-6 py-3 text-sm font-medium border-b-2 border-red-500 text-red-500 hover:text-red-600 transition-colors" data-category="latest">
                                    LATEST LAPTOPS
                                </h2>
                            </div>
                            {{-- Navigation Arrows --}}
                            <div class="flex space-x-2">
                                <button id="prevProduct" class="p-2 text-gray-400 hover:text-gray-600 transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"/>
                                    </svg>
                                </button>
                                <button id="nextProduct" class="p-2 text-gray-400 hover:text-gray-600 transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Product Grid --}}
                    <div class="product-container overflow-hidden relative">
                        <div class="product-track flex transition-transform duration-500 ease-in-out" id="productTrack">
                            @foreach($laptopData['latestLaptops'] as $laptop)
                                <div class="product-card w-1/3 min-w-[280px] bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 mx-2 flex-shrink-0">
                                    <div class="p-4">
                                        {{-- Product Image --}}
                                        <div class="relative mb-4">
                                            <img src="{{ $laptop->images->first() ? asset('storage/' . $laptop->images->first()->image_path) : 'data:image/svg+xml;base64,' . base64_encode('<svg width="200" height="200" xmlns="http://www.w3.org/2000/svg"><rect width="200" height="200" fill="#f3f4f6"/><text x="50%" y="50%" text-anchor="middle" dy=".3em" fill="#9ca3af">No Image</text></svg>') }}" 
                                                 alt="{{ $laptop->name }}" 
                                                 class="w-full h-48 object-contain bg-gray-100 rounded">
                                        </div>

                                        {{-- Product Thumbnails (if multiple images exist) --}}
                                        @if($laptop->images->count() > 1)
                                            <div class="flex justify-center space-x-2 mb-4">
                                                @foreach($laptop->images->take(4) as $image)
                                                    <img src="{{ asset('storage/' . $image->image_path) }}" 
                                                         class="w-8 h-8 object-cover rounded border cursor-pointer hover:border-blue-500" 
                                                         alt="View {{ $loop->iteration }}">
                                                @endforeach
                                            </div>
                                        @endif

                                        {{-- Product Title --}}
                                        <h3 class="text-sm font-medium text-gray-900 mb-2 line-clamp-2">
                                            {{ $laptop->name }}
                                        </h3>

                                        {{-- Brand --}}
                                        @if($laptop->brand)
                                            <p class="text-xs text-gray-500 mb-2">{{ $laptop->brand->name }}</p>
                                        @endif

                                        {{-- Price --}}
                                        <div class="text-center mb-4">
                                            <div class="text-xl font-bold text-blue-600">{{ number_format($laptop->price, 2) }} per unit</div>
                                            @if($laptop->compare_price && $laptop->compare_price > $laptop->price)
                                                <div class="text-sm text-gray-500 line-through">{{ number_format($laptop->compare_price, 2) }}</div>
                                            @endif
                                        </div>

                                        {{-- Availability --}}
                                        <div class="flex items-center justify-center mb-4">
                                            <span class="text-sm text-gray-600 mr-2">Availability:</span>
                                            @if($laptop->inventory_quantity > 0)
                                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">Yes ({{ $laptop->inventory_quantity }})</span>
                                            @else
                                                <span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full">Out of Stock</span>
                                            @endif
                                        </div>

                                        {{-- Add to Cart Section --}}
                                        <form class="add-to-cart-form" data-product-id="{{ $laptop->id }}">
                                            @csrf
                                            <div class="flex items-center space-x-2">
                                                <span class="text-sm text-gray-600">Qty:</span>
                                                <input type="number" name="quantity" value="1" min="1" max="{{ $laptop->inventory_quantity }}" 
                                                       class="w-16 px-2 py-1 border border-gray-300 rounded text-center text-sm" 
                                                       {{ $laptop->inventory_quantity <= 0 ? 'disabled' : '' }}>
                                                <button type="submit" 
                                                        class="flex-1 bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-medium py-2 px-4 rounded text-sm transition-colors {{ $laptop->inventory_quantity <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                        {{ $laptop->inventory_quantity <= 0 ? 'disabled' : '' }}>
                                                    ADD TO CART
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Hot Deal Sidebar --}}
                <div class="lg:w-80">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        {{-- Hot Deal Header --}}
                        <div class="bg-yellow-400 px-4 py-3 relative">
                            <h2 class="text-lg font-bold text-gray-900">HOT DEAL</h2>
                            <div class="absolute top-0 right-0 bg-red-500 text-white px-2 py-1 text-xs font-bold transform rotate-12 translate-x-2 -translate-y-1">
                                HOT
                            </div>
                        </div>

                        {{-- Hot Deal Product --}}
                        @if($laptopData['hotDealLaptop'])
                            @php $hotLaptop = $laptopData['hotDealLaptop']; @endphp
                            <div class="p-4">
                                <div class="relative mb-4">
                                    <img src="{{ $hotLaptop->images->first() ? asset('storage/' . $hotLaptop->images->first()->image_path) : 'data:image/svg+xml;base64,' . base64_encode('<svg width="200" height="200" xmlns="http://www.w3.org/2000/svg"><rect width="200" height="200" fill="#f3f4f6"/><text x="50%" y="50%" text-anchor="middle" dy=".3em" fill="#9ca3af">No Image</text></svg>') }}" 
                                         alt="{{ $hotLaptop->name }}" 
                                         class="w-full h-48 object-contain bg-gray-100 rounded">
                                </div>

                                @if($hotLaptop->images->count() > 1)
                                    <div class="flex justify-center space-x-2 mb-4">
                                        @foreach($hotLaptop->images->take(4) as $image)
                                            <img src="{{ asset('storage/' . $image->image_path) }}" 
                                                 class="w-8 h-8 object-cover rounded border cursor-pointer hover:border-blue-500" 
                                                 alt="View {{ $loop->iteration }}">
                                        @endforeach
                                    </div>
                                @endif

                                <h3 class="text-sm font-medium text-gray-900 mb-2 line-clamp-2">
                                    {{ $hotLaptop->name }}
                                </h3>

                                @if($hotLaptop->brand)
                                    <p class="text-xs text-gray-500 mb-2">{{ $hotLaptop->brand->name }}</p>
                                @endif

                                <div class="text-center mb-4">
                                    <div class="text-xl font-bold text-blue-600">{{ number_format($hotLaptop->price, 2) }} per unit</div>
                                    @if($hotLaptop->compare_price && $hotLaptop->compare_price > $hotLaptop->price)
                                        <div class="text-sm text-gray-500 line-through">{{ number_format($hotLaptop->compare_price, 2) }}</div>
                                    @endif
                                </div>

                                <div class="flex items-center justify-center mb-4">
                                    <span class="text-sm text-gray-600 mr-2">Availability:</span>
                                    @if($hotLaptop->inventory_quantity > 0)
                                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">Yes ({{ $hotLaptop->inventory_quantity }})</span>
                                    @else
                                        <span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full">Out of Stock</span>
                                    @endif
                                </div>

                                <form class="add-to-cart-form" data-product-id="{{ $hotLaptop->id }}">
                                    @csrf
                                    <div class="flex items-center space-x-2">
                                        <span class="text-sm text-gray-600">Qty:</span>
                                        <input type="number" name="quantity" value="1" min="1" max="{{ $hotLaptop->inventory_quantity }}" 
                                               class="w-16 px-2 py-1 border border-gray-300 rounded text-center text-sm"
                                               {{ $hotLaptop->inventory_quantity <= 0 ? 'disabled' : '' }}>
                                        <button type="submit" 
                                                class="flex-1 bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-bold py-2 px-4 rounded text-sm transition-colors {{ $hotLaptop->inventory_quantity <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                {{ $hotLaptop->inventory_quantity <= 0 ? 'disabled' : '' }}>
                                            ADD TO CART
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @else
                            <div class="p-4 text-center">
                                <p class="text-gray-500">No hot deals available at the moment!</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.tab-btn.active {
    color: #dc2626;
    border-bottom-color: #dc2626;
}

.product-container {
    -webkit-overflow-scrolling: touch;
}

.product-track {
    width: calc(100% * 4 / 3); /* Width for 4 cards when showing 3 */
}

.product-card {
    flex: 0 0 calc(100% / 3); /* Each card takes 1/3 of visible width */
    box-sizing: border-box;
}

@media (max-width: 1024px) {
    .product-card {
        flex: 0 0 calc(100% / 2); /* Show 2 cards on tablet */
    }
    
    .product-track {
        width: calc(100% * 4 / 2); /* Width for 4 cards when showing 2 */
    }
}

@media (max-width: 640px) {
    .product-card {
        flex: 0 0 100%; /* Show 1 card on mobile */
    }
    
    .product-track {
        width: 400%; /* Width for 4 cards when showing 1 */
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // CSRF token for AJAX requests
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Carousel functionality for 3-product display
    const productTrack = document.getElementById('productTrack');
    const prevBtn = document.getElementById('prevProduct');
    const nextBtn = document.getElementById('nextProduct');
    
    if (productTrack && prevBtn && nextBtn) {
        let currentPosition = 0;
        const totalCards = document.querySelectorAll('.product-card').length;
        
        function getVisibleCards() {
            const width = window.innerWidth;
            if (width <= 640) return 1; // Mobile
            if (width <= 1024) return 2; // Tablet  
            return 3; // Desktop
        }
        
        function updateCarousel() {
            const visibleCards = getVisibleCards();
            const maxPosition = Math.max(0, totalCards - visibleCards);
            
            // Ensure currentPosition is within bounds
            if (currentPosition > maxPosition) {
                currentPosition = maxPosition;
            }
            
            // Calculate the percentage to move
            const translatePercentage = currentPosition * (100 / visibleCards);
            productTrack.style.transform = `translateX(-${translatePercentage}%)`;
            
            // Update button states
            prevBtn.style.opacity = currentPosition === 0 ? '0.3' : '1';
            prevBtn.style.cursor = currentPosition === 0 ? 'not-allowed' : 'pointer';
            nextBtn.style.opacity = currentPosition >= maxPosition ? '0.3' : '1';
            nextBtn.style.cursor = currentPosition >= maxPosition ? 'not-allowed' : 'pointer';
            
            // Update button hover effects
            if (currentPosition === 0) {
                prevBtn.classList.add('pointer-events-none');
            } else {
                prevBtn.classList.remove('pointer-events-none');
            }
            
            if (currentPosition >= maxPosition) {
                nextBtn.classList.add('pointer-events-none');
            } else {
                nextBtn.classList.remove('pointer-events-none');
            }
            
            return { visibleCards, maxPosition };
        }

        prevBtn.addEventListener('click', function() {
            const { maxPosition } = updateCarousel();
            if (currentPosition > 0) {
                currentPosition--;
                updateCarousel();
            }
        });

        nextBtn.addEventListener('click', function() {
            const { maxPosition } = updateCarousel();
            if (currentPosition < maxPosition) {
                currentPosition++;
                updateCarousel();
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            updateCarousel();
        });

        // Touch/swipe support for mobile
        let startX = 0;
        let endX = 0;
        let startTime = 0;

        productTrack.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
            startTime = Date.now();
        });

        productTrack.addEventListener('touchmove', (e) => {
            endX = e.touches[0].clientX;
            e.preventDefault(); // Prevent scrolling
        });

        productTrack.addEventListener('touchend', () => {
            const { maxPosition } = updateCarousel();
            const threshold = 50;
            const diff = startX - endX;
            const timeDiff = Date.now() - startTime;

            // Only process if it's a quick swipe (not a long press/scroll)
            if (Math.abs(diff) > threshold && timeDiff < 300) {
                if (diff > 0 && currentPosition < maxPosition) {
                    // Swipe left - go to next
                    currentPosition++;
                    updateCarousel();
                } else if (diff < 0 && currentPosition > 0) {
                    // Swipe right - go to previous
                    currentPosition--;
                    updateCarousel();
                }
            }
        });

        // Initialize carousel
        const initialState = updateCarousel();
        
        // Debug info
        console.log('Laptop Slider initialized:', {
            totalCards: totalCards,
            visibleCards: initialState.visibleCards,
            maxPosition: initialState.maxPosition,
            currentPosition: currentPosition
        });
    }

    // Thumbnail switching functionality
    document.querySelectorAll('.product-card, .p-4').forEach(card => {
        const mainImage = card.querySelector('img[alt*=""]');
        const thumbnails = card.querySelectorAll('.w-8');
        
        if (mainImage && thumbnails.length > 1) {
            thumbnails.forEach((thumb, index) => {
                thumb.addEventListener('click', function() {
                    // Remove active border from all thumbnails
                    thumbnails.forEach(t => {
                        t.classList.remove('border-blue-500');
                        t.classList.add('border-gray-300');
                    });
                    // Add active border to clicked thumbnail
                    this.classList.add('border-blue-500');
                    this.classList.remove('border-gray-300');
                    
                    // Update main image
                    mainImage.src = this.src;
                });
            });
        }
    });

    // Add to cart functionality
    document.querySelectorAll('.add-to-cart-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const productId = this.dataset.productId;
            const quantity = this.querySelector('input[name="quantity"]').value;
            const button = this.querySelector('button[type="submit"]');
            const originalText = button.textContent;
            
            // Disable button and show loading state
            button.disabled = true;
            button.textContent = 'ADDING...';
            button.classList.add('opacity-75');
            
            // Send AJAX request to add to cart
            fetch('{{ route("cart.add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: parseInt(quantity)
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success state
                    button.textContent = 'ADDED!';
                    button.classList.remove('bg-yellow-400', 'hover:bg-yellow-500');
                    button.classList.add('bg-green-500', 'hover:bg-green-600');
                    
                    // Update cart count in header if exists
                    const cartCount = document.querySelector('.cart-count');
                    if (cartCount && data.cartCount) {
                        cartCount.textContent = data.cartCount;
                    }
                    
                    // Reset button after 2 seconds
                    setTimeout(() => {
                        button.disabled = false;
                        button.textContent = originalText;
                        button.classList.remove('bg-green-500', 'hover:bg-green-600', 'opacity-75');
                        button.classList.add('bg-yellow-400', 'hover:bg-yellow-500');
                    }, 2000);
                } else {
                    throw new Error(data.message || 'Failed to add to cart');
                }
            })
            .catch(error => {
                console.error('Error adding to cart:', error);
                
                // Show error state
                button.textContent = 'ERROR!';
                button.classList.remove('bg-yellow-400', 'hover:bg-yellow-500');
                button.classList.add('bg-red-500', 'hover:bg-red-600');
                
                // Reset button after 2 seconds
                setTimeout(() => {
                    button.disabled = false;
                    button.textContent = originalText;
                    button.classList.remove('bg-red-500', 'hover:bg-red-600', 'opacity-75');
                    button.classList.add('bg-yellow-400', 'hover:bg-yellow-500');
                }, 2000);
                
                // Show error message to user
                alert(error.message || 'Failed to add item to cart. Please try again.');
            });
        });
    });
});
</script>