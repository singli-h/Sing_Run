<?php

namespace App\Http\Controllers;

use App\Models\Athlete;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AthleteController extends Controller
{
    public function index()
    {
        // Fetch and return user's athlete id
        $userID = Auth::id();
        $athlete = Athlete::where('user_id', $userID)->first();
        
        if (!$athlete) {
            // Handle the case where no matching athlete is found for the user
            return response()->json(['message' => 'Athlete not found'], 404);
        }
    
        return response()->json($athlete);

    }
}
