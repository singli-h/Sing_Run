<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExerciseType extends Model
{
    use HasFactory;
    
    protected $fillable = ['type', 'body_part_id', 'target'];

    public function exercises() {
        return $this->hasMany(Exercise::class, 'exercise_type_id');
    }
}
