<?php
namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Family;
use App\Models\CustomMedia as Media;
use Livewire\Component;

class PortalStats extends Component
{
    public int $totalUsers;
    public int $totalFamilies;
    public int $totalPhotos;
    protected $listeners = ['statsChanged' => 'loadStats'];

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        $this->totalUsers = User::count();
        $this->totalFamilies = Family::count();
        $this->totalPhotos = Media::count();
        $this->onlineUsers = User::where('last_seen', '>', now()->subMinutes(5))->get();
    }

    public function render()
{
    // Die 'loadStats'-Methode wird jetzt durch `wire:poll` aufgerufen
    // und aktualisiert die öffentlichen Eigenschaften. Wir müssen sie hier
    // nicht erneut aufrufen, sondern nur die Eigenschaften an die View übergeben.
    
    return view('livewire.admin.portal-stats', [
        'totalUsers' => $this->totalUsers,
        'totalFamilies' => $this->totalFamilies,
        'totalPhotos' => $this->totalPhotos,
        'onlineUsers' => $this->onlineUsers ?? collect(), 
    ]);
}
}