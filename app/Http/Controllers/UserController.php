<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getSession(Request $request){
        $userID = Auth::id();
        $now = Carbon::now();
        return response()->json([
            'userID'=> $userID,
            'now'=> $now
        ]);
    }

}
