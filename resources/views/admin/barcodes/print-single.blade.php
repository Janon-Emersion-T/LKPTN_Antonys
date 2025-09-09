<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Barcode - {{ $product->name }}</title>
    <style>
        /* Print-optimized styles */
        @media print {
            @page {
                width: 100mm;
                height: auto;
                margin: 2mm;
            }
            body {
                margin: 0;
                padding: 0;
                font-family: 'Courier New', monospace;
            }
            .no-print {
                display: none;
            }
        }
        
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            line-height: 1.2;
            margin: 0;
            padding: 10px;
            background: white;
            color: black;
        }
        
        .barcode-container {
            width: 90mm;
            margin: 0 auto;
            page-break-inside: avoid;
            margin-bottom: 10mm;
        }
        
        .barcode-item {
            border: 1px dashed #ccc;
            padding: 8px;
            margin-bottom: 4mm;
            background: white;
            text-align: center;
        }
        
        .product-name {
            font-size: 10px;
            font-weight: bold;
            margin-bottom: 4px;
            text-transform: uppercase;
            word-wrap: break-word;
        }
        
        .product-sku {
            font-size: 8px;
            color: #666;
            margin-bottom: 4px;
        }
        
        .barcode-visual {
            margin: 8px 0;
            padding: 4px;
            background: white;
        }
        
        .barcode-lines {
            display: inline-block;
            height: 30px;
            background: repeating-linear-gradient(
                to right,
                black 0px, black 1px,
                white 1px, white 2px,
                black 2px, black 3px,
                white 3px, white 4px
            );
            width: 100%;
            margin: 4px 0;
        }
        
        .barcode-number {
            font-size: 10px;
            font-weight: bold;
            margin: 4px 0;
            letter-spacing: 2px;
            font-family: monospace;
        }
        
        .product-price {
            font-size: 11px;
            font-weight: bold;
            margin-top: 4px;
        }
        
        .company-info {
            font-size: 8px;
            color: #666;
            margin-top: 4px;
        }
        
        /* Control buttons */
        .print-controls {
            text-align: center;
            margin: 20px 0;
            padding: 20px;
            border-top: 2px dashed #ccc;
        }
        
        .btn {
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin: 0 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        
        .btn:hover {
            background: #0056b3;
        }
        
        .btn.btn-success {
            background: #28a745;
        }
        
        .btn.btn-success:hover {
            background: #218838;
        }
        
        .btn.btn-secondary {
            background: #6c757d;
        }
        
        .btn.btn-secondary:hover {
            background: #5a6268;
        }
    </style>
</head>
<body>
    <div class="barcode-container">
        @for($i = 0; $i < $quantity; $i++)
            <div class="barcode-item">
                <!-- Product Name -->
                <div class="product-name">
                    {{ $product->name }}
                </div>
                
                <!-- Product SKU -->
                @if($product->sku)
                    <div class="product-sku">
                        SKU: {{ $product->sku }}
                    </div>
                @endif
                
                <!-- Barcode Visual -->
                <div class="barcode-visual">
                    @if($product->barcode)
                        <div class="barcode-lines"></div>
                        <div class="barcode-number">
                            {{ $product->barcode }}
                        </div>
                    @else
                        <div style="font-size: 10px; color: #999; padding: 15px;">
                            No Barcode Available
                        </div>
                    @endif
                </div>
                
                <!-- Product Price -->
                <div class="product-price">
                    LKR {{ number_format($product->price, 2) }}
                </div>
                
                <!-- Company Info -->
                <div class="company-info">
                    {{ env('GLOBALS_COMPANY_NAME', config('app.name')) }}
                </div>
            </div>
        @endfor
    </div>
    
    <!-- Print Controls -->
    <div class="no-print print-controls">
        <h3 style="margin-bottom: 15px; color: #333;">Barcode Ready for Printing</h3>
        <p style="margin-bottom: 15px; color: #666;">
            Product: <strong>{{ $product->name }}</strong> | 
            Quantity: <strong>{{ $quantity }}</strong> label(s)
        </p>
        
        <button onclick="printBarcode()" class="btn btn-success">
            🖨️ Print Barcodes
        </button>
        
        <button onclick="window.close()" class="btn btn-secondary">
            ❌ Close
        </button>
        
        <div style="margin-top: 15px;">
            <label for="copies">Number of copies:</label>
            <select id="copies" onchange="updateQuantity()" style="margin-left: 10px; padding: 5px;">
                @for($i = 1; $i <= 20; $i++)
                    <option value="{{ $i }}" {{ $i == $quantity ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
            <button onclick="reloadWithQuantity()" class="btn" style="margin-left: 10px;">
                🔄 Update
            </button>
        </div>
        
        <div style="margin-top: 10px; font-size: 12px; color: #666;">
            Click "Print Barcodes" to print these labels to your barcode printer
        </div>
    </div>
    
    <script>
        function printBarcode() {
            window.print();
        }
        
        function updateQuantity() {
            // This function is called when the quantity is changed
        }
        
        function reloadWithQuantity() {
            const quantity = document.getElementById('copies').value;
            const url = new URL(window.location);
            url.searchParams.set('quantity', quantity);
            window.location.href = url.toString();
        }
        
        // Handle print dialog events
        window.addEventListener('beforeprint', function() {
            console.log('Starting to print barcodes...');
        });
        
        window.addEventListener('afterprint', function() {
            console.log('Print dialog closed');
        });
        
        // Focus print button when page loads
        window.addEventListener('load', function() {
            console.log('Barcode page loaded successfully');
        });
        
        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key === 'p') {
                e.preventDefault();
                printBarcode();
            }
            if (e.key === 'Escape') {
                window.close();
            }
        });
    </script>
</body>
</html>