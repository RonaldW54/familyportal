<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Album extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description'];

    // Ein Album gehört EINEM User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Ein Album hat VIELE Bilder (Media-Objekte)
    public function media()
    {
        return $this->belongsToMany(CustomMedia::class, 'album_media', 'album_id', 'media_id');
    }
}