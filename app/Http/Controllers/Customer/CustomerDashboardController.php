<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class CustomerDashboardController extends Controller
{
    /**
     * Display customer dashboard
     */
    public function index(): View
    {
        $customer = auth()->user();
        
        // Get recent orders
        $recentOrders = $customer->orders()
            ->with(['items.product'])
            ->latest()
            ->limit(5)
            ->get();
        
        // Get customer statistics
        $totalOrders = $customer->orders()->count();
        $totalSpent = $customer->orders()
            ->where('status', '!=', 'cancelled')
            ->sum('total_amount');
        $wishlistCount = $customer->wishlists()->count();
        
        // Get pending orders count
        $pendingOrders = $customer->orders()
            ->whereIn('status', ['pending', 'processing', 'shipped'])
            ->count();
        
        return view('customer.dashboard', compact(
            'customer',
            'recentOrders',
            'totalOrders',
            'totalSpent',
            'wishlistCount',
            'pendingOrders'
        ));
    }

    /**
     * Display customer orders
     */
    public function orders(Request $request): View
    {
        $customer = auth()->user();
        
        $orders = $customer->orders()
            ->with(['items.product', 'items.product.images'])
            ->latest();
        
        // Filter by status if provided
        if ($request->filled('status') && $request->status !== 'all') {
            $orders->where('status', $request->status);
        }
        
        $orders = $orders->paginate(10)->withQueryString();
        
        // Get available order statuses for filter
        $statuses = [
            'all' => 'All Orders',
            'pending' => 'Pending',
            'processing' => 'Processing',
            'shipped' => 'Shipped',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled'
        ];
        
        return view('customer.orders', compact('orders', 'statuses'));
    }

    /**
     * Display single order
     */
    public function orderShow(Order $order): View
    {
        // Ensure the order belongs to the authenticated customer
        if ($order->customer_id !== auth()->id()) {
            abort(403);
        }
        
        $order->load([
            'items.product.images',
            'items.product.brand',
            'shippingAddress',
            'billingAddress'
        ]);
        
        return view('customer.order-show', compact('order'));
    }

    /**
     * Display customer profile
     */
    public function profile(): View
    {
        $customer = auth()->user();
        
        return view('customer.profile', compact('customer'));
    }

    /**
     * Update customer profile
     */
    public function updateProfile(Request $request): JsonResponse
    {
        $customer = auth()->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $customer->id,
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,other',
            
            // Address fields
            'address_line_1' => 'nullable|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            
            // Password fields (optional)
            'current_password' => 'nullable|required_with:password|current_password',
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);
        
        // Update basic information
        $customer->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'address_line_1' => $request->address_line_1,
            'address_line_2' => $request->address_line_2,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postal_code,
            'country' => $request->country,
        ]);
        
        // Update password if provided
        if ($request->filled('password')) {
            $customer->update([
                'password' => Hash::make($request->password),
            ]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully.',
        ]);
    }

    /**
     * Get customer wishlist count for AJAX requests
     */
    public function getWishlistCount(): JsonResponse
    {
        $count = auth()->user()->wishlists()->count();
        
        return response()->json([
            'success' => true,
            'count' => $count
        ]);
    }

    /**
     * Get customer order statistics for dashboard widgets
     */
    public function getOrderStats(): JsonResponse
    {
        $customer = auth()->user();
        
        $stats = [
            'total_orders' => $customer->orders()->count(),
            'pending_orders' => $customer->orders()
                ->whereIn('status', ['pending', 'processing', 'shipped'])
                ->count(),
            'completed_orders' => $customer->orders()
                ->where('status', 'delivered')
                ->count(),
            'total_spent' => $customer->orders()
                ->where('status', '!=', 'cancelled')
                ->sum('total_amount'),
            'wishlist_items' => $customer->wishlists()->count(),
        ];
        
        return response()->json([
            'success' => true,
            'stats' => $stats
        ]);
    }

    /**
     * Cancel an order (if allowed)
     */
    public function cancelOrder(Request $request, Order $order): JsonResponse
    {
        // Ensure the order belongs to the authenticated customer
        if ($order->customer_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found.'
            ], 404);
        }
        
        // Check if order can be cancelled (only pending orders)
        if ($order->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'This order cannot be cancelled.'
            ], 422);
        }
        
        $order->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'cancellation_reason' => $request->get('reason', 'Cancelled by customer')
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Order cancelled successfully.'
        ]);
    }
}
