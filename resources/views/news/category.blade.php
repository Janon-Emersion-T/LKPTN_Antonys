<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
    <title>{{ $category->name }} News - TechHub</title>
    <meta name="description" content="Browse {{ $category->name }} news articles and updates from TechHub. {{ $category->description }}">
</head>
<body class="min-h-screen bg-gray-50 dark:bg-gray-900">
    @include('partials.header')
    
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <div class="mb-4">
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-lg font-medium text-white border-2 border-white/30"
                          style="background-color: {{ $category->color }}">
                        {{ $category->name }}
                    </span>
                </div>
                <h1 class="text-4xl lg:text-5xl font-bold mb-4">{{ $category->name }} News</h1>
                @if($category->description)
                    <p class="text-xl text-blue-100 max-w-2xl mx-auto">
                        {{ $category->description }}
                    </p>
                @endif
                <div class="mt-6">
                    <p class="text-blue-200">
                        {{ $news->total() }} {{ Str::plural('article', $news->total()) }} in this category
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Navigation -->
    <section class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
        <div class="container mx-auto px-4">
            <nav class="py-4">
                <div class="flex items-center space-x-4 text-sm">
                    <a href="{{ route('home') }}" class="text-gray-500 hover:text-blue-600 dark:text-gray-400">Home</a>
                    <span class="text-gray-400">→</span>
                    <a href="{{ route('news.index') }}" class="text-gray-500 hover:text-blue-600 dark:text-gray-400">News</a>
                    <span class="text-gray-400">→</span>
                    <span class="text-gray-700 dark:text-gray-300 font-medium">{{ $category->name }}</span>
                </div>
            </nav>
        </div>
    </section>

    <!-- News Grid -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            @if($news->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($news as $article)
                        <article class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden group">
                            {{-- Article Image --}}
                            <div class="relative overflow-hidden h-48">
                                @if($article->featured_image)
                                    <img src="{{ asset('storage/' . $article->featured_image) }}" 
                                         alt="{{ $article->title }}" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                        <svg class="h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                
                                {{-- Date Badge --}}
                                <div class="absolute top-4 right-4 bg-black/70 text-white px-3 py-1 rounded text-sm">
                                    {{ $article->formatted_date }}
                                </div>

                                {{-- Featured Badge --}}
                                @if($article->is_featured)
                                    <div class="absolute top-4 left-4 bg-yellow-500 text-white px-3 py-1 rounded-full text-sm font-medium">
                                        Featured
                                    </div>
                                @endif
                            </div>

                            {{-- Article Content --}}
                            <div class="p-6">
                                {{-- Title --}}
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 group-hover:text-blue-600 transition-colors duration-300">
                                    <a href="{{ route('news.show', $article->slug) }}" class="hover:underline">
                                        {{ $article->title }}
                                    </a>
                                </h3>

                                {{-- Excerpt --}}
                                <p class="text-gray-600 dark:text-gray-400 leading-relaxed mb-4">
                                    {{ $article->excerpt ?? Str::limit(strip_tags($article->content), 120) }}
                                </p>

                                {{-- Read More Link --}}
                                <div class="flex items-center justify-between">
                                    <a href="{{ route('news.show', $article->slug) }}" 
                                       class="text-blue-600 hover:text-blue-800 dark:text-blue-400 font-medium flex items-center group-hover:translate-x-1 transition-transform duration-300">
                                        Read More
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                    
                                    {{-- Views Count --}}
                                    <div class="flex items-center text-gray-500 dark:text-gray-400 text-sm">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        {{ number_format($article->views_count) }}
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if($news->hasPages())
                    <div class="mt-12">
                        {{ $news->links() }}
                    </div>
                @endif
            @else
                {{-- No News Available --}}
                <div class="text-center py-16">
                    <div class="mb-6">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full text-white mb-4"
                             style="background-color: {{ $category->color }}">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">No {{ $category->name }} news available</h3>
                    <p class="mt-2 text-gray-500 dark:text-gray-400">
                        There are currently no articles in the {{ $category->name }} category. Check back later for updates.
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('news.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            Browse All News
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </section>

    @include('partials.footer')
</body>
</html>