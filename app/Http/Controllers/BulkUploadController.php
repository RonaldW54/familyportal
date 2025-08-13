<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BulkUploadController extends Controller
{
    /**
     * Zeigt die Bulk-Upload-Seite an und übergibt die Alben des Benutzers.
     */
    public function create()
    {
        $albums = Auth::user()->albums()->orderBy('title')->get();
        return view('photos.upload-bulk', compact('albums'));
    }

    /**
     * Verarbeitet eine einzelne Datei, die von FilePond hochgeladen wird.
     */
    public function store(Request $request)
    {
        $request->validate([
            // FilePond sendet die Datei unter dem Namen des <input>-Feldes,
            // standardmäßig 'filepond' oder der 'name'-Attributwert.
            'file' => 'required|file|image|max:20480',
            
            // Die album_id kommt als Query-Parameter in der URL.
            'album_id' => 'nullable|exists:albums,id,user_id,' . Auth::id(),
        ]);

        $media = Auth::user()
            // Der Feldname hier muss mit dem Namen im JS übereinstimmen
            ->addMediaFromRequest('file')
            // Bulk-Uploads gehen in die 'default' Collection zur späteren Bearbeitung
            ->toMediaCollection('default');

        // Bild dem Album zuweisen, wenn eine ID in der URL war
        if ($request->has('album_id')) {
            $media->albums()->attach($request->query('album_id'));
        }

        // FilePond erwartet eine einfache Text-ID oder eine JSON-Antwort
        return response()->json(['id' => $media->id], 200);
    }
}