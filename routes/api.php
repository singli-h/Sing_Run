<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\TrainingExerciseController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//fetch preset exercise
Route::get('/exercises', [ExerciseController::class, 'index']);

//store the user's custom exercise as preset
Route::post('/exercises', [ExerciseController::class, 'store']);

//store the user's training exercise
Route::post('/training-exercises', [TrainingExerciseController::class, 'store']);

