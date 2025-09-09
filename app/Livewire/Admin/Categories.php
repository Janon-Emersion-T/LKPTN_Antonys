<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Categories extends Component
{
    use WithPagination, WithFileUploads;
    
    public $search = '';
    public $sortBy = 'name';
    public $sortDirection = 'asc';
    public $filterStatus = 'all';
    public $showingModal = false;
    public $editingCategory = null;
    
    // Category form fields
    public $name = '';
    public $description = '';
    public $parent_id = '';
    public $is_active = true;
    public $sort_order = '';
    public $image;
    
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
        $this->editingCategory = null;
        $this->showingModal = true;
    }
    
    public function openEditModal(int $categoryId): void
    {
        $category = Category::findOrFail($categoryId);
        $this->editingCategory = $category;
        $this->name = $category->name;
        $this->description = $category->description ?? '';
        $this->parent_id = $category->parent_id ?? '';
        $this->is_active = $category->is_active;
        $this->sort_order = $category->sort_order;
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
            'parent_id' => 'nullable|exists:categories,id',
            'sort_order' => 'nullable|integer|min:0',
            'image' => 'nullable|image|max:2048', // 2MB Max
        ]);
        
        $data = [
            'name' => $this->name,
            'description' => $this->description ?: null,
            'parent_id' => $this->parent_id ?: null,
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order ?: null,
        ];
        
        // Handle file upload
        if ($this->image) {
            // Delete old image if updating and new image is provided
            if ($this->editingCategory && $this->editingCategory->image) {
                $oldPath = storage_path('app/public/' . $this->editingCategory->image);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            $data['image'] = $this->image->store('categories', 'public');
        }
        
        if ($this->editingCategory) {
            $this->editingCategory->update($data);
            session()->flash('message', 'Category updated successfully.');
        } else {
            Category::create($data);
            session()->flash('message', 'Category created successfully.');
        }
        
        $this->closeModal();
    }
    
    public function deleteCategory(int $categoryId): void
    {
        $category = Category::findOrFail($categoryId);
        
        if ($category->children()->count() > 0) {
            session()->flash('error', 'Cannot delete category with child categories.');
            return;
        }
        
        if ($category->products()->count() > 0) {
            session()->flash('error', 'Cannot delete category with products.');
            return;
        }
        
        // Delete category image if exists
        if ($category->image && file_exists(storage_path('app/public/' . $category->image))) {
            unlink(storage_path('app/public/' . $category->image));
        }
        
        $category->delete();
        session()->flash('message', 'Category deleted successfully.');
    }
    
    public function toggleStatus(int $categoryId): void
    {
        $category = Category::findOrFail($categoryId);
        $category->update(['is_active' => !$category->is_active]);
        session()->flash('message', 'Category status updated successfully.');
    }
    
    public function resetForm(): void
    {
        $this->name = '';
        $this->description = '';
        $this->parent_id = '';
        $this->is_active = true;
        $this->sort_order = '';
        $this->image = null;
    }
    
    public function getCategoriesProperty()
    {
        return Category::with(['parent', 'children'])
            ->when($this->search, function($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('description', 'like', "%{$this->search}%");
            })
            ->when($this->filterStatus !== 'all', function($q) {
                $q->where('is_active', $this->filterStatus === 'active');
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);
    }
    
    public function getParentCategoriesProperty()
    {
        return Category::whereNull('parent_id')->active()->orderBy('name')->get();
    }

    public function render()
    {
        return view('livewire.admin.categories');
    }
}
