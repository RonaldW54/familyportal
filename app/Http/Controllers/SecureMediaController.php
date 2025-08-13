<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Facades\Log;

class SecureMediaController extends Controller
{
    public function show(Media $media)
{
    $user = auth()->user();

    // Grundvoraussetzung: Ein Benutzer muss angemeldet sein.
    if (!$user) {
        abort(403, 'Nicht authentifiziert.');
    }

    // Berechtigungsprüfung: Ist der Benutzer der Besitzer ODER ein Admin?
    $isOwner = ($media->model_id === $user->id);
    $isAdmin = $user->isAdmin();

    // Später fügen wir hier die Prüfung für geteilte Bilder hinzu.
    $isSharedWithFamily = false; 
    // if ($user->family_id && $media->sharedWithFamilies->contains('id', $user->family_id)) {
    //     $isSharedWithFamily = true;
    // }

    if ($isOwner || $isAdmin || $isSharedWithFamily) {
        
        // MANUELLE PFAD-ERSTELLUNG (DER FIX)
        $diskRootPath = config("filesystems.disks.{$media->disk}.root");
        
        // STANDARD-PFAD-STRUKTUR DER MEDIALIBRARY
        $filePathRelativeToDisk = $media->id . '/' . $media->file_name;

        $absolutePath = $diskRootPath . '/' . $filePathRelativeToDisk;

        // FINALE PRÜFUNG: Existiert die Datei wirklich dort?
        if (file_exists($absolutePath) && is_readable($absolutePath)) {
            return response()->file($absolutePath);
        }

        // Wenn nicht, ist etwas fundamental falsch.
        Log::error("KRITISCHER DATEIZUGRIFFSFEHLER", [
            'media_id' => $media->id,
            'user_id' => $user->id,
            'disk' => $media->disk,
            'versuchter_pfad' => $absolutePath,
            'getPath_ergebnis' => $media->getPath(), // Zum Vergleich
        ]);
        
        // Wir geben einen 404 zurück, weil die Datei fehlt.
        abort(404, 'Datei nicht gefunden.');
    }

    // Wenn keine Berechtigung, gib 403 zurück.
    abort(403);
}
}