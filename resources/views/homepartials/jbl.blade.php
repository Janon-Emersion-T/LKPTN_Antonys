{{-- Promotional Banners Section --}}
<section class="py-8 px-4 sm:px-6 lg:px-8 bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            {{-- Victus Gaming Banner (Large) --}}
            <div class="lg:col-span-6">
                <div class="relative h-150 rounded-lg overflow-hidden group cursor-pointer transition-transform duration-300 hover:scale-[1.02] shadow-lg bg-cover bg-center"
                    style="background-image: url('{{ asset('images/home/Victus.jpg') }}');">
                    
                    {{-- Dark Gradient Overlay --}}
                    <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/40 to-transparent"></div>

                    {{-- Content --}}
                    <div class="relative z-10 h-full flex flex-col justify-between p-6 lg:p-8">
                        {{-- Header --}}
                        <div class="py-32">
                            {{-- Brand Label --}}
                            <div class="text-gray-300 text-lg lg:text-xl font-light mb-2">
                                Victus
                            </div>
                            <h2 class="text-white text-2xl lg:text-3xl font-bold leading-tight">
                                Sharp Looks. Sharper<br>
                                Performance
                            </h2>
                        </div>

                        {{-- Gaming Specs --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div class="text-center">
                                <div class="text-white text-2xl lg:text-3xl font-bold">144 Hz</div>
                                <div class="text-gray-300 text-sm">refresh rate</div>
                            </div>
                            <div class="text-center">
                                <div class="text-white text-2xl lg:text-3xl font-bold">IPS panel</div>
                                <div class="text-gray-300 text-sm">anti-glare</div>
                            </div>
                            <div class="text-center">
                                <div class="text-white text-2xl lg:text-3xl font-bold">250</div>
                                <div class="text-gray-300 text-sm">nits</div>
                            </div>
                            <div class="text-center">
                                <div class="text-white text-2xl lg:text-3xl font-bold">9 ms</div>
                                <div class="text-gray-300 text-sm">response time</div>
                            </div>
                        </div>

                        {{-- CTA Button --}}
                        <div class="flex justify-start mt-4">
                            <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                                EXPLORE VICTUS
                            </button>
                        </div>
                    </div>
                </div>
            </div>


            {{-- Right Column (JBL + PC Assembly) --}}
            <div class="lg:col-span-6 space-y-6">
                {{-- JBL Audio Banner --}}
                <div class="relative bg-gradient-to-br from-gray-700 via-gray-600 to-gray-800 rounded-lg overflow-hidden h-48 group cursor-pointer transition-transform duration-300 hover:scale-[1.02]">
                    {{-- Background Image --}}
                    <img src="{{ asset('images/home/JBL.jpg') }}" 
                         alt="JBL Audio Background" 
                         class="absolute inset-0 w-full h-full object-cover opacity-60">
                    
                    {{-- Content --}}
                    <div class="relative h-full flex items-center justify-between p-6">
                        <div class="flex-1">
                            {{-- JBL Logo --}}
                            <div class="mb-4">
                                <h2 class="text-white text-4xl lg:text-5xl font-bold tracking-wider">
                                    JBL
                                </h2>
                            </div>
                            
                            {{-- Tagline --}}
                            <div class="text-gray-200 text-lg font-medium mb-6">
                                Hear the truth
                            </div>

                            {{-- CTA Button --}}
                            <a href="{{url('/brands/jbl')}}" class="bg-yellow-400 hover:bg-yellow-500 text-black font-bold py-2 px-6 rounded-full transition-all duration-300 transform hover:scale-105">
                                BUY NOW
                            </a>
                        </div>

                        {{-- JBL Speaker Image --}}
                        <div class="flex-shrink-0 ml-4">
                            <img src="{{ asset('images/home/JBL.jpg') }}" 
                                 alt="JBL Speaker" 
                                 class="w-32 h-32 lg:w-40 lg:h-40 object-contain drop-shadow-2xl">
                        </div>
                    </div>

                    {{-- Glow Effect --}}
                    <div class="absolute top-1/2 right-1/4 w-16 h-16 bg-red-500 rounded-full opacity-60 blur-xl"></div>
                </div>

                {{-- PC Assembly Banner --}}
                <div class="relative bg-gradient-to-br from-blue-900 via-purple-900 to-indigo-900 rounded-lg overflow-hidden h-44 group cursor-pointer transition-transform duration-300 hover:scale-[1.02]">
                    {{-- Background Pattern --}}
                    <div class="absolute inset-0 bg-gradient-to-r from-black/50 to-transparent"></div>
                    
                    {{-- Content --}}
                    <div class="relative h-full flex items-center justify-between p-6">
                        <div class="flex-1">
                            {{-- Category Label --}}
                            <div class="inline-block bg-blue-500 text-white px-3 py-1 rounded-full text-sm font-bold mb-3">
                                Computers
                            </div>
                            
                            {{-- Title --}}
                            <h2 class="text-white text-2xl lg:text-3xl font-bold mb-4">
                                ASSEMBLE PC
                            </h2>

                            {{-- CTA Button --}}
                            <a href="{{url('/categories/assemble-pc')}}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded-lg transition-all duration-300 transform hover:scale-105">
                                Shop now
                            </a>
                        </div>

                        {{-- PC Setup Image --}}
                        <div class="flex-shrink-0 ml-4">
                            <img src="{{ asset('images/home/desktop.png') }}" 
                                 alt="Gaming PC Setup" 
                                 class="w-32 h-32 lg:w-40 lg:h-32 object-contain">
                        </div>
                    </div>

                    {{-- Animated Elements --}}
                    <div class="absolute top-4 right-8 w-2 h-2 bg-blue-400 rounded-full animate-pulse"></div>
                    <div class="absolute bottom-8 right-12 w-1 h-1 bg-purple-400 rounded-full animate-pulse delay-500"></div>
                </div>

                {{-- Additional Small Banner (Laptop Category) --}}
                <div class="relative bg-gradient-to-br from-gray-800 via-blue-900 to-purple-900 rounded-lg overflow-hidden h-44 group cursor-pointer transition-transform duration-300 hover:scale-[1.02]">
                    {{-- Background Image --}}
                    <img src="{{ asset('images/banners/laptops-collection.jpg') }}" 
                         alt="Laptops Collection" 
                         class="absolute inset-0 w-full h-full object-cover opacity-70">
                    
                    {{-- Content --}}
                    <div class="relative h-full flex items-center justify-between p-6">
                        <div class="flex-1">
                            {{-- Category Label --}}
                            <div class="inline-block bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold mb-3">
                                COLLECTION
                            </div>
                            
                            {{-- Title --}}
                            <h2 class="text-white text-2xl lg:text-3xl font-bold mb-4">
                                LAPTOPS
                            </h2>

                            {{-- CTA Button --}}
                            <a href="{{url('/categories/laptop')}}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-lg transition-all duration-300 transform hover:scale-105">
                                VIEW ALL
                            </a>
                        </div>

                        {{-- Laptop Stack Image --}}
                        <div class="flex-shrink-0 ml-4">
                            <img src="{{ asset('images/home/laptop.png') }}" 
                                 alt="Laptop Collection" 
                                 class="w-32 h-32 lg:w-36 lg:h-28 object-contain">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.3;
    }
}

