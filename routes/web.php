<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\TrainingExerciseController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('LandingPage', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/record', function () {
        return Inertia::render('Record'); // Assuming you have a Record component
    })->name('record');
    
    Route::get('/resource', function () {
        return Inertia::render('Resource'); // Assuming you have a Resources component
    })->name('resource');
});


//fetch preset exercise
Route::get('/api/exercises', [ExerciseController::class, 'index'])->name('exercises');

//store the user's custom exercise as preset
Route::post('/api/exercises', [ExerciseController::class, 'store'])->name('exercises');

//store the user's training exercise
Route::post('/api/training-exercises', [TrainingExerciseController::class, 'store'])->name('training-exercises');

//get session time and user id
Route::post('/api/getSession', [TrainingExerciseController::class, 'getSession'])->name('getSession');