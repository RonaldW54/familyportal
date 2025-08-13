<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting; 

class TextController extends Controller
{
    public function edit()
    {
        // Lade die Texte oder erstelle sie, falls sie nicht existieren
        $settings = Setting::firstOrCreate(['key' => 'welcome_title'], ['value' => 'Willkommen im Familienportal']);
        $settings = Setting::firstOrCreate(['key' => 'welcome_subtitle'], ['value' => 'Der sichere Ort...']);

        // Lade alle Texte als Array
        $texts = Setting::pluck('value', 'key');

        return view('admin.texts.edit', compact('texts'));
    }

    public function update(Request $request)
    {
        Setting::updateOrCreate(['key' => 'welcome_title'], ['value' => $request->welcome_title]);
        Setting::updateOrCreate(['key' => 'welcome_subtitle'], ['value' => $request->welcome_subtitle]);

        return redirect()->route('admin.texts.edit')->with('success', 'Texte erfolgreich gespeichert!');
    }
}