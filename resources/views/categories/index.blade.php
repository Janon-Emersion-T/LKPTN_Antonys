<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
    <title>Product Categories - {{ config('app.name') }}</title>
    <meta name="description" content="Browse all product categories at {{ config('app.name') }}. Find laptops, desktops, gaming PCs, accessories and more.">
</head>
<body class="min-h-screen bg-gray-50 dark:bg-gray-900">
    @include('partials.header')

    <main class="container mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <nav class="mb-8 text-sm">
            <ol class="flex space-x-2 text-gray-600 dark:text-gray-400">
                <li><a href="{{ route('home') }}" class="hover:text-blue-600">Home</a></li>
                <li>/</li>
                <li class="text-gray-900 dark:text-white">Categories</li>
            </ol>
        </nav>

        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Product Categories</h1>
            <p class="text-gray-600 dark:text-gray-400">Browse our complete range of computer products by category</p>
        </div>

        @php
            $categories = \App\Models\Category::where('is_active', true)
                ->withCount(['products' => function($query) {
                    $query->where('status', 'published');
                }])
                ->orderBy('name')
                ->get()
                ->groupBy(function($category) {
                    return strtoupper(substr($category->name, 0, 1));
                });

            $alphabet = range('A', 'Z');
        @endphp

        <!-- Alphabet Navigation -->
        <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
            <div class="flex flex-wrap gap-2 justify-center">
                @foreach($alphabet as $letter)
                    @if($categories->has($letter))
                        <a href="#letter-{{ $letter }}"
                           class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-600 text-white font-semibold hover:bg-blue-700 transition-colors">
                            {{ $letter }}
                        </a>
                    @else
                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-600 text-gray-400 dark:text-gray-500 font-semibold">
                            {{ $letter }}
                        </span>
                    @endif
                @endforeach
            </div>
        </div>

        @if($categories->count() > 0)
            <!-- Categories by Letter -->
            @foreach($alphabet as $letter)
                @if($categories->has($letter))
                    <div id="letter-{{ $letter }}" class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 border-b-2 border-blue-600 pb-2">
                            {{ $letter }}
                        </h2>

                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Category
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Description
                                            </th>
                                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Products
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                                        @foreach($categories[$letter] as $category)
                                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <a href="{{ route('categories.show', $category->slug) }}"
                                                       class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium">
                                                        {{ $category->name }}
                                                    </a>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <span class="text-gray-900 dark:text-gray-100 text-sm">
                                                        {{ $category->description ?: 'Browse ' . $category->name . ' products' }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                                    <span class="text-sm text-gray-600 dark:text-gray-400">
                                                        {{ $category->products_count }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach

            <!-- Back to Top Navigation -->
            <div class="mt-8 bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
                <div class="flex flex-wrap gap-2 justify-center">
                    @foreach($alphabet as $letter)
                        @if($categories->has($letter))
                            <a href="#letter-{{ $letter }}"
                               class="inline-flex items-center justify-center w-8 h-8 rounded bg-gray-100 dark:bg-gray-700 text-blue-600 dark:text-blue-400 text-sm font-medium hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                                {{ $letter }}
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        @else
            <!-- No Categories Found -->
            <div class="rounded-lg bg-white p-12 text-center shadow-sm dark:bg-gray-800">
                <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">No categories available</h3>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Categories will appear here when they are added to the system.</p>
            </div>
        @endif
    </main>

    @include('partials.footer')
</body>
</html>