<?php
namespace App\Livewire\Admin;

use App\Models\CustomMedia as Media;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class PhotoGallery extends Component
{
    use WithPagination;

    // Filter-Eigenschaften
    public $search = '';
    public $filterUser = ''; // ID des ausgewählten Benutzers
    public $filterStatus = ''; // z.B. 'no-description', 'no-album'
    public $filterDateAfter = ''; // z.B. '2024-08-01'

    // Daten für die UI
    public $allUsers;

    public function mount()
    {
        // Lade alle Benutzer einmalig für das Filter-Dropdown
        $this->allUsers = User::orderBy('name')->get(['id', 'name']);
    }

    // Setzt die Paginierung zurück, wenn ein Filter geändert wird
    public function updating($property)
    {
        if (in_array($property, ['search', 'filterUser', 'filterStatus', 'filterDateAfter'])) {
            $this->resetPage();
        }
    }
    
    public function render()
    {
        // Starte die Query für alle Medien
        $query = Media::query();

        // Wende die Filter an
        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        if ($this->filterUser) {
            $query->where('model_type', User::class)->where('model_id', $this->filterUser);
        }

        if ($this->filterStatus === 'no-description') {
            // Sucht nach Medien, bei denen die 'description' in den custom_properties leer oder null ist
            $query->where(fn($q) => $q->whereNull('custom_properties->description')->orWhere('custom_properties->description', ''));
        }

        if ($this->filterStatus === 'no-album') {
            $query->whereDoesntHave('albums');
        }

        if ($this->filterDateAfter) {
            $query->where('created_at', '>=', $this->filterDateAfter);
        }

        $photos = $query->with('model')->latest()->paginate(20);
        
        return view('livewire.admin.photo-gallery', [
            'photos' => $photos
        ]);
    }
}