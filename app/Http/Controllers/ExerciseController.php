<?php

namespace App\Http\Controllers;

use App\Http\Resources\ExerciseResource;
use App\Models\Exercise;
use App\Models\TrainingExercise;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ExerciseController extends Controller
{
    public function index()
    {
        // Fetch and return all exercises
        $exercises = Exercise::with('unit', 'exerciseType')->get();
        return $exercises;
    }

    public function store(Request $request)
    {
        // Validate incoming request
        $validatedData = $request->validate([
            'exercise_id' => 'required|exists:exercises,id',
            'sets' => 'required|integer|min:1',
            // Add validation for other fields as required
        ]);

        // Create a new TrainingExercise record
        $Exercise = Exercise::create($validatedData);

        // Return a success response
        return response()->json(['message' => 'Workout data created successfully', 'data' => $Exercise]);
    }
}

