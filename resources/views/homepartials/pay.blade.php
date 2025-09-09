{{-- Payment Methods & Partners Section --}}
<section class="py-8 px-4 sm:px-6 lg:px-8 bg-gray-100">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Payment Methods Section --}}
            <div class="relative bg-white rounded-lg shadow-md overflow-hidden">
                {{-- Background Pattern --}}
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute inset-0" style="background-image: repeating-linear-gradient(45deg, #e5e7eb 0px, #e5e7eb 10px, transparent 10px, transparent 20px), repeating-linear-gradient(-45deg, #e5e7eb 0px, #e5e7eb 10px, transparent 10px, transparent 20px);"></div>
                </div>
                
                {{-- Content --}}
                <div class="relative p-6 lg:p-8 bg-url('{{ asset('images/we accept.jpg') }}') bg-cover bg-center bg-no-repeat">
                    {{-- Overlay --}}
                    {{-- Header --}}
                    <div class="mb-6">
                        <h3 class="text-sm text-gray-600 font-medium mb-2">For your convenience</h3>
                        <h2 class="text-2xl lg:text-3xl font-bold text-red-500 mb-4">we accept</h2>
                    </div>

                    {{-- Payment Methods Grid --}}
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                        {{-- Visa --}}
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 flex items-center justify-center hover:shadow-md transition-shadow duration-300">
                            <img src="{{ asset('images/visa.png')}}" 
                                 alt="Visa" 
                                 class="h-8 w-auto object-contain">
                        </div>

                        {{-- Mastercard --}}
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 flex items-center justify-center hover:shadow-md transition-shadow duration-300">
                            <img src="{{ asset('images/master-card.png') }}" 
                                 alt="Mastercard" 
                                 class="h-8 w-auto object-contain">
                        </div>

                        {{-- Bank Transfer --}}
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 flex items-center justify-center hover:shadow-md transition-shadow duration-300">
                            <div class="text-center">
                                <div class="text-blue-600 mb-1">
                                    <svg class="w-8 h-8 mx-auto" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2L2 7V10C2 16 6 20.5 12 22C18 20.5 22 16 22 10V7L12 2Z"/>
                                    </svg>
                                </div>
                                <div class="text-xs font-medium text-blue-600">Bank transfer</div>
                            </div>
                        </div>

                        {{-- Koko --}}
                        {{-- <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 flex items-center justify-center hover:shadow-md transition-shadow duration-300">
                            <div class="text-center">
                                <div class="text-purple-600 font-bold text-lg">KOKO</div>
                            </div>
                        </div> --}}
                    </div>

                    {{-- Disclaimer --}}
                    <div class="text-xs text-gray-500 flex items-start">
                        <span class="text-red-500 mr-1">*</span>
                        <span>Discounts/processing fee apply at checkout</span>
                    </div>
                </div>

                {{-- Decorative Elements --}}
                <div class="absolute top-4 right-4 text-6xl text-gray-200 opacity-50">*</div>
                <div class="absolute bottom-4 left-4 w-12 h-12 bg-gradient-to-br from-blue-100 to-purple-100 rounded-full opacity-30"></div>
            </div>

            {{-- Partner Brands Section --}}
            <div class="bg-yellow-400 rounded-lg shadow-md overflow-hidden p-6 lg:p-8">
                {{-- Partners Grid --}}
                @php
                    $logos = collect(File::files(public_path('images/brands/logos')))
                                ->map(fn($file) => asset('images/brands/logos/' . $file->getFilename()))
                                ->toArray();
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 h-full">
                    <div class="bg-white rounded-lg shadow-sm p-6 flex items-center justify-center">
                        <img id="logo1" src="{{ $logos[array_rand($logos)] }}" 
                            class="w-full h-full object-contain p-4 transition-transform duration-300">
                    </div>

                    <div class="bg-white rounded-lg shadow-sm p-6 flex items-center justify-center">
                        <img id="logo2" src="{{ $logos[array_rand($logos)] }}" 
                            class="w-full h-full object-contain p-4 transition-transform duration-300">
                    </div>
                </div>

                {{-- Partnership Badge --}}
                <div class="absolute top-4 right-4 bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full transform rotate-12">
                    OFFICIAL
                </div>

                {{-- Decorative Elements --}}
                <div class="absolute bottom-0 left-0 w-20 h-20 bg-white opacity-10 rounded-full transform -translate-x-10 translate-y-10"></div>
                <div class="absolute top-0 right-0 w-16 h-16 bg-white opacity-5 rounded-full transform translate-x-8 -translate-y-8"></div>
            </div>
        </div>

        {{-- Additional Partners Row (Optional) --}}
        {{-- <div class="mt-8 bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 text-center">Our Key Brands</h3>

            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                <div class="bg-gray-50 rounded-lg flex items-center justify-center h-24 hover:bg-gray-100 transition-colors duration-300">
                    <img src="{{ asset('images/home/partners/hp.jpg')}}" 
                        alt="HP" 
                        class="h-full w-auto object-contain opacity-70 hover:opacity-100 transition-opacity duration-300">
                </div>

                <div class="bg-gray-50 rounded-lg flex items-center justify-center h-24 hover:bg-gray-100 transition-colors duration-300">
                                <img src="{{ asset('images/home/partners/hp.jpg')}}" 

                        alt="Dell" 
                        class="h-full w-auto object-contain opacity-70 hover:opacity-100 transition-opacity duration-300">
                </div>

                <div class="bg-gray-50 rounded-lg flex items-center justify-center h-24 hover:bg-gray-100 transition-colors duration-300">
                                <img src="{{ asset('images/home/partners/lenovo.jpg')}}" 

                        alt="Lenovo" 
                        class="h-full w-auto object-contain opacity-70 hover:opacity-100 transition-opacity duration-300">
                </div>

                <div class="bg-gray-50 rounded-lg flex items-center justify-center h-24 hover:bg-gray-100 transition-colors duration-300">
                                <img src="{{ asset('images/home/partners/acer.jpg')}}" 

                        alt="Acer" 
                        class="h-full w-auto object-contain opacity-70 hover:opacity-100 transition-opacity duration-300">
                </div>

                <div class="bg-gray-50 rounded-lg flex items-center justify-center h-24 hover:bg-gray-100 transition-colors duration-300">
                            <img src="{{ asset('images/home/partners/msi.jpg')}}" 

                        alt="MSI" 
                        class="h-full w-auto object-contain opacity-70 hover:opacity-100 transition-opacity duration-300">
                </div>

                <div class="bg-gray-50 rounded-lg flex items-center justify-center h-24 hover:bg-gray-100 transition-colors duration-300">
                                <img src="{{ asset('images/home/laptop.png') }}" 

                        alt="Intel" 
                        class="h-full w-auto object-contain opacity-70 hover:opacity-100 transition-opacity duration-300">
                </div>
            </div>
        </div> --}}

    </div>
</section>

<style>
/* Custom animations */
@keyframes float {
    0%, 100% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-5px);
    }
}

