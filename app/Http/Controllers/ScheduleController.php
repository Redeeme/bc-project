<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    public function index()
    {
        return view('scheduleSelection');
    }

    public function getSchedules(){
        $schedules = Schedule::all();
        return view('scheduleSelection',[
            'schedules' => $schedules,
        ]);
    }

    public function getFilteredSchedules()
    {
        $schedules = DB::table('schedules')
            ->select('schedule_no')
            ->distinct()
            ->get();
        $schedules->sortBy('schedule_no');
        $categories = DB::table('schedules')
            ->select('type')
            ->distinct()
            ->get();
        return view('scheduleSelection', ['schedules' => $schedules,'categories' => $categories]);
    }
}
