<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Athlete extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'height',
        'weight',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function coaches()
    {
        return $this->belongsToMany(Coach::class, 'coach_athletes', 'athlete_id', 'coach_id');
    }
}
