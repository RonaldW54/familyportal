<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;

class UserApprovals extends Component
{
    public $usersToApprove;

    protected $listeners = ['userHandled' => '$refresh'];

    public function mount()
    {
        $this->loadUsers();
    }
    
    public function loadUsers()
    {
        $this->usersToApprove = User::where('status', 'pending')->get();
    }

    public function approve(User $user)
    {
        $user->status = 'approved';
        $user->save();
        $this->loadUsers(); // Liste neu laden
        $this->dispatch('statsChanged'); // Event für das Statistik-Widget
    }

    public function reject(User $user)
    {
        $user->delete();
        $this->loadUsers();
        $this->dispatch('statsChanged');
    }

    public function render()
    {
        return view('livewire.admin.user-approvals');
    }
}