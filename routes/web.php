<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Customer\CustomerDashboardController;
use App\Http\Controllers\Admin\BarcodeController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Category and Brand index pages
Route::get('/categories', function () {
    return view('categories.index');
})->name('categories.index');

Route::get('/brands', function () {
    return view('brands.index');
})->name('brands.index');

// Shop page
Route::get('/shop', function () {
    return view('shop.index');
})->name('shop.index');

Route::get('/delivery-information', function () {
    return view('pages/deliveryinformation');
})->name('deliveryinformation');

Route::get('/privacy-policy', function () {
    return view('pages/privacypolicy');
})->name('privacypolicy');

Route::get('/frequently-asked-question', function () {
    return view('pages/faq');
})->name('faq');

Route::get('/about-us', function () {
    return view('pages/aboutus');
})->name('aboutus');

Route::get('/contact-us', [ContactController::class, 'index'])->name('contactus');
Route::post('/contact-us', [ContactController::class, 'store'])->name('contact.store');

// Product routes (public)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/categories/{category:slug}', [ProductController::class, 'category'])->name('categories.show');
Route::get('/brands/{brand:slug}', [ProductController::class, 'brand'])->name('brands.show');

// Cart routes (public - works for both guests and authenticated users)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
Route::post('/checkout/whatsapp', [CartController::class, 'whatsappCheckout'])->name('checkout.whatsapp');

// AJAX route for cart count
Route::get('/cart-count', function() {
    $cartService = new \App\Services\CartService();
    return response()->json(['count' => $cartService->getItemCount()]);
});

// Staff Dashboard (for company users)
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified', 'role:super-admin|admin|manager|cashier|sales-representative|inventory-manager|customer-support'])
    ->name('dashboard');

// Admin Management Routes (for admins only)
Route::middleware(['auth', 'verified', 'role:super-admin|admin'])->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/products', \App\Livewire\Admin\Products::class)->name('products');
    Route::get('/categories', \App\Livewire\Admin\Categories::class)->name('categories');
    Route::get('/brands', \App\Livewire\Admin\Brands::class)->name('brands');
    Route::get('/users', \App\Livewire\Admin\UserManagement::class)->name('users');
    Route::get('/settings', \App\Livewire\Admin\SystemSettings::class)->name('settings');
    Route::get('/analytics', \App\Livewire\Admin\Analytics::class)->name('analytics');
    Route::get('/roles', \App\Livewire\Admin\RolesPermissions::class)->name('roles');
    Route::get('/contacts', \App\Livewire\Admin\Contacts::class)->name('contacts');
    
    // Barcode printing routes
    Route::prefix('barcodes')->name('barcodes.')->group(function () {
        Route::post('/print', [BarcodeController::class, 'print'])->name('print');
        Route::get('/print-single/{product}', [BarcodeController::class, 'printSingle'])->name('print-single');
        Route::post('/bulk-print', [BarcodeController::class, 'bulkPrint'])->name('bulk-print');
        Route::get('/generate/{code}', [BarcodeController::class, 'generateBarcode'])->name('generate');
    });
});

// POS System Routes (for admins and cashiers)
Route::middleware(['auth', 'verified', 'role:super-admin|admin|cashier'])->group(function () {
    Route::get('/pos', \App\Livewire\Admin\Pos::class)->name('pos');
    Route::get('/pos/transactions', \App\Livewire\Admin\Transactions::class)->name('pos.transactions');
    Route::get('/pos/receipt/{order}', function(\App\Models\Order $order) {
        // Ensure user can only access receipts from their terminal/session
        if (!auth()->user()->hasRole(['super-admin', 'admin']) && $order->cashier_id !== auth()->id()) {
            abort(403);
        }
        
        $terminal = $order->terminal;
        return view('receipt', compact('order', 'terminal'));
    })->name('pos.receipt');
    
    // Debug route for testing barcode scanning
    Route::get('/pos/test-barcode/{barcode}', function($barcode) {
        $cleanBarcode = trim($barcode);
        
        $product = \App\Models\Product::where('barcode', $cleanBarcode)
            ->where('status', 'published')
            ->where('inventory_quantity', '>', 0)
            ->first();
            
        return response()->json([
            'input' => $barcode,
            'clean' => $cleanBarcode,
            'length' => strlen($cleanBarcode),
            'found' => $product ? true : false,
            'product' => $product ? [
                'id' => $product->id,
                'name' => $product->name,
                'barcode' => $product->barcode,
                'stock' => $product->inventory_quantity
            ] : null,
            'expected_barcode' => '6974316463313SN:202412030094',
            'is_expected_match' => ($cleanBarcode === '6974316463313SN:202412030094')
        ]);
    })->name('pos.test-barcode');
});

// Customer Dashboard and routes (for customers)
Route::middleware(['auth', 'verified', 'role:customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/orders', [CustomerDashboardController::class, 'orders'])->name('orders');
    Route::get('/orders/{order}', [CustomerDashboardController::class, 'orderShow'])->name('orders.show');
    Route::post('/orders/{order}/cancel', [CustomerDashboardController::class, 'cancelOrder'])->name('orders.cancel');
    Route::get('/profile', [CustomerDashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [CustomerDashboardController::class, 'updateProfile'])->name('profile.update');
    
    // AJAX routes for customer dashboard
    Route::get('/api/wishlist-count', [CustomerDashboardController::class, 'getWishlistCount'])->name('api.wishlist-count');
    Route::get('/api/order-stats', [CustomerDashboardController::class, 'getOrderStats'])->name('api.order-stats');
    
    // Wishlist routes (authenticated customers only)
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
    Route::post('/wishlist/add', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('/wishlist/remove', [WishlistController::class, 'remove'])->name('wishlist.remove');
    Route::delete('/wishlist/clear', [WishlistController::class, 'clear'])->name('wishlist.clear');
});

// Staff settings (only for company users)
Route::middleware(['auth', 'role:super-admin|admin|manager|cashier|sales-representative|inventory-manager|customer-support'])->group(function () {
    Route::redirect('settings', 'settings/profile');
    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

// Apply role-based redirect middleware
Route::middleware(['auth', App\Http\Middleware\RedirectBasedOnRole::class])->group(function () {
    // This will automatically redirect users to appropriate dashboards
});

require __DIR__.'/auth.php';
