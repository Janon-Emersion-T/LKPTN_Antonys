<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Display cart page
     */
    public function index(): View
    {
        $items = $this->cartService->getItems();
        $subtotal = $this->cartService->getSubtotal();
        $total = $this->cartService->getTotal();
        $itemCount = $this->cartService->getItemCount();

        return view('cart.index', compact('items', 'subtotal', 'total', 'itemCount'));
    }

    /**
     * Add item to cart
     */
    public function add(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            $success = $this->cartService->addItem(
                $request->product_id,
                $request->quantity,
                $request->options ?? []
            );

            if ($success) {
                return response()->json([
                    'success' => true,
                    'message' => 'Item added to cart successfully',
                    'cart_count' => $this->cartService->getItemCount(),
                    'cart_total' => number_format($this->cartService->getTotal(), 2)
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Unable to add item to cart. Please check stock availability.'
            ], 422);
            
        } catch (\Exception $e) {
            \Log::error('Cart add error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding item to cart.'
            ], 500);
        }
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:0',
        ]);

        $success = $this->cartService->updateItem($request->product_id, $request->quantity);

        if ($success) {
            return response()->json([
                'success' => true,
                'message' => 'Cart updated successfully',
                'cart_count' => $this->cartService->getItemCount(),
                'cart_total' => number_format($this->cartService->getTotal(), 2)
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Unable to update cart item.'
        ], 422);
    }

    /**
     * Remove item from cart
     */
    public function remove(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $success = $this->cartService->removeItem($request->product_id);

        if ($success) {
            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart',
                'cart_count' => $this->cartService->getItemCount(),
                'cart_total' => number_format($this->cartService->getTotal(), 2)
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Unable to remove item from cart.'
        ], 422);
    }

    /**
     * Clear entire cart
     */
    public function clear(): JsonResponse
    {
        $this->cartService->clear();

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared successfully',
            'cart_count' => 0,
            'cart_total' => '0.00'
        ]);
    }

    /**
     * Show checkout page
     */
    public function checkout(): View
    {
        $cart = $this->cartService->getCart();
        
        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        return view('checkout.index', compact('cart'));
    }

    /**
     * Process WhatsApp checkout
     */
    public function whatsappCheckout(Request $request): JsonResponse
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email',
            'shipping_address' => 'required|string|max:500',
            'notes' => 'nullable|string|max:1000',
        ]);

        $cart = $this->cartService->getCart();
        
        if ($cart->items->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Your cart is empty.'
            ], 422);
        }

        // Generate order summary for WhatsApp
        $orderSummary = $this->generateWhatsAppMessage($cart, $request->all());
        
        // WhatsApp URL
        $whatsappNumber = preg_replace('/[^0-9]/', '', config('globals.contact.whatsapp_phone_number', '94772798192'));
        $whatsappUrl = "https://wa.me/{$whatsappNumber}?text=" . urlencode($orderSummary);

        // Clear cart after generating message
        $this->cartService->clear();

        return response()->json([
            'success' => true,
            'whatsapp_url' => $whatsappUrl,
            'message' => 'Order details prepared. You will be redirected to WhatsApp.'
        ]);
    }

    /**
     * Generate WhatsApp message for order
     */
    protected function generateWhatsAppMessage($cart, $customerData): string
    {
        $message = "🛒 *NEW ORDER REQUEST*\n\n";
        $message .= "📋 *Customer Details:*\n";
        $message .= "• Name: {$customerData['customer_name']}\n";
        $message .= "• Phone: {$customerData['customer_phone']}\n";
        
        if (!empty($customerData['customer_email'])) {
            $message .= "• Email: {$customerData['customer_email']}\n";
        }
        
        $message .= "• Address: {$customerData['shipping_address']}\n\n";

        $message .= "🛍️ *Order Items:*\n";
        foreach ($cart->items as $item) {
            $message .= "• {$item->product_name}\n";
            $message .= "  Qty: {$item->quantity} x LKR " . number_format($item->unit_price, 2) . "\n";
            $message .= "  Subtotal: LKR " . number_format($item->quantity * $item->unit_price, 2) . "\n\n";
        }

        $message .= "💰 *Order Summary:*\n";
        $message .= "• Subtotal: LKR " . number_format($cart->subtotal, 2) . "\n";
        
        if ($cart->shipping_amount > 0) {
            $message .= "• Shipping: LKR " . number_format($cart->shipping_amount, 2) . "\n";
        } else {
            $message .= "• Shipping: FREE 🎉\n";
        }
        
        $message .= "• *Total: LKR " . number_format($cart->total_amount, 2) . "*\n\n";

        if (!empty($customerData['notes'])) {
            $message .= "📝 *Notes:*\n{$customerData['notes']}\n\n";
        }

        $message .= "📞 Please confirm this order and provide payment instructions.\n\n";
        $message .= "Thank you for choosing LKPTradeNest! Designed and Developed by LKProfessionals (Pvt) Ltd - https://www.lkprofessionals.com";


        return $message;
    }
}
