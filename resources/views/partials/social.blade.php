@php
    // Get social media links from configuration
    $facebookUrl = config('globals.socials.facebook');
    $xUrl = config('globals.socials.x');
    $linkedinUrl = config('globals.socials.linkedin');
    $instagramUrl = config('globals.socials.instagram');
    $tiktokUrl = config('globals.socials.tiktok');
    
    // Check if any social media links exist
    $hasSocialLinks = !empty($facebookUrl) || !empty($xUrl) || !empty($linkedinUrl) || !empty($instagramUrl) || !empty($tiktokUrl);
@endphp

@if($hasSocialLinks)
    {{-- Enhanced Social Media Bar --}}
    <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 py-4 px-4 sm:px-6 lg:px-8 shadow-md">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                
                {{-- Follow Us Text --}}
                <div class="flex items-center">
                    <span class="text-gray-900 font-semibold text-sm sm:text-base">
                        Connect with us:
                    </span>
                </div>

                {{-- Social Media Icons --}}
                <div class="flex items-center gap-3 sm:gap-4">
                    
                    {{-- Facebook --}}
                    @if(!empty($facebookUrl))
                        <a href="{{ str_starts_with($facebookUrl, 'http') ? $facebookUrl : 'https://' . $facebookUrl }}"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="group relative w-12 h-12 bg-blue-600 hover:bg-blue-700 rounded-full flex items-center justify-center text-white transition-all duration-300 hover:scale-110 hover:shadow-xl hover:shadow-blue-500/25"
                           aria-label="Follow us on Facebook">
                            <svg class="w-6 h-6 transition-transform duration-300 group-hover:scale-110" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12S0 5.446 0 12.073c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                            {{-- Tooltip --}}
                            <div class="absolute -top-10 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white px-2 py-1 rounded text-xs opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                                Facebook
                            </div>
                        </a>
                    @endif

                    {{-- X (Twitter) --}}
                    @if(!empty($xUrl))
                        <a href="{{ str_starts_with($xUrl, 'http') ? $xUrl : 'https://' . $xUrl }}"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="group relative w-12 h-12 bg-black hover:bg-gray-800 rounded-full flex items-center justify-center text-white transition-all duration-300 hover:scale-110 hover:shadow-xl hover:shadow-gray-500/25"
                           aria-label="Follow us on X">
                            <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                            </svg>
                            <div class="absolute -top-10 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white px-2 py-1 rounded text-xs opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                                X (Twitter)
                            </div>
                        </a>
                    @endif

                    {{-- LinkedIn --}}
                    @if(!empty($linkedinUrl))
                        <a href="{{ str_starts_with($linkedinUrl, 'http') ? $linkedinUrl : 'https://' . $linkedinUrl }}"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="group relative w-12 h-12 bg-blue-700 hover:bg-blue-800 rounded-full flex items-center justify-center text-white transition-all duration-300 hover:scale-110 hover:shadow-xl hover:shadow-blue-700/25"
                           aria-label="Follow us on LinkedIn">
                            <svg class="w-6 h-6 transition-transform duration-300 group-hover:scale-110" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M4.98 3.5C4.98 5 3.9 6.1 2.5 6.1S0 5 0 3.5C0 2 1.08.9 2.5.9S4.98 2 4.98 3.5zM.22 24h4.56V7.98H.22V24zm7.95-16h4.37v2.16h.06c.61-1.16 2.1-2.39 4.33-2.39 4.63 0 5.48 3.04 5.48 6.98V24h-4.55v-7.58c0-1.81-.03-4.14-2.52-4.14-2.52 0-2.91 1.96-2.91 3.99V24H8.17V7.98z"/>
                            </svg>
                            <div class="absolute -top-10 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white px-2 py-1 rounded text-xs opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                                LinkedIn
                            </div>
                        </a>
                    @endif

                    {{-- Instagram --}}
                    @if(!empty($instagramUrl))
                        <a href="{{ str_starts_with($instagramUrl, 'http') ? $instagramUrl : 'https://' . $instagramUrl }}"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="group relative w-12 h-12 bg-gradient-to-tr from-purple-500 via-pink-500 to-orange-500 hover:from-purple-600 hover:via-pink-600 hover:to-orange-600 rounded-full flex items-center justify-center text-white transition-all duration-300 hover:scale-110 hover:shadow-xl hover:shadow-pink-500/25"
                           aria-label="Follow us on Instagram">
                            <svg class="w-6 h-6 transition-transform duration-300 group-hover:scale-110" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M7.5 2h9A5.5 5.5 0 0122 7.5v9a5.5 5.5 0 01-5.5 5.5h-9A5.5 5.5 0 012 16.5v-9A5.5 5.5 0 017.5 2zm0 2A3.5 3.5 0 004 7.5v9A3.5 3.5 0 007.5 20h9a3.5 3.5 0 003.5-3.5v-9A3.5 3.5 0 0016.5 4h-9zM12 7a5 5 0 110 10 5 5 0 010-10zm0 2a3 3 0 100 6 3 3 0 000-6zm4.75-3a1.25 1.25 0 110 2.5 1.25 1.25 0 010-2.5z"/>
                            </svg>
                            <div class="absolute -top-10 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white px-2 py-1 rounded text-xs opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                                Instagram
                            </div>
                        </a>
                    @endif

                    {{-- TikTok --}}
                    @if(!empty($tiktokUrl))
                        <a href="{{ str_starts_with($tiktokUrl, 'http') ? $tiktokUrl : 'https://' . $tiktokUrl }}"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="group relative w-12 h-12 bg-black hover:bg-gray-800 rounded-full flex items-center justify-center text-white transition-all duration-300 hover:scale-110 hover:shadow-xl hover:shadow-gray-500/25"
                           aria-label="Follow us on TikTok">
                            <svg class="w-6 h-6 transition-transform duration-300 group-hover:scale-110" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.53.02C13.84 0 15.14.01 16.44 0c.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                            </svg>
                            <div class="absolute -top-10 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white px-2 py-1 rounded text-xs opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                                TikTok
                            </div>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Social media tracking
    const socialLinks = document.querySelectorAll('a[aria-label*="Follow us"]');
    
    socialLinks.forEach(link => {
        link.addEventListener('click', function() {
            const platform = this.getAttribute('aria-label').replace('Follow us on ', '');
            console.log(`Social media click: ${platform}`);
            
            // Google Analytics event (if available)
            if (typeof gtag !== 'undefined') {
                gtag('event', 'social_click', {
                    platform: platform.toLowerCase(),
                    page_title: document.title
                });
            }
        });
    });

    // Enhanced keyboard navigation
    socialLinks.forEach((link, index) => {
        link.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowLeft' && index > 0) {
                e.preventDefault();
                socialLinks[index - 1].focus();
            } else if (e.key === 'ArrowRight' && index < socialLinks.length - 1) {
                e.preventDefault();
                socialLinks[index + 1].focus();
            } else if (e.key === 'Home') {
                e.preventDefault();
                socialLinks[0].focus();
            } else if (e.key === 'End') {
                e.preventDefault();
                socialLinks[socialLinks.length - 1].focus();
            }
        });
    });

    // Entrance animation on scroll
    const socialBar = document.querySelector('[class*="bg-gradient-to-r from-yellow"]');
    if (socialBar) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const icons = entry.target.querySelectorAll('a');
                    icons.forEach((icon, index) => {
                        setTimeout(() => {
                            icon.style.animation = 'socialBounce 0.6s ease-out forwards';
                        }, index * 100);
                    });
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.3 });
        
        observer.observe(socialBar);
    }
});
</script>

<style>
@keyframes socialBounce {
    0% { 
        opacity: 0; 
        transform: translateY(20px) scale(0.8); 
    }
    60% { 
        opacity: 1; 
        transform: translateY(-5px) scale(1.05); 
    }
    100% { 
        opacity: 1; 
        transform: translateY(0) scale(1); 
    }
}

/* Focus styles for accessibility */
.group:focus-visible {
    outline: 2px solid #3B82F6;
    outline-offset: 2px;
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .group:focus-visible {
        outline-color: #60A5FA;
    }
}
</style>
@endpush
