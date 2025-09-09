<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Show the application home page.
     */
    public function index(): View
    {
        $laptopData = $this->getLaptopData();
        
        return view('home', compact('laptopData'));
    }

    /**
     * Get laptop data for the homepage
     */
    private function getLaptopData(): array
    {
        // Find the laptop category
        $laptopCategory = Category::where('name', 'Laptop')
            ->where('is_active', true)
            ->first();

        if (!$laptopCategory) {
            return [
                'hasLaptops' => false,
                'latestLaptops' => collect(),
                'hotDealLaptop' => null,
                'message' => 'We are out of Laptops at the moment. Check back later!'
            ];
        }

        // Get latest laptops for slider
        $latestLaptops = Product::where('category_id', $laptopCategory->id)
            ->where('status', 'published')
            ->where('inventory_quantity', '>', 0)
            ->with(['images', 'brand'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Get random laptop for hot deal
        $hotDealLaptop = Product::where('category_id', $laptopCategory->id)
            ->where('status', 'published')
            ->where('inventory_quantity', '>', 0)
            ->with(['images', 'brand'])
            ->inRandomOrder()
            ->first();

        if ($latestLaptops->isEmpty() && !$hotDealLaptop) {
            return [
                'hasLaptops' => false,
                'latestLaptops' => collect(),
                'hotDealLaptop' => null,
                'message' => 'We are out of Laptops at the moment. Check back later!'
            ];
        }

        return [
            'hasLaptops' => true,
            'latestLaptops' => $latestLaptops,
            'hotDealLaptop' => $hotDealLaptop,
            'message' => null
        ];
    }
}
