<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class UserManagement extends Component
{
    use WithPagination;

    public $search = '';

    public $showCreateModal = false;

    public $showEditModal = false;

    public $editingUserId = null;

    // Form fields
    public $name = '';

    public $email = '';

    public $password = '';

    public $password_confirmation = '';

    public $role = 'customer';

    public function mount(): void
    {
        if (! auth()->user()->hasRole(['super-admin', 'admin'])) {
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
            ->when($this->search, function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function create(): void
    {
        $this->resetFields();
        $this->showCreateModal = true;
    }

    public function edit($userId): void
    {
        $user = User::findOrFail($userId);

        $this->editingUserId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->roles->first()?->name ?? 'customer';
        $this->password = '';
        $this->password_confirmation = '';

        $this->showEditModal = true;
    }

    public function save(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$this->editingUserId,
            'password' => $this->editingUserId ? 'nullable|min:8|confirmed' : 'required|min:8|confirmed',
            'role' => 'required|in:customer,admin,super-admin',
        ]);

        if ($this->editingUserId) {
            // Update existing user
            $user = User::findOrFail($this->editingUserId);
            $user->update([
                'name' => $this->name,
                'email' => $this->email,
                'password' => $this->password ? Hash::make($this->password) : $user->password,
            ]);

            // Update role
            $user->syncRoles([$this->role]);

            $this->showEditModal = false;
            session()->flash('message', 'User updated successfully.');
        } else {
            // Create new user
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'email_verified_at' => now(),
            ]);

            // Assign role
            $user->assignRole($this->role);

            $this->showCreateModal = false;
            session()->flash('message', 'User created successfully.');
        }

        $this->resetFields();
    }

    public function delete($userId): void
    {
        $user = User::findOrFail($userId);

        // Prevent deleting own account
        if ($user->id === auth()->id()) {
            session()->flash('error', 'You cannot delete your own account.');

            return;
        }

        $user->delete();
        session()->flash('message', 'User deleted successfully.');
    }

    public function closeModal(): void
    {
        $this->showCreateModal = false;
        $this->showEditModal = false;
        $this->resetFields();
    }

    private function resetFields(): void
    {
        $this->editingUserId = null;
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->role = 'customer';
    }

    public function render()
    {
        return view('livewire.admin.user-management');
    }
}
