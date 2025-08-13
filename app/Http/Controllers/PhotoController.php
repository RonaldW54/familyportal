<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CustomMedia as Media;
use App\Models\Tag;
use App\Models\Family;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Image\Image; 
use Spatie\Image\Manipulations;
use Spatie\Image\Enums\Orientation;
use Illuminate\Support\Facades\Artisan;
use App\Services\MediaManagementService;
use App\Models\Setting;

class PhotoController extends Controller
{
    protected $mediaManagementService;

    public function __construct(MediaManagementService $mediaManagementService)
    {
        $this->mediaManagementService = $mediaManagementService;
    }
    /**
     * Zeigt die Galerie aller Bilder des eingeloggten Users an.
     */
    public function index(Request $request)
{
    $mediaQuery = Media::where('model_type', 'App\Models\User')->where('model_id', auth()->id());
    $mediaQuery = $this->applyFiltersPublic($mediaQuery, $request);
    
    return view('photos.index', $this->prepareViewDataPublic($request, $mediaQuery, 'mine'));
}

    /**
     * Zeigt das Upload-Formular an.
     */
   public function create()
{
    $albums = auth()->user()->albums()->orderBy('title')->get();
    return view('photos.create', compact('albums'));
}

    /**
     * Speichert das hochgeladene Bild mit Metadaten.
     */
    public function store(Request $request)
    {
        // ... (deine store-Methode bleibt unverändert)
        // Hier können wir später noch die EXIF-Logik beim direkten Upload einbauen
        $request->validate([
            'photo' => 'required|image|max:20480',
            'description' => 'nullable|string|max:1000',
            'photo_date' => 'nullable|date',
        ]);

        Auth::user()->addMediaFromRequest('photo')
            ->withCustomProperties([
                'description' => $request->input('description'),
                'photo_date' => $request->input('photo_date'),
            ])
            ->toMediaCollection('photos');

        return redirect()->route('photos.index')->with('success', 'Foto erfolgreich hochgeladen!');
    }

    /**
     * Zeigt das Formular zum Bearbeiten der Foto-Details an.
     *
     * @param  \Spatie\MediaLibrary\MediaCollections\Models\Media  $media
     * @return \Illuminate\View\View
     */

public function edit(Media $media, Request $request)
{
    // Sicherheitsprüfung
    if ($media->model_id !== Auth::id() && !auth()->user()->is_admin) {
        abort(403, 'Zugriff verweigert.');
    }

    // Hole Alben des Benutzers
    $userAlbums = Auth::user()->albums()->orderBy('title')->get();

    // Hole alle Familien, an die freigegeben werden kann
    $allFamilies = Family::where('id', '!=', $media->model->family_id)
                         ->orderBy('name')
                         ->get();

    // Übergib alle Daten an die View
    return view('photos.edit', [
        'media' => $media,
        'albums' => $userAlbums,
        'filters' => $request->query('filters', []),
        'allFamilies' => $allFamilies,
    ]);
}

