<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Receipt #{{ $order->receipt_number }}</title>
    <style>
        /* 80mm thermal printer styles */
        @media print {
            @page {
                width: 80mm;
                margin: 0;
            }
            body {
                margin: 0;
                padding: 0;
            }
        }
        
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            line-height: 1.2;
            margin: 0;
            padding: 8px;
            width: 80mm;
            max-width: 80mm;
            background: white;
            color: black;
        }
        
        .receipt-header {
            text-align: center;
            border-bottom: 1px dashed #000;
            padding-bottom: 8px;
            margin-bottom: 8px;
        }
        
        .company-name {
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 2px;
        }
        
        .company-info {
            font-size: 10px;
            margin-bottom: 1px;
        }
        
        .receipt-info {
            margin-bottom: 8px;
            font-size: 10px;
        }
        
        .receipt-info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1px;
        }
        
        .items-section {
            border-bottom: 1px dashed #000;
            padding-bottom: 8px;
            margin-bottom: 8px;
        }
        
        .item-header {
            font-weight: bold;
            border-bottom: 1px solid #000;
            padding: 2px 0;
            font-size: 10px;
        }
        
        .item-row {
            font-size: 11px;
            margin-bottom: 2px;
        }
        
        .item-name {
            font-weight: bold;
            margin-bottom: 1px;
        }
        
        .item-details {
            display: flex;
            justify-content: space-between;
            font-size: 10px;
        }
        
        .totals-section {
            border-bottom: 1px dashed #000;
            padding-bottom: 8px;
            margin-bottom: 8px;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2px;
            font-size: 11px;
        }
        
        .total-row.final-total {
            font-weight: bold;
            font-size: 14px;
            border-top: 1px solid #000;
            padding-top: 4px;
            margin-top: 4px;
        }
        
        .payment-section {
            border-bottom: 1px dashed #000;
            padding-bottom: 8px;
            margin-bottom: 8px;
        }
        
        .payment-header {
            font-weight: bold;
            margin-bottom: 4px;
            font-size: 11px;
        }
        
        .payment-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1px;
            font-size: 10px;
        }
        
        .receipt-footer {
            text-align: center;
            font-size: 10px;
        }
        
        .thank-you {
            font-weight: bold;
            margin-bottom: 4px;
        }
        
        .footer-info {
            margin-bottom: 2px;
        }
        
        .barcode-section {
            text-align: center;
            margin: 8px 0;
            font-size: 8px;
        }
        
        /* Logo styles */
        .company-logo {
            text-align: center;
            margin-bottom: 8px;
        }
        
        .company-logo img {
            max-width: 60mm;
            max-height: 20mm;
            width: auto;
            height: auto;
            filter: contrast(1.2) brightness(0.9); /* Better for thermal printing */
        }
        
        /* Print-specific styles */
        @media print {
            .no-print {
                display: none;
            }
            
            .company-logo img {
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }
        }
        
        /* Utility classes */
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .text-right { text-align: right; }
        .bold { font-weight: bold; }
        .small { font-size: 9px; }
        .large { font-size: 14px; }
        
        /* Spacing */
        .mt-1 { margin-top: 2px; }
        .mt-2 { margin-top: 4px; }
        .mb-1 { margin-bottom: 2px; }
        .mb-2 { margin-bottom: 4px; }
    </style>
