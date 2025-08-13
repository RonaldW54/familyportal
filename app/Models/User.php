<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements HasMedia
{
    use HasFactory, Notifiable, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'is_family_head',
        'requested_family_name',
        'family_id',
        'isAdmin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'isAdmin' => 'boolean',
            'is_family_head' => 'boolean',
        ];
    }

    /**
     * Prüft zuverlässig, ob der Benutzer Administratorrechte hat.
     */
    public function isAdmin(): bool
    {
        return $this->isAdmin === true;
    }

    /**
     * Definiert die Beziehung zu einer Familie.
     */
    public function family()
    {
        return $this->belongsTo(Family::class);
    }

    /**
     * Definiert die Beziehung zu Alben.
     */
    public function albums()
    {
        return $this->hasMany(Album::class);
    }
    
    /**
     * Definiert die Media-Konvertierungen.
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('thumbnail')
            ->fit(\Spatie\Image\Manipulations::FIT_CROP, 300, 300)
            ->nonQueued();

        $this
            ->addMediaConversion('preview')
            ->fit(\Spatie\Image\Manipulations::FIT_MAX, 1200, 1200)
            ->nonQueued();
    }

    /** Berichte und Geschichten
     * Ein Benutzer kann viele Berichte schreiben.
     */

    public function reports()
{
    return $this->hasMany(Report::class);
}
}