<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function members()
    {
        return $this->hasMany(User::class);
    }

    public function sharedReports()
{
    return $this->belongsToMany(Report::class, 'family_report', 'family_id', 'report_id');
}
}