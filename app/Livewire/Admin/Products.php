<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Products extends Component
{
    use WithPagination, WithFileUploads;
    
    public $search = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $filterStatus = 'all';
    public $filterCategory = '';
    public $filterBrand = '';
    public $showingModal = false;
    public $editingProduct = null;
    
    // Product form fields
    public $name = '';
    public $description = '';
    public $short_description = '';
    public $price = '';
    public $compare_price = '';
    public $cost_price = '';
    public $sku = '';
    public $barcode = '';
    public $inventory_quantity = 0;
    public $low_stock_threshold = 5;
    public $category_id = '';
    public $brand_id = '';
    public $status = 'draft';
    public $track_inventory = true;
    public $requires_shipping = true;
    public $is_digital = false;
    public $weight = '';
    public $featured_image;
    
    public function mount(): void
    {
        if (!auth()->user()->hasRole(['super-admin', 'admin'])) {
            abort(403, 'Access denied');
        }
    }
    
    public function updatedSearch(): void
    {
        $this->resetPage();
    }
    
    public function updatedFilterStatus(): void
    {
        $this->resetPage();
    }
    
    public function updatedFilterCategory(): void
    {
        $this->resetPage();
    }
    
    public function updatedFilterBrand(): void
    {
        $this->resetPage();
    }
    
    public function sortBy($field): void
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }
    
    public function openCreateModal(): void
    {
        $this->resetForm();
        $this->editingProduct = null;
        $this->showingModal = true;
    }
    
    public function openEditModal(int $productId): void
    {
        $product = Product::findOrFail($productId);
        $this->editingProduct = $product;
        $this->name = $product->name;
        $this->description = $product->description ?? '';
        $this->short_description = $product->short_description ?? '';
        $this->price = $product->price;
        $this->compare_price = $product->compare_price ?? '';
        $this->cost_price = $product->cost_price ?? '';
        $this->sku = $product->sku;
        $this->barcode = $product->barcode ?? '';
        $this->inventory_quantity = $product->inventory_quantity;
        $this->low_stock_threshold = $product->low_stock_threshold;
        $this->category_id = $product->category_id ?? '';
        $this->brand_id = $product->brand_id ?? '';
        $this->status = $product->status;
        $this->track_inventory = $product->track_inventory;
        $this->requires_shipping = $product->requires_shipping;
        $this->is_digital = $product->is_digital;
        $this->weight = $product->weight ?? '';
        $this->showingModal = true;
    }
    
    public function closeModal(): void
    {
        $this->showingModal = false;
        $this->resetForm();
    }
    
    public function save(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'sku' => 'required|string|max:255|unique:products,sku' . ($this->editingProduct ? ',' . $this->editingProduct->id : ''),
            'category_id' => 'nullable|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'inventory_quantity' => 'required|integer|min:0',
            'low_stock_threshold' => 'required|integer|min:0',
            'status' => 'required|in:draft,published,archived',
            'featured_image' => 'nullable|image|max:2048', // 2MB Max
        ]);
        
        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'short_description' => $this->short_description,
            'price' => $this->price,
            'compare_price' => $this->compare_price ?: null,
            'cost_price' => $this->cost_price ?: null,
            'sku' => $this->sku,
            'barcode' => $this->barcode ?: null,
            'inventory_quantity' => $this->inventory_quantity,
            'low_stock_threshold' => $this->low_stock_threshold,
            'category_id' => $this->category_id ?: null,
            'brand_id' => $this->brand_id ?: null,
            'status' => $this->status,
            'track_inventory' => $this->track_inventory,
            'requires_shipping' => $this->requires_shipping,
            'is_digital' => $this->is_digital,
            'weight' => $this->weight ?: null,
            'published_at' => $this->status === 'published' ? now() : null,
        ];
        
        // Handle file upload
        if ($this->featured_image) {
            // Delete old image if updating and new image is provided
            if ($this->editingProduct && $this->editingProduct->featured_image) {
                $oldPath = storage_path('app/public/' . $this->editingProduct->featured_image);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            $data['featured_image'] = $this->featured_image->store('products', 'public');
        }
        
        if ($this->editingProduct) {
            $this->editingProduct->update($data);
            session()->flash('message', 'Product updated successfully.');
        } else {
            Product::create($data);
            session()->flash('message', 'Product created successfully.');
        }
        
        $this->closeModal();
    }
    
    public function deleteProduct(int $productId): void
    {
        $product = Product::findOrFail($productId);
        
        // Check for related records that would prevent deletion
        if ($product->cartItems()->count() > 0) {
            session()->flash('error', 'Cannot delete product that exists in shopping carts.');
            return;
        }
        
        if ($product->orderItems()->count() > 0) {
            session()->flash('error', 'Cannot delete product that has been ordered.');
            return;
        }
        
        // Delete associated images first
        foreach ($product->images as $image) {
            if (file_exists(storage_path('app/public/' . $image->image_path))) {
                unlink(storage_path('app/public/' . $image->image_path));
            }
        }
        
        // Delete featured image if exists
        if ($product->featured_image && file_exists(storage_path('app/public/' . $product->featured_image))) {
            unlink(storage_path('app/public/' . $product->featured_image));
        }
        
        $product->delete();
        session()->flash('message', 'Product deleted successfully.');
    }
    
    public function resetForm(): void
    {
        $this->name = '';
        $this->description = '';
        $this->short_description = '';
        $this->price = '';
        $this->compare_price = '';
        $this->cost_price = '';
        $this->sku = '';
        $this->barcode = '';
        $this->inventory_quantity = 0;
        $this->low_stock_threshold = 5;
        $this->category_id = '';
        $this->brand_id = '';
        $this->status = 'draft';
        $this->track_inventory = true;
        $this->requires_shipping = true;
        $this->is_digital = false;
        $this->weight = '';
        $this->featured_image = null;
    }
    
    public function getProductsProperty()
    {
        return Product::with(['category', 'brand'])
            ->when($this->search, fn($q) => $q->search($this->search))
            ->when($this->filterStatus !== 'all', fn($q) => $q->where('status', $this->filterStatus))
            ->when($this->filterCategory, fn($q) => $q->where('category_id', $this->filterCategory))
            ->when($this->filterBrand, fn($q) => $q->where('brand_id', $this->filterBrand))
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);
    }
    
    public function getCategoriesProperty()
    {
        return Category::active()->orderBy('name')->get();
    }
    
    public function getBrandsProperty()
    {
        return Brand::active()->orderBy('name')->get();
    }

    public function render()
    {
        return view('livewire.admin.products');
    }
}
