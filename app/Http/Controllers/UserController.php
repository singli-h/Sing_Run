<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Athlete;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserController extends Controller
{
    public function getSession(Request $request){
        $userID = Auth::id();
        $now = Carbon::now();

        // Retrieve the athlete ID using the user ID
        $athlete = Athlete::where('user_id', $userID)->first();
        if (!$athlete) {
            return response()->json(['error' => 'Athlete not found'], 404);
        }

        // Returning the athlete's ID and the current datetime
        return response()->json([
            'athleteId' => $athlete->id, 
            'now' => $now
        ]);
    }

}
