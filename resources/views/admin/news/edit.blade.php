<x-layouts.app>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Edit News Article</h1>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">Update the news article information.</p>
        </div>

        <form action="{{ route('dashboard.news.update', $news) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Title -->
                    <div>
                        <flux:field>
                            <flux:label for="title">Title</flux:label>
                            <flux:input 
                                name="title" 
                                id="title" 
                                value="{{ old('title', $news->title) }}" 
                                placeholder="Enter news article title"
                                required 
                            />
                            @error('title')
                                <flux:error>{{ $message }}</flux:error>
                            @enderror
                        </flux:field>
                    </div>

                    <!-- Excerpt -->
                    <div>
                        <flux:field>
                            <flux:label for="excerpt">Excerpt (Optional)</flux:label>
                            <flux:textarea 
                                name="excerpt" 
                                id="excerpt" 
                                rows="3"
                                placeholder="Brief summary of the news article"
                            >{{ old('excerpt', $news->excerpt) }}</flux:textarea>
                            @error('excerpt')
                                <flux:error>{{ $message }}</flux:error>
                            @enderror
                        </flux:field>
                    </div>

                    <!-- Content -->
                    <div>
                        <flux:field>
                            <flux:label for="content">Content</flux:label>
                            <flux:textarea 
                                name="content" 
                                id="content" 
                                rows="15"
                                placeholder="Write your news article content here..."
                                required
                            >{{ old('content', $news->content) }}</flux:textarea>
                            @error('content')
                                <flux:error>{{ $message }}</flux:error>
                            @enderror
                        </flux:field>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Current Featured Image -->
                    @if($news->featured_image)
                        <div>
                            <flux:label>Current Featured Image</flux:label>
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $news->featured_image) }}" 
                                     alt="{{ $news->title }}" 
                                     class="w-full h-32 object-cover rounded-lg">
                            </div>
                        </div>
                    @endif

                    <!-- Featured Image -->
                    <div>
                        <flux:field>
                            <flux:label for="featured_image">{{ $news->featured_image ? 'Replace Featured Image' : 'Featured Image' }}</flux:label>
                            <flux:input 
                                type="file" 
                                name="featured_image" 
                                id="featured_image" 
                                accept="image/*"
                            />
                            @error('featured_image')
                                <flux:error>{{ $message }}</flux:error>
                            @enderror
                        </flux:field>
                    </div>

                    <!-- Category -->
                    <div>
                        <flux:field>
                            <flux:label for="news_category_id">Category</flux:label>
                            <flux:select name="news_category_id" id="news_category_id" required>
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ old('news_category_id', $news->news_category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </flux:select>
                            @error('news_category_id')
                                <flux:error>{{ $message }}</flux:error>
                            @enderror
                        </flux:field>
                    </div>

                    <!-- Status -->
                    <div>
                        <flux:field>
                            <flux:label for="status">Status</flux:label>
                            <flux:select name="status" id="status" required>
                                <option value="draft" {{ old('status', $news->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status', $news->status) === 'published' ? 'selected' : '' }}>Published</option>
                                <option value="archived" {{ old('status', $news->status) === 'archived' ? 'selected' : '' }}>Archived</option>
                            </flux:select>
                            @error('status')
                                <flux:error>{{ $message }}</flux:error>
                            @enderror
                        </flux:field>
                    </div>

                    <!-- Featured -->
                    <div>
                        <flux:field>
                            <flux:checkbox name="is_featured" id="is_featured" value="1" 
                                          {{ old('is_featured', $news->is_featured) ? 'checked' : '' }}>
                                Featured Article
                            </flux:checkbox>
                            @error('is_featured')
                                <flux:error>{{ $message }}</flux:error>
                            @enderror
                        </flux:field>
                    </div>

                    <!-- Published Date -->
                    <div>
                        <flux:field>
                            <flux:label for="published_at">Published Date (Optional)</flux:label>
                            <flux:input 
                                type="datetime-local" 
                                name="published_at" 
                                id="published_at" 
                                value="{{ old('published_at', $news->published_at ? $news->published_at->format('Y-m-d\TH:i') : '') }}"
                            />
                            @error('published_at')
                                <flux:error>{{ $message }}</flux:error>
                            @enderror
                        </flux:field>
                    </div>

                    <!-- Article Stats -->
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-3">Article Statistics</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Views:</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ number_format($news->views_count) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Created:</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $news->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Updated:</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $news->updated_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                <flux:button variant="ghost" :href="route('dashboard.news.index')" wire:navigate>
                    Cancel
                </flux:button>
                <div class="flex space-x-3">
                    @if($news->status === 'published')
                        <flux:button variant="ghost" :href="route('news.show', $news->slug)" target="_blank">
                            View Article
                        </flux:button>
                    @endif
                    <flux:button type="submit" variant="primary">
                        Update Article
                    </flux:button>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        // Image preview
        document.getElementById('featured_image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Add image preview functionality here if needed
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
    @endpush
</x-layouts.app>