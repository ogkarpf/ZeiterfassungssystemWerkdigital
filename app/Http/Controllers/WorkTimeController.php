<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkTime;

class WorkTimeController extends Controller
{
    
    public function start(Request $request)
    {
        
        $workTime = new WorkTime();
        $workTime->user_id = auth()->user()->id; 
        $workTime->start_time = now(); 
        $workTime->save();

        
        return response()->json(['message' => 'Arbeitszeit gestartet', 'workTime' => $workTime], 201);
    }

    
    public function stop(Request $request)
    {
        
        $workTime = WorkTime::where('user_id', auth()->user()->id)->latest()->first();

        if (!$workTime) {
            return response()->json(['error' => 'Es wurde keine Arbeitszeit gefunden'], 404);
        }

        
        $workTime->end_time = now();
        $workTime->save();

        
        return response()->json(['message' => 'Arbeitszeit beendet', 'workTime' => $workTime]);
    }
}
