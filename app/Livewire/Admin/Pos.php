<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\PosTerminal;
use App\Models\PosSession;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class Pos extends Component
{
    use WithPagination;
    
    public $terminal;
    public $session;
    public $transactions = [];
    public $activeTransactionId = 1;
    public $maxTransactions = 8;
    public $search = '';
    public $selectedCategory = null;
    public $showPaymentModal = false;
    public $showSessionModal = false;
    public $startingCash = 0;
    public $lastOrderId = null;
    public $showReceiptModal = false;
    public $showReceiptContent = false;
    public $receiptOrder = null;
    public $barcodeInput = '';
    public $showBarcodeError = false;
    public $barcodeErrorMessage = '';
    private $lastScanTime = 0;
    
    public function mount(): void
    {
        if (!auth()->user()->hasRole(['super-admin', 'admin', 'cashier'])) {
            abort(403, 'Access denied');
        }
        
        $this->terminal = PosTerminal::where('is_active', true)->first();
        
        if (!$this->terminal) {
            session()->flash('error', 'No active POS terminal found. Please contact administrator.');
            return;
        }
        
        $this->session = $this->terminal->getCurrentSession();
        
        if (!$this->session) {
            $this->showSessionModal = true;
        }
        
        // Initialize first transaction
        $this->initializeTransaction(1);
    }
    
    public function startSession(): void
    {
        $this->validate([
            'startingCash' => 'required|numeric|min:0',
        ]);
        
        $this->session = PosSession::create([
            'terminal_id' => $this->terminal->id,
            'cashier_id' => auth()->id(),
            'starting_cash' => $this->startingCash,
            'opened_at' => now(),
            'status' => 'open',
        ]);
        
        $this->showSessionModal = false;
        session()->flash('message', 'POS session started successfully.');
    }
    
    public function initializeTransaction(int $transactionId): void
    {
        if (!isset($this->transactions[$transactionId])) {
            $this->transactions[$transactionId] = [
                'id' => $transactionId,
                'cart' => [],
                'customerName' => '',
                'customerEmail' => '',
                'customerPhone' => '',
                'payments' => [],
                'remainingAmount' => 0,
                'created_at' => now(),
            ];
        }
    }
    
    public function addNewTransaction(): void
    {
        if (count($this->transactions) >= $this->maxTransactions) {
            session()->flash('error', 'Maximum number of transactions reached.');
            return;
        }
        
        $newId = max(array_keys($this->transactions)) + 1;
        $this->initializeTransaction($newId);
        $this->activeTransactionId = $newId;
    }
    
    public function switchTransaction(int $transactionId): void
    {
        if (isset($this->transactions[$transactionId])) {
            $this->activeTransactionId = $transactionId;
        }
    }
    
    public function closeTransaction(int $transactionId): void
    {
        if (isset($this->transactions[$transactionId])) {
            unset($this->transactions[$transactionId]);
            
            // Switch to first available transaction
            if (!empty($this->transactions)) {
                $this->activeTransactionId = array_keys($this->transactions)[0];
            } else {
                // Always keep at least one transaction
                $this->initializeTransaction(1);
                $this->activeTransactionId = 1;
            }
        }
    }
    
    public function getActiveTransaction()
    {
        if (!isset($this->transactions[$this->activeTransactionId])) {
            $this->initializeTransaction($this->activeTransactionId);
        }
        return $this->transactions[$this->activeTransactionId];
    }
    
    public function addToCart(int $productId): void
    {
        $product = Product::findOrFail($productId);
        
        if ($product->inventory_quantity <= 0) {
            session()->flash('error', 'Product is out of stock.');
            return;
        }
        
        $transaction = &$this->transactions[$this->activeTransactionId];
        $cartKey = $product->id;
        
        if (isset($transaction['cart'][$cartKey])) {
            if ($transaction['cart'][$cartKey]['quantity'] >= $product->inventory_quantity) {
                session()->flash('error', 'Cannot add more items. Stock limit reached.');
                return;
            }
            $transaction['cart'][$cartKey]['quantity']++;
        } else {
            $transaction['cart'][$cartKey] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'total' => $product->price,
            ];
        }
        
        $this->updateCartItemTotal($cartKey);
    }
    
    public function updateQuantity(int $productId, int $quantity): void
    {
        if ($quantity <= 0) {
            $this->removeFromCart($productId);
            return;
        }
        
        $product = Product::find($productId);
        if (!$product || $quantity > $product->inventory_quantity) {
            session()->flash('error', 'Invalid quantity or insufficient stock.');
            return;
        }
        
        $this->transactions[$this->activeTransactionId]['cart'][$productId]['quantity'] = $quantity;
        $this->updateCartItemTotal($productId);
    }
    
    public function removeFromCart(int $productId): void
    {
        unset($this->transactions[$this->activeTransactionId]['cart'][$productId]);
    }
    
    public function clearCart(): void
    {
        $this->transactions[$this->activeTransactionId]['cart'] = [];
        $this->transactions[$this->activeTransactionId]['customerName'] = '';
        $this->transactions[$this->activeTransactionId]['customerEmail'] = '';
        $this->transactions[$this->activeTransactionId]['customerPhone'] = '';
    }
    
    private function updateCartItemTotal(int $productId): void
    {
        $cart = &$this->transactions[$this->activeTransactionId]['cart'];
        $cart[$productId]['total'] = $cart[$productId]['price'] * $cart[$productId]['quantity'];
    }
    
    public function getCartTotalProperty(): float
    {
        $activeTransaction = $this->getActiveTransaction();
        return collect($activeTransaction['cart'])->sum('total');
    }
    
    public function getCartItemCountProperty(): int
    {
        $activeTransaction = $this->getActiveTransaction();
        return collect($activeTransaction['cart'])->sum('quantity');
    }
    
    public function openPaymentModal(): void
    {
        $activeTransaction = $this->getActiveTransaction();
        if (empty($activeTransaction['cart'])) {
            session()->flash('error', 'Cart is empty.');
            return;
        }
        
        $this->transactions[$this->activeTransactionId]['payments'] = [];
        $this->transactions[$this->activeTransactionId]['remainingAmount'] = $this->cartTotal;
        $this->showPaymentModal = true;
    }
    
    public function addPayment(string $method, float $amount): void
    {
        if ($amount <= 0) {
            session()->flash('error', 'Payment amount must be greater than zero.');
            return;
        }
        
        $transaction = &$this->transactions[$this->activeTransactionId];
        if ($amount > $transaction['remainingAmount']) {
            $amount = $transaction['remainingAmount'];
        }
        
        $transaction['payments'][] = [
            'method' => $method,
            'amount' => $amount,
        ];
        
        $transaction['remainingAmount'] = $this->cartTotal - collect($transaction['payments'])->sum('amount');
    }
    
    public function removePayment(int $index): void
    {
        $transaction = &$this->transactions[$this->activeTransactionId];
        unset($transaction['payments'][$index]);
        $transaction['payments'] = array_values($transaction['payments']);
        $transaction['remainingAmount'] = $this->cartTotal - collect($transaction['payments'])->sum('amount');
    }
    
    public function processPayment(): void
    {
        $activeTransaction = $this->getActiveTransaction();
        if (empty($activeTransaction['payments'])) {
            session()->flash('error', 'No payments added.');
            return;
        }
        
        $totalPayments = collect($activeTransaction['payments'])->sum('amount');
        if ($totalPayments < $this->cartTotal) {
            session()->flash('error', 'Total payments must equal cart total.');
            return;
        }
        
        $order = $this->createOrder();
        $this->createMultiplePayments($order);
        
        $this->showPaymentModal = false;
        $this->lastOrderId = $order->id;
        $this->receiptOrder = $order->load(['items', 'payments', 'terminal', 'cashier']);
        $this->showReceiptModal = true;
        $this->clearCart();
        
        session()->flash('message', 'Order processed successfully. Order #' . $order->order_number);
    }
    
    private function createOrder(): Order
    {
        $activeTransaction = $this->getActiveTransaction();
        
        $order = Order::create([
            'type' => 'pos',
            'channel' => 'pos',
            'status' => 'completed',
            'payment_status' => 'paid',
            'cashier_id' => auth()->id(),
            'terminal_id' => $this->terminal->id,
            'session_id' => $this->session->id,
            'customer_name' => $activeTransaction['customerName'] ?: 'Walk-in Customer',
            'customer_email' => $activeTransaction['customerEmail'],
            'customer_phone' => $activeTransaction['customerPhone'],
            'subtotal' => $this->cartTotal,
            'tax_amount' => 0, // TODO: Implement tax calculation
            'discount_amount' => 0,
            'total_amount' => $this->cartTotal,
            'currency' => 'LKR',
            'receipt_number' => 'REC-' . date('YmdHis') . '-' . $this->terminal->id,
        ]);
        
        foreach ($activeTransaction['cart'] as $item) {
            $product = Product::find($item['product_id']);
            
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'product_name' => $item['name'],
                'product_sku' => $product->sku ?? '',
                'product_description' => $product->description ?? '',
                'product_image' => $product->featured_image,
                'unit_price' => $item['price'],
                'quantity' => $item['quantity'],
                'line_total' => $item['total'],
                'discount_amount' => 0,
                'tax_amount' => 0,
                'final_total' => $item['total'],
                'fulfillment_status' => 'fulfilled',
            ]);
            
            // Update product inventory
            $product->decrement('inventory_quantity', $item['quantity']);
        }
        
        return $order;
    }
    
    private function createMultiplePayments(Order $order): void
    {
        $activeTransaction = $this->getActiveTransaction();
        foreach ($activeTransaction['payments'] as $payment) {
            Payment::create([
                'order_id' => $order->id,
                'method' => $payment['method'],
                'amount' => $payment['amount'],
                'status' => 'completed',
                'processed_at' => now(),
                'currency' => 'LKR',
                'payment_id' => 'POS-' . uniqid(),
            ]);
        }
    }
    
    public function getTotalPaymentsProperty(): float
    {
        $activeTransaction = $this->getActiveTransaction();
        return collect($activeTransaction['payments'])->sum('amount');
    }
    
    public function printReceipt(): void
    {
        $this->showReceiptContent = true;
    }
    
    public function actuallyPrintReceipt(): void
    {
        // Trigger browser print dialog for the receipt content
        $this->dispatch('printReceiptContent');
    }
    
    public function skipReceipt(): void
    {
        $this->showReceiptModal = false;
        $this->showReceiptContent = false;
        $this->receiptOrder = null;
        $this->lastOrderId = null;
    }
    
    public function scanBarcode(): void
    {
        // Prevent rapid double-scanning (debounce for 1 second)
        $currentTime = time();
        if ($currentTime - $this->lastScanTime < 1) {
            return;
        }
        $this->lastScanTime = $currentTime;
        
        if (empty($this->barcodeInput)) {
            $this->showBarcodeError('Please enter a barcode');
            return;
        }
        
        // Clean the barcode input (remove any whitespace)
        $cleanBarcode = trim($this->barcodeInput);
        
        // Log the barcode being scanned for debugging
        \Log::info('POS Barcode Scan Attempt', [
            'barcode' => $cleanBarcode,
            'length' => strlen($cleanBarcode),
            'user_id' => auth()->id(),
            'terminal_id' => $this->terminal->id ?? null
        ]);
        
        // First, try exact barcode match
        $product = Product::where('barcode', $cleanBarcode)
            ->where('status', 'published')
            ->where('inventory_quantity', '>', 0)
            ->first();
        
        // If not found, try SKU match as fallback
        if (!$product) {
            $product = Product::where('sku', $cleanBarcode)
                ->where('status', 'published')
                ->where('inventory_quantity', '>', 0)
                ->first();
        }
        
        // If still not found, check if product exists but is out of stock
        if (!$product) {
            $outOfStockProduct = Product::where(function($query) use ($cleanBarcode) {
                $query->where('barcode', $cleanBarcode)
                      ->orWhere('sku', $cleanBarcode);
            })
            ->where('status', 'published')
            ->first();
            
            if ($outOfStockProduct) {
                $this->showBarcodeError("Product '{$outOfStockProduct->name}' is out of stock (Available: {$outOfStockProduct->inventory_quantity})");
                return;
            }
        }
        
        // If still not found, check if product exists but is not published
        if (!$product) {
            $unpublishedProduct = Product::where(function($query) use ($cleanBarcode) {
                $query->where('barcode', $cleanBarcode)
                      ->orWhere('sku', $cleanBarcode);
            })->first();
            
            if ($unpublishedProduct) {
                $this->showBarcodeError("Product '{$unpublishedProduct->name}' is not available for sale (Status: {$unpublishedProduct->status})");
                return;
            }
        }
        
        if ($product) {
            $this->addToCart($product->id);
            $this->barcodeInput = '';
            $this->dispatch('barcode-success', ['message' => "Added {$product->name} to cart"]);
            
            // Log successful scan
            \Log::info('POS Barcode Scan Success', [
                'barcode' => $cleanBarcode,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'user_id' => auth()->id()
            ]);
        } else {
            $this->showBarcodeError("No product found with barcode: {$cleanBarcode}");
            
            // Log failed scan
            \Log::warning('POS Barcode Scan Failed', [
                'barcode' => $cleanBarcode,
                'user_id' => auth()->id(),
                'reason' => 'No matching product found'
            ]);
        }
    }
    
    public function updatedBarcodeInput(): void
    {
        // Auto-scan when barcode is entered (typical barcode scanners add newline)
        // Only auto-scan if length looks like a complete barcode (10+ chars to avoid partial scans)
        if (strlen(trim($this->barcodeInput)) >= 10) {
            $this->scanBarcode();
        }
    }
    
    private function showBarcodeError(string $message): void
    {
        $this->barcodeErrorMessage = $message;
        $this->showBarcodeError = true;
        $this->barcodeInput = '';
        
        // Auto-hide error after 3 seconds
        $this->dispatch('auto-hide-barcode-error');
    }
    
    public function closeBarcodeError(): void
    {
        $this->showBarcodeError = false;
        $this->barcodeErrorMessage = '';
    }
    
    public function updatedSearch(): void
    {
        $this->resetPage();
    }
    
    public function selectCategory(?int $categoryId): void
    {
        $this->selectedCategory = $categoryId;
        $this->resetPage();
    }
    
    public function getProductsProperty()
    {
        return Product::where('status', 'published')
            ->where('inventory_quantity', '>', 0)
            ->when($this->search, function($q) {
                $q->where(function($query) {
                    $query->where('name', 'like', "%{$this->search}%")
                          ->orWhere('sku', 'like', "%{$this->search}%");
                });
            })
            ->when($this->selectedCategory, function($q) {
                $q->where('category_id', $this->selectedCategory);
            })
            ->orderBy('name')
            ->paginate(12);
    }
    
    public function getCategoriesProperty()
    {
        return Category::where('is_active', true)
            ->whereHas('products', function($q) {
                $q->where('status', 'published')
                  ->where('inventory_quantity', '>', 0);
            })
            ->orderBy('name')
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.pos-multi')
            ->layout('components.layouts.pos');
    }
}
