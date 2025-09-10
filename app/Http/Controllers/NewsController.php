<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::with('category')
            ->published()
            ->recent(20)
            ->paginate(12);

        return view('news.index', compact('news'));
    }

    public function show(string $slug)
    {
        $news = News::with('category')
            ->where('slug', $slug)
            ->published()
            ->firstOrFail();

        $news->incrementViews();

        $relatedNews = News::with('category')
            ->where('news_category_id', $news->news_category_id)
            ->where('id', '!=', $news->id)
            ->published()
            ->recent(3)
            ->get();

        return view('news.show', compact('news', 'relatedNews'));
    }

    public function category(string $slug)
    {
        $category = NewsCategory::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $news = News::with('category')
            ->where('news_category_id', $category->id)
            ->published()
            ->recent(20)
            ->paginate(12);

        return view('news.category', compact('category', 'news'));
    }

    public function adminIndex()
    {
        $news = News::with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        $categories = NewsCategory::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admin.news.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'news_category_id' => 'required|exists:news_categories,id',
            'status' => 'required|in:draft,published,archived',
            'is_featured' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('news', 'public');
        }

        $news = News::create($validated);

        return redirect()->route('admin.news.index')
            ->with('success', 'News article created successfully.');
    }

    public function edit(News $news)
    {
        $categories = NewsCategory::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admin.news.edit', compact('news', 'categories'));
    }

    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'news_category_id' => 'required|exists:news_categories,id',
            'status' => 'required|in:draft,published,archived',
            'is_featured' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('featured_image')) {
            if ($news->featured_image) {
                Storage::disk('public')->delete($news->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('news', 'public');
        }

        $news->update($validated);

        return redirect()->route('admin.news.index')
            ->with('success', 'News article updated successfully.');
    }

    public function destroy(News $news)
    {
        if ($news->featured_image) {
            Storage::disk('public')->delete($news->featured_image);
        }

        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'News article deleted successfully.');
    }
}
