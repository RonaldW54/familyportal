<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\MediaCollections\Models\Media; // WICHTIG: Diese Zeile hinzufügen!

class DashboardController extends Controller
{
    /**
     * Zeigt das persönliche Dashboard des Benutzers an.
     */
    public function index()
{
    $user = auth()->user();

    // Zähle die unbearbeiteten Fotos des Benutzers
    $unprocessedPhotosCount = $user->media()
        ->where('collection_name', 'default')
        ->where(fn($query) => 
            $query->whereNull('custom_properties->description')
                  ->orWhere('custom_properties->description', '')
        )
        ->where('custom_properties->ignore_completeness', '!=', true)
        ->count();

    return view('dashboard', [
        'unprocessedPhotosCount' => $unprocessedPhotosCount
    ]);
}
}