{{-- Social Media Bar Component --}}
<div class="bg-yellow-400 py-3 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-center items-center space-x-4">

            {{-- Facebook --}}
            @if(env('GLOBALS.SOCIALS.FACEBOOK'))
                <a href="{{ env('GLOBALS.SOCIALS.FACEBOOK') }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="w-10 h-10 bg-blue-600 hover:bg-blue-700 rounded-full flex items-center justify-center text-white transition-all duration-300 hover:scale-110 hover:shadow-lg"
                   aria-label="Follow us on Facebook">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12S0 5.446 0 12.073c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                </a>
            @endif

            {{-- Twitter --}}
            @if(env('GLOBALS.SOCIALS.X'))
                <a href="{{ env('GLOBALS.SOCIALS.X') }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="w-10 h-10 bg-blue-400 hover:bg-blue-500 rounded-full flex items-center justify-center text-white transition-all duration-300 hover:scale-110 hover:shadow-lg"
                   aria-label="Follow us on Twitter">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M23 3a10.9 10.9 0 01-3.14 1.53A4.48 4.48 0 0022.4.36a9.1 9.1 0 01-2.88 1.1A4.52 4.52 0 0016.11 0c-2.63 0-4.77 2.15-4.77 4.8 0 .38.04.75.12 1.1C7.69 5.7 4.07 3.8 1.64.9a4.82 4.82 0 00-.65 2.42c0 1.67.84 3.15 2.13 4.02a4.42 4.42 0 01-2.17-.61v.06c0 2.33 1.64 4.27 3.82 4.71a4.52 4.52 0 01-2.15.08c.61 1.9 2.39 3.29 4.5 3.33A9.06 9.06 0 010 19.54 12.8 12.8 0 006.92 21c8.3 0 12.84-7.06 12.84-13.18 0-.2 0-.39-.01-.58A9.22 9.22 0 0023 3z"/>
                    </svg>
                </a>
            @endif

            {{-- LinkedIn --}}
            @if(env('globals.socials.linkedin'))
                <a href="{{ env('globals.socials.linkedin') }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="w-10 h-10 bg-blue-700 hover:bg-blue-800 rounded-full flex items-center justify-center text-white transition-all duration-300 hover:scale-110 hover:shadow-lg"
                   aria-label="Follow us on LinkedIn">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M4.98 3.5C4.98 5 3.9 6.1 2.5 6.1S0 5 0 3.5C0 2 1.08.9 2.5.9S4.98 2 4.98 3.5zM.22 24h4.56V7.98H.22V24zm7.95-16h4.37v2.16h.06c.61-1.16 2.1-2.39 4.33-2.39 4.63 0 5.48 3.04 5.48 6.98V24h-4.55v-7.58c0-1.81-.03-4.14-2.52-4.14-2.52 0-2.91 1.96-2.91 3.99V24H8.17V7.98z"/>
                    </svg>
                </a>
            @endif

            {{-- Instagram --}}
            @if(env('globals.socials.instagram'))
                <a href="{{ env('globals.socials.instagram') }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="w-10 h-10 bg-gradient-to-tr from-yellow-400 via-red-500 to-purple-500 hover:from-yellow-500 hover:via-red-600 hover:to-purple-600 rounded-full flex items-center justify-center text-white transition-all duration-300 hover:scale-110 hover:shadow-lg"
                   aria-label="Follow us on Instagram">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M7.5 2h9A5.5 5.5 0 0122 7.5v9a5.5 5.5 0 01-5.5 5.5h-9A5.5 5.5 0 012 16.5v-9A5.5 5.5 0 017.5 2zm0 2A3.5 3.5 0 004 7.5v9A3.5 3.5 0 007.5 20h9a3.5 3.5 0 003.5-3.5v-9A3.5 3.5 0 0016.5 4h-9zM12 7a5 5 0 110 10 5 5 0 010-10zm0 2a3 3 0 100 6 3 3 0 000-6zm4.75-3a1.25 1.25 0 110 2.5 1.25 1.25 0 010-2.5z"/>
                    </svg>
                </a>
            @endif

            @if(env('globals.socials.tiktok'))
                <a href="{{ env('globals.socials.tiktok') }}"
                target="_blank"
                rel="noopener noreferrer"
                class="w-10 h-10 bg-black hover:bg-gray-900 rounded-full flex items-center justify-center text-white transition-all duration-300 hover:scale-110 hover:shadow-lg"
                aria-label="Follow us on TikTok">
                    <svg class="w-5 h-5" viewBox="0 0 256 256" fill="currentColor">
                        <path d="M204.3 70.9c-9.4 0-18.2-2.3-25.9-6.4v79.8c0 42.6-34.6 77.2-77.2 77.2-42.6 0-77.2-34.6-77.2-77.2 0-42.6 34.6-77.2 77.2-77.2 9.1 0 17.9 1.5 26 4.3v27.3c-7.1-1.7-14.5-2.6-22.1-2.6-30.3 0-55 24.7-55 55s24.7 55 55 55c30.3 0 55-24.7 55-55V70.9z"/>
                    </svg>
                </a>
            @endif
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const socialLinks = document.querySelectorAll('a[aria-label*="Follow us"], a[aria-label*="Subscribe"]');
    
    socialLinks.forEach(link => {
        link.addEventListener('click', function() {
            const platform = this.getAttribute('aria-label').split(' ').pop();
            console.log(`Social media click: ${platform}`);
            // Example: gtag('event', 'social_click', { platform: platform });
        });
    });

    // Keyboard navigation
    socialLinks.forEach((link, index) => {
        link.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowLeft' && index > 0) {
                e.preventDefault();
                socialLinks[index - 1].focus();
            } else if (e.key === 'ArrowRight' && index < socialLinks.length - 1) {
                e.preventDefault();
                socialLinks[index + 1].focus();
            }
        });
    });

    // Scroll animation
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const socialIcons = entry.target.querySelectorAll('a');
                socialIcons.forEach((icon, index) => {
                    setTimeout(() => {
                        icon.style.transform = 'scale(1.1)';
                        setTimeout(() => {
                            icon.style.transform = 'scale(1)';
                        }, 150);
                    }, index * 100);
                });
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -10px 0px' });

    const socialBar = document.querySelector('.bg-yellow-400');
    if (socialBar) observer.observe(socialBar);
});
</script>
