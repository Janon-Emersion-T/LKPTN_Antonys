<?php

namespace App\Livewire\Admin;

use App\Models\Brand;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Brands extends Component
{
    use WithPagination, WithFileUploads;
    
    public $search = '';
    public $sortBy = 'name';
    public $sortDirection = 'asc';
    public $filterStatus = 'all';
    public $showingModal = false;
    public $editingBrand = null;
    
    // Brand form fields
    public $name = '';
    public $description = '';
    public $website = '';
    public $is_active = true;
    public $logo;
    
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
        $this->editingBrand = null;
        $this->showingModal = true;
    }
    
    public function openEditModal(int $brandId): void
    {
        $brand = Brand::findOrFail($brandId);
        $this->editingBrand = $brand;
        $this->name = $brand->name;
        $this->description = $brand->description ?? '';
        $this->website = $brand->website ?? '';
        $this->is_active = $brand->is_active;
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
            'description' => 'nullable|string',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|image|max:2048', // 2MB Max
        ]);
        
        $data = [
            'name' => $this->name,
            'description' => $this->description ?: null,
            'website' => $this->website ?: null,
            'is_active' => $this->is_active,
        ];
        
        // Handle file upload
        if ($this->logo) {
            // Delete old logo if updating and new logo is provided
            if ($this->editingBrand && $this->editingBrand->logo) {
                $oldPath = storage_path('app/public/' . $this->editingBrand->logo);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            $data['logo'] = $this->logo->store('brands', 'public');
        }
        
        if ($this->editingBrand) {
            $this->editingBrand->update($data);
            session()->flash('message', 'Brand updated successfully.');
        } else {
            Brand::create($data);
            session()->flash('message', 'Brand created successfully.');
        }
        
        $this->closeModal();
    }
    
    public function deleteBrand(int $brandId): void
    {
        $brand = Brand::findOrFail($brandId);
        
        if ($brand->products()->count() > 0) {
            session()->flash('error', 'Cannot delete brand with products.');
            return;
        }
        
        // Delete brand logo if exists
        if ($brand->logo && file_exists(storage_path('app/public/' . $brand->logo))) {
            unlink(storage_path('app/public/' . $brand->logo));
        }
        
        $brand->delete();
        session()->flash('message', 'Brand deleted successfully.');
    }
    
    public function toggleStatus(int $brandId): void
    {
        $brand = Brand::findOrFail($brandId);
        $brand->update(['is_active' => !$brand->is_active]);
        session()->flash('message', 'Brand status updated successfully.');
    }
    
    public function resetForm(): void
    {
        $this->name = '';
        $this->description = '';
        $this->website = '';
        $this->is_active = true;
        $this->logo = null;
    }
    
    public function getBrandsProperty()
    {
        return Brand::withCount('products')
            ->when($this->search, function($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('description', 'like', "%{$this->search}%")
                  ->orWhere('website', 'like', "%{$this->search}%");
            })
            ->when($this->filterStatus !== 'all', function($q) {
                $q->where('is_active', $this->filterStatus === 'active');
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.admin.brands');
    }
}
