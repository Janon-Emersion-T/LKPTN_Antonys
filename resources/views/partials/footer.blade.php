@include('partials.social')
{{-- St Antony's Computers Footer Component --}}
<footer class="bg-gradient-to-br from-gray-900 to-gray-800 text-white">
    {{-- Main Footer Content --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
            
            {{-- Company Info Section --}}
            <div class="col-span-1 lg:col-span-1">
                {{-- Logo and Company Name --}}
                <div class="mb-6">
                    <div class="flex items-center space-x-4 mb-4">
                        <img src="{{ asset('images/logo.png')}}" 
                            alt="{{ env('GLOBALS_COMPANY_NAME') }}" 
                            class="h-16 w-auto">
                        <div>
                            <h2 class="text-xl font-bold text-white leading-tight">
                                {{ env('GLOBALS_COMPANY_NAME') }}
                            </h2>
                            <p class="text-sm text-gray-300"></p>
                        </div>
                    </div>

                    <p class="text-gray-300 text-sm leading-relaxed">
                        {{ env('GLOBALS_COMPANY_TAGLINE') }}
                    </p>
                </div>
            </div>


            {{-- Contact Section--}}
            {{-- Contact Information --}}
            <div class="col-span 1">
                <h3 class="font-bold text-white mb-6 text-lg">Contact Us</h3>
                <div class="space-y-4">
                    <div class="flex items-center space-x-3 group">
                        <div class="flex-shrink-0 w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center group-hover:bg-blue-500 transition-colors">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                            </svg>
                        </div>
                        <div>
                            <a href="mailto:{{ env('globals.contact.CONTACT_EMAIL') }}" 
                               class="text-gray-300 hover:text-white transition-colors text-sm">
                                {{ env('GLOBALS.CONTACT.EMAIL') }}
                            </a>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-3 group">
                        <div class="flex-shrink-0 w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center group-hover:bg-green-500 transition-colors">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                            </svg>
                        </div>
                        <div>
                            <a href="tel:+{{ env('GLOBALS.CONTACT.PHONE_NUMBER') }}" 
                               class="text-gray-300 hover:text-white transition-colors text-sm">
                                {{ env('GLOBALS.CONTACT.PHONE_NUMBER') }}
                            </a>
                        </div>
                    </div>
                    
                   <div class="flex items-center space-x-3 group">
                        <div class="flex-shrink-0 w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center group-hover:bg-green-400 transition-colors">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                            </svg>
                        </div>
                        <div>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', env('GLOBALS.CONTACT.WHATAPP_PHONE_NUMBER')) }}" 
                            target="_blank" 
                            rel="noopener"
                            class="text-gray-300 hover:text-white transition-colors text-sm font-medium">
                                WhatsApp Support
                            </a>
                            <p class="text-xs text-gray-400 mt-1">Quick assistance available</p>
                        </div>
                    </div>

                    
                    <div class="flex items-start space-x-3 pt-2">
                        <div class="flex-shrink-0 w-8 h-8 bg-red-600 rounded-lg flex items-center justify-center mt-1">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"/>
                            </svg>
                        </div>
                        <div class="text-gray-300 text-sm">
                            <p class="font-medium text-white">Visit Our Store</p>
                            <p class="leading-relaxed">{{ env('GLOBALS.CONTACT.ADDRESS') }}</p>
                        </div>
                    </div>
                </div>
            </div>


            {{-- Information Section --}}
            <div class="col-span-1">
                <h3 class="font-bold text-white mb-6 text-lg">Information</h3>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('deliveryinformation')}}" 
                           class="text-gray-300 hover:text-white transition-colors duration-200 flex items-center group text-sm">
                            <svg class="w-3 h-3 mr-2 text-blue-400 group-hover:translate-x-1 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"/>
                            </svg>
                            Delivery Information
                        </a>
                    </li>
                    {{-- <li>
                        <a href="#" 
                           class="text-gray-300 hover:text-white transition-colors duration-200 flex items-center group text-sm">
                            <svg class="w-3 h-3 mr-2 text-blue-400 group-hover:translate-x-1 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"/>
                            </svg>
                            Special Offers
                        </a>
                    </li> --}}
                    <li>
                        <a href="{{ route('privacypolicy')}}" 
                           class="text-gray-300 hover:text-white transition-colors duration-200 flex items-center group text-sm">
                            <svg class="w-3 h-3 mr-2 text-blue-400 group-hover:translate-x-1 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"/>
                            </svg>
                            Privacy Policy
                        </a>
                    </li>
                    <li>
                        <a href="{{-- {{ route('faq')}} --}}" 
                           class="text-gray-300 hover:text-white transition-colors duration-200 flex items-center group text-sm">
                            <svg class="w-3 h-3 mr-2 text-blue-400 group-hover:translate-x-1 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"/>
                            </svg>
                            FAQs
                        </a>
                    </li>
                    <li>
                        <a href="{{-- {{ route('termsandconditions')}} --}}" 
                           class="text-gray-300 hover:text-white transition-colors duration-200 flex items-center group text-sm">
                            <svg class="w-3 h-3 mr-2 text-blue-400 group-hover:translate-x-1 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"/>
                            </svg>
                            Terms & Conditions
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Quick Links Section --}}
            <div class="col-span-1">
                <h3 class="font-bold text-white mb-6 text-lg">Quick Links</h3>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('home')}}" 
                           class="text-gray-300 hover:text-white transition-colors duration-200 flex items-center group text-sm">
                            <svg class="w-3 h-3 mr-2 text-blue-400 group-hover:translate-x-1 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"/>
                            </svg>
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('aboutus')}}" 
                           class="text-gray-300 hover:text-white transition-colors duration-200 flex items-center group text-sm">
                            <svg class="w-3 h-3 mr-2 text-blue-400 group-hover:translate-x-1 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"/>
                            </svg>
                            About Us
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contactus')}}" 
                           class="text-gray-300 hover:text-white transition-colors duration-200 flex items-center group text-sm">
                            <svg class="w-3 h-3 mr-2 text-blue-400 group-hover:translate-x-1 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"/>
                            </svg>
                            Contact Us
                        </a>
                    </li>
                    <li>
                        <a href="#" 
                           class="text-gray-300 hover:text-white transition-colors duration-200 flex items-center group text-sm">
                            <svg class="w-3 h-3 mr-2 text-blue-400 group-hover:translate-x-1 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"/>
                            </svg>
                            Track Your Order
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Services Section --}}
            {{-- <div class="col-span-1">
                <h3 class="font-bold text-white mb-6 text-lg">Our Services</h3>
                <ul class="space-y-3">
                    <li>
                        <a href="#" 
                           class="text-gray-300 hover:text-white transition-colors duration-200 flex items-center group text-sm">
                            <svg class="w-3 h-3 mr-2 text-blue-400 group-hover:translate-x-1 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"/>
                            </svg>
                            Laptop Price List
                        </a>
                    </li>
                    <li>
                        <a href="#" 
                           class="text-gray-300 hover:text-white transition-colors duration-200 flex items-center group text-sm">
                            <svg class="w-3 h-3 mr-2 text-blue-400 group-hover:translate-x-1 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"/>
                            </svg>
                            Online Payment
                        </a>
                    </li>
                    <li>
                        <a href="#" 
                           class="text-gray-300 hover:text-white transition-colors duration-200 flex items-center group text-sm">
                            <svg class="w-3 h-3 mr-2 text-blue-400 group-hover:translate-x-1 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"/>
                            </svg>
                            Technical Support
                        </a>
                    </li>
                    <li>
                        <a href="#" 
                           class="text-gray-300 hover:text-white transition-colors duration-200 flex items-center group text-sm">
                            <svg class="w-3 h-3 mr-2 text-blue-400 group-hover:translate-x-1 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"/>
                            </svg>
                            Postal Codes
                        </a>
                    </li>
                </ul>
            </div> --}}
        </div>
    </div>

    {{-- Bottom Section --}}
    <div class="border-t border-gray-700 bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                
                {{-- Copyright --}}
                <div class="text-center md:text-left">
                    <p class="text-gray-300 text-sm">
                        © {{ now()->year }} <a href="{{ env('globals.contact.url')}}">{{env('globals.contact.company_name')}}</a>. All rights reserved.
                    </p>
                    <p class="text-gray-400 text-xs mt-1">
                        Design & Developed by 
                        <a href="https://lkprofessionals.com" target="_blank" rel="noopener"
                           class="text-blue-400 hover:text-blue-300 transition-colors font-medium">
                           LKProfessionals (Pvt) Ltd.
                        </a>
                    </p>
                </div>

                {{-- Payment Methods --}}
                <div class="flex items-center space-x-4">
                    <p class="text-gray-400 text-xs mr-2">Secure Payments:</p>
                    <div class="flex items-center space-x-3">
                        <img src="{{ asset('images/visa.png')}}" alt="Visa Payment" 
                             class="h-8 w-auto opacity-70 hover:opacity-100 transition-opacity duration-200">
                        <img src="{{ asset('images/master-card.png')}}" alt="Mastercard Payment" 
                             class="h-8 w-auto opacity-70 hover:opacity-100 transition-opacity duration-200">
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enhanced smooth scroll for internal links
    const internalLinks = document.querySelectorAll('footer a[href^="#"]');
    internalLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            if (targetElement) {
                const headerOffset = 80; // Adjust based on your header height
                const elementPosition = targetElement.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                
                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Add loading state for external links
    const externalLinks = document.querySelectorAll('footer a[href^="http"], footer a[href^="mailto:"], footer a[href^="tel:"]');
    externalLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Add a subtle loading indicator for external links
            const originalText = this.innerHTML;
            if (this.href.startsWith('http')) {
                // Only show loading for http links, not mailto/tel
                this.style.opacity = '0.7';
                setTimeout(() => {
                    this.style.opacity = '1';
                }, 200);
            }
        });
    });

    // Enhanced WhatsApp link with custom message
    const whatsappLink = document.querySelector('a[href^="https://wa.me/"]');
    if (whatsappLink) {
        // Add a default message to WhatsApp link
        const currentHref = whatsappLink.getAttribute('href');
        const defaultMessage = encodeURIComponent('Hello! I\'m interested in your computer products and services.');
        if (!currentHref.includes('?text=')) {
            whatsappLink.setAttribute('href', `${currentHref}?text=${defaultMessage}`);
        }
        
        whatsappLink.addEventListener('click', function() {
            // Track WhatsApp engagement
            if (typeof gtag !== 'undefined') {
                gtag('event', 'click', {
                    event_category: 'Contact',
                    event_label: 'WhatsApp',
                    value: 1
                });
            }
        });
    }

    // Add hover effects for contact icons
    const contactIcons = document.querySelectorAll('footer .w-8.h-8');
    contactIcons.forEach(icon => {
        icon.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.1)';
        });
        
        icon.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });

    // Accessibility improvements
    const footerLinks = document.querySelectorAll('footer a');
    footerLinks.forEach(link => {
        // Add focus indicators
        link.addEventListener('focus', function() {
            this.style.outline = '2px solid #3B82F6';
            this.style.outlineOffset = '2px';
        });
        
        link.addEventListener('blur', function() {
            this.style.outline = 'none';
        });
    });
});

// Add intersection observer for footer animation (optional)
const footer = document.querySelector('footer');
if (footer && 'IntersectionObserver' in window) {
    const footerObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, {
        threshold: 0.1
    });
    
    footer.style.opacity = '0';
    footer.style.transform = 'translateY(20px)';
    footer.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
    
    footerObserver.observe(footer);
}
</script>