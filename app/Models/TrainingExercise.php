<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingExercise extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'training_session_id', 
        'exercise_id', 
        'output', 
        'sets', 
        'reps', 
        'set_rest_time_seconds', 
        'rep_rest_time_seconds'
    ];

    public function exercise() {
        return $this->belongsTo(Exercise::class);
    }
}

