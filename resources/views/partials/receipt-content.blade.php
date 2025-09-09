<!-- Receipt Content (Optimized for Modal Display) -->
<div style="max-width: 80mm; margin: 0 auto; background: white; color: black; padding: 8px;">
    
    <!-- Company Header -->
    <div style="text-align: center; border-bottom: 1px dashed #000; padding-bottom: 8px; margin-bottom: 8px;">
        @if(file_exists(public_path('images/logo.png')))
            <div style="text-align: center; margin-bottom: 8px;">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" style="max-width: 50mm; max-height: 15mm; width: auto; height: auto; display: block; margin: 0 auto;">
            </div>
        @endif
        
        <div style="font-size: 16px; font-weight: bold; text-transform: uppercase; margin-bottom: 2px;">
            {{ env('GLOBALS_COMPANY_NAME') ?: config('app.name') }}
        </div>
        
        @if(env('GLOBALS.CONTACT.ADDRESS'))
            <div style="font-size: 10px; margin-bottom: 1px;">{{ env('GLOBALS.CONTACT.ADDRESS') }}</div>
        @endif
        @if(env('GLOBALS.CONTACT.PHONE_NUMBER'))
            <div style="font-size: 10px; margin-bottom: 1px;">Tel: {{ env('GLOBALS.CONTACT.PHONE_NUMBER') }}</div>
        @endif
        @if(env('GLOBALS.CONTACT.EMAIL'))
            <div style="font-size: 10px; margin-bottom: 1px;">{{ env('GLOBALS.CONTACT.EMAIL') }}</div>
        @endif
    </div>
    
    <!-- Receipt Information -->
    <div style="margin-bottom: 8px; font-size: 10px;">
        <div style="display: flex; justify-content: space-between; margin-bottom: 1px;">
            <span>Receipt #:</span>
            <span>{{ $order->receipt_number }}</span>
        </div>
        <div style="display: flex; justify-content: space-between; margin-bottom: 1px;">
            <span>Date/Time:</span>
            <span>{{ $order->created_at->format('d/m/Y H:i:s') }}</span>
        </div>
        <div style="display: flex; justify-content: space-between; margin-bottom: 1px;">
            <span>Cashier:</span>
            <span>{{ $order->cashier->name ?? 'N/A' }}</span>
        </div>
        @if($order->customer_name && $order->customer_name !== 'Walk-in Customer')
            <div style="display: flex; justify-content: space-between; margin-bottom: 1px;">
                <span>Customer:</span>
                <span>{{ $order->customer_name }}</span>
            </div>
        @endif
    </div>
    
    <!-- Items Section -->
    <div style="border-bottom: 1px dashed #000; padding-bottom: 8px; margin-bottom: 8px;">
        <div style="font-weight: bold; border-bottom: 1px solid #000; padding: 2px 0; font-size: 10px;">
            <div style="display: flex; justify-content: space-between;">
                <span>ITEM</span>
                <span>QTY  PRICE  TOTAL</span>
            </div>
        </div>
        
        @foreach($order->items as $item)
            <div style="font-size: 11px; margin-bottom: 2px;">
                <div style="font-weight: bold; margin-bottom: 1px;">{{ $item->product_name }}</div>
                <div style="display: flex; justify-content: space-between; font-size: 10px;">
                    <span>{{ $item->product_sku ?? '' }}</span>
                    <span>{{ $item->quantity }}x {{ number_format($item->unit_price, 2) }} {{ $order->currency }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 10px;">
                    <span></span>
                    <span style="font-weight: bold;">{{ number_format($item->line_total, 2) }} {{ $order->currency }}</span>
                </div>
            </div>
        @endforeach
    </div>
    
    <!-- Totals Section -->
    <div style="border-bottom: 1px dashed #000; padding-bottom: 8px; margin-bottom: 8px;">
        <div style="display: flex; justify-content: space-between; margin-bottom: 2px; font-size: 11px;">
            <span>Subtotal:</span>
            <span>{{ number_format($order->subtotal, 2) }} {{ $order->currency }}</span>
        </div>
        
        @if($order->discount_amount > 0)
            <div style="display: flex; justify-content: space-between; margin-bottom: 2px; font-size: 11px;">
                <span>Discount:</span>
                <span>-{{ number_format($order->discount_amount, 2) }} {{ $order->currency }}</span>
            </div>
        @endif
        
        @if($order->tax_amount > 0)
            <div style="display: flex; justify-content: space-between; margin-bottom: 2px; font-size: 11px;">
                <span>Tax:</span>
                <span>{{ number_format($order->tax_amount, 2) }} {{ $order->currency }}</span>
            </div>
        @endif
        
        <div style="display: flex; justify-content: space-between; font-weight: bold; font-size: 14px; border-top: 1px solid #000; padding-top: 4px; margin-top: 4px;">
            <span>TOTAL:</span>
            <span>{{ number_format($order->total_amount, 2) }} {{ $order->currency }}</span>
        </div>
    </div>
    
    <!-- Payment Section -->
    @if($order->payments->count() > 0)
        <div style="border-bottom: 1px dashed #000; padding-bottom: 8px; margin-bottom: 8px;">
            <div style="font-weight: bold; margin-bottom: 4px; font-size: 11px;">PAYMENT DETAILS</div>
            @foreach($order->payments as $payment)
                <div style="display: flex; justify-content: space-between; margin-bottom: 1px; font-size: 10px;">
                    <span>{{ ucfirst($payment->method ?? 'Cash') }}:</span>
                    <span>{{ number_format($payment->amount, 2) }} {{ $order->currency }}</span>
                </div>
            @endforeach
            
            @php
                $totalPaid = $order->payments->sum('amount');
                $change = $totalPaid - $order->total_amount;
            @endphp
            
            <div style="display: flex; justify-content: space-between; font-weight: bold; border-top: 1px solid #000; padding-top: 2px; margin-top: 2px; font-size: 10px;">
                <span>Total Paid:</span>
                <span>{{ number_format($totalPaid, 2) }} {{ $order->currency }}</span>
            </div>
            
            @if($change > 0)
                <div style="display: flex; justify-content: space-between; font-weight: bold; font-size: 10px;">
                    <span>Change:</span>
                    <span>{{ number_format($change, 2) }} {{ $order->currency }}</span>
                </div>
            @endif
        </div>
    @endif
    
    <!-- Footer -->
    <div style="text-align: center; font-size: 10px;">
        <div style="font-weight: bold; margin-bottom: 4px;">THANK YOU FOR YOUR PURCHASE!</div>
        <div style="margin-bottom: 2px;">Visit us again soon!</div>
        
        @if(env('GLOBALS.CONTACT.PHONE_NUMBER'))
            <div style="margin-bottom: 2px;">Questions? Call {{ env('GLOBALS.CONTACT.PHONE_NUMBER') }}</div>
        @endif
        
        <div style="font-size: 8px; margin-top: 8px;">
            Powered by {{ env('GLOBALS_COMPANY_NAME') ?: config('app.name') }} POS
        </div>
        
        <div style="font-size: 8px;">
            Printed: {{ now()->format('d/m/Y H:i:s') }}
        </div>
    </div>
</div>