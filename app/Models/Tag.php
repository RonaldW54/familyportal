<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tag extends Model
{
    use HasFactory;

    // Erlaubt das Befüllen von 'name' und 'slug' per Massenzuweisung
    protected $fillable = ['name', 'slug'];

    /**
     * Die Medien (Bilder), die mit diesem Tag verknüpft sind.
     */
    public function media()
    {
        return $this->belongsToMany(CustomMedia::class, 'media_tag', 'tag_id', 'media_id');
    }

    /**
     * Sorgt dafür, dass automatisch ein URL-freundlicher "Slug"
     * aus dem Namen erstellt wird, wenn ein neuer Tag gespeichert wird.
     * Z.B. aus "Jutta Schmidt" wird "jutta-schmidt".
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tag) {
            if (empty($tag->slug)) {
                $tag->slug = Str::slug($tag->name);
            }
        });
    }
}