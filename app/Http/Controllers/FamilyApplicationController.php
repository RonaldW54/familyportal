<?php

namespace App\Http\Controllers;

// In app/Http/Controllers/FamilyApplicationController.php
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class FamilyApplicationController extends Controller
{
    // Methode zum Anzeigen des Formulars
    public function create()
    {
        return view('apply'); // Zeigt die apply.blade.php an
    }

    // Methode zum Speichern des Antrags
    public function store(Request $request)
    {
        // 1. Validieren der Eingaben
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'family_name' => 'required|string|max:255', // Temporäres Feld, nicht in DB
        ]);

        // 2. Neuen User mit Status "pending" erstellen
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => 'pending', 
            //'is_family_head' => true, 
            'requested_family_name' => $request->family_name,
        ]);
        
        return redirect('/')->with('success', 'Dein Antrag wurde eingereicht und wird vom Admin geprüft.');
    }
}
