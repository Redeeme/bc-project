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


    public function getSchedule($dataset)
    {
        $schedule = DB::table('schedules')
            ->select('schedule_no AS id')
            ->where('dataset_name',$dataset)
            ->distinct()
            ->get();
        $schedule->sortBy('id');
        $categories = DB::table('schedules')
            ->select('type')
            ->distinct()
            ->get();
        return view('ganttSelection', ['schedule' => $schedule,'categories' => $categories,'dataset' => $dataset]);
    }
    public function schedulesSelectGraph($dataset){
        $schedules = DB::table('schedules')
            ->select('schedule_no')
            ->where('dataset_name',$dataset)
            ->distinct()
            ->get();
        $schedules->sortBy('schedule_no');
        $categories = DB::table('schedules')
            ->select('type')
            ->where('dataset_name',$dataset)
            ->distinct()
            ->get();
        return view('scheduleSelectionGraph', ['schedules' => $schedules,'categories' => $categories,'dataset' => $dataset]);
    }
    public function getScheduleTable(Request $request)
    {
        $schedule = DB::table('schedules')
            ->select('schedule_no AS id')
            ->distinct()
            ->get();
        $schedule->sortBy('id');
        $categories = DB::table('schedules')
            ->select('type')
            ->distinct()
            ->get();
        return view('ganttSelection', ['schedule' => $schedule,'categories' => $categories]);
    }
    public function getScheduleGantt(Request $request)
    {
        $schedule = DB::table('schedules')
            ->select('schedule_no AS id')
            ->distinct()
            ->get();
        $schedule->sortBy('id');
        $categories = DB::table('schedules')
            ->select('type')
            ->distinct()
            ->get();
        return view('ganttSelection', ['schedule' => $schedule,'categories' => $categories]);
    }
    public function getScheduleStats(Request $request)
    {
        $schedule = DB::table('schedules')
            ->select('schedule_no AS id')
            ->distinct()
            ->get();
        $schedule->sortBy('id');
        $categories = DB::table('schedules')
            ->select('type')
            ->distinct()
            ->get();
        return view('ganttSelection', ['schedule' => $schedule,'categories' => $categories]);
    }
}
