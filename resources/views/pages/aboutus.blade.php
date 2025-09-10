<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
    <title>About Us - {{ config('globals.company.name') }}</title>
    <meta name="description" content="Learn about Antony's Computers - Your trusted computer shop in Jaffna since 2010. We offer quality computers, laptops, accessories and professional IT services.">
</head>
<body class="min-h-screen bg-gray-50 dark:bg-gray-900">
    @include('partials.header')
    <main>
        {{-- Hero Section --}}
        <div class="relative bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 text-white overflow-hidden">
            <div class="absolute inset-0 bg-black opacity-50"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-blue-600/20 to-purple-600/20"></div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                <div class="text-center">
                    <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
                        Welcome to <span class="text-yellow-400">Antony's Computers</span>
                    </h1>
                    <p class="text-xl md:text-2xl mb-8 text-blue-100 max-w-3xl mx-auto">
                        Your trusted technology partner in Jaffna since 2010
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('contactus') }}" class="bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-3 px-8 rounded-full transition duration-300 transform hover:scale-105">
                            Get in Touch
                        </a>
                        <a href="#services" class="border border-white text-white hover:bg-white hover:text-gray-900 font-bold py-3 px-8 rounded-full transition duration-300">
                            Our Services
                        </a>
                    </div>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0">
                <svg viewBox="0 0 1440 120" class="fill-white">
                    <path d="M0,32L48,37.3C96,43,192,53,288,58.7C384,64,480,64,576,58.7C672,53,768,43,864,42.7C960,43,1056,53,1152,58.7C1248,64,1344,64,1392,64L1440,64L1440,120L1392,120C1344,120,1248,120,1152,120C1056,120,960,120,864,120C768,120,672,120,576,120C480,120,384,120,288,120C192,120,96,120,48,120L0,120Z"></path>
                </svg>
            </div>
        </div>

        {{-- About Content Section --}}
        <div class="bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                
                {{-- Story Section --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-20">
                    {{-- Main Content --}}
                    <div>
                        <div class="mb-8">
                            <span class="text-yellow-500 font-semibold text-lg">Our Story</span>
                            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-2 mb-6">
                                Serving Jaffna's Tech Needs Since 2010
                            </h2>
                        </div>
                        
                        <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed space-y-6">
                            <p>
                                Founded in 2010, Antony's Computers has been the go-to destination for quality computer hardware, laptops, and IT services in Jaffna. What started as a small computer shop has grown into a trusted technology partner for individuals, students, businesses, and organizations throughout the Northern Province.
                            </p>
                            
                            <p>
                                With over a decade of experience, we've witnessed the evolution of technology and have consistently adapted to bring the latest innovations to our community. Our commitment to quality products, competitive prices, and exceptional customer service has earned us the trust of thousands of satisfied customers.
                            </p>
                            
                            <p>
                                At Antony's Computers, we believe technology should be accessible to everyone. Whether you're a student looking for your first laptop, a business owner setting up an office, or a gaming enthusiast building your dream setup, we're here to guide you every step of the way.
                            </p>
                        </div>

                        {{-- Key Stats --}}
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-6 mt-10">
                            <div class="text-center">
                                <div class="text-3xl font-bold text-blue-600 mb-2">14+</div>
                                <div class="text-sm text-gray-600">Years of Service</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-blue-600 mb-2">5000+</div>
                                <div class="text-sm text-gray-600">Happy Customers</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-blue-600 mb-2">50+</div>
                                <div class="text-sm text-gray-600">Brand Partners</div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Image Section --}}
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl transform rotate-3"></div>
                        <div class="relative bg-white rounded-2xl p-8 shadow-xl">
                            <img src="{{ asset('images/about/store-front.jpg') }}" 
                                alt="Antony's Computers Store Front" 
                                class="w-full h-64 object-cover rounded-lg mb-6">
                            
                            {{-- Contact Info Card --}}
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h4 class="font-bold text-gray-900 mb-3">Visit Our Store</h4>
                                <div class="space-y-2 text-sm text-gray-600">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"/>
                                        </svg>
                                        {{ config('globals.contact.address') }}
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                        </svg>
                                        {{ config('globals.contact.phone_number') }}
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                        </svg>
                                        {{ config('globals.contact.email') }}
                                    </div>
                                </div>
                                <div class="mt-4 text-xs text-gray-500">
                                    <strong>Hours:</strong> {{ config('globals.other.company_opening_hours') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Mission & Vision --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-20">
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-100 rounded-2xl p-8">
                        <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Our Mission</h3>
                        <p class="text-gray-700 leading-relaxed">
                            To provide high-quality computer hardware, accessories, and IT services at competitive prices while delivering exceptional customer service. We aim to be the most trusted technology partner in Jaffna, helping our customers achieve their digital goals.
                        </p>
                    </div>
                    
                    <div class="bg-gradient-to-br from-yellow-50 to-orange-100 rounded-2xl p-8">
                        <div class="w-12 h-12 bg-yellow-600 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Our Vision</h3>
                        <p class="text-gray-700 leading-relaxed">
                            To become the leading computer retail and service center in the Northern Province, known for innovation, reliability, and customer satisfaction. We envision a digitally empowered community where technology enhances every aspect of life and business.
                        </p>
                    </div>
                </div>

                {{-- Our Brands Section --}}
                <div class="mb-20">
                    <div class="text-center mb-12">
                        <span class="text-yellow-500 font-semibold text-lg">Trusted Partners</span>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-2 mb-4">
                            Premium Brands We Carry
                        </h2>
                        <p class="text-gray-600 max-w-2xl mx-auto">
                            We partner with leading technology brands to bring you authentic, high-quality products with full warranty support.
                        </p>
                    </div>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-8">
                        {{-- ASUS --}}
                        <div class="group text-center p-6 bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                            <div class="mb-4 flex items-center justify-center h-16">
                                <img src="{{ asset('images/brands/asus-logo.png') }}" 
                                    alt="ASUS" 
                                    class="max-h-full w-auto object-contain group-hover:scale-110 transition-transform duration-300">
                            </div>
                            <h4 class="font-bold text-gray-900 text-sm">ASUS</h4>
                            <p class="text-xs text-gray-500 mt-1">Laptops & Components</p>
                        </div>

                        {{-- HP --}}
                        <div class="group text-center p-6 bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                            <div class="mb-4 flex items-center justify-center h-16">
                                <img src="{{ asset('images/brands/hp-logo.png') }}" 
                                    alt="HP" 
                                    class="max-h-full w-auto object-contain group-hover:scale-110 transition-transform duration-300">
                            </div>
                            <h4 class="font-bold text-gray-900 text-sm">HP</h4>
                            <p class="text-xs text-gray-500 mt-1">Laptops & Printers</p>
                        </div>

                        {{-- Dell --}}
                        <div class="group text-center p-6 bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                            <div class="mb-4 flex items-center justify-center h-16">
                                <img src="{{ asset('images/brands/dell-logo.png') }}" 
                                    alt="Dell" 
                                    class="max-h-full w-auto object-contain group-hover:scale-110 transition-transform duration-300">
                            </div>
                            <h4 class="font-bold text-gray-900 text-sm">DELL</h4>
                            <p class="text-xs text-gray-500 mt-1">Desktops & Monitors</p>
                        </div>

                        {{-- Lenovo --}}
                        <div class="group text-center p-6 bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                            <div class="mb-4 flex items-center justify-center h-16">
                                <img src="{{ asset('images/brands/lenovo-logo.png') }}" 
                                    alt="Lenovo" 
                                    class="max-h-full w-auto object-contain group-hover:scale-110 transition-transform duration-300">
                            </div>
                            <h4 class="font-bold text-gray-900 text-sm">LENOVO</h4>
                            <p class="text-xs text-gray-500 mt-1">ThinkPads & IdeaPads</p>
                        </div>

                        {{-- MSI --}}
                        <div class="group text-center p-6 bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                            <div class="mb-4 flex items-center justify-center h-16">
                                <img src="{{ asset('images/brands/msi-logo.png') }}" 
                                    alt="MSI" 
                                    class="max-h-full w-auto object-contain group-hover:scale-110 transition-transform duration-300">
                            </div>
                            <h4 class="font-bold text-gray-900 text-sm">MSI</h4>
                            <p class="text-xs text-gray-500 mt-1">Gaming Laptops</p>
                        </div>

                        {{-- Apple --}}
                        <div class="group text-center p-6 bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                            <div class="mb-4 flex items-center justify-center h-16">
                                <img src="{{ asset('images/brands/apple-logo.png') }}" 
                                    alt="Apple" 
                                    class="max-h-full w-auto object-contain group-hover:scale-110 transition-transform duration-300">
                            </div>
                            <h4 class="font-bold text-gray-900 text-sm">APPLE</h4>
                            <p class="text-xs text-gray-500 mt-1">MacBooks & iMacs</p>
                        </div>
                    </div>

                    {{-- Additional Brands Row --}}
                    <div class="grid grid-cols-3 md:grid-cols-6 gap-6 mt-8">
                        <div class="text-center">
                            <div class="bg-gray-100 rounded-lg p-4 mb-2">
                                <span class="text-sm font-semibold text-gray-700">Logitech</span>
                            </div>
                            <p class="text-xs text-gray-500">Accessories</p>
                        </div>
                        <div class="text-center">
                            <div class="bg-gray-100 rounded-lg p-4 mb-2">
                                <span class="text-sm font-semibold text-gray-700">Corsair</span>
                            </div>
                            <p class="text-xs text-gray-500">Gaming Gear</p>
                        </div>
                        <div class="text-center">
                            <div class="bg-gray-100 rounded-lg p-4 mb-2">
                                <span class="text-sm font-semibold text-gray-700">Samsung</span>
                            </div>
                            <p class="text-xs text-gray-500">Monitors & SSDs</p>
                        </div>
                        <div class="text-center">
                            <div class="bg-gray-100 rounded-lg p-4 mb-2">
                                <span class="text-sm font-semibold text-gray-700">Western Digital</span>
                            </div>
                            <p class="text-xs text-gray-500">Storage</p>
                        </div>
                        <div class="text-center">
                            <div class="bg-gray-100 rounded-lg p-4 mb-2">
                                <span class="text-sm font-semibold text-gray-700">Intel</span>
                            </div>
                            <p class="text-xs text-gray-500">Processors</p>
                        </div>
                        <div class="text-center">
                            <div class="bg-gray-100 rounded-lg p-4 mb-2">
                                <span class="text-sm font-semibold text-gray-700">NVIDIA</span>
                            </div>
                            <p class="text-xs text-gray-500">Graphics Cards</p>
                        </div>
                    </div>
                </div>

                {{-- Services Section --}}
                <div id="services" class="mb-20">
                    <div class="text-center mb-12">
                        <span class="text-yellow-500 font-semibold text-lg">What We Offer</span>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-2 mb-4">
                            Our Services
                        </h2>
                        <p class="text-gray-600 max-w-2xl mx-auto">
                            From sales to support, we provide comprehensive technology solutions for all your computing needs.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        {{-- Computer Sales --}}
                        <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 p-8">
                            <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20 3H4c-1.103 0-2 .897-2 2v11c0 1.103.897 2 2 2h7v2H8v2h8v-2h-3v-2h7c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2zM4 14V5h16l.002 9H4z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-4">Computer Sales</h3>
                            <p class="text-gray-600 mb-6 leading-relaxed">
                                Wide selection of laptops, desktops, and components from leading brands. We help you find the perfect system for your needs and budget.
                            </p>
                            <ul class="text-sm text-gray-500 mb-6 space-y-2">
                                <li>• Gaming & Business Laptops</li>
                                <li>• Custom PC Builds</li>
                                <li>• Components & Upgrades</li>
                                <li>• Student Packages</li>
                            </ul>
                            <a href="{{ route('contactus') }}" class="inline-flex items-center text-blue-600 hover:text-blue-700 font-semibold transition-colors">
                                Learn More 
                                <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"/>
                                </svg>
                            </a>
                        </div>

                        {{-- Repair Services --}}
                        <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 p-8">
                            <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-green-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M22.7 19l-9.1-9.1c.9-2.3.4-5-1.5-6.9-2-2-5-2.4-7.4-1.3L9 6 6 9 1.6 4.7C.4 7.1.9 10.1 2.9 12.1c1.9 1.9 4.6 2.4 6.9 1.5l9.1 9.1c.4.4 1 .4 1.4 0l2.3-2.3c.5-.4.5-1.1.1-1.4z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-4">Repair & Maintenance</h3>
                            <p class="text-gray-600 mb-6 leading-relaxed">
                                Expert repair services for laptops, desktops, and peripherals. Our certified technicians provide quality repairs with warranty.
                            </p>
                            <ul class="text-sm text-gray-500 mb-6 space-y-2">
                                <li>• Laptop Screen Replacement</li>
                                <li>• Motherboard Repairs</li>
                                <li>• Virus Removal & Cleanup</li>
                                <li>• Hardware Upgrades</li>
                            </ul>
                            <a href="{{ route('contactus') }}" class="inline-flex items-center text-green-600 hover:text-green-700 font-semibold transition-colors">
                                Learn More 
                                <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"/>
                                </svg>
                            </a>
                        </div>

                        {{-- Technical Support --}}
                        <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 p-8">
                            <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-4">Technical Support</h3>
                            <p class="text-gray-600 mb-6 leading-relaxed">
                                Comprehensive technical support including software installation, system optimization, and troubleshooting services.
                            </p>
                            <ul class="text-sm text-gray-500 mb-6 space-y-2">
                                <li>• Windows Installation & Setup</li>
                                <li>• Software Installation</li>
                                <li>• Network Configuration</li>
                                <li>• System Optimization</li>
                            </ul>
                            <a href="{{ route('contactus') }}" class="inline-flex items-center text-purple-600 hover:text-purple-700 font-semibold transition-colors">
                                Learn More 
                                <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"/>
                                </svg>
                            </a>
                        </div>

                        {{-- Business Solutions --}}
                        <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 p-8">
                            <div class="w-16 h-16 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-4">Business Solutions</h3>
                            <p class="text-gray-600 mb-6 leading-relaxed">
                                Complete IT solutions for businesses including network setup, bulk computer sales, and ongoing support services.
                            </p>
                            <ul class="text-sm text-gray-500 mb-6 space-y-2">
                                <li>• Bulk Computer Orders</li>
                                <li>• Network Setup & Maintenance</li>
                                <li>• Office IT Infrastructure</li>
                                <li>• Annual Maintenance Contracts</li>
                            </ul>
                            <a href="{{ route('contactus') }}" class="inline-flex items-center text-orange-600 hover:text-orange-700 font-semibold transition-colors">
                                Learn More 
                                <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"/>
                                </svg>
                            </a>
                        </div>

                        {{-- Accessories & Parts --}}
                        <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 p-8">
                            <div class="w-16 h-16 bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9.4 16.6L4.8 12l4.6-4.6L8 6l-6 6 6 6 1.4-1.4zm5.2 0L19.2 12l-4.6-4.6L16 6l6 6-6 6-1.4-1.4z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-4">Accessories & Parts</h3>
                            <p class="text-gray-600 mb-6 leading-relaxed">
                                Complete range of computer accessories, peripherals, and replacement parts from trusted brands.
                            </p>
                            <ul class="text-sm text-gray-500 mb-6 space-y-2">
                                <li>• Keyboards & Mice</li>
                                <li>• Monitors & Speakers</li>
                                <li>• Storage Devices</li>
                                <li>• Cables & Adapters</li>
                            </ul>
                            <a href="{{ route('contactus') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-700 font-semibold transition-colors">
                                Learn More 
                                <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"/>
                                </svg>
                            </a>
                        </div>

                        {{-- Custom PC Building --}}
                        <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 p-8">
                            <div class="w-16 h-16 bg-gradient-to-r from-red-500 to-pink-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12,2A3,3 0 0,1 15,5V11A3,3 0 0,1 12,14A3,3 0 0,1 9,11V5A3,3 0 0,1 12,2M19,11C19,14.53 16.39,17.44 13,17.93V21H11V17.93C7.61,17.44 5,14.53 5,11H7A5,5 0 0,0 12,16A5,5 0 0,0 17,11H19Z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-4">Custom PC Building</h3>
                            <p class="text-gray-600 mb-6 leading-relaxed">
                                Professional custom PC building services for gaming, workstations, and specialized computing needs.
                            </p>
                            <ul class="text-sm text-gray-500 mb-6 space-y-2">
                                <li>• Gaming PC Builds</li>
                                <li>• Workstation Systems</li>
                                <li>• Budget PC Assembly</li>
                                <li>• Performance Optimization</li>
                            </ul>
                            <a href="{{ route('contactus') }}" class="inline-flex items-center text-pink-600 hover:text-pink-700 font-semibold transition-colors">
                                Learn More 
                                <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Payment Methods Section --}}
                <div class="bg-gradient-to-r from-gray-50 to-blue-50 rounded-3xl p-8 mb-20">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Payment Options</h3>
                        <p class="text-gray-600">We accept multiple payment methods for your convenience</p>
                    </div>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        <div class="bg-white rounded-xl p-6 text-center shadow-md hover:shadow-lg transition-shadow duration-300">
                            <img src="{{ asset('images/visa.png') }}" alt="Visa" class="h-8 w-auto mx-auto mb-3">
                            <div class="text-sm font-medium text-gray-700">Visa Cards</div>
                        </div>
                        <div class="bg-white rounded-xl p-6 text-center shadow-md hover:shadow-lg transition-shadow duration-300">
                            <img src="{{ asset('images/master-card.png') }}" alt="Mastercard" class="h-8 w-auto mx-auto mb-3">
                            <div class="text-sm font-medium text-gray-700">Mastercard</div>
                        </div>
                        <div class="bg-white rounded-xl p-6 text-center shadow-md hover:shadow-lg transition-shadow duration-300">
                            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center mx-auto mb-3">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm0 2h12v8H4V6z"/>
                                </svg>
                            </div>
                            <div class="text-sm font-medium text-gray-700">Bank Transfer</div>
                        </div>
                        <div class="bg-white rounded-xl p-6 text-center shadow-md hover:shadow-lg transition-shadow duration-300">
                            <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center mx-auto mb-3">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm0 2h12v8H4V6z"/>
                                </svg>
                            </div>
                            <div class="text-sm font-medium text-gray-700">Cash Payment</div>
                        </div>
                    </div>
                    
                    <div class="text-center mt-6">
                        <p class="text-sm text-gray-500">
                            <span class="text-red-500">*</span> Flexible payment terms available for bulk orders
                        </p>
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
                        title: 'About Antony\'s Computers',
                        text: 'Learn more about Antony\'s Computers - Your trusted technology partner in Jaffna since 2010',
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