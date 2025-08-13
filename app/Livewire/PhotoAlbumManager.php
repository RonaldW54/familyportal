<?php
namespace App\Livewire;

use Livewire\Component;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Models\Album;

class PhotoAlbumManager extends Component
{
    public Media $media;
    public $newAlbumId = '';

    // Fügt das Bild zum ausgewählten Album hinzu
    public function addToAlbum()
    {
        $this->media->albums()->attach($this->newAlbumId);
        $this->newAlbumId = ''; // Dropdown zurücksetzen
    }

    // Entfernt das Bild aus einem Album
    public function removeFromAlbum($albumId)
    {
        $this->media->albums()->detach($albumId);
    }

    public function render()
    {
        // Lade die Alben, in denen das Bild bereits ist
        $assignedAlbums = $this->media->albums;

        // Lade die Alben, in denen das Bild noch nicht ist
        $availableAlbums = auth()->user()->albums()
            ->whereNotIn('id', $assignedAlbums->pluck('id'))
            ->get();

        return view('livewire.photo-album-manager', [
            'assignedAlbums' => $assignedAlbums,
            'availableAlbums' => $availableAlbums,
        ]);
    }
}