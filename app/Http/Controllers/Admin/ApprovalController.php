<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Family;
use App\Models\User;

class ApprovalController extends Controller
{
    /**
     * Zeigt die Liste der ausstehenden Freigaben an.
     */
    public function index()
{
    // Wir nennen die Variable so, wie die View sie erwartet.
    $users = User::where('status', 'pending')->orderBy('created_at')->get();

    // Jetzt findet compact('users') die richtige Variable.
    return view('admin.approvals.index', compact('users'));
}

    /**
     * Gibt einen Benutzer frei und weist ihn einer Familie zu.
     */
    public function approve(User $user)
    {
        // Hole oder erstelle die Familie basierend auf dem Wunsch des Benutzers
        $familyName = $user->requested_family_name;
        if ($familyName) {
            $family = Family::firstOrCreate(['name' => $familyName]);
            $user->family_id = $family->id;
        }

        $user->status = 'approved';
        $user->save();

        return back()->with('success', "Benutzer {$user->name} wurde erfolgreich freigegeben.");
    }

    /**
     * Lehnt einen Benutzer ab und löscht ihn.
     */
    public function reject(User $user)
    {
        $userName = $user->name;
        $user->delete();

        return back()->with('success', "Benutzer {$userName} wurde abgelehnt und gelöscht.");
    }
}