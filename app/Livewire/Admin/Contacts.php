<?php

namespace App\Livewire\Admin;

use App\Models\Contact;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Contacts extends Component
{
    use WithPagination;
    
    public $search = '';
    public $statusFilter = '';
    public $selectedContact = null;
    public $showModal = false;
    public $adminReply = '';
    
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
    
    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }
    
    public function getContactsProperty()
    {
        return Contact::with('repliedBy')
            ->when($this->search, function($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('email', 'like', "%{$this->search}%")
                  ->orWhere('subject', 'like', "%{$this->search}%");
            })
            ->when($this->statusFilter, function($q) {
                $q->where('status', $this->statusFilter);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }
    
    public function viewContact($contactId): void
    {
        $this->selectedContact = Contact::with('repliedBy')->find($contactId);
        $this->adminReply = $this->selectedContact->admin_reply ?? '';
        $this->showModal = true;
    }
    
    public function closeModal(): void
    {
        $this->showModal = false;
        $this->selectedContact = null;
        $this->adminReply = '';
    }
    
    public function updateStatus($contactId, $status): void
    {
        $contact = Contact::find($contactId);
        if ($contact) {
            $contact->update([
                'status' => $status,
                'replied_by' => $status === 'replied' ? auth()->id() : $contact->replied_by,
                'replied_at' => $status === 'replied' ? now() : $contact->replied_at,
            ]);
            
            $this->dispatch('contact-updated');
        }
    }
    
    public function saveReply(): void
    {
        if (!$this->selectedContact) return;
        
        $this->selectedContact->update([
            'admin_reply' => $this->adminReply,
            'status' => 'replied',
            'replied_by' => auth()->id(),
            'replied_at' => now(),
        ]);
        
        $this->dispatch('contact-updated');
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.admin.contacts');
    }
}
