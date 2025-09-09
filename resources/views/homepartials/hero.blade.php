{{-- Banner Slider Component --}}
<div class="relative w-full overflow-hidden bg-gray-100">
    {{-- Slider Container --}}
    <div id="bannerSlider" class="relative w-full">
        {{-- Slides Container --}}
        <div class="slider-wrapper relative" id="sliderWrapper">
            @php
$slides = [
    ['image' => asset('images/slides/slide1.jpg'), 'name' => 'ASUS ROG Maximus'],
    ['image' => asset('images/slides/slide2.jpg'), 'name' => 'ASUS ROG'],
    ['image' => asset('images/slides/slide3.jpg'), 'name' => 'ASUS CrossHair'],
    ['image' => asset('images/slides/slide4.jpg'), 'name' => 'ASUS Tuf'],
    ['image' => asset('images/slides/slide5.jpg'), 'name' => 'ASUS'],
    ['image' => asset('images/slides/slide6.jpg'), 'name' => 'Targus'],
    ['image' => asset('images/slides/slide7.jpg'), 'name' => 'VCOM'],
    ['image' => asset('images/slides/slide8.jpg'), 'name' => 'Cooler Master'],
    ['image' => asset('images/slides/slide9.jpg'), 'name' => 'Windows'],
    ['image' => asset('images/slides/slide10.jpg'), 'name' => 'Microsoft'],
];
$totalSlides = count($slides);
@endphp

@foreach($slides as $slide)
    <img src="{{ $slide['image'] }}" alt="{{ $slide['name'] }}">
@endforeach



            @foreach ($slides as $slide)
                <div class="slide absolute top-0 left-0 w-full {{ $loop->first ? 'active' : 'opacity-0' }}" 
                     data-slide="{{ $loop->index }}"
                     style="transition: opacity 0.7s ease-in-out;">
                    
                    {{-- Background Image --}}
                    <div class="relative w-full">
                        <img src="{{ $slide['image'] }}" 
                             alt="{{ $slide['name'] }}" 
                             class="w-full h-auto block"
                             style="max-width: 100%; height: auto;"
                             loading="{{ $loop->first ? 'eager' : 'lazy' }}">
                        
                        {{-- Shop Button with Animation --}}
                        <div class="absolute bottom-6 right-6 md:bottom-8 md:right-8 lg:bottom-12 lg:right-12 z-10 opacity-0 transform translate-x-8 slide-button" 
                             style="animation-delay: 1.6s;">
                            <a href="{{ route('shop.index') }}" 
                               class="inline-block bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 md:py-4 md:px-8 rounded-lg text-sm md:text-base lg:text-lg transition-all duration-300 transform hover:scale-105 hover:shadow-xl uppercase tracking-wide">
                                Shop Now!
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{-- Navigation Controls --}}
        @if($totalSlides > 1)
            {{-- Previous Button --}}
            <button id="prevBtn" 
                    class="absolute left-4 top-1/2 transform -translate-y-1/2 w-12 h-12 md:w-14 md:h-14 bg-black/30 hover:bg-black/50 text-white rounded-full transition-all duration-300 z-30 group">
                <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>

            {{-- Next Button --}}
            <button id="nextBtn" 
                    class="absolute right-4 top-1/2 transform -translate-y-1/2 w-12 h-12 md:w-14 md:h-14 bg-black/30 hover:bg-black/50 text-white rounded-full transition-all duration-300 z-30 group">
                <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>

            {{-- Dot Navigation --}}
            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-3 z-20" id="dotsContainer">
                @for ($i = 0; $i < $totalSlides; $i++)
                    <button class="dot w-3 h-3 rounded-full bg-white/50 hover:bg-white transition-all duration-300 {{ $i === 0 ? 'active' : '' }}" 
                            data-slide="{{ $i }}" 
                            aria-label="Go to slide {{ $i + 1 }}">
                    </button>
                @endfor
            </div>
        @endif
    </div>
</div>

<style>
/* Slide Animations */
.slide.active {
    opacity: 1 !important;
}

.slide.active .slide-button {
    animation: slideInFromRight 1.5s ease-out 1.6s forwards;
}

