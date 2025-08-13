<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Services\MediaManagementService;

class PhotoManagementController extends Controller
{
    protected $mediaManagementService;
    public function __construct(MediaManagementService $mediaManagementService)
    {
        $this->mediaManagementService = $mediaManagementService;
    }
    // Die Galerie-Ansicht für den Admin
    public function index()
    {
        // Hier kommt später die interaktive Livewire-Komponente rein.
        // Vorerst zeigen wir einfach alle Bilder paginiert an.
        $allPhotos = Media::latest()->paginate(20);
        return view('admin.photos.index', ['photos' => $allPhotos]);
    }

    // Die Bearbeiten-Ansicht für den Admin
    public function edit(Media $media)
    {
        // Als Admin brauchen wir keine Prüfung, wem das Bild gehört.
        $users = User::orderBy('name')->get(); // Lade alle User für das "Besitzerwechsel"-Dropdown

        return view('admin.photos.edit', [
            'media' => $media,
            'users' => $users,
        ]);
    }

    // Die Update-Aktion für den Admin
    public function update(Request $request, Media $media)
    {
        // ... (Hier kommt die Speicherlogik rein, ähnlich wie im PhotoController,
        // aber potenziell mit mehr Feldern, die nur ein Admin ändern darf)
        
        // Beispiel:
        $request->validate(['description' => 'nullable|string']);
        $media->setCustomProperty('description', $request->description);
        $media->save();

        return redirect()->route('admin.photos.manage.index')->with('success', 'Bild erfolgreich aktualisiert.');
    }
    
    // Die Methode für den Besitzerwechsel
    public function reassign(Request $request, Media $media)
    {
        $request->validate(['new_owner_id' => 'required|exists:users,id']);
        $newOwner = User::findOrFail($request->input('new_owner_id'));

        // --- Besitz über den zentralen Service übertragen ---
        $this->mediaManagementService->transferOwnership($media, $newOwner);

        return back()->with('success', "Das Bild wurde erfolgreich an {$newOwner->name} übertragen.");
    }
}
