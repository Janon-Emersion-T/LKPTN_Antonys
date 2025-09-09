<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;

class BarcodeController extends Controller
{
    public function print(Request $request)
    {
        $productIds = $request->input('products', []);
        $quantity = (int) $request->input('quantity', 1);
        
        if (empty($productIds)) {
            return back()->with('error', 'Please select at least one product.');
        }
        
        $products = Product::whereIn('id', $productIds)->get();
        
        if ($products->isEmpty()) {
            return back()->with('error', 'No products found.');
        }
        
        return view('admin.barcodes.print', compact('products', 'quantity'));
    }
    
    public function printSingle(Product $product, Request $request)
    {
        $quantity = (int) $request->input('quantity', 1);
        
        return view('admin.barcodes.print-single', compact('product', 'quantity'));
    }
    
    public function bulkPrint(Request $request)
    {
        $request->validate([
            'products' => 'required|array|min:1',
            'products.*' => 'exists:products,id',
            'quantity' => 'integer|min:1|max:100'
        ]);
        
        $productIds = $request->input('products');
        $quantity = (int) $request->input('quantity', 1);
        
        $products = Product::whereIn('id', $productIds)->get();
        
        return view('admin.barcodes.bulk-print', compact('products', 'quantity'));
    }
    
    public function generateBarcode(string $code, string $type = 'code128')
    {
        // This method can be extended to use a barcode generation library
        // For now, we'll use a simple CSS-based barcode representation
        return response()->json([
            'code' => $code,
            'type' => $type,
            'success' => true
        ]);
    }
}
