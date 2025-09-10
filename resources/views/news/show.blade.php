<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
    <title>{{ $news->title }} - TechHub News</title>
    <meta name="description" content="{{ $news->excerpt ?? Str::limit(strip_tags($news->content), 160) }}">
    
    {{-- Open Graph Meta Tags --}}
    <meta property="og:title" content="{{ $news->title }}">
    <meta property="og:description" content="{{ $news->excerpt ?? Str::limit(strip_tags($news->content), 160) }}">
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ route('news.show', $news->slug) }}">
    @if($news->featured_image)
        <meta property="og:image" content="{{ asset('storage/' . $news->featured_image) }}">
    @endif
    
    {{-- Article Meta --}}
    <meta property="article:published_time" content="{{ $news->published_at?->toISOString() }}">
    <meta property="article:modified_time" content="{{ $news->updated_at->toISOString() }}">
    <meta property="article:section" content="{{ $news->category->name }}">
</head>
<body class="min-h-screen bg-gray-50 dark:bg-gray-900">
    @include('partials.header')
    
    <article class="py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                {{-- Article Header --}}
                <header class="mb-8">
                    {{-- Breadcrumb --}}
                    <nav class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                        <a href="{{ route('home') }}" class="hover:text-blue-600">Home</a>
                        <span class="mx-2">→</span>
                        <a href="{{ route('news.index') }}" class="hover:text-blue-600">News</a>
                        <span class="mx-2">→</span>
                        <a href="{{ route('news.category', $news->category->slug) }}" class="hover:text-blue-600">{{ $news->category->name }}</a>
                        <span class="mx-2">→</span>
                        <span class="text-gray-700 dark:text-gray-300">{{ Str::limit($news->title, 50) }}</span>
                    </nav>

                    {{-- Category Badge --}}
                    <div class="mb-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium text-white"
                              style="background-color: {{ $news->category->color }}">
                            {{ $news->category->name }}
                        </span>
                    </div>

                    {{-- Title --}}
                    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                        {{ $news->title }}
                    </h1>

                    {{-- Meta Info --}}
                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 dark:text-gray-400">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ $news->formatted_date }}
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            {{ number_format($news->views_count) }} views
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $news->reading_time }} min read
                        </div>
                    </div>
                </header>

                {{-- Featured Image --}}
                @if($news->featured_image)
                    <div class="mb-8">
                        <img src="{{ asset('storage/' . $news->featured_image) }}" 
                             alt="{{ $news->title }}" 
                             class="w-full h-64 lg:h-96 object-cover rounded-lg shadow-lg">
                    </div>
                @endif

                {{-- Article Content --}}
                <div class="prose prose-lg dark:prose-invert max-w-none mb-12">
                    @if($news->excerpt)
                        <div class="text-xl text-gray-700 dark:text-gray-300 font-medium mb-8 p-6 bg-gray-100 dark:bg-gray-800 rounded-lg border-l-4 border-blue-600">
                            {{ $news->excerpt }}
                        </div>
                    @endif
                    
                    <div class="leading-relaxed">
                        {!! nl2br(e($news->content)) !!}
                    </div>
                </div>

                {{-- Share Section --}}
                <div class="border-t border-gray-200 dark:border-gray-700 pt-8 mb-12">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Share this article</h3>
                    <div class="flex space-x-4">
                        <button onclick="shareArticle('{{ addslashes($news->title) }}', '{{ route('news.show', $news->slug) }}')" 
                                class="flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z"/>
                            </svg>
                            Share
                        </button>
                        <button onclick="copyToClipboard('{{ route('news.show', $news->slug) }}')" 
                                class="flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                            Copy Link
                        </button>
                    </div>
                </div>

                {{-- Related Articles --}}
                @if($relatedNews->count() > 0)
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-12">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-8">Related Articles</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @foreach($relatedNews as $relatedArticle)
                                <article class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden group">
                                    <div class="relative overflow-hidden h-32">
                                        @if($relatedArticle->featured_image)
                                            <img src="{{ asset('storage/' . $relatedArticle->featured_image) }}" 
                                                 alt="{{ $relatedArticle->title }}" 
                                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                        @else
                                            <div class="w-full h-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                                <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="p-4">
                                        <h4 class="font-semibold text-gray-900 dark:text-white mb-2 group-hover:text-blue-600 transition-colors">
                                            <a href="{{ route('news.show', $relatedArticle->slug) }}" class="hover:underline">
                                                {{ Str::limit($relatedArticle->title, 60) }}
                                            </a>
                                        </h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            {{ $relatedArticle->formatted_date }}
                                        </p>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </article>

    @include('partials.footer')

    <script>
        // Share functionality
        function shareArticle(title, url) {
            if (navigator.share) {
                navigator.share({
                    title: title,
                    url: url
                }).then(() => {
                    console.log('Article shared successfully');
                }).catch((error) => {
                    console.log('Error sharing article:', error);
                    copyToClipboard(url);
                });
            } else {
                copyToClipboard(url);
            }
        }

        // Copy to clipboard functionality
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                showToast('Link copied to clipboard!');
            }).catch(() => {
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = text;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                showToast('Link copied to clipboard!');
            });
        }

        // Toast notification
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
    </script>
</body>
</html>