<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class WishlistController extends Controller
{
    /**
     * Display wishlist page
     */
    public function index(): View
    {
        $wishlistItems = auth()->user()->wishlists()
            ->with(['product', 'product.images', 'product.brand'])
            ->latest()
            ->get();

        return view('customer.wishlist', compact('wishlistItems'));
    }

    /**
     * Add item to wishlist
     */
    public function add(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::find($request->product_id);
        
        if (!$product || $product->status !== 'active') {
            return response()->json([
                'success' => false,
                'message' => 'Product not found or unavailable.'
            ], 422);
        }

        // Check if already in wishlist
        $existingWishlist = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($existingWishlist) {
            return response()->json([
                'success' => false,
                'message' => 'Product is already in your wishlist.'
            ], 422);
        }

        // Add to wishlist
        Wishlist::create([
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product added to wishlist successfully.',
            'wishlist_count' => auth()->user()->wishlists()->count()
        ]);
    }

    /**
     * Remove item from wishlist
     */
    public function remove(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $removed = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->delete();

        if ($removed) {
            return response()->json([
                'success' => true,
                'message' => 'Product removed from wishlist.',
                'wishlist_count' => auth()->user()->wishlists()->count()
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Product not found in wishlist.'
        ], 422);
    }

    /**
     * Clear entire wishlist
     */
    public function clear(): JsonResponse
    {
        auth()->user()->wishlists()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Wishlist cleared successfully.',
            'wishlist_count' => 0
        ]);
    }
}