</head>
<body>
    <!-- Receipt Header -->
    <div class="receipt-header">
        <!-- Company Logo -->
        @if(file_exists(public_path('images/logo.png')))
            <div class="company-logo">
                <img src="{{ asset('images/logo.png') }}" alt="{{ env('GLOBALS_COMPANY_NAME') ?: config('app.name') }} Logo">
            </div>
        @endif
        
        <!-- Company Name -->
        <div class="company-name">
            {{ env('GLOBALS_COMPANY_NAME') ?: config('app.name') }}
        </div>
        
        <!-- Company Address -->
        @if(env('GLOBALS.CONTACT.ADDRESS'))
            <div class="company-info">{{ env('GLOBALS.CONTACT.ADDRESS') }}</div>
        @endif
        
        <!-- Phone Numbers -->
        @if(env('GLOBALS.CONTACT.PHONE_NUMBER'))
            <div class="company-info">Tel: {{ env('GLOBALS.CONTACT.PHONE_NUMBER') }}</div>
        @endif
        @if(env('GLOBALS.CONTACT.WHATAPP_PHONE_NUMBER'))
            <div class="company-info">WhatsApp: {{ env('GLOBALS.CONTACT.WHATAPP_PHONE_NUMBER') }}</div>
        @endif
        
        <!-- Email -->
        @if(env('GLOBALS.CONTACT.EMAIL'))
            <div class="company-info">{{ env('GLOBALS.CONTACT.EMAIL') }}</div>
        @endif
    </div>
    
    <!-- Receipt Information -->
    <div class="receipt-info">
        <div class="receipt-info-row">
            <span>Receipt #:</span>
            <span>{{ $order->receipt_number }}</span>
        </div>
        <div class="receipt-info-row">
            <span>Date/Time:</span>
            <span>{{ $order->created_at->format('d/m/Y H:i:s') }}</span>
        </div>
        <div class="receipt-info-row">
            <span>Cashier:</span>
            <span>{{ $order->cashier->name ?? 'N/A' }}</span>
        </div>
        @if($order->customer_name && $order->customer_name !== 'Walk-in Customer')
            <div class="receipt-info-row">
                <span>Customer:</span>
                <span>{{ $order->customer_name }}</span>
            </div>
        @endif
        @if($order->customer_phone)
            <div class="receipt-info-row">
                <span>Phone:</span>
                <span>{{ $order->customer_phone }}</span>
            </div>
        @endif
    </div>
    
    <!-- Items Section -->
    <div class="items-section">
        <div class="item-header">
            <div style="display: flex; justify-content: space-between;">
                <span>ITEM</span>
                <span>QTY  PRICE  TOTAL</span>
            </div>
        </div>
        
        @foreach($order->items as $item)
            <div class="item-row">
                <div class="item-name">{{ $item->product_name }}</div>
                <div class="item-details">
                    <span>{{ $item->product_sku ?? '' }}</span>
                    <span>{{ $item->quantity }}x {{ number_format($item->unit_price, 2) }} {{ $order->currency }}</span>
                </div>
                <div class="item-details">
                    <span></span>
                    <span class="bold">{{ number_format($item->line_total, 2) }} {{ $order->currency }}</span>
                </div>
            </div>
        @endforeach
    </div>
    
    <!-- Totals Section -->
    <div class="totals-section">
        <div class="total-row">
            <span>Subtotal:</span>
            <span>{{ number_format($order->subtotal, 2) }} {{ $order->currency }}</span>
        </div>
        
        @if($order->discount_amount > 0)
            <div class="total-row">
                <span>Discount:</span>
                <span>-{{ number_format($order->discount_amount, 2) }} {{ $order->currency }}</span>
            </div>
        @endif
        
        @if($order->tax_amount > 0)
            <div class="total-row">
                <span>Tax:</span>
                <span>{{ number_format($order->tax_amount, 2) }} {{ $order->currency }}</span>
            </div>
        @endif
        
        <div class="total-row final-total">
            <span>TOTAL:</span>
            <span>{{ number_format($order->total_amount, 2) }} {{ $order->currency }}</span>
        </div>
    </div>
    
    <!-- Payment Section -->
    @if($order->payments->count() > 0)
        <div class="payment-section">
            <div class="payment-header">PAYMENT DETAILS</div>
            @foreach($order->payments as $payment)
                <div class="payment-row">
                    <span>{{ ucfirst($payment->method ?? 'Cash') }}:</span>
                    <span>{{ number_format($payment->amount, 2) }} {{ $order->currency }}</span>
                </div>
            @endforeach
            
            @php
                $totalPaid = $order->payments->sum('amount');
                $change = $totalPaid - $order->total_amount;
            @endphp
            
            <div class="payment-row bold" style="border-top: 1px solid #000; padding-top: 2px; margin-top: 2px;">
                <span>Total Paid:</span>
                <span>{{ number_format($totalPaid, 2) }} {{ $order->currency }}</span>
            </div>
            
            @if($change > 0)
                <div class="payment-row bold">
                    <span>Change:</span>
                    <span>{{ number_format($change, 2) }} {{ $order->currency }}</span>
                </div>
            @endif
        </div>
    @endif
    
    <!-- Order Summary -->
    <div class="text-center mb-2">
        <div class="small">Total Items: {{ $order->items->sum('quantity') }}</div>
        @if($order->session)
            <div class="small">Terminal: {{ $order->terminal->name ?? 'N/A' }}</div>
        @endif
    </div>
    
    <!-- Barcode/QR Section (Optional) -->
    <div class="barcode-section">
        <div class="small">Order ID: {{ $order->id }}</div>
        <!-- You can add barcode/QR code generation here later -->
    </div>
    
    <!-- Receipt Footer -->
    <div class="receipt-footer">
        <div class="thank-you">THANK YOU FOR YOUR PURCHASE!</div>
        
        @if($terminal->receipt_footer_text ?? false)
            <div class="footer-info">{{ $terminal->receipt_footer_text }}</div>
        @endif
        
        <div class="footer-info">Visit us again soon!</div>
        
        <!-- Contact Information -->
        @if(env('GLOBALS.CONTACT.PHONE_NUMBER'))
            <div class="footer-info">Questions? Call {{ env('GLOBALS.CONTACT.PHONE_NUMBER') }}</div>
        @endif
        
        @if(env('GLOBALS.CONTACT.WHATAPP_PHONE_NUMBER'))
            <div class="footer-info">WhatsApp: {{ env('GLOBALS.CONTACT.WHATAPP_PHONE_NUMBER') }}</div>
        @endif
        
        @if(env('GLOBALS.CONTACT.EMAIL'))
            <div class="footer-info">Email: {{ env('GLOBALS.CONTACT.EMAIL') }}</div>
        @endif
        
        @if(env('GLOBALS.CONTACT.ADDRESS'))
            <div class="footer-info small">{{ env('GLOBALS.CONTACT.ADDRESS') }}</div>
        @endif
        
        <!-- System Info -->
        <div class="footer-info small mt-2">
            Powered by {{ env('GLOBALS_COMPANY_NAME') ?: config('app.name') }} POS
        </div>
        
        <div class="footer-info small">
            Printed: {{ now()->format('d/m/Y H:i:s') }}
        </div>
    </div>
    
    <!-- Print Button (hidden when printing) -->
    <div class="no-print text-center mt-2" style="padding: 20px; border-top: 2px dashed #ccc;">
        <h3 style="margin-bottom: 15px; color: #333;">Receipt Ready</h3>
        <button 
            id="printBtn"
            onclick="printReceipt()" 
            style="background: #28a745; color: white; border: none; padding: 12px 24px; border-radius: 6px; cursor: pointer; font-size: 16px; margin-right: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.2);"
            onmouseover="this.style.background='#218838'"
            onmouseout="this.style.background='#28a745'"
        >
            🖨️ Print Now
        </button>
        <button 
            onclick="window.close()" 
            style="background: #dc3545; color: white; border: none; padding: 12px 24px; border-radius: 6px; cursor: pointer; font-size: 16px; box-shadow: 0 2px 4px rgba(0,0,0,0.2);"
            onmouseover="this.style.background='#c82333'"
            onmouseout="this.style.background='#dc3545'"
        >
            ❌ Close
        </button>
        <div style="margin-top: 10px; font-size: 12px; color: #666;">
            Click "Print Now" to print this receipt to your thermal printer
        </div>
    </div>
    
    <script>
        function printReceipt() {
            // Hide print button during printing
            const printBtn = document.getElementById('printBtn');
            const originalText = printBtn.innerHTML;
            printBtn.innerHTML = '🖨️ Printing...';
            printBtn.disabled = true;
            
            // Print the receipt
            window.print();
            
            // Restore button after short delay
            setTimeout(() => {
                printBtn.innerHTML = originalText;
                printBtn.disabled = false;
            }, 2000);
        }
        
        // Handle print dialog events
        window.addEventListener('beforeprint', function() {
            console.log('Starting to print receipt...');
        });
        
        window.addEventListener('afterprint', function() {
            console.log('Print dialog closed');
            // Optional: Auto-close window after printing
            // setTimeout(() => window.close(), 1000);
        });
        
        // Focus print button when page loads
        window.addEventListener('load', function() {
            document.getElementById('printBtn').focus();
            console.log('Receipt loaded successfully');
        });
        
        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key === 'p') {
                e.preventDefault();
                printReceipt();
            }
            if (e.key === 'Escape') {
                window.close();
            }
        });
    </script>
</body>
</html>