<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaManagementService
{
    /**
     * Aktualisiert die Familien-Freigaben für Medien.
     *
     * @param Media|Collection $mediaItems
     * @param array $familyIds
     */
    public function updateShares($mediaItems, array $familyIds): void
    {
        if ($mediaItems instanceof Media) {
            $mediaItems = new Collection([$mediaItems]);
        }
        if ($mediaItems->isEmpty()) { return; }

        DB::transaction(function () use ($mediaItems, $familyIds) {
            foreach ($mediaItems as $media) {
                $media->sharedWithFamilies()->sync($familyIds);
            }
        });
    }

    /**
     * Überträgt den Besitz von Medien an einen neuen Benutzer.
     *
     * @param Media|Collection $mediaItems
     * @param User $newOwner
     */
    public function transferOwnership($mediaItems, User $newOwner): void
    {
        if ($mediaItems instanceof Media) {
            $mediaItems = new Collection([$mediaItems]);
        }
        if ($mediaItems->isEmpty()) { return; }

        foreach ($mediaItems as $media) {
            $media->model()->associate($newOwner); // Der saubere Eloquent-Weg
            $media->save();
        }
    }
}