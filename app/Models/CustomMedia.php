<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseMedia; // Wir geben dem Original einen Spitznamen

class CustomMedia extends BaseMedia // Erbe vom Spatie-Model, nicht von 'Model'
{
    use HasFactory;

    /**
     * Ein Medium kann in vielen Alben sein.
     */
    public function albums()
    {
         return $this->belongsToMany(Album::class, 'album_media', 'media_id', 'album_id');
    }
    /**
     * Hier werden die Suchbegriffe verlinked
     */
    public function tags()
{
    return $this->belongsToMany(Tag::class, 'media_tag', 'media_id', 'tag_id');
}

    public function sharedWithFamilies()
{
    return $this->belongsToMany(Family::class, 'family_media', 'media_id', 'family_id');
}
}