    /**
     * Aktualisiert die Metadaten eines Fotos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Spatie\MediaLibrary\MediaCollections\Models\Media  $media
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Media $media)
{
    // Sicherheitsprüfung (bleibt gleich)
    if ($media->model_id !== Auth::id() && !Auth::user()->isAdmin) {
        abort(403);
    }

    // Validierung erweitern
    $request->validate([
        'description' => 'nullable|string|max:1000',
        'photo_date' => 'nullable|date',
        'location' => 'nullable|string|max:255',
        'photographer' => 'nullable|string|max:255',
        'tags' => 'nullable|string',
        'ignore_completeness' => 'nullable|boolean',
        
        // NEUE REGEL: Prüft, ob das Album existiert UND dem User gehört
        'album_id' => 'nullable|exists:albums,id,user_id,' . Auth::id(), 
    ]);

    // Speichern der Custom Properties (bleibt gleich)
    $media->setCustomProperty('description', $request->input('description'));
    $media->setCustomProperty('photo_date', $request->input('photo_date'));
    $media->setCustomProperty('location', $request->input('location'));
    $media->setCustomProperty('photographer', $request->input('photographer'));
    $media->setCustomProperty('ignore_completeness', $request->boolean('ignore_completeness'));
    
    $media->save(); // Speichert die Custom Properties
    // Zuweisungen für Freigaben 
    $familyIdsToShareWith = $request->input('share_with_families', []);
    $this->mediaManagementService->updateShares($media, $familyIdsToShareWith);
    // --- NEUE LOGIK FÜR DIE ALBUM-ZUWEISUNG ---
    if ($request->has('album_ids')) {
    $media->albums()->sync($request->input('album_ids', []));   
    } else {
    // Wenn das Feld existiert, aber leer ist (User hat alles abgewählt)
        if (array_key_exists('album_ids', $request->all())) {
            $media->albums()->sync([]);
        }
     // Wenn das Feld gar nicht im Request ist, machen wir NICHTS.
    }
    // ------------------------------------------
    // ====================T A G S
    $tagIds = [];
    if ($request->filled('tags')) {
        // 1. Zerlege den String in einzelne Namen
        $tagNames = explode(',', $request->input('tags'));

        foreach ($tagNames as $tagName) {
            $trimmedName = trim($tagName); // Entferne Leerzeichen am Anfang/Ende
            if (!empty($trimmedName)) {
                // 2. Finde den Tag oder erstelle ihn, falls er nicht existiert
                $tag = Tag::firstOrCreate(
                    ['slug' => Str::slug($trimmedName)], // Suche anhand des Slugs
                    ['name' => $trimmedName]            // Falls neu, setze diesen Namen
                );
                $tagIds[] = $tag->id;
            }
        }
    }
    // 3. Synchronisiere die Tags. Alte werden entfernt, die im Formular waren, werden zugewiesen.
    // Wenn $tagIds leer ist, werden alle Zuweisungen entfernt.
    $media->tags()->sync($tagIds);
    // ==========================================
    // ==========================================
    // Collection verschieben 
    if (in_array($media->collection_name, ['default', 'unprocessed'])) {
        $media->move($media->model, 'photos');
    }

    return redirect()->route('photos.index', $request->input('filters', []))->with('success', 'Foto-Details erfolgreich aktualisiert!');
}
// Bilder drehen
// In app/Http/Controllers/PhotoController.php

public function rotate(Request $request, Media $media)
{
    // Sicherheitsprüfung
    if (auth()->id() !== $media->model_id && !auth()->user()->is_admin) {
        abort(403);
    }
    $request->validate(['direction' => 'required|in:left,right']);

    $path = $media->getPath();
    
    $imageInfo = @getimagesize($path);
    if (!$imageInfo) {
        return back()->with('error', 'Konnte Bildinformationen nicht lesen.');
    }
    $mimeType = $imageInfo['mime'];

    $sourceImage = null;
    switch ($mimeType) {
        case 'image/jpeg':
            $sourceImage = imagecreatefromjpeg($path);
            break;
        case 'image/png':
            $sourceImage = imagecreatefrompng($path);
            break;
        case 'image/gif':
            $sourceImage = imagecreatefromgif($path);
            break;
        default:
            return back()->with('error', 'Dieser Bildtyp kann nicht gedreht werden.');
    }

    if (!$sourceImage) {
        return back()->with('error', 'Bild konnte nicht geladen oder verarbeitet werden.');
    }

    // Bestimme den Drehwinkel
    $degrees = $request->input('direction') === 'left' ? 90 : -90;

    // Führe die Drehung durch
    $rotatedImage = imagerotate($sourceImage, $degrees, 0);

    // Speichere das gedrehte Bild und überschreibe das Original
    switch ($mimeType) {
        case 'image/jpeg':
            imagejpeg($rotatedImage, $path, 90);
            break;
        case 'image/png':
            imagepng($rotatedImage, $path);
            break;
        case 'image/gif':
            imagegif($rotatedImage, $path);
            break;
    }

    // Gib den Speicher frei
    imagedestroy($sourceImage);
    imagedestroy($rotatedImage);
    
    // Regeneriere Konvertierungen mit dem Artisan-Befehl
    Artisan::call('media-library:regenerate', [
        '--ids' => $media->id,
        '--force' => true,
    ]);
    
    return back()->with('success', 'Bild erfolgreich gedreht.');
}



public function crop(Request $request, Media $media)
{
    // Sicherheitsprüfung
    if (auth()->id() !== $media->model_id && !auth()->user()->is_admin) {
        abort(403);
    }
    $request->validate([
        'data.x' => 'required|numeric',
        'data.y' => 'required|numeric',
        'data.width' => 'required|numeric|min:1',
        'data.height' => 'required|numeric|min:1',
    ]);
    $data = $request->input('data');
    $path = $media->getPath();

    $imageInfo = getimagesize($path);
    if (!$imageInfo) {
        return response()->json(['success' => false, 'message' => 'Bildinfo konnte nicht gelesen werden.'], 500);
    }
    $mimeType = $imageInfo['mime'];

    $sourceImage = null;
    switch ($mimeType) {
        case 'image/jpeg': $sourceImage = imagecreatefromjpeg($path); break;
        case 'image/png': $sourceImage = imagecreatefrompng($path); break;
        case 'image/gif': $sourceImage = imagecreatefromgif($path); break;
        default: return response()->json(['success' => false, 'message' => 'Bildtyp nicht unterstützt.'], 422);
    }

    if (!$sourceImage) {
        return response()->json(['success' => false, 'message' => 'Bild konnte nicht geladen werden.'], 500);
    }
    
    // Erstelle ein neues, leeres Bild mit den Ziel-Dimensionen
    $croppedImage = imagecreatetruecolor($data['width'], $data['height']);
    
    // Kopiere den ausgewählten Bereich
    imagecopyresampled(
        $croppedImage, $sourceImage,
        0, 0,
        (int)$data['x'], (int)$data['y'],
        (int)$data['width'], (int)$data['height'],
        (int)$data['width'], (int)$data['height']
    );

    // Speichere das zugeschnittene Bild
    switch ($mimeType) {
        case 'image/jpeg': imagejpeg($croppedImage, $path, 95); break;
        case 'image/png': imagepng($croppedImage, $path); break;
        case 'image/gif': imagegif($croppedImage, $path); break;
    }

    imagedestroy($sourceImage);
    imagedestroy($croppedImage);

    // Regeneriere Konvertierungen mit dem Artisan-Befehl
    Artisan::call('media-library:regenerate', [
        '--ids' => $media->id,
        '--force' => true,
    ]);

    return response()->json(['success' => true, 'message' => 'Bild erfolgreich zugeschnitten.']);
}
//Löschen
public function destroy(Media $media)
{
    // Sicherheitsprüfung: Nur der Besitzer oder ein Admin darf löschen.
    if (auth()->id() !== $media->model_id && !auth()->user()->is_admin) {
        abort(403, 'Sie haben keine Berechtigung, dieses Bild zu löschen.');
    }

    // Das 'delete'-Kommando der Spatie Media Library entfernt nicht nur den DB-Eintrag,
    // sondern auch alle zugehörigen Dateien und Konvertierungen vom Server.
    $media->delete();

    return redirect()->route('photos.index')->with('success', 'Das Foto wurde erfolgreich gelöscht.');
}
// Bilder von Anderen für mich freigegeben
public function sharedWithMe(Request $request)
{
    $user = auth()->user();
    if (!$user->family_id) {
        $mediaQuery = Media::where('id', -1);
    } else {
        $mediaQuery = Media::query()->whereHas('sharedWithFamilies', function ($q) use ($user) {
            $q->where('families.id', $user->family_id);
        });
        $mediaQuery = $this->applyFiltersPublic($mediaQuery, $request);
    }
    
    return view('photos.index', $this->prepareViewDataPublic($request, $mediaQuery, 'shared'));
}

    /**
     * Liest die EXIF-Daten eines Fotos und gibt sie als JSON zurück.
     *
     * @param  \Spatie\MediaLibrary\MediaCollections\Models\Media  $media
     * @return \Illuminate\Http\JsonResponse
     */
    public function readExif(Media $media)
    {
        // ... (deine readExif-Methode bleibt unverändert)
        if ($media->model_id !== auth()->id() && !auth()->user()->isAdmin) {
            abort(403);
        }
        $exifData = @exif_read_data($media->getPath());
        if (!$exifData) {
            return response()->json(['message' => 'Keine EXIF-Daten gefunden.'], 404);
        }
        $data = [
            'photo_date' => isset($exifData['DateTimeOriginal']) 
                ? date('Y-m-d', strtotime($exifData['DateTimeOriginal'])) 
                : null,
            'camera' => $exifData['Model'] ?? null,
        ];
        return response()->json($data);
    }

