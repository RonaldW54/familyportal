<?php

namespace App\Livewire\Admin;

use App\Models\Setting;
use Livewire\Component;

class SettingsManager extends Component
{
    // Diese Eigenschaft wird an das Eingabefeld in der View gebunden
    public $slideshowDelay;

    /**
     * Wird beim Initialisieren der Komponente aufgerufen.
     * Lädt den aktuellen Wert aus der Datenbank.
     */
    public function mount()
    {
        $this->slideshowDelay = Setting::where('key', 'slideshow_delay')->value('value') ?? 0;
    }

    /**
     * Wird aufgerufen, wenn der "Speichern"-Button geklickt wird.
     */
    public function save()
    {
        // Validierung (optional, aber empfohlen)
        $this->validate([
            'slideshowDelay' => 'required|integer|min:0',
        ]);

        // Speichert den Wert in der 'settings'-Tabelle.
        // Wenn der Schlüssel 'slideshow_delay' nicht existiert, wird er erstellt.
        // Wenn er existiert, wird er aktualisiert.
        Setting::updateOrCreate(
            ['key' => 'slideshow_delay'],
            ['value' => $this->slideshowDelay]
        );
        
        // Zeigt eine Erfolgsmeldung an
        session()->flash('success', 'Einstellungen erfolgreich gespeichert.');
    }

    /**
     * Rendert die Ansicht.
     */
    public function render()
    {
        // Weist die Komponente an, das Admin-Layout zu verwenden
        return view('livewire.admin.settings-manager')
            ->layout('layouts.admin', ['header' => 'Einstellungen']);
    }
}
