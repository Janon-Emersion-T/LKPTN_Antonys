<?php

namespace App\Livewire\Admin;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Livewire\Component;

class RolesPermissions extends Component
{
    public function mount(): void
    {
        if (!auth()->user()->hasRole(['super-admin', 'admin'])) {
            abort(403, 'Access denied');
        }
    }
    
    public function getRolesProperty()
    {
        return Role::withCount('users')->orderBy('name')->get();
    }
    
    public function getPermissionsProperty()
    {
        return Permission::orderBy('name')->get();
    }

    public function render()
    {
        return view('livewire.admin.roles-permissions');
    }
}
