<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    /**
     * Die Attribute, die massenhaft zugewiesen werden können.
     */
    protected $fillable = [
        'user_id',
        'title',
        'content_json',
        'content_html',
        'status',
    ];

    /**
     * Ein Bericht gehört zu genau einem Benutzer (dem Autor).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Ein Bericht kann viele Tags (Schlagworte) haben.
     * (Wir verwenden hier exakt dieselbe Tag-Struktur wie bei den Bildern)
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'report_tag', 'report_id', 'tag_id');
    }

    /**
     * Ein Bericht kann für viele Familien freigegeben werden.
     */
    public function sharedWithFamilies()
    {
        return $this->belongsToMany(Family::class, 'family_report', 'report_id', 'family_id');
    }
}