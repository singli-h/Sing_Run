<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coach extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'speciality',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function athletes()
    {
        return $this->belongsToMany(Athlete::class, 'coach_athletes', 'coach_id', 'athlete_id');
    }
}
