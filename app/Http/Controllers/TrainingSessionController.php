<?php

namespace App\Http\Controllers;

use App\Models\TrainingSession;
use Illuminate\Http\Request;

class TrainingSessionController extends Controller
{
    public function index()
    {
        $trainingSessions = TrainingSession::with('athlete')->get();
        return inertia('TrainingSessions/Index', ['trainingSessions' => $trainingSessions]);
    }

    public function create()
    {
        return inertia('TrainingSessions/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'athlete_id' => ['required', 'exists:athletes,id'],
            'date_time' => ['required', 'date'],
            'notes' => 'nullable',
            'name' => 'required',
        ]);

        TrainingSession::create($request->all());

        return back()->with('status', 'Training session created successfully!');
    }

    public function show(TrainingSession $trainingSession)
    {
        return inertia('TrainingSessions/Show', ['trainingSession' => $trainingSession]);
    }

    public function edit(TrainingSession $trainingSession)
    {
        return inertia('TrainingSessions/Edit', ['trainingSession' => $trainingSession]);
    }

    public function update(Request $request, TrainingSession $trainingSession)
    {
        $request->validate([
            'notes' => ['required', 'string'],
            'athlete_id' => ['required', 'exists:athletes,id'],
            'date_time' => ['required', 'date'],
        ]);

        $trainingSession->update($request->all());

        return redirect()->route('trainingSessions.index');
    }

    public function destroy(TrainingSession $trainingSession)
    {
        $trainingSession->delete();

        return redirect()->route('trainingSessions.index');
    }
}

