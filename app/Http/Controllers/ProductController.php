<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Database\Eloquent\Builder;

class ProductController extends Controller
{
    /**
     * Display products listing with filtering and search
     */
    public function index(Request $request): View
    {
        $products = Product::query()
            ->with(['category', 'brand', 'images'])
            ->where('status', 'published')
            ->where('inventory_quantity', '>', 0);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $products->where(function (Builder $query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%")
                    ->orWhere('sku', 'LIKE', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $products->whereHas('category', function (Builder $query) use ($request) {
                $query->where('slug', $request->get('category'));
            });
        }

        // Brand filter
        if ($request->filled('brand')) {
            $products->whereHas('brand', function (Builder $query) use ($request) {
                $query->where('slug', $request->get('brand'));
            });
        }

        // Price range filter
        if ($request->filled('min_price')) {
            $products->where('price', '>=', $request->get('min_price'));
        }
        if ($request->filled('max_price')) {
            $products->where('price', '<=', $request->get('max_price'));
        }

        // Sorting
        $sort = $request->get('sort', 'name');
        $direction = $request->get('direction', 'asc');
        
        switch ($sort) {
            case 'price':
                $products->orderBy('price', $direction);
                break;
            case 'created':
                $products->orderBy('created_at', $direction);
                break;
            case 'name':
            default:
                $products->orderBy('name', $direction);
                break;
        }

        $products = $products->paginate(12)->withQueryString();

        // Get categories and brands for filters
        $categories = Category::active()
            ->orderBy('name')
            ->get();
        
        $brands = Brand::active()
            ->orderBy('name')
            ->get();

        return view('products.index', compact(
            'products',
            'categories',
            'brands'
        ));
    }

    /**
     * Display single product with SEO optimization
     */
    public function show(Product $product): View
    {
        // Check if product is published
        if ($product->status !== 'published') {
            abort(404);
        }

        // Load relationships
        $product->load([
            'category',
            'brand',
            'images',
            'variants' => function ($query) {
                $query->where('status', 'active');
            }
        ]);

        // Get related products from same category
        $relatedProducts = Product::query()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'published')
            ->where('inventory_quantity', '>', 0)
            ->with(['images', 'brand'])
            ->inRandomOrder()
            ->limit(4)
            ->get();

        // SEO meta data
        $metaTitle = $product->name . ' - ' . config('app.name');
        $metaDescription = substr(strip_tags($product->description), 0, 160);
        $metaKeywords = implode(', ', [
            $product->name,
            $product->category->name ?? '',
            $product->brand->name ?? '',
            'sri lanka',
            'online store'
        ]);

        return view('products.show', compact(
            'product',
            'relatedProducts',
            'metaTitle',
            'metaDescription',
            'metaKeywords'
        ));
    }

    /**
     * Display products by category
     */
    public function category(Category $category): View
    {
        // Check if category is active
        if (!$category->is_active) {
            abort(404);
        }

        $products = Product::query()
            ->where('category_id', $category->id)
            ->where('status', 'published')
            ->where('inventory_quantity', '>', 0)
            ->with(['brand', 'images'])
            ->orderBy('name')
            ->paginate(12);

        // SEO meta data
        $metaTitle = $category->name . ' - ' . config('app.name');
        $metaDescription = $category->description 
            ? substr(strip_tags($category->description), 0, 160)
            : "Shop {$category->name} products at " . config('app.name');
        
        return view('products.category', compact(
            'category',
            'products',
            'metaTitle',
            'metaDescription'
        ));
    }

    /**
     * Display products by brand
     */
    public function brand(Brand $brand): View
    {
        // Check if brand is active
        if (!$brand->is_active) {
            abort(404);
        }

        $products = Product::query()
            ->where('brand_id', $brand->id)
            ->where('status', 'published')
            ->where('inventory_quantity', '>', 0)
            ->with(['category', 'images'])
            ->orderBy('name')
            ->paginate(12);

        // SEO meta data
        $metaTitle = $brand->name . ' Products - ' . config('app.name');
        $metaDescription = $brand->description 
            ? substr(strip_tags($brand->description), 0, 160)
            : "Shop {$brand->name} products at " . config('app.name');

        return view('products.brand', compact(
            'brand',
            'products',
            'metaTitle',
            'metaDescription'
        ));
    }
}
