<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exercise;
use App\Models\TrainingExercise;

class TrainingExerciseController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'training_session_id' => 'required|exists:training_sessions,id',
            'exercise_id' => 'required|exists:exercises,id',
            'output' => 'nullable|numeric',
            'sets' => 'nullable|integer',
            'reps' => 'nullable|integer',
            'set_rest_time_seconds' => 'nullable|integer',
            'rep_rest_time_seconds' => 'nullable|integer',
        ]);

        $trainingExercise = TrainingExercise::create($data);

        return response()->json($trainingExercise, 201);
    }
}

