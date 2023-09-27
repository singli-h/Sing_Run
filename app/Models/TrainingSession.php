<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'notes',
        'athlete_id',
        'date_time',
    ];

    public function athlete()
    {
        return $this->belongsTo(Athlete::class);
    }
}


