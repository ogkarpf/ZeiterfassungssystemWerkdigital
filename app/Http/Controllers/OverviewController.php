<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkTime;
use Carbon\Carbon;

class OverviewController extends Controller
{
    public function getOverview(Request $request)
    {
        $user = auth()->user();
        
        $query = WorkTime::where('user_id', $user->id)->orderBy('start_time');
        
        if ($request->has('day')) {
            $day = Carbon::createFromFormat('d-m-Y', $request->input('day'))->format('Y-m-d');
            $query->whereDate('start_time', $day);
        }
        
        $workTimes = $query->get();

        $groupedWorkTimes = $workTimes->groupBy(function ($workTime) {
            return $workTime->start_time->format('d.m.Y');
        });
        
        $totalWorkHours = [];
        foreach ($groupedWorkTimes as $date => $dayWorkTimes) {
            $totalWorkHours[$date] = number_format($dayWorkTimes->sum(function ($workTime) {
                return $workTime->start_time->diffInHours($workTime->end_time); 
            }), 2);
        }
        
        $availableDays = WorkTime::where('user_id', $user->id)->orderBy('start_time')
            ->selectRaw("DATE_FORMAT(start_time, '%d.%m.%Y') AS date")
            ->distinct()
            ->pluck('date');
        
        return view('overview', [
            'groupedWorkTimes' => $groupedWorkTimes,
            'totalWorkHours' => $totalWorkHours,
            'availableDays' => $availableDays,
        ]);
    }
}
