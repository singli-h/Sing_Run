<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'notes',
        'user_id',
        'date_time',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}


