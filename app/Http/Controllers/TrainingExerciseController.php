<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exercise;
use App\Models\TrainingExercise;
use Carbon\Carbon;

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

    public function getProgress(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $exerciseId = $request->exercise_id;

        // Validate the date format (make sure they are in 'YYYY-MM-DD' format)
        try {
            $startDate = Carbon::createFromFormat('Y-m-d', $startDate);
            $endDate = Carbon::createFromFormat('Y-m-d', $endDate);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid date format'], 422);
        }

        // Ensure the start date is before the end date
        if ($startDate->gt($endDate)) {
            return response()->json(['error' => 'Start date must be before end date'], 422);
        }

        // Query builder
        $query = TrainingExercise::query()
            ->join('training_sessions', 'training_exercises.training_session_id', '=', 'training_sessions.id')
            ->whereBetween('training_sessions.date_time', [$startDate, $endDate])
            ->with(['exercise']);

        // If an exercise ID was provided, add it to the query
        if ($exerciseId) {
            $query->where('training_exercises.exercise_id', $exerciseId);
        }

        $data = $query->get(['training_exercises.*', 'training_sessions.date_time as session_date'])
            ->groupBy(function($data) {
                // Group by week number
                return Carbon::parse($data->session_date)->format('W');
            });

        return response()->json($data);
    }
}

