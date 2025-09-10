<x-layouts.app>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Create News Article</h1>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">Add a new news article to your website.</p>
        </div>

        <form action="{{ route('dashboard.news.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

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
                                value="{{ old('title') }}" 
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
                            >{{ old('excerpt') }}</flux:textarea>
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
                            >{{ old('content') }}</flux:textarea>
                            @error('content')
                                <flux:error>{{ $message }}</flux:error>
                            @enderror
                        </flux:field>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Featured Image -->
                    <div>
                        <flux:field>
                            <flux:label for="featured_image">Featured Image</flux:label>
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
                                    <option value="{{ $category->id }}" {{ old('news_category_id') == $category->id ? 'selected' : '' }}>
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
                                <option value="draft" {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                                <option value="archived" {{ old('status') === 'archived' ? 'selected' : '' }}>Archived</option>
                            </flux:select>
                            @error('status')
                                <flux:error>{{ $message }}</flux:error>
                            @enderror
                        </flux:field>
                    </div>

                    <!-- Featured -->
                    <div>
                        <flux:field>
                            <flux:checkbox name="is_featured" id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
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
                                value="{{ old('published_at') }}"
                            />
                            @error('published_at')
                                <flux:error>{{ $message }}</flux:error>
                            @enderror
                        </flux:field>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                <flux:button variant="ghost" :href="route('dashboard.news.index')" wire:navigate>
                    Cancel
                </flux:button>
                <div class="flex space-x-3">
                    <flux:button type="submit" name="action" value="save">
                        Save Article
                    </flux:button>
                    <flux:button type="submit" name="action" value="save_and_continue" variant="primary">
                        Save & Continue Editing
                    </flux:button>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        // Auto-generate slug from title
        document.getElementById('title').addEventListener('input', function() {
            // This is handled automatically by the model
        });

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