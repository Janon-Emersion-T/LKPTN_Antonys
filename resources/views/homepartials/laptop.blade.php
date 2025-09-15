{{-- Product Showcase Section --}}
<section class="py-8 px-4 sm:px-6 lg:px-8 bg-gray-50 dark:bg-gray-800">
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
                <div class="flex-1 min-w-0">
                    {{-- Category Tabs --}}
                    <div class="mb-6">
                        <div class="flex flex-wrap items-center justify-between border-b border-gray-200 dark:border-gray-600">
                            <div class="flex flex-wrap gap-2 mb-4 lg:mb-0">
                                <h2 class="tab-btn active px-6 py-3 text-sm font-medium border-b-2 border-red-500 text-red-500 hover:text-red-600 transition-colors" data-category="latest">
                                    LATEST LAPTOPS
                                </h2>
                            </div>
                            {{-- Navigation Arrows --}}
                            <div class="flex space-x-2">
                                <button id="prevProduct" class="p-2 text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-400 transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"/>
                                    </svg>
                                </button>
                                <button id="nextProduct" class="p-2 text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-400 transition-colors">
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
                                <div class="product-card bg-white dark:bg-gray-700 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 mx-2 flex-shrink-0">
                                    <a href="{{ route('products.show', $laptop->slug) }}" class="block p-4">
                                        {{-- Product Image --}}
                                        <div class="relative mb-4">
                                            <img src="{{ $laptop->images->first() ? asset('storage/' . $laptop->images->first()->image_path) : 'data:image/svg+xml;base64,' . base64_encode('<svg width="200" height="200" xmlns="http://www.w3.org/2000/svg"><rect width="200" height="200" fill="#f3f4f6"/><text x="50%" y="50%" text-anchor="middle" dy=".3em" fill="#9ca3af">No Image</text></svg>') }}"
                                                 alt="{{ $laptop->name }}"
                                                 class="w-full h-48 object-contain bg-gray-100 dark:bg-gray-600 rounded">
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
                                        <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-2 line-clamp-2">
                                            {{ $laptop->name }}
                                        </h3>

                                        {{-- Brand --}}
                                        @if($laptop->brand)
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">{{ $laptop->brand->name }}</p>
                                        @endif

                                        {{-- Price --}}
                                        <div class="text-center mb-4">
                                            <div class="text-xl font-bold text-blue-600 dark:text-blue-400">LKR {{ number_format($laptop->price, 0) }}</div>
                                            @if($laptop->compare_price && $laptop->compare_price > $laptop->price)
                                                <div class="text-sm text-gray-500 line-through">LKR {{ number_format($laptop->compare_price, 0) }}</div>
                                            @endif
                                        </div>

                                        {{-- Availability --}}
                                        <div class="flex items-center justify-center mb-4">
                                            <span class="text-sm text-gray-600 dark:text-gray-400 mr-2">Availability:</span>
                                            @if($laptop->inventory_quantity > 0)
                                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">Yes ({{ $laptop->inventory_quantity }})</span>
                                            @else
                                                <span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full">Out of Stock</span>
                                            @endif
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Hot Deal Sidebar --}}
                <div class="lg:w-80 flex-shrink-0">
                    <div class="bg-white dark:bg-gray-700 rounded-lg shadow-md overflow-hidden">
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
                            <a href="{{ route('products.show', $hotLaptop->slug) }}" class="block p-4">
                                <div class="relative mb-4">
                                    <img src="{{ $hotLaptop->images->first() ? asset('storage/' . $hotLaptop->images->first()->image_path) : 'data:image/svg+xml;base64,' . base64_encode('<svg width="200" height="200" xmlns="http://www.w3.org/2000/svg"><rect width="200" height="200" fill="#f3f4f6"/><text x="50%" y="50%" text-anchor="middle" dy=".3em" fill="#9ca3af">No Image</text></svg>') }}"
                                         alt="{{ $hotLaptop->name }}"
                                         class="w-full h-48 object-contain bg-gray-100 dark:bg-gray-600 rounded">
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

                                <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-2 line-clamp-2">
                                    {{ $hotLaptop->name }}
                                </h3>

                                @if($hotLaptop->brand)
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">{{ $hotLaptop->brand->name }}</p>
                                @endif

                                <div class="text-center mb-4">
                                    <div class="text-xl font-bold text-blue-600 dark:text-blue-400">LKR {{ number_format($hotLaptop->price, 0) }}</div>
                                    @if($hotLaptop->compare_price && $hotLaptop->compare_price > $hotLaptop->price)
                                        <div class="text-sm text-gray-500 line-through">LKR {{ number_format($hotLaptop->compare_price, 0) }}</div>
                                    @endif
                                </div>

                                <div class="flex items-center justify-center mb-4">
                                    <span class="text-sm text-gray-600 dark:text-gray-400 mr-2">Availability:</span>
                                    @if($hotLaptop->inventory_quantity > 0)
                                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">Yes ({{ $hotLaptop->inventory_quantity }})</span>
                                    @else
                                        <span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full">Out of Stock</span>
                                    @endif
                                </div>
                            </a>
                        @else
                            <div class="p-4 text-center">
                                <p class="text-gray-500 dark:text-gray-400">No hot deals available at the moment!</p>
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
    width: fit-content;
}