.animate-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

.delay-500 {
    animation-delay: 0.5s;
}

/* Hover effects */
.group:hover .drop-shadow-2xl {
    filter: drop-shadow(0 25px 25px rgb(0 0 0 / 0.3));
}

/* Responsive adjustments */
@media (max-width: 1024px) {
    .lg\:col-span-6 {
        grid-column: span 12;
    }
}

@media (max-width: 768px) {
    .grid-cols-2 {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1rem;
    }
    
    .text-2xl {
        font-size: 1.25rem;
    }
    
    .text-3xl {
        font-size: 1.5rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Banner click handlers
    const banners = document.querySelectorAll('[class*="cursor-pointer"]');
    
    banners.forEach(banner => {
        banner.addEventListener('click', function() {
            const title = this.querySelector('h2')?.textContent.trim();
            console.log(`Banner clicked: ${title}`);
            
            // Route to appropriate page based on banner content
            if (title?.includes('Victus')) {
                window.location.href = '/category/gaming-laptops';
            } else if (title?.includes('JBL')) {
                window.location.href = '/category/audio';
            } else if (title?.includes('ASSEMBLE')) {
                window.location.href = '/services/pc-assembly';
            } else if (title?.includes('LAPTOPS')) {
                window.location.href = '/category/laptops';
            }
        });
    });

    // Button click handlers with event stopping
    const buttons = document.querySelectorAll('button');
    
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation(); // Prevent banner click when button is clicked
            
            const buttonText = this.textContent.trim();
            console.log(`Button clicked: ${buttonText}`);
            
            // Add loading state
            const originalText = this.textContent;
            this.textContent = 'Loading...';
            this.disabled = true;
            
            // Simulate loading and restore button
            setTimeout(() => {
                this.textContent = originalText;
                this.disabled = false;
            }, 1500);
            
            // Route based on button text
            switch(buttonText) {
                case 'EXPLORE VICTUS':
                    window.location.href = '/category/victus-gaming';
                    break;
                case 'BUY NOW':
                    window.location.href = '/category/jbl-audio';
                    break;
                case 'GET QUOTE':
                    window.location.href = '/services/pc-assembly-quote';
                    break;
                case 'VIEW ALL':
                    window.location.href = '/category/all-laptops';
                    break;
            }
        });
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
            }
        });
    }, observerOptions);

    // Observe all banners for scroll animations
    banners.forEach(banner => {
        banner.style.opacity = '0';
        banner.style.transform = 'translateY(20px)';
        banner.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(banner);
    });

    // Parallax effect for large banner
    const victusBanner = document.querySelector('.lg\\:col-span-6 img');
    if (victusBanner) {
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const rate = scrolled * -0.3;
            victusBanner.style.transform = `translateY(${rate}px)`;
        });
    }

    // Add hover sound effect (optional)
    banners.forEach(banner => {
        banner.addEventListener('mouseenter', function() {
            // You can add sound effects here
            console.log('Banner hover sound effect');
        });
    });

    // Track banner impressions for analytics
    const trackBannerImpression = (bannerName) => {
        console.log(`Banner impression: ${bannerName}`);
        // Add your analytics tracking here
        // Example: gtag('event', 'banner_impression', { banner_name: bannerName });
    };

    // Track when banners come into view
    const impressionObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const title = entry.target.querySelector('h2')?.textContent.trim();
                if (title) {
                    trackBannerImpression(title);
                }
            }
        });
    }, { threshold: 0.5 });

    banners.forEach(banner => {
        impressionObserver.observe(banner);
    });
});
</script>