.floating {
    animation: float 3s ease-in-out infinite;
}

/* Hover effects for payment methods */
.payment-method:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

/* Partnership cards gradient effect */
.partner-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.1) 50%, transparent 70%);
    transform: translateX(-100%);
    transition: transform 0.6s;
}

.partner-card:hover::before {
    transform: translateX(100%);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .grid-cols-4 {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
    
    .lg\:grid-cols-6 {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }
}

/* Loading animation for partner logos */
.partner-logo {
    transition: all 0.3s ease;
}

.partner-logo:hover {
    filter: brightness(1.1) contrast(1.1);
}
</style>

<script>
    const logos = @json($logos);

    function getRandomLogo(exclude) {
        let choice;
        do {
            choice = logos[Math.floor(Math.random() * logos.length)];
        } while (choice === exclude);
        return choice;
    }

    setInterval(() => {
        const logo1 = document.getElementById("logo1");
        const logo2 = document.getElementById("logo2");

        logo1.src = getRandomLogo(logo1.src);
        logo2.src = getRandomLogo(logo2.src);
    }, 6000);
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Payment method click handlers
    const paymentMethods = document.querySelectorAll('.payment-method, [class*="hover:shadow-md"]');
    
    paymentMethods.forEach(method => {
        method.addEventListener('click', function() {
            const paymentType = this.querySelector('img')?.alt || 
                               this.querySelector('.text-xs')?.textContent || 
                               this.querySelector('.font-bold')?.textContent;
            
            console.log(`Payment method selected: ${paymentType}`);
            
            // Add visual feedback
            this.classList.add('ring-2', 'ring-blue-500', 'ring-opacity-50');
            setTimeout(() => {
                this.classList.remove('ring-2', 'ring-blue-500', 'ring-opacity-50');
            }, 2000);
        });
    });

    // Partner logo click handlers
    const partnerLogos = document.querySelectorAll('[alt*="Partner"], [alt*="HP"], [alt*="Dell"]');
    
    partnerLogos.forEach(logo => {
        logo.closest('div').addEventListener('click', function() {
            const partnerName = logo.alt;
            console.log(`Partner clicked: ${partnerName}`);
            
            // Redirect to partner page or show more info
            // window.location.href = `/partners/${partnerName.toLowerCase()}`;
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
                
                // Stagger animation for payment methods
                if (entry.target.querySelector('[alt*="Visa"], [alt*="Mastercard"]')) {
                    const paymentCards = entry.target.querySelectorAll('.grid > div');
                    paymentCards.forEach((card, index) => {
                        setTimeout(() => {
                            card.style.opacity = '1';
                            card.style.transform = 'translateY(0)';
                        }, index * 100);
                    });
                }
            }
        });
    }, observerOptions);

    // Observe main sections
    const sections = document.querySelectorAll('.bg-white, .bg-yellow-400');
    sections.forEach(section => {
        section.style.opacity = '0';
        section.style.transform = 'translateY(20px)';
        section.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(section);
    });

    // Initialize payment cards with stagger effect
    const paymentCards = document.querySelectorAll('.grid-cols-2.md\\:grid-cols-4 > div');
    paymentCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    });

    // Add floating animation to decorative elements
    const decorativeElements = document.querySelectorAll('.absolute.w-12, .absolute.w-20');
    decorativeElements.forEach(element => {
        element.classList.add('floating');
    });

    // Payment security tooltip
    const paymentSection = document.querySelector('.relative.bg-white');
    if (paymentSection) {
        const tooltip = document.createElement('div');
        tooltip.className = 'absolute top-2 left-2 bg-green-500 text-white text-xs px-2 py-1 rounded opacity-0 transition-opacity duration-300';
        tooltip.textContent = 'SSL Secured';
        paymentSection.appendChild(tooltip);

        paymentSection.addEventListener('mouseenter', () => {
            tooltip.style.opacity = '1';
        });

        paymentSection.addEventListener('mouseleave', () => {
            tooltip.style.opacity = '0';
        });
    }

    // Track partner interactions for analytics
    const trackPartnerInteraction = (partnerName, action) => {
        console.log(`Partner interaction: ${partnerName} - ${action}`);
        // Add your analytics tracking here
        // Example: gtag('event', 'partner_interaction', { partner: partnerName, action: action });
    };

    // Enhanced partner logo interactions
    partnerLogos.forEach(logo => {
        const container = logo.closest('div');
        
        container.addEventListener('mouseenter', () => {
            trackPartnerInteraction(logo.alt, 'hover');
        });
        
        container.addEventListener('click', () => {
            trackPartnerInteraction(logo.alt, 'click');
        });
    });

    // Form validation helper for payment methods
    window.validatePaymentMethod = function(selectedMethod) {
        const validMethods = ['Visa', 'Mastercard', 'Bank transfer'];
        return validMethods.includes(selectedMethod);
    };

    // Dynamic payment fee calculator
    window.calculatePaymentFee = function(amount, method) {
        const fees = {
            'Visa': amount * 0.035,
            'Mastercard': amount * 0.035,
            'Bank transfer': 0,
            'KOKO': amount * 0.02
        };
        return fees[method] || 0;
    };
});
</script>