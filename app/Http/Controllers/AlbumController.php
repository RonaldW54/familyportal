<?php
namespace App\Http\Controllers;
use App\Http\Controllers\PhotoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Album;

class AlbumController extends Controller
{
    public function index()
    {
        $albums = Auth::user()->albums()->latest()->get();
        return view('albums.index', compact('albums'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Auth::user()->albums()->create($request->only('title', 'description'));

        return redirect()->route('albums.index')->with('success', 'Neues Album erfolgreich erstellt!');
    }
    public function ajaxStore(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255|unique:albums,title,NULL,id,user_id,' . auth()->id(),
    ]);

    $album = auth()->user()->albums()->create($validated);

    // Gib das neue Album als JSON zurück, damit JS es verwenden kann
    return response()->json([
        'success' => true,
        'album' => [
            'id' => $album->id,
            'title' => $album->title,
        ]
    ]);
}
public function show(Album $album, Request $request)
{
    if ($album->user_id !== auth()->id() && !auth()->user()->is_admin) {
        abort(403, 'Zugriff verweigert.');
    }

    // === DATENABFRAGE ===
    $mediaQuery = $album->media()->getQuery(); 

    $photoController = app(PhotoController::class);
    $mediaQuery = $photoController->applyFiltersPublic($mediaQuery, $request);

    // Daten für die View vorbereiten (genau wie im PhotoController)
    $viewData = $photoController->prepareViewDataPublic($request, $mediaQuery, 'album');
    
    // Füge das Album selbst zu den View-Daten hinzu
    $viewData['album'] = $album;

    // Wir rendern dieselbe View wie für Fotos!
    return view('photos.index', $viewData);
}
}