<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'unit_id', 'exercise_type_id', 'description', 'video_url'];

    public function unit() {
        return $this->belongsTo(Unit::class);
    }

    public function exerciseType() {
        return $this->belongsTo(ExerciseType::class);
    }

}
