<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Supplier;
use App\Models\Inventory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Using existing categories and brands...');
        
        // Skip creating categories and brands since they're handled by CategorySeeder and BrandSeeder

        $this->command->info('Creating sample suppliers...');

        // Create Suppliers
        $suppliers = [
            [
                'name' => 'Tech Distribution Lanka',
                'code' => 'TDL001',
                'email' => 'info@techdistribution.lk',
                'phone' => '+94 11 234 5678',
                'contact_person' => 'Saman Perera',
                'address' => json_encode([
                    'street' => 'No. 123, Galle Road',
                    'city' => 'Colombo',
                    'postal_code' => '00300',
                    'country' => 'Sri Lanka'
                ]),
                'payment_terms' => 30,
                'status' => 'published',
            ],
            [
                'name' => 'Digital Hardware Solutions',
                'code' => 'DHS002',
                'email' => 'sales@digitalhardware.lk',
                'phone' => '+94 11 345 6789',
                'contact_person' => 'Nimal Silva',
                'address' => json_encode([
                    'street' => 'No. 456, Kandy Road',
                    'city' => 'Colombo',
                    'postal_code' => '00700',
                    'country' => 'Sri Lanka'
                ]),
                'payment_terms' => 45,
                'status' => 'published',
            ],
        ];

        foreach ($suppliers as $supplierData) {
            Supplier::create($supplierData);
        }

        $this->command->info('Creating sample products...');

        // Get existing categories and brands from our seeders
        $laptopCategory = Category::where('name', 'Laptop')->first();
        $desktopCategory = Category::where('name', 'Desktop Pc')->first();
        $gamingCategory = Category::where('name', 'Rog Gaming Pcs')->first();
        $accessoriesCategory = Category::where('name', 'Other Accessories')->first();

        $dellBrand = Brand::where('name', 'Dell')->first();
        $hpBrand = Brand::where('name', 'Hp')->first();
        $lenovoBrand = Brand::where('name', 'Lenovo')->first();
        $asusBrand = Brand::where('name', 'Asus')->first();
        $msiBrand = Brand::where('name', 'Msi')->first();

        // Create Products
        $products = [
            [
                'name' => 'Dell Inspiron 15 3000',
                'slug' => 'dell-inspiron-15-3000',
                'description' => 'Reliable everyday laptop with Intel Core i5 processor, 8GB RAM, and 256GB SSD. Perfect for work and entertainment.',
                'short_description' => 'Intel Core i5, 8GB RAM, 256GB SSD',
                'sku' => 'DELL-INS15-3000',
                'barcode' => '1234567890123',
                'price' => 125000.00,
                'compare_price' => 140000.00,
                'cost_price' => 110000.00,
                'inventory_quantity' => 25,
                'category_id' => $laptopCategory->id,
                'brand_id' => $dellBrand->id,
                'status' => 'published',
                'published_at' => now(),
            ],
            [
                'name' => 'ASUS ROG Strix G15',
                'slug' => 'asus-rog-strix-g15',
                'description' => 'High-performance gaming laptop with AMD Ryzen 7, NVIDIA RTX 3060, 16GB RAM, and 512GB SSD. Built for serious gamers.',
                'short_description' => 'AMD Ryzen 7, RTX 3060, 16GB RAM',
                'sku' => 'ASUS-ROG-G15',
                'barcode' => '1234567890124',
                'price' => 285000.00,
                'cost_price' => 240000.00,
                'inventory_quantity' => 15,
                'category_id' => $gamingCategory->id,
                'brand_id' => $asusBrand->id,
                'status' => 'published',
                'published_at' => now(),
            ],
            [
                'name' => 'Lenovo ThinkPad E14',
                'slug' => 'lenovo-thinkpad-e14',
                'description' => 'Professional business laptop with Intel Core i7, 16GB RAM, and 512GB SSD. Built for productivity and durability.',
                'short_description' => 'Intel Core i7, 16GB RAM, 512GB SSD',
                'sku' => 'LENOVO-TP-E14',
                'barcode' => '1234567890126',
                'price' => 195000.00,
                'compare_price' => 210000.00,
                'cost_price' => 175000.00,
                'inventory_quantity' => 20,
                'category_id' => $laptopCategory->id,
                'brand_id' => $lenovoBrand->id,
                'status' => 'published',
                'published_at' => now(),
            ],
            [
                'name' => 'HP Pavilion Desktop',
                'slug' => 'hp-pavilion-desktop',
                'description' => 'Complete desktop system with Intel Core i5, 8GB RAM, 1TB HDD + 256GB SSD, and integrated graphics.',
                'short_description' => 'Intel Core i5, 8GB RAM, Dual Storage',
                'sku' => 'HP-PAV-DESKTOP',
                'barcode' => '1234567890127',
                'price' => 95000.00,
                'cost_price' => 85000.00,
                'inventory_quantity' => 18,
                'category_id' => $desktopCategory->id,
                'brand_id' => $hpBrand->id,
                'status' => 'published',
                'published_at' => now(),
            ],
            [
                'name' => 'MSI Gaming Laptop GF63',
                'slug' => 'msi-gaming-gf63',
                'description' => 'Entry-level gaming laptop with Intel Core i5, NVIDIA GTX 1650, 8GB RAM, and 512GB SSD.',
                'short_description' => 'Intel Core i5, GTX 1650, 8GB RAM',
                'sku' => 'MSI-GF63-GAMING',
                'barcode' => '1234567890128',
                'price' => 165000.00,
                'cost_price' => 145000.00,
                'inventory_quantity' => 22,
                'category_id' => $gamingCategory->id,
                'brand_id' => $msiBrand->id,
                'status' => 'published',
                'published_at' => now(),
            ],
        ];

        foreach ($products as $productData) {
            // Skip product if category or brand doesn't exist
            if (!$productData['category_id'] || !$productData['brand_id']) {
                $this->command->warn('Skipping product: ' . $productData['name'] . ' (missing category or brand)');
                continue;
            }
            
            $product = Product::create($productData);
            
            // Create sample product images (using placeholder images)
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => 'products/sample-' . $product->id . '-1.jpg',
                'alt_text' => $product->name . ' - Main Image',
                'is_primary' => true,
                'sort_order' => 1,
            ]);

            // Create inventory record
            Inventory::create([
                'product_id' => $product->id,
                'supplier_id' => rand(1, 2), // Random supplier
                'quantity_on_hand' => $product->inventory_quantity,
                'quantity_available' => $product->inventory_quantity,
                'reorder_level' => 10,
                'reorder_quantity' => $product->inventory_quantity,
                'cost_price' => $product->cost_price,
                'location' => 'Main Warehouse',
                'status' => 'published',
            ]);
        }

        $this->command->info('Sample data created successfully!');
        $this->command->info('Created:');
        $this->command->info('- ' . Category::count() . ' categories');
        $this->command->info('- ' . Brand::count() . ' brands');
        $this->command->info('- ' . Supplier::count() . ' suppliers');
        $this->command->info('- ' . Product::count() . ' products');
        $this->command->info('- ' . ProductImage::count() . ' product images');
        $this->command->info('- ' . Inventory::count() . ' inventory records');
    }
}
