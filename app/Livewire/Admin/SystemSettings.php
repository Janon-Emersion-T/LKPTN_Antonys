<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class SystemSettings extends Component
{
    public $siteName = '';
    public $siteDescription = '';
    public $maintenanceMode = false;
    public $allowRegistration = true;
    
    public function mount(): void
    {
        if (!auth()->user()->hasRole(['super-admin', 'admin'])) {
            abort(403, 'Access denied');
        }
        
        $this->siteName = config('app.name', 'POS Ecommerce');
        $this->siteDescription = 'A modern POS and ecommerce solution';
        $this->maintenanceMode = app()->isDownForMaintenance();
        $this->allowRegistration = true;
    }
    
    public function save(): void
    {
        $this->validate([
            'siteName' => 'required|string|max:255',
            'siteDescription' => 'required|string|max:500',
        ]);
        
        // In a real app, you'd save these to database or config
        session()->flash('success', 'Settings updated successfully!');
    }

    public function render()
    {
        return view('livewire.admin.system-settings');
    }
}