.product-card {
    width: 280px;
    max-width: 280px;
    min-width: 280px;
}

/* Responsive adjustments for better screen adaptation */
@media (max-width: 1024px) {
    .product-card {
        width: 260px;
        max-width: 260px;
        min-width: 260px;
    }
}

@media (max-width: 768px) {
    .product-card {
        width: 240px;
        max-width: 240px;
        min-width: 240px;
    }
}

@media (max-width: 640px) {
    .product-card {
        width: calc(100vw - 80px);
        max-width: 300px;
        min-width: 250px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Carousel functionality for responsive slider
    const productTrack = document.getElementById('productTrack');
    const prevBtn = document.getElementById('prevProduct');
    const nextBtn = document.getElementById('nextProduct');

    if (productTrack && prevBtn && nextBtn) {
        let currentPosition = 0;
        const totalCards = document.querySelectorAll('.product-card').length;

        function getVisibleCards() {
            const containerWidth = productTrack.parentElement.offsetWidth;
            const cardWidth = 280; // Base card width
            return Math.floor(containerWidth / (cardWidth + 16)); // 16px for margins
        }

        function updateCarousel() {
            const visibleCards = getVisibleCards();
            const maxPosition = Math.max(0, totalCards - visibleCards);

            // Ensure currentPosition is within bounds
            if (currentPosition > maxPosition) {
                currentPosition = maxPosition;
            }

            // Calculate the translateX value
            const cardWidth = document.querySelector('.product-card').offsetWidth + 16; // Include margin
            const translateX = currentPosition * cardWidth;
            productTrack.style.transform = `translateX(-${translateX}px)`;

            // Update button states
            prevBtn.style.opacity = currentPosition === 0 ? '0.3' : '1';
            prevBtn.style.cursor = currentPosition === 0 ? 'not-allowed' : 'pointer';
            nextBtn.style.opacity = currentPosition >= maxPosition ? '0.3' : '1';
            nextBtn.style.cursor = currentPosition >= maxPosition ? 'not-allowed' : 'pointer';

            // Update button pointer events
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
        updateCarousel();

        // Debug info
        console.log('Laptop Slider initialized:', {
            totalCards: totalCards,
            currentPosition: currentPosition
        });
    }

    // Thumbnail switching functionality
    document.querySelectorAll('.product-card').forEach(card => {
        const mainImage = card.querySelector('img[alt*=""]');
        const thumbnails = card.querySelectorAll('.w-8');

        if (mainImage && thumbnails.length > 1) {
            thumbnails.forEach((thumb, index) => {
                thumb.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

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
});
</script>

