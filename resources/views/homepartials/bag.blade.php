
{{-- Dual Promotional Banners Section --}}
<section class="py-8 px-4 sm:px-6 lg:px-8 bg-gray-50">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            {{-- Software Banner --}}
            <div class="relative bg-gradient-to-br from-gray-200 via-gray-300 to-gray-400 rounded-lg overflow-hidden h-64 group cursor-pointer transition-transform duration-300 hover:scale-[1.02]">
                {{-- Background Image --}}
                <img src="{{ asset('images/banners/software-background.jpg') }}" 
                     alt="Software Collection Background" 
                     class="absolute inset-0 w-full h-full object-cover opacity-80">
                
                {{-- Content Overlay --}}
                <div class="absolute inset-0 bg-gradient-to-r from-black/60 via-black/30 to-transparent">
                    <div class="relative h-full flex flex-col justify-center items-start p-8">
                        {{-- Main Title --}}
                        <h2 class="text-white text-3xl lg:text-4xl font-bold mb-3 tracking-wide">
                            SOFTWARES
                        </h2>
                        
                        {{-- Subtitle --}}
                        <p class="text-gray-200 text-lg mb-6 max-w-sm">
                            Simply make and get delivered Digitally
                        </p>
                        
                        {{-- CTA Button --}}
                        <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                            BROWSE SOFTWARE
                        </button>
                    </div>
                </div>

                {{-- Software Products Display --}}
                <div class="absolute right-4 top-1/2 transform -translate-y-1/2">
                    <div class="flex flex-col space-y-4">
                        {{-- Software Box 1 --}}
                        <div class="w-20 h-24 bg-gradient-to-b from-green-400 to-green-600 rounded shadow-lg transform rotate-12 group-hover:rotate-6 transition-transform duration-500">
                            <div class="p-2 text-white text-xs text-center">
                                <div class="font-bold">ESET</div>
                                <div class="text-xs">Antivirus</div>
                            </div>
                        </div>
                        
                        {{-- Software Box 2 --}}
                        <div class="w-20 h-24 bg-gradient-to-b from-blue-400 to-blue-600 rounded shadow-lg transform -rotate-6 group-hover:rotate-0 transition-transform duration-500">
                            <div class="p-2 text-white text-xs text-center">
                                <div class="font-bold">Office</div>
                                <div class="text-xs">365</div>
                            </div>
                        </div>
                        
                        {{-- Software Box 3 --}}
                        <div class="w-20 h-24 bg-gradient-to-b from-purple-400 to-purple-600 rounded shadow-lg transform rotate-6 group-hover:-rotate-3 transition-transform duration-500">
                            <div class="p-2 text-white text-xs text-center">
                                <div class="font-bold">Adobe</div>
                                <div class="text-xs">Creative</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Decorative Elements --}}
                <div class="absolute top-4 left-4 w-8 h-8 bg-white/20 rounded-full animate-pulse"></div>
                <div class="absolute bottom-4 right-24 w-4 h-4 bg-blue-400/60 rounded-full animate-pulse delay-1000"></div>
            </div>

            {{-- New Arrivals Banner --}}
            <div class="relative bg-gradient-to-br from-gray-600 via-gray-700 to-gray-800 rounded-lg overflow-hidden h-64 group cursor-pointer transition-transform duration-300 hover:scale-[1.02]">
                {{-- Background Image --}}
                <img src="{{ asset('images/banners/bags-background.jpg') }}" 
                     alt="Bags and Backpacks Collection" 
                     class="absolute inset-0 w-full h-full object-cover opacity-70">
                
                {{-- Content Overlay --}}
                <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/40 to-transparent">
                    <div class="relative h-full flex flex-col justify-center items-start p-8">
                        {{-- Main Title --}}
                        <h2 class="text-white text-3xl lg:text-4xl font-bold mb-3 tracking-wide">
                            NEW ARRIVALS
                        </h2>
                        
                        {{-- Subtitle --}}
                        <p class="text-gray-200 text-lg mb-6 max-w-sm">
                            Buy online and get delivered digitally
                        </p>
                        
                        {{-- CTA Button --}}
                        <button class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-8 rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                            SHOP NEW ARRIVALS
                        </button>
                    </div>
                </div>

                {{-- Bags Display --}}
                <div class="absolute right-4 top-1/2 transform -translate-y-1/2">
                    <div class="flex space-x-2">
                        {{-- Bag 1 - Red --}}
                        <div class="relative">
                            <div class="w-12 h-16 bg-red-500 rounded-t-lg rounded-b-sm shadow-lg transform -rotate-12 group-hover:-rotate-6 transition-transform duration-500">
                                <div class="absolute top-2 left-1/2 transform -translate-x-1/2 w-6 h-1 bg-red-700 rounded"></div>
                                <div class="absolute top-4 left-1 right-1 bottom-2 bg-red-600 rounded"></div>
                            </div>
                        </div>
                        
                        {{-- Bag 2 - Navy --}}
                        <div class="relative">
                            <div class="w-12 h-16 bg-blue-800 rounded-t-lg rounded-b-sm shadow-lg transform rotate-6 group-hover:rotate-3 transition-transform duration-500">
                                <div class="absolute top-2 left-1/2 transform -translate-x-1/2 w-6 h-1 bg-blue-900 rounded"></div>
                                <div class="absolute top-4 left-1 right-1 bottom-2 bg-blue-700 rounded"></div>
                            </div>
                        </div>
                        
                        {{-- Bag 3 - Gray --}}
                        <div class="relative">
                            <div class="w-12 h-16 bg-gray-600 rounded-t-lg rounded-b-sm shadow-lg transform -rotate-3 group-hover:rotate-0 transition-transform duration-500">
                                <div class="absolute top-2 left-1/2 transform -translate-x-1/2 w-6 h-1 bg-gray-800 rounded"></div>
                                <div class="absolute top-4 left-1 right-1 bottom-2 bg-gray-500 rounded"></div>
                            </div>
                        </div>
                        
                        {{-- Bag 4 - Black --}}
                        <div class="relative">
                            <div class="w-12 h-16 bg-black rounded-t-lg rounded-b-sm shadow-lg transform rotate-12 group-hover:rotate-6 transition-transform duration-500">
                                <div class="absolute top-2 left-1/2 transform -translate-x-1/2 w-6 h-1 bg-gray-700 rounded"></div>
                                <div class="absolute top-4 left-1 right-1 bottom-2 bg-gray-800 rounded"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Decorative Elements --}}
                <div class="absolute top-4 right-4 w-6 h-6 bg-white/20 rounded-full animate-pulse delay-500"></div>
                <div class="absolute bottom-4 left-4 w-3 h-3 bg-red-400/60 rounded-full animate-pulse delay-1500"></div>
            </div>
        </div>

        {{-- Additional Info Cards (Optional) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-8">
            {{-- Feature 1 --}}
            <div class="bg-white rounded-lg p-4 shadow-sm text-center">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h4 class="font-semibold text-gray-900 mb-1">Digital Delivery</h4>
                <p class="text-sm text-gray-600">Instant software downloads</p>
            </div>

            {{-- Feature 2 --}}
            <div class="bg-white rounded-lg p-4 shadow-sm text-center">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                    </svg>
                </div>
                <h4 class="font-semibold text-gray-900 mb-1">Latest Products</h4>
                <p class="text-sm text-gray-600">Fresh arrivals weekly</p>
            </div>

            {{-- Feature 3 --}}
            <div class="bg-white rounded-lg p-4 shadow-sm text-center">
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                </div>
                <h4 class="font-semibold text-gray-900 mb-1">Premium Quality</h4>
                <p class="text-sm text-gray-600">Authentic products only</p>
            </div>

            {{-- Feature 4 --}}
            <div class="bg-white rounded-lg p-4 shadow-sm text-center">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"/>
                    </svg>
                </div>
                <h4 class="font-semibold text-gray-900 mb-1">Fast Support</h4>
                <p class="text-sm text-gray-600">24/7 customer service</p>
            </div>
        </div>
    </div>
</section>

<style>
/* Custom animations */
@keyframes float-rotate {
    0%, 100% {
        transform: translateY(0px) rotate(0deg);
    }
    33% {
        transform: translateY(-5px) rotate(5deg);
    }
    66% {
        transform: translateY(5px) rotate(-5deg);
    }
}

.floating-bag {
    animation: float-rotate 4s ease-in-out infinite;
}

/* Stagger animation delays */
.floating-bag:nth-child(1) {
    animation-delay: 0s;
}
.floating-bag:nth-child(2) {
    animation-delay: 0.5s;
}
.floating-bag:nth-child(3) {
    animation-delay: 1s;
}
.floating-bag:nth-child(4) {
    animation-delay: 1.5s;
}

/* Hover effects for banners */
.banner-hover {
    transition: all 0.3s ease;
}

.banner-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

/* Responsive adjustments */
@media (max-width: 1024px) {
    .lg\:grid-cols-2 {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .absolute.right-4 {
        right: 1rem;
    }
}

@media (max-width: 768px) {
    .text-3xl {
        font-size: 1.5rem;
    }
    
    .text-4xl {
        font-size: 1.75rem;
    }
    
    .p-8 {
        padding: 1.5rem;
    }
    
    .lg\:grid-cols-4 {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Banner click handlers
    const banners = document.querySelectorAll('.group.cursor-pointer');
    
    banners.forEach((banner, index) => {
        const title = banner.querySelector('h2').textContent.trim();
        
        banner.addEventListener('click', function() {
            console.log(`Banner clicked: ${title}`);
            
            // Route based on banner type
            if (title.includes('SOFTWARES')) {
                window.location.href = '/category/software';
            } else if (title.includes('NEW ARRIVALS')) {
                window.location.href = '/category/new-arrivals';
            }
        });
        
        // Add hover sound effect (optional)
        banner.addEventListener('mouseenter', function() {
            console.log(`Banner hover: ${title}`);
        });
    });

    // Button click handlers
    const buttons = document.querySelectorAll('button');
    
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation(); // Prevent banner click
            
            const buttonText = this.textContent.trim();
            console.log(`Button clicked: ${buttonText}`);
            
            // Add loading state
            const originalText = this.textContent;
            const originalColor = this.className;
            
            this.textContent = 'Loading...';
            this.disabled = true;
            this.className = this.className.replace('hover:bg-', 'bg-').replace('bg-blue-600', 'bg-gray-400').replace('bg-red-600', 'bg-gray-400');
            
            // Simulate loading
            setTimeout(() => {
                this.textContent = originalText;
                this.disabled = false;
                this.className = originalColor;
                
                // Route based on button
                if (buttonText.includes('SOFTWARE')) {
                    window.location.href = '/category/software';
                } else if (buttonText.includes('NEW ARRIVALS')) {
                    window.location.href = '/category/new-arrivals';
                }
            }, 1500);
        });
    });

    // Add floating animation to product displays
    const softwareBoxes = document.querySelectorAll('.w-20.h-24');
    const bagElements = document.querySelectorAll('.w-12.h-16');
    
    // Add floating class to bags
    bagElements.forEach(bag => {
        bag.parentElement.classList.add('floating-bag');
    });

    // Intersection Observer for animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
                
                // Animate feature cards with stagger
                if (entry.target.classList.contains('grid') && entry.target.querySelector('.bg-white')) {
                    const cards = entry.target.querySelectorAll('.bg-white');
                    cards.forEach((card, index) => {
                        setTimeout(() => {
                            card.style.opacity = '1';
                            card.style.transform = 'translateY(0)';
                        }, index * 100);
                    });
                }
            }
        });
    }, observerOptions);

    // Observe banners and feature section
    const elementsToObserve = document.querySelectorAll('.group.cursor-pointer, .grid.grid-cols-1.md\\:grid-cols-2');
    elementsToObserve.forEach(element => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(20px)';
        element.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(element);
    });

    // Initialize feature cards for animation
    const featureCards = document.querySelectorAll('.bg-white.rounded-lg.p-4');
    featureCards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    });

    // Track banner impressions for analytics
    const impressionObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const title = entry.target.querySelector('h2')?.textContent.trim();
                if (title) {
                    console.log(`Banner impression: ${title}`);
                    // Add your analytics tracking here
                    // gtag('event', 'banner_impression', { banner_title: title });
                }
            }
        });
    }, { threshold: 0.5 });

    banners.forEach(banner => {
        impressionObserver.observe(banner);
    });

    // Feature card click handlers
    const featureCardsClickable = document.querySelectorAll('.bg-white.rounded-lg.p-4');
    featureCardsClickable.forEach(card => {
        card.style.cursor = 'pointer';
        card.addEventListener('click', function() {
            const featureTitle = this.querySelector('h4').textContent.trim();
            console.log(`Feature clicked: ${featureTitle}`);
            
            // Route based on feature
            switch(featureTitle) {
                case 'Digital Delivery':
                    window.location.href = '/info/digital-delivery';
                    break;
                case 'Latest Products':
                    window.location.href = '/category/latest';
                    break;
                case 'Premium Quality':
                    window.location.href = '/info/quality-guarantee';
                    break;
                case 'Fast Support':
                    window.location.href = '/support';
                    break;
            }
        });
        
        // Add hover effect
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
            this.style.boxShadow = '0 10px 25px rgba(0, 0, 0, 0.1)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1)';
        });
    });

    // Parallax effect for banners (optional)
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const rate = scrolled * -0.2;
        
        banners.forEach(banner => {
            const img = banner.querySelector('img');
            if (img) {
                img.style.transform = `translateY(${rate}px)`;
            }
        });
    });
});
</script>