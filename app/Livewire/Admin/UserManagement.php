<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserManagement extends Component
{
    use WithPagination;
    
    public $search = '';
    
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
    
    public function getUsersProperty()
    {
        return User::with('roles')
            ->when($this->search, function($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('email', 'like', "%{$this->search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.admin.user-management');
    }
}
