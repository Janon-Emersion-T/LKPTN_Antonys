{{-- Location & Services Section --}}
<section class="py-8 px-4 sm:px-6 lg:px-8 bg-gray-50">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Map Section --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    {{-- Map Header --}}
                    <div class="p-4 bg-gray-100 border-b">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Our Location</h3>
                        <p class="text-sm text-gray-600">{{ config('globals.company.name') }}, {{ config('globals.contact.address') }}</p>
                    </div>

                    {{-- Map Container --}}
                    <div class="relative h-96 lg:h-[500px] bg-gray-200" id="mapContainer">
                        {{-- Map Placeholder/Iframe --}}
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-100 to-blue-300">
                            {{-- Interactive Map Overlay --}}
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm mx-4 text-center">
                                    <div class="mb-4">
                                        <svg class="w-12 h-12 text-red-500 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"/>
                                        </svg>
                                    </div>
                                    <h4 class="font-bold text-gray-900 mb-2">{{ config('globals.company.name') }}</h4>
                                    <p class="text-sm text-gray-600 mb-4">{{ config('globals.contact.address') }}</p>
                                    <button 
                                        id="viewMapBtn"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-medium transition-colors duration-300">
                                        View Larger Map
                                    </button>
                                </div>
                            </div>

                            {{-- Map Controls --}}
                            <div class="absolute top-4 left-4">
                                <button 
                                    id="viewLargerMapBtn"
                                    class="bg-white hover:bg-gray-50 text-gray-700 px-3 py-2 rounded shadow text-sm font-medium transition-colors duration-300 border">
                                    View larger map
                                </button>
                            </div>

                            {{-- Zoom Controls --}}
                            <div class="absolute top-4 right-4 flex flex-col space-y-1">
                                <button 
                                    id="zoomInBtn"
                                    class="w-8 h-8 bg-white hover:bg-gray-50 text-gray-700 rounded shadow flex items-center justify-center text-lg font-bold transition-colors duration-300 border">
                                    +
                                </button>
                                <button 
                                    id="zoomOutBtn"
                                    class="w-8 h-8 bg-white hover:bg-gray-50 text-gray-700 rounded shadow flex items-center justify-center text-lg font-bold transition-colors duration-300 border">
                                    −
                                </button>
                            </div>

                            {{-- Map Instructions --}}
                            <div class="absolute bottom-4 left-4 bg-black/70 text-white px-3 py-2 rounded text-sm">
                                Use ctrl + scroll to zoom the map
                            </div>

                            {{-- Map Attribution --}}
                            <div class="absolute bottom-2 right-2 text-xs text-gray-600 bg-white/80 px-2 py-1 rounded">
                                <span>Keyboard shortcuts</span> | <span>Map data ©2025</span> | <span>Terms</span> | <span>Report a map error</span>
                            </div>
                        </div>

                        {{-- Actual Google Maps Embed --}}
                        <iframe 
                            id="googleMap"
                            src="{{ config('globals.other.map_iframe') }}"
                            width="100%" 
                            height="100%" 
                            style="border:0; display: none;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>

                    {{-- Contact Info Bar --}}
                    <div class="p-4 bg-gray-50 border-t">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-blue-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                </svg>
                                <span class="text-gray-700">{{ config('globals.contact.phone_number') }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                </svg>
                                <span class="text-gray-700">{{ config('globals.contact.email') }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-red-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"/>
                                </svg>
                                <span class="text-gray-700">{{ config('globals.other.company_opening_hours') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Services Section --}}
            <div class="lg:col-span-1 space-y-1">
                {{-- Service 1: Laptop Repairing --}}
                <div class="bg-white rounded-lg shadow-md p-6 text-center group hover:shadow-lg transition-shadow duration-300">
                    <div class="mb-2">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto group-hover:bg-blue-200 transition-colors duration-300">
                            <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 3H4c-1.103 0-2 .897-2 2v11c0 1.103.897 2 2 2h7v2H8v2h8v-2h-3v-2h7c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2zM4 14V5h16l.002 9H4z"/>
                                <path d="M6 12h4v2H6z"/>
                            </svg>
                        </div>
                    </div>
                    <h4 class="text-lg font-bold text-gray-900 mb-2">LAPTOP REPAIRING</h4>
                    <p class="text-sm text-gray-600 mb-4">Professional laptop repair services with genuine parts and expert technicians.</p>
                    {{-- <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg text-sm font-medium transition-colors duration-300 transform hover:scale-105">
                        Learn More
                    </button> --}}
                </div>

                {{-- Service 2: Onsite Services --}}
                <div class="bg-white rounded-lg shadow-md p-6 text-center group hover:shadow-lg transition-shadow duration-300">
                    <div class="mb-2">
                        <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto group-hover:bg-orange-200 transition-colors duration-300">
                            <svg class="w-8 h-8 text-orange-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 3H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2h14c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2zM5 19V5h14l.002 14H5z"/>
                                <path d="M7 7h10v2H7zm0 4h7v2H7z"/>
                                <circle cx="16" cy="12" r="1"/>
                                <circle cx="16" cy="15" r="1"/>
                            </svg>
                        </div>
                    </div>
                    <h4 class="text-lg font-bold text-gray-900 mb-2">ONSITE SERVICES</h4>
                    <p class="text-sm text-gray-600 mb-4">We come to you! Professional on-site computer services at your location.</p>
                    {{-- <button class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-2 rounded-lg text-sm font-medium transition-colors duration-300 transform hover:scale-105">
                        Book Service
                    </button> --}}
                </div>

                {{-- Service 3: Network Solutions --}}
                <div class="bg-white rounded-lg shadow-md p-6 text-center group hover:shadow-lg transition-shadow duration-300">
                    <div class="mb-2">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto group-hover:bg-green-200 transition-colors duration-300">
                            <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2zM5 19V5h14v14H5z"/>
                                <circle cx="7.5" cy="11.5" r="1.5"/>
                                <circle cx="16.5" cy="11.5" r="1.5"/>
                                <circle cx="12" cy="7.5" r="1.5"/>
                                <circle cx="12" cy="15.5" r="1.5"/>
                                <path d="M7.5 11.5h9M12 7.5v8"/>
                            </svg>
                        </div>
                    </div>
                    <h4 class="text-lg font-bold text-gray-900 mb-2">NETWORK SOLUTIONS</h4>
                    <p class="text-sm text-gray-600 mb-4">Complete network setup, configuration, and troubleshooting services.</p>
                    {{-- <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg text-sm font-medium transition-colors duration-300 transform hover:scale-105">
                        Get Quote
                    </button> --}}
                </div>

                {{-- Contact CTA --}}
                {{-- <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg p-6 text-center text-white">
                    <h4 class="text-lg font-bold mb-2">Need Help?</h4>
                    <p class="text-sm mb-4 text-blue-100">Contact us for personalized computer solutions</p>
                    <div class="space-y-2">
                        <a href="tel:+94117510510" class="block bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded text-sm font-medium transition-colors duration-300">
                            📞 Call Us Now
                        </a>
                        <a href="mailto:websales@barclays.lk" class="block bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded text-sm font-medium transition-colors duration-300">
                            ✉️ Email Us
                        </a>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</section>

<style>
/* Map container styles */
#mapContainer {
    position: relative;
    overflow: hidden;
}

/* Service card hover effects */
.service-card {
    transition: all 0.3s ease;
}

.service-card:hover {
    transform: translateY(-5px);
}

/* Button hover animations */
.hover\:scale-105:hover {
    transform: scale(1.05);
}

/* Responsive adjustments */
@media (max-width: 1024px) {
    .lg\:col-span-2 {
        grid-column: span 1;
    }
    
    .lg\:col-span-1 {
        grid-column: span 1;
    }
    
    .lg\:h-\[500px\] {
        height: 300px;
    }
}

@media (max-width: 768px) {
    .md\:grid-cols-3 {
        grid-template-columns: 1fr;
        gap: 0.5rem;
    }
    
    .space-y-6 > * + * {
        margin-top: 1rem;
    }
}

/* Loading animation for map */
.map-loading {
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200% 100%;
    animation: loading 1.5s infinite;
}

@keyframes loading {
    0% {
        background-position: 200% 0;
    }
    100% {
        background-position: -200% 0;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Map interaction handlers
    const viewMapBtn = document.getElementById('viewMapBtn');
    const viewLargerMapBtn = document.getElementById('viewLargerMapBtn');
    const zoomInBtn = document.getElementById('zoomInBtn');
    const zoomOutBtn = document.getElementById('zoomOutBtn');
    const googleMap = document.getElementById('googleMap');
    const mapContainer = document.getElementById('mapContainer');

    let mapVisible = false;

    // Toggle map visibility
    function toggleMap() {
        if (!mapVisible) {
            googleMap.style.display = 'block';
            mapContainer.querySelector('.absolute.inset-0.bg-gradient-to-br').style.display = 'none';
            mapVisible = true;
            console.log('Map loaded');
        } else {
            // Open in new window for larger view
            window.open('https://www.google.com/maps/place/St+Antony%27s+Computers,+149%2F1+Jaffna-Kankesanturai+Rd,+Jaffna', '_blank');
        }
    }

    // Event listeners for map buttons
    viewMapBtn.addEventListener('click', toggleMap);
    viewLargerMapBtn.addEventListener('click', toggleMap);

    // Zoom controls (simulated)
    zoomInBtn.addEventListener('click', function() {
        console.log('Zoom in clicked');
        // In a real implementation, you would control the map zoom level
    });

    zoomOutBtn.addEventListener('click', function() {
        console.log('Zoom out clicked');
        // In a real implementation, you would control the map zoom level
    });

    // Service button handlers
    const serviceButtons = document.querySelectorAll('.bg-blue-600, .bg-orange-600, .bg-green-600');
    
    serviceButtons.forEach(button => {
        button.addEventListener('click', function() {
            const serviceCard = this.closest('.bg-white');
            const serviceName = serviceCard.querySelector('h4').textContent.trim();
            
            console.log(`Service clicked: ${serviceName}`);
            
            // Add loading state
            const originalText = this.textContent;
            this.textContent = 'Loading...';
            this.disabled = true;
            
            // Simulate loading and route
            setTimeout(() => {
                this.textContent = originalText;
                this.disabled = false;
                
                // Route based on service
                switch(serviceName) {
                    case 'LAPTOP REPAIRING':
                        window.location.href = '/services/laptop-repair';
                        break;
                    case 'ONSITE SERVICES':
                        window.location.href = '/services/onsite';
                        break;
                    case 'NETWORK SOLUTIONS':
                        window.location.href = '/services/network';
                        break;
                }
            }, 1500);
        });
    });

    // Contact CTA handlers
    const contactLinks = document.querySelectorAll('a[href^="tel:"], a[href^="mailto:"]');
    
    contactLinks.forEach(link => {
        link.addEventListener('click', function() {
            const contactType = this.href.startsWith('tel:') ? 'phone' : 'email';
            console.log(`Contact ${contactType} clicked`);
            
            // Add your analytics tracking here
            // gtag('event', 'contact_click', { contact_type: contactType });
        });
    });

    // Service card hover animations
    const serviceCards = document.querySelectorAll('.group.hover\\:shadow-lg');
    
    serviceCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Map keyboard controls
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey && mapVisible) {
            if (e.key === '+' || e.key === '=') {
                e.preventDefault();
                console.log('Keyboard zoom in');
            } else if (e.key === '-') {
                e.preventDefault();
                console.log('Keyboard zoom out');
            }
        }
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
                
                // Animate service cards with stagger
                if (entry.target.classList.contains('space-y-6')) {
                    const cards = entry.target.querySelectorAll('.bg-white, .bg-gradient-to-r');
                    cards.forEach((card, index) => {
                        setTimeout(() => {
                            card.style.opacity = '1';
                            card.style.transform = 'translateY(0)';
                        }, index * 150);
                    });
                }
            }
        });
    }, observerOptions);

    // Initialize animations
    const elementsToAnimate = document.querySelectorAll('.bg-white.rounded-lg.shadow-md, .space-y-6');
    elementsToAnimate.forEach(element => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(20px)';
        element.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(element);
    });

    // Initialize service cards for stagger animation
    const serviceCardsForAnimation = document.querySelectorAll('.space-y-6 > div');
    serviceCardsForAnimation.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    });

    // Get directions functionality
    window.getDirections = function() {
        const destination = "St Antony's Computers, 149/1 Jaffna-Kankesanturai Rd, Jaffna";
        const googleMapsUrl = `https://www.google.com/maps/dir/?api=1&destination=${encodeURIComponent(destination)}`;
        window.open(googleMapsUrl, '_blank');
    };

    // Share location functionality
    window.shareLocation = function() {
        const locationData = {
            title: 'Antony\'s Computers',
            text: 'Visit us at 149/1 Jaffna-Kankesanturai Rd, Jaffna',
            url: 'https://www.google.com/maps/place/St+Antony%27s+Computers,+149%2F1+Jaffna-Kankesanturai+Rd,+Jaffna'
        };

        if (navigator.share) {
            navigator.share(locationData);
        } else {
            // Fallback - copy to clipboard
            navigator.clipboard.writeText(locationData.url).then(() => {
                alert('Location link copied to clipboard!');
            });
        }
    };

    // Load map on user interaction (performance optimization)
    let mapLoaded = false;
    function loadMapOnInteraction() {
        if (!mapLoaded) {
            // Add loading animation
            mapContainer.classList.add('map-loading');
            
            setTimeout(() => {
                mapContainer.classList.remove('map-loading');
                mapLoaded = true;
            }, 1000);
        }
    }

    // Trigger map load on scroll or click
    window.addEventListener('scroll', loadMapOnInteraction, { once: true });
    mapContainer.addEventListener('click', loadMapOnInteraction, { once: true });
});
</script>