    public function importExif(Media $media)
{
    // ... (Sicherheitsprüfung) ...
    if ($media->model_id !== auth()->id() && !auth()->user()->isAdmin) {
        abort(403);
    }

    $exifData = @exif_read_data($media->getPath());

    if ($exifData) {
        $photoDate = isset($exifData['DateTimeOriginal']) ? date('Y-m-d', strtotime($exifData['DateTimeOriginal'])) : $media->getCustomProperty('photo_date');
        $cameraModel = $exifData['Model'] ?? $media->getCustomProperty('camera');

        $media->setCustomProperty('photo_date', $photoDate);
        $media->setCustomProperty('camera', $cameraModel);
        $media->setCustomProperty('full_exif', $exifData);
        $media->setCustomProperty('exif_read', true);
        $media->save();

        return response()->json([
            'message' => 'EXIF-Daten erfolgreich importiert!',
            'photo_date' => $photoDate,
            'camera' => $cameraModel,
        ]);
    }
    return response()->json(['message' => 'Keine EXIF-Daten gefunden.'], 404);
}

public function unprocessed()
{
    $user = auth()->user();
    $allPhotos = \Spatie\MediaLibrary\MediaCollections\Models\Media::where('model_type', 'App\Models\User')
                                                               ->where('model_id', $user->id)
                                                               ->get();

    // Wir filtern nach allen Bildern, die noch Arbeit benötigen
    $unprocessedPhotos = $allPhotos->filter(function ($photo) {
        if ($photo->getCustomProperty('ignore_completeness')) {
            return false; // Ignoriere die, die der User als "fertig" markiert hat
        }
        // Zeige die aus dem Bulk-Upload ODER die ohne Beschreibung
        return $photo->collection_name === 'default' || empty($photo->getCustomProperty('description'));
    });

    return view('photos.unprocessed', ['photos' => $unprocessedPhotos]);
}

/**
 * Wendet die Filter aus der URL auf eine Medien-Query an.
 * @param Builder $query
 * @param Request $request
 * @return Builder
 */
public function applyFiltersPublic(Builder $query, Request $request)
{
    if ($request->input('filter') === 'by-album' && $request->input('album_id')) {
        $query->whereHas('albums', fn ($q) => $q->where('albums.id', $request->input('album_id')));
    } elseif ($request->input('filter') === 'no-album') {
        $query->whereDoesntHave('albums');
    }

    if ($request->filled('person')) {
        $query->whereHas('tags', fn ($q) => $q->where('name', 'like', '%' . $request->input('person') . '%'));
    }
    return $query;
}
/**
     * Private Hilfsmethode, um die Daten für die Anzeige-Views vorzubereiten.
     */
    public function prepareViewDataPublic(Request $request, Builder $mediaQuery, string $mode) : array
    {
        // Lade die Slideshow-Verzögerung aus den Einstellungen
        $slideshowDelay = (int) Setting::where('key', 'slideshow_delay')->value('value');

        // Paginieren oder alle Bilder holen, basierend auf dem 'view'-Parameter
        if ($request->input('view') === 'slideshow') {
            $photos = $mediaQuery->latest()->get();
        } else {
            $photos = $mediaQuery->latest()->paginate(24)->withQueryString();
        }
        
        return [
            'mode' => $mode,
            'photos' => $photos,
            'albums' => auth()->user()->albums()->orderBy('title')->get(),
            'slideshowDelay' => $slideshowDelay,
            'currentView' => $request->input('view', 'grid'),
            'currentFilter' => $request->input('filter'),
            'currentAlbumId' => $request->input('album_id'),
            'currentPerson' => $request->input('person'),
        ];
    }
}