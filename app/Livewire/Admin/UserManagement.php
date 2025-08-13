<?php
namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Family;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class UserManagement extends Component
{
    use WithPagination;

    public ?User $editingUser = null;
    public $families;
    public $showEditModal = false;
    public $newPassword = null;
    public $search = '';

    // Für die Formular-Bindung im Modal
    public $resetLink = null;
    public $name;
    public $email;
    public $family_id;

    public function mount()
    {
        $this->families = Family::orderBy('name')->get();
    }

    public function edit(User $user)
    {
        $this->editingUser = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->family_id = $user->family_id;
        $this->newPassword = null; // Passwort-Feld zurücksetzen
        $this->showEditModal = true;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->editingUser->id,
            'family_id' => 'nullable|exists:families,id',
        ]);

        $this->editingUser->update([
            'name' => $this->name,
            'email' => $this->email,
            'family_id' => $this->family_id,
        ]);

        $this->showEditModal = false;
        session()->flash('success', 'Benutzer erfolgreich aktualisiert.');
    }

    public function resetPassword()
    {
        if ($this->editingUser) {
            $password = Str::random(10);
            $this->editingUser->update(['password' => Hash::make($password)]);
            $this->newPassword = $password; // Dem Admin das neue Passwort anzeigen
        }
    }
    
public function generateResetLink()
{
    if ($this->editingUser) {
        $token = Str::random(60);
        $this->editingUser->update([
            'password_reset_token' => $token,
            'password_reset_expires_at' => now()->addMinutes(15),
        ]);
        
        // Generiere den Link, den der Admin kopieren kann
        $this->resetLink = route('password.reset', ['token' => $token, 'email' => $this->editingUser->email]);
        $this->newPassword = null; // Alte Logik entfernen
    }
}

    public function render()
    {
        $users = User::with('family')
            ->where('name', 'like', '%'.$this->search.'%')
            ->orWhere('email', 'like', '%'.$this->search.'%')
            ->paginate(15);
            
        return view('livewire.admin.user-management', [
            'users' => $users
        ]);
    }
}