@keyframes slideInFromRight {
    from {
        opacity: 0;
        transform: translateX(32px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Dot Navigation Active State */
.dot.active {
    background-color: #dc2626;
    transform: scale(1.3);
}

/* Slide Transitions */
.slide {
    will-change: opacity;
    backface-visibility: hidden;
}

/* Button Hover Effects */
.slide a:hover {
    box-shadow: 0 8px 25px rgba(220, 38, 38, 0.3);
}

/* Navigation Button Hover Effects */
#prevBtn:hover, #nextBtn:hover {
    transform: translateY(-50%) scale(1.1);
    background-color: rgba(0, 0, 0, 0.7);
}

/* Responsive Image Sizing */
@media (max-width: 768px) {
    .slide img {
        width: 100%;
        height: auto;
        max-height: 60vh;
        object-fit: contain;
    }
}

@media (min-width: 769px) {
    .slide img {
        width: 100%;
        height: auto;
        max-height: 80vh;
        object-fit: contain;
    }
}

/* Loading State */
.slide img {
    transition: opacity 0.3s ease-in-out;
}

.slide img[loading="lazy"] {
    opacity: 0.8;
}

.slide img[loading="lazy"].loaded {
    opacity: 1;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sliderWrapper = document.getElementById('sliderWrapper');
    const slides = document.querySelectorAll('.slide');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const dots = document.querySelectorAll('.dot');
    
    let currentSlide = 0;
    const totalSlides = slides.length;
    let autoSlideInterval;
    const autoSlideDelay = 6000; // 6 seconds per slide

    // Initialize slider
    function initSlider() {
        if (totalSlides === 0) return;
        
        // Set initial slide heights to prevent layout shift
        setSliderHeight();
        
        // Start auto-slide if multiple slides
        if (totalSlides > 1) {
            startAutoSlide();
        }
        
        // Initialize lazy loading
        initLazyLoading();
    }

    // Set slider height based on active slide
    function setSliderHeight() {
        const activeSlide = slides[currentSlide];
        if (activeSlide) {
            const img = activeSlide.querySelector('img');
            if (img) {
                // Wait for image to load before setting height
                if (img.complete) {
                    sliderWrapper.style.height = img.offsetHeight + 'px';
                } else {
                    img.onload = () => {
                        sliderWrapper.style.height = img.offsetHeight + 'px';
                    };
                }
            }
        }
    }

    // Enhanced slide transition with animations
    function goToSlide(slideIndex) {
        if (slideIndex < 0) {
            currentSlide = totalSlides - 1;
        } else if (slideIndex >= totalSlides) {
            currentSlide = 0;
        } else {
            currentSlide = slideIndex;
        }

        // Hide all slides and buttons
        slides.forEach((slide, index) => {
            const button = slide.querySelector('.slide-button');
            
            if (index === currentSlide) {
                // Show current slide
                slide.classList.add('active');
                // Animate button with delay
                setTimeout(() => {
                    if (button) {
                        button.style.opacity = '1';
                        button.style.transform = 'translateX(0)';
                    }
                }, 100);
            } else {
                // Hide other slides
                slide.classList.remove('active');
                if (button) {
                    button.style.opacity = '0';
                    button.style.transform = 'translateX(32px)';
                }
            }
        });

        // Update dots
        dots.forEach((dot, index) => {
            dot.classList.toggle('active', index === currentSlide);
        });

        // Update slider height
        setTimeout(setSliderHeight, 100);
    }

    // Auto-slide functionality
    function startAutoSlide() {
        if (totalSlides <= 1) return;
        
        stopAutoSlide();
        autoSlideInterval = setInterval(() => {
            goToSlide(currentSlide + 1);
        }, autoSlideDelay);
    }

    function stopAutoSlide() {
        if (autoSlideInterval) {
            clearInterval(autoSlideInterval);
        }
    }

    // Navigation functions
    function nextSlide() {
        goToSlide(currentSlide + 1);
        stopAutoSlide();
        startAutoSlide();
    }

    function prevSlide() {
        goToSlide(currentSlide - 1);
        stopAutoSlide();
        startAutoSlide();
    }

    // Lazy loading for images
    function initLazyLoading() {
        const lazyImages = document.querySelectorAll('img[loading="lazy"]');
        
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.classList.add('loaded');
                        imageObserver.unobserve(img);
                    }
                });
            });
            
            lazyImages.forEach(img => imageObserver.observe(img));
        } else {
            // Fallback for browsers without IntersectionObserver
            lazyImages.forEach(img => img.classList.add('loaded'));
        }
    }

    // Event listeners
    if (nextBtn) nextBtn.addEventListener('click', nextSlide);
    if (prevBtn) prevBtn.addEventListener('click', prevSlide);

    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            goToSlide(index);
            stopAutoSlide();
            startAutoSlide();
        });
    });

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        switch(e.key) {
            case 'ArrowLeft':
                prevSlide();
                e.preventDefault();
                break;
            case 'ArrowRight':
                nextSlide();
                e.preventDefault();
                break;
            case 'Escape':
                stopAutoSlide();
                break;
        }
    });

    // Touch/swipe support for mobile
    let startX = 0, startY = 0, endX = 0, endY = 0;
    
    sliderWrapper.addEventListener('touchstart', (e) => {
        startX = e.touches[0].clientX;
        startY = e.touches[0].clientY;
        stopAutoSlide();
    }, { passive: true });

    sliderWrapper.addEventListener('touchmove', (e) => {
        endX = e.touches[0].clientX;
        endY = e.touches[0].clientY;
    }, { passive: true });

    sliderWrapper.addEventListener('touchend', () => {
        const diffX = startX - endX;
        const diffY = Math.abs(startY - endY);
        
        // Only trigger if horizontal swipe is more significant than vertical
        if (Math.abs(diffX) > 50 && diffY < 100) {
            if (diffX > 0) {
                nextSlide();
            } else {
                prevSlide();
            }
        } else {
            startAutoSlide();
        }
    });

    // Pause on hover (desktop only)
    if (window.innerWidth > 768) {
        const bannerSlider = document.getElementById('bannerSlider');
        if (bannerSlider && totalSlides > 1) {
            bannerSlider.addEventListener('mouseenter', stopAutoSlide);
            bannerSlider.addEventListener('mouseleave', startAutoSlide);
        }
    }

    // Visibility API support
    document.addEventListener('visibilitychange', () => {
        if (totalSlides > 1) {
            if (document.hidden) {
                stopAutoSlide();
            } else {
                startAutoSlide();
            }
        }
    });

    // Responsive handling
    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            setSliderHeight();
        }, 250);
    });

    // Initialize everything
    initSlider();
});
</script>