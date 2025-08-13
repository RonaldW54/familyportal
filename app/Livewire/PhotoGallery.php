<?php

namespace App\Livewire;

use App\Models\Album;
use App\Models\CustomMedia as Media;
use Livewire\Component;
use Livewire\WithPagination;

class PhotoGallery extends Component
{
    use WithPagination;

    // Definiert den Modus ('mine' oder 'shared')
    public string $mode = 'mine';

    // Eigenschaften für die Filterung, die mit der View synchronisiert werden
    public ?string $view = 'grid';
    public ?string $filter = null;
    public ?string $albumId = null;
    public ?string $person = null;

    // Speichert die Alben des Benutzers für das Filter-Dropdown
    public $userAlbums = [];

    // Verknüpft die Eigenschaften mit den URL-Query-Parametern
    protected $queryString = [
        'view' => ['except' => 'grid'],
        'filter' => ['except' => ''],
        'albumId' => ['except' => ''],
        'person' => ['except' => ''],
    ];
    
    // Wird einmal beim Initialisieren der Komponente ausgeführt
    public function mount($mode = 'mine')
    {
        $this->mode = $mode;
        $this->userAlbums = auth()->user()->albums()->orderBy('title')->get();
    }

    // Wird jedes Mal aufgerufen, wenn sich eine Eigenschaft ändert
    public function updated()
    {
        // Setzt die Paginierung auf Seite 1 zurück, wenn ein Filter geändert wird
        $this->resetPage();
    }
    
    // Erstellt die Ansicht
    public function render()
    {
        $user = auth()->user();
        $baseQuery = Media::query();

        // 1. Basis-Query basierend auf dem Modus ('mine' vs 'shared')
        if ($this->mode === 'mine') {
            $baseQuery->where('model_type', 'App\Models\User')->where('model_id', $user->id);
        } else { // 'shared'
            if (!$user->family_id) {
                $baseQuery->where('id', -1);
            } else {
                $baseQuery->whereHas('sharedWithFamilies', function ($q) use ($user) {
                    $q->where('families.id', $user->family_id);
                });
            }
        }

        // 2. Anwenden der Filter
        if ($this->filter === 'no-album') {
            $baseQuery->whereDoesntHave('albums');
        }
        if ($this->filter === 'by-album' && $this->albumId) {
            $baseQuery->whereHas('albums', fn ($q) => $q->where('albums.id', $this->albumId));
        }
        if ($this->person) {
            $baseQuery->whereHas('tags', fn ($q) => $q->where('name', 'like', '%' . $this->person . '%'));
        }

        // Finale Abfrage ausführen
        $photos = $baseQuery->latest()->paginate(24);

        // Daten an die View übergeben
        return view('livewire.photo-gallery', [
            'photos' => $photos,
            'userAlbums' => $this->userAlbums,
        ]);
    }
     public function applyFilters()
    {
        // Diese Methode muss nichts tun. Der Aufruf selbst sorgt dafür,
        // dass die aktuellen Eigenschaftswerte zum Server gesendet werden
        // und die render()-Methode neu ausgeführt wird.
        
        // Wir senden ein Event an Alpine.js, um das Modal zu schließen.
        $this->dispatch('filters-applied');
    }

    public function resetFilters()
    {
        // Setzt alle Filter-Eigenschaften auf ihre Standardwerte zurück.
        $this->reset('filter', 'albumId', 'person');
    }
}