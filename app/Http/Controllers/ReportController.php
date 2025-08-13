<?php
namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        // Zeigt eine Liste der Berichte (bauen wir später)
        $reports = auth()->user()->reports()->latest()->get();
        return view('reports.index', compact('reports'));
    }

    public function create()
    {
        // Zeigt das Formular mit dem Editor an
        return view('reports.create');
    }

    public function store(Request $request)
    {
        // Speichert den neuen Bericht
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content_json' => 'required|json',
            'content_html' => 'required|string',
        ]);

        auth()->user()->reports()->create($validated);

        return redirect()->route('reports.index')->with('success', 'Bericht erfolgreich erstellt.');
    }
}