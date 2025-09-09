<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
    <title>Brands - {{ config('app.name') }}</title>
    <meta name="description" content="Browse all brands at {{ config('app.name') }}. Find products from Dell, HP, Lenovo, ASUS, Acer, Apple and more leading technology brands.">
</head>
<body class="min-h-screen bg-gray-50 dark:bg-gray-900">
    @include('partials.header')
    <main>
        {{-- About Page Component --}}
        <div class="bg-white min-h-screen">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                
                {{-- Header Section --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
                    {{-- Main Content --}}
                    <div class="lg:col-span-2">
                        <h1 class="text-3xl font-bold text-gray-900 mb-4">Welcome to Barclays Computers (PVT) Ltd</h1>
                        <h2 class="text-xl text-blue-600 font-semibold mb-6">Elevate Your Digital Experience with Excellence!</h2>
                        
                        {{-- Company Description --}}
                        <div class="prose prose-gray max-w-none text-justify leading-relaxed space-y-4">
                            <p>
                                Barclays Computers PVT LTD was founded in 2004 with the idea of leveraging the established and recognized computer parts in the market. We have shared a vision for providing outstanding services for over two decades. We have consistently updated our products and Services significantly shaping the nations tech landscape.
                            </p>
                            
                            <p>
                                With an impassioned team pushing more than two decades, we have consistently maintained a forward-thinking approach that enables us to serve our clients better. Our headquarters is currently located at 149/1 Jaffna-Kankesanturai Rd, Jaffna which serves as a monument for all our valued customers. In 2024 and engagement our exceptional services franchise.
                            </p>
                            
                            <p>
                                At Barclays Computers, we are your gateway to a world of cutting-edge technology, ensuring optimal efficiency and convenience for leading international brands, we bring you the best in tech innovation.
                            </p>
                            
                            {{-- Services List --}}
                            <ul class="list-disc list-inside space-y-1 text-gray-700">
                                <li>Abuse, Motherboards, Graphics Cards, Monitors and Gaming, etc.</li>
                                <li>Cooler Master - Callings, Power Supplies and Coolers</li>
                                <li>A4 Tech - Computer Accessories</li>
                                <li>Logitech - Computer Keyboards and Mouse</li>
                                <li>EZCool - Callings and Power Supply Units</li>
                                <li>VCOM all types of IT related Cables and Networking Products</li>
                            </ul>
                            
                            <p>
                                We are also proud to offer nationwide Mega POS designed to meet your unique needs, whether it's for home, office, or gaming. Our team of experts can guide these systems for peak performance, ensuring your digital journey. We provide comprehensive business solutions.
                            </p>
                            
                            <p>
                                Above all, Barclays Computers holds the distinction of being an authorized channel reseller for renowned industry leaders in demos and desktop computing, including Intel, Microsoft, HP, Dell Samsung, Lenovo, and Acer. This strategic partnership underscores our dedication to offering cutting-edge technology solutions to our valued clientele.
                            </p>
                        </div>
                        
                        {{-- Vision Section --}}
                        <div class="mt-8 p-6 bg-blue-50 rounded-lg">
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Our Vision:</h3>
                            <p class="text-gray-700 italic">"We are dedicated to providing you with the "Best Sales and Service Experience""</p>
                        </div>
                    </div>
                    
                    {{-- Sidebar Image --}}
                    <div class="lg:col-span-1">
                        <div class="sticky top-8">
                            <img src="{{ asset('images/about/office-interior.jpg') }}" 
                                alt="Barclays Computers Office Interior" 
                                class="w-full h-auto rounded-lg shadow-lg">
                            <div class="mt-4 text-center">
                                <div class="bg-yellow-400 text-black px-4 py-2 rounded-lg font-bold text-sm">
                                    149/1 Jaffna-Kankesanturai Rd, Jaffna - Tel: 011 7291918
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Our Brands Section --}}
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-gray-900 mb-8 text-center">Key Brands</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                        {{-- Intel Partner --}}
                        <div class="text-center p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                            <div class="mb-4">
                                <img src="{{ asset('images/brands/logo/intel-logo.png') }}" 
                                    alt="Intel" 
                                    class="h-16 w-auto mx-auto object-contain">
                            </div>
                            <h4 class="font-bold text-gray-900 mb-1">INTEL</h4>
                            <p class="text-sm text-gray-600">PLATINUM PARTNER</p>
                        </div>

                        {{-- HP Partner --}}
                        <div class="text-center p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                            <div class="mb-4">
                                <img src="{{ asset('images/partners/hp-logo.png') }}" 
                                    alt="HP" 
                                    class="h-16 w-auto mx-auto object-contain">
                            </div>
                            <h4 class="font-bold text-gray-900 mb-1">HP</h4>
                            <p class="text-sm text-gray-600">GOLD PARTNER</p>
                        </div>

                        {{-- Dell Partner --}}
                        <div class="text-center p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                            <div class="mb-4">
                                <img src="{{ asset('images/partners/dell-logo.png') }}" 
                                    alt="Dell" 
                                    class="h-16 w-auto mx-auto object-contain">
                            </div>
                            <h4 class="font-bold text-gray-900 mb-1">DELL</h4>
                            <p class="text-sm text-gray-600">GOLD PARTNER</p>
                        </div>

                        {{-- Microsoft Partner --}}
                        <div class="text-center p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                            <div class="mb-4">
                                <img src="{{ asset('images/partners/microsoft-logo.png') }}" 
                                    alt="Microsoft" 
                                    class="h-16 w-auto mx-auto object-contain">
                            </div>
                            <h4 class="font-bold text-gray-900 mb-1">MICROSOFT</h4>
                            <p class="text-sm text-gray-600">GOLD PARTNER</p>
                        </div>
                    </div>
                </div>

                {{-- Payment & Partners Section --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
                    {{-- Payment Methods --}}
                    <div class="bg-gray-100 rounded-lg p-6">
                        <div class="mb-4">
                            <h3 class="text-sm text-gray-600 mb-2">For your convenience</h3>
                            <h2 class="text-2xl font-bold text-red-500 mb-4">we accept</h2>
                        </div>
                        
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                            <div class="bg-white rounded p-3 flex items-center justify-center">
                                <img src="{{ asset('images/payment/visa-logo.png') }}" alt="Visa" class="h-8 w-auto">
                            </div>
                            <div class="bg-white rounded p-3 flex items-center justify-center">
                                <img src="{{ asset('images/payment/mastercard-logo.png') }}" alt="Mastercard" class="h-8 w-auto">
                            </div>
                            <div class="bg-white rounded p-3 flex items-center justify-center text-center">
                                <div class="text-blue-600 text-xs font-medium">Bank transfer</div>
                            </div>
                            <div class="bg-white rounded p-3 flex items-center justify-center">
                                <div class="text-purple-600 font-bold text-sm">KOKO</div>
                            </div>
                        </div>
                        
                        <p class="text-xs text-gray-500">
                            <span class="text-red-500">*</span> Discounts/processing fee apply at checkout
                        </p>
                    </div>

                    {{-- Brand Partners --}}
                    <div class="bg-yellow-400 rounded-lg p-6">
                        <div class="grid grid-cols-2 gap-4 h-full">
                            <div class="bg-white rounded-lg p-4 flex items-center justify-center">
                                <img src="{{ asset('images/partners/vcom-logo.png') }}" 
                                    alt="VCOM" 
                                    class="max-h-12 w-auto object-contain">
                            </div>
                            <div class="bg-white rounded-lg p-4 flex items-center justify-center">
                                <img src="{{ asset('images/partners/a4tech-logo.png') }}" 
                                    alt="A4TECH" 
                                    class="max-h-12 w-auto object-contain">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Services Section --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    {{-- Laptop Repairing --}}
                    <div class="text-center p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                        <div class="mb-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto">
                                <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20 3H4c-1.103 0-2 .897-2 2v11c0 1.103.897 2 2 2h7v2H8v2h8v-2h-3v-2h7c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2zM4 14V5h16l.002 9H4z"/>
                                </svg>
                            </div>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">Laptop Repairing</h4>
                        <p class="text-sm text-gray-600 mb-3">Extend your valuable laptops to real experienced technicians who repair cost to motherboard-level repair.</p>
                        <a href="/services/laptop-repair" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            Learn More →
                        </a>
                    </div>

                    {{-- Onsite Services --}}
                    <div class="text-center p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                        <div class="mb-4">
                            <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mx-auto">
                                <svg class="w-6 h-6 text-orange-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                            </div>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">Onsite Services</h4>
                        <p class="text-sm text-gray-600 mb-3">Desktop, Laptop, Server and Networking & OMNI. We will come to our business. Call us for a quick fix to minimize your downtime.</p>
                        <a href="/services/onsite" class="text-orange-600 hover:text-orange-800 text-sm font-medium">
                            Learn More →
                        </a>
                    </div>

                    {{-- Annual Maintenance --}}
                    <div class="text-center p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                        <div class="mb-4">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto">
                                <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                                </svg>
                            </div>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">Annual maintenance</h4>
                        <p class="text-sm text-gray-600 mb-3">Sign up for an annual maintenance contract with Barclays to understand all your IT infrastructure for better performance.</p>
                        <a href="/services/maintenance" class="text-green-600 hover:text-green-800 text-sm font-medium">
                            Learn More →
                        </a>
                    </div>

                    {{-- Network Solutions --}}
                    <div class="text-center p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                        <div class="mb-4">
                            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto">
                                <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M1 9l2 2c2.88-2.88 6.78-4.08 10.53-3.62l1.48-1.48C10.15 4.12 4.45 5.82 1 9z"/>
                                    <path d="M5 13l2 2c1.78-1.77 4.37-2.08 6.56-.92l1.44-1.44C12.38 10.84 7.57 11.12 5 13z"/>
                                    <path d="M9 17l2 2c.67-.67 1.76-.67 2.43 0L15 17c-1.31-1.31-3.69-1.31-5 0z"/>
                                </svg>
                            </div>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">Network Solutions</h4>
                        <p class="text-sm text-gray-600 mb-3">Networking our "POP WiFi are a good job installer It is a setup project of an existing network.</p>
                        <a href="/services/network" class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                            Learn More →
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <style>
        .prose {
            max-width: none;
        }

        .prose p {
            margin-bottom: 1rem;
        }

        .prose ul {
            margin-top: 0.5rem;
            margin-bottom: 1rem;
        }

        .prose li {
            margin-bottom: 0.25rem;
        }

        /* Smooth scroll behavior for internal links */
        html {
            scroll-behavior: smooth;
        }

        /* Hover effects for partner cards */
        .hover\:shadow-lg:hover {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        /* Responsive text adjustments */
        @media (max-width: 768px) {
            .text-3xl {
                font-size: 1.75rem;
            }
            
            .text-xl {
                font-size: 1.125rem;
            }
            
            .prose {
                font-size: 0.9rem;
            }
        }

        /* Print styles */
        @media print {
            .shadow-md,
            .shadow-lg {
                box-shadow: none;
                border: 1px solid #e5e7eb;
            }
        }
        </style>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Smooth scroll for anchor links
            const anchorLinks = document.querySelectorAll('a[href^="#"]');
            anchorLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href').substring(1);
                    const targetElement = document.getElementById(targetId);
                    if (targetElement) {
                        targetElement.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Add loading animation for images
            const images = document.querySelectorAll('img');
            images.forEach(img => {
                img.addEventListener('load', function() {
                    this.style.opacity = '1';
                });
                
                // Set initial opacity for smooth loading
                img.style.opacity = '0';
                img.style.transition = 'opacity 0.3s ease';
            });

            // Partner card click tracking
            const partnerCards = document.querySelectorAll('.hover\\:shadow-lg');
            partnerCards.forEach(card => {
                card.addEventListener('click', function() {
                    const partnerName = this.querySelector('h4')?.textContent;
                    console.log(`Partner card clicked: ${partnerName}`);
                    // Add analytics tracking here
                });
            });

            // Service links click tracking
            const serviceLinks = document.querySelectorAll('a[href^="/services/"]');
            serviceLinks.forEach(link => {
                link.addEventListener('click', function() {
                    const serviceName = this.closest('.text-center').querySelector('h4').textContent;
                    console.log(`Service link clicked: ${serviceName}`);
                    // Add analytics tracking here
                });
            });

            // Intersection Observer for scroll animations
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

            // Animate sections on scroll
            const sections = document.querySelectorAll('.grid, .prose, .bg-blue-50');
            sections.forEach((section, index) => {
                section.style.opacity = '0';
                section.style.transform = 'translateY(20px)';
                section.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
                observer.observe(section);
            });

            // Contact form handling (if needed)
            window.contactUs = function() {
                window.location.href = '/contact';
            };

            // Print page function
            window.printPage = function() {
                window.print();
            };

            // Share page function
            window.sharePage = function() {
                if (navigator.share) {
                    navigator.share({
                        title: 'About Barclays Computers',
                        text: 'Learn more about Barclays Computers - Your trusted technology partner since 2004',
                        url: window.location.href
                    });
                } else {
                    // Fallback - copy URL to clipboard
                    navigator.clipboard.writeText(window.location.href).then(() => {
                        alert('Page URL copied to clipboard!');
                    });
                }
            };
        });
        </script>
    </main>
    @include('partials.footer')

    <script>
        // Add to Cart functionality
        async function addToCart(productId) {
            try {
                const response = await fetch('{{ route('cart.add') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: 1
                    })
                });

                const data = await response.json();
                
                if (data.success) {
                    showNotification('Product added to cart!', 'success');
                    updateCartCount(data.cart_count);
                } else {
                    showNotification(data.message || 'Failed to add product to cart', 'error');
                }
            } catch (error) {
                showNotification('An error occurred. Please try again.', 'error');
            }
        }

        // Wishlist functionality
        async function toggleWishlist(productId) {
            @guest
                alert('Please login to add items to wishlist');
                return;
            @endguest

            try {
                const response = await fetch('{{ route('customer.wishlist.add') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: productId
                    })
                });

                const data = await response.json();
                
                if (data.success) {
                    showNotification('Added to wishlist!', 'success');
                } else {
                    showNotification(data.message || 'Failed to add to wishlist', 'error');
                }
            } catch (error) {
                showNotification('An error occurred. Please try again.', 'error');
            }
        }

        // Utility function for notifications
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 rounded-lg px-6 py-3 text-white shadow-lg transition-opacity ${
                type === 'success' ? 'bg-green-500' : 'bg-red-500'
            }`;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.opacity = '0';
                setTimeout(() => document.body.removeChild(notification), 300);
            }, 3000);
        }

        function updateCartCount(count) {
            const cartCountElements = document.querySelectorAll('[data-cart-count]');
            cartCountElements.forEach(el => {
                el.textContent = count;
            });
        }
    </script>
</body>
</html>