{{-- Latest News Section --}}
<section class="py-8 px-4 sm:px-6 lg:px-8 bg-white">
    <div class="max-w-7xl mx-auto">
        {{-- Section Header --}}
        <div class="mb-8">
            <h2 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-2">LATEST NEWS</h2>
            <div class="w-16 h-1 bg-blue-600 rounded"></div>
        </div>

        {{-- News Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            @php
                try {
                    $latestNews = \App\Models\News::with('category')
                        ->where('status', 'published')
                        ->whereNotNull('published_at')
                        ->where('published_at', '<=', now())
                        ->orderBy('published_at', 'desc')
                        ->limit(3)
                        ->get();
                } catch (Exception $e) {
                    $latestNews = collect([]);
                    \Log::error('Error fetching latest news: ' . $e->getMessage());
                }
            @endphp

            @forelse($latestNews as $news)
                <article class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden group">
                    {{-- Article Image --}}
                    <div class="relative overflow-hidden h-48">
                        @if($news->featured_image)
                            <img src="{{ asset('storage/' . $news->featured_image) }}" 
                                 alt="{{ $news->title }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                <svg class="h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                        
                        {{-- Category Badge --}}
                        <div class="absolute top-4 left-4 text-white px-3 py-1 rounded-full text-sm font-medium"
                             style="background-color: {{ $news->category->color }}">
                            {{ $news->category->name }}
                        </div>
                        
                        {{-- Date Badge --}}
                        <div class="absolute top-4 right-4 bg-black/70 text-white px-3 py-1 rounded text-sm">
                            {{ $news->formatted_date }}
                        </div>
                    </div>

                    {{-- Article Content --}}
                    <div class="p-6">
                        {{-- Title --}}
                        <h3 class="text-lg font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-blue-600 transition-colors duration-300">
                            <a href="{{ route('news.show', $news->slug) }}" class="hover:underline">
                                {{ $news->title }}
                            </a>
                        </h3>

                        {{-- Excerpt --}}
                        <p class="text-gray-600 text-sm leading-relaxed mb-4 line-clamp-3">
                            {{ $news->excerpt ?? Str::limit(strip_tags($news->content), 150) }}
                        </p>

                        {{-- Read More Link --}}
                        <div class="flex items-center justify-between">
                            <a href="{{ route('news.show', $news->slug) }}" 
                               class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center group-hover:translate-x-1 transition-transform duration-300">
                                Read More
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                            
                            {{-- Share Button --}}
                            <button class="text-gray-400 hover:text-gray-600 transition-colors duration-300" 
                                    onclick="shareArticle('{{ addslashes($news->title) }}', '{{ route('news.show', $news->slug) }}')">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </article>
            @empty
                {{-- No News Available --}}
                <div class="col-span-3 text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No news available</h3>
                    <p class="mt-1 text-sm text-gray-500">Check back later for the latest updates.</p>
                </div>
            @endforelse
        </div>

        {{-- View All News Button --}}
        @if($latestNews->count() > 0)
            <div class="text-center mt-8">
                <a href="{{ route('news.index') }}" 
                   class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-8 rounded-lg transition-colors duration-300 transform hover:scale-105">
                    View All News
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </a>
            </div>
        @endif
    </div>
</section>

<style>
/* Text truncation utilities */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Custom hover effects */
.group:hover .group-hover\:scale-105 {
    transform: scale(1.05);
}

.group:hover .group-hover\:translate-x-1 {
    transform: translateX(0.25rem);
}

.group:hover .group-hover\:text-blue-600 {
    color: #2563eb;
}

/* Category badge animations */
@keyframes pulse-glow {
    0%, 100% {
        box-shadow: 0 0 5px rgba(37, 99, 235, 0.3);
    }
    50% {
        box-shadow: 0 0 20px rgba(37, 99, 235, 0.6);
    }
}

.category-badge:hover {
    animation: pulse-glow 2s infinite;
}

/* Responsive adjustments */
@media (max-width: 1024px) {
    .lg\:grid-cols-3 {
        grid-template-columns: repeat(1, minmax(0, 1fr));
        gap: 2rem;
    }
}

@media (max-width: 768px) {
    .text-lg {
        font-size: 1rem;
    }
    
    .p-6 {
        padding: 1rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Article click tracking
    const articles = document.querySelectorAll('article');
    
    articles.forEach((article, index) => {
        const title = article.querySelector('h3 a').textContent.trim();
        
        // Track article impressions
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    console.log(`Article impression: ${title}`);
                    // Add your analytics tracking here
                    // gtag('event', 'article_impression', { article_title: title });
                }
            });
        }, { threshold: 0.5 });
        
        observer.observe(article);
        
        // Track article clicks
        article.addEventListener('click', function(e) {
            if (!e.target.closest('button')) {
                console.log(`Article clicked: ${title}`);
                // Add your analytics tracking here
                // gtag('event', 'article_click', { article_title: title });
            }
        });
    });

    // Read More button enhancements
    const readMoreLinks = document.querySelectorAll('a[href*="/news/"]');
    
    readMoreLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Add loading state
            const originalText = this.innerHTML;
            this.innerHTML = 'Loading... <svg class="w-4 h-4 ml-1 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/></svg>';
            
            // Track read more clicks
            const articleTitle = this.closest('article').querySelector('h3').textContent.trim();
            console.log(`Read more clicked: ${articleTitle}`);
        });
    });

    // Share functionality
    window.shareArticle = function(title, url) {
        const fullUrl = window.location.origin + url;
        
        if (navigator.share) {
            navigator.share({
                title: title,
                url: fullUrl
            }).then(() => {
                console.log('Article shared successfully');
            }).catch((error) => {
                console.log('Error sharing article:', error);
                fallbackShare(title, fullUrl);
            });
        } else {
            fallbackShare(title, fullUrl);
        }
    };

    // Fallback share function
    function fallbackShare(title, url) {
        // Copy to clipboard
        navigator.clipboard.writeText(url).then(() => {
            // Show toast notification
            showToast('Link copied to clipboard!');
        }).catch(() => {
            // Open share dialog
            const shareText = `Check out: ${title} - ${url}`;
            const emailUrl = `mailto:?subject=${encodeURIComponent(title)}&body=${encodeURIComponent(shareText)}`;
            window.open(emailUrl);
        });
    }

    // Toast notification function
    function showToast(message) {
        const toast = document.createElement('div');
        toast.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform translate-y-full transition-transform duration-300';
        toast.textContent = message;
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.style.transform = 'translateY(0)';
        }, 100);
        
        setTimeout(() => {
            toast.style.transform = 'translateY(full)';
            setTimeout(() => {
                document.body.removeChild(toast);
            }, 300);
        }, 3000);
    }

    // Lazy loading for images
    const imageObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                if (img.dataset.src) {
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                    imageObserver.unobserve(img);
                }
            }
        });
    });

    // Apply lazy loading to images
    document.querySelectorAll('img[data-src]').forEach(img => {
        imageObserver.observe(img);
    });

    // Category badge hover effects
    const categoryBadges = document.querySelectorAll('[class*="bg-blue-600"], [class*="bg-purple-600"], [class*="bg-green-600"]');
    categoryBadges.forEach(badge => {
        badge.classList.add('category-badge');
    });

    // Search functionality for news (if needed)
    window.searchNews = function(query) {
        const articles = document.querySelectorAll('article');
        
        articles.forEach(article => {
            const title = article.querySelector('h3').textContent.toLowerCase();
            const content = article.querySelector('p').textContent.toLowerCase();
            const searchQuery = query.toLowerCase();
            
            if (title.includes(searchQuery) || content.includes(searchQuery)) {
                article.style.display = 'block';
            } else {
                article.style.display = 'none';
            }
        });
    };

    // Reading time calculation
    function calculateReadingTime(text) {
        const wordsPerMinute = 200;
        const words = text.trim().split(/\s+/).length;
        const minutes = Math.ceil(words / wordsPerMinute);
        return minutes;
    }

    // Add reading time to articles
    articles.forEach(article => {
        const content = article.querySelector('p').textContent;
        const readingTime = calculateReadingTime(content);
        const timeElement = document.createElement('span');
        timeElement.className = 'text-xs text-gray-500 ml-2';
        timeElement.textContent = `${readingTime} min read`;
        
        const dateElement = article.querySelector('.absolute.top-4.right-4');
        if (dateElement) {
            dateElement.appendChild(timeElement);
        }
    });
});
</script>