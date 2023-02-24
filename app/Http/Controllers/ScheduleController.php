<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Task;
use Carbon\Carbon;
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
    public function scheduleStats(Request $request)
    {

        $dataset = $request->dataset;
        $name = $request->name;
        $scheduleFlag = $request->data;
        $type = $request->type;

        $chargingTime = $this->timeSpent('CHARGER', $dataset, $name, $scheduleFlag);
        $tripTime = $this->timeSpent('TRIP',$dataset,$name,$scheduleFlag);
        $overallTime = $chargingTime + $tripTime;
        $energyRecharged = $this->energyRecharged($dataset,$name,$scheduleFlag);
        $energySpent = $this->energySpent($dataset,$name,$scheduleFlag);



        $stats=[];
        $stats[] = [
            'name'=> 'chargingTime',
            'stat'=> $chargingTime,
        ];
        $stats[] = [
            'name'=> 'tripTime',
            'stat'=> $tripTime,
        ];
        $stats[] = [
            'name'=> 'overallTime',
            'stat'=> $overallTime,
        ];
        $stats[] = [
            'name'=> 'energyRecharged',
            'stat'=> $energyRecharged,
        ];
        $stats[] = [
            'name'=> 'energySpent',
            'stat'=> $energySpent,
        ];
        //return response()->json(array('1'=>$stats,'2'=>$tripTime,'3'=>$overallTime,'4'=>$energyRecharged,'5'=>$energySpent));
        return view('ganttStats', [
            'scheduleFlag' => $scheduleFlag,
            'dataset' => $dataset,
            'name' => $name,
            'type' => $type,
            'stats' => $stats
        ]);
    }

    public function timeSpent(String $type,String $dataset,String $name,String $scheduleFlag)
    {
        $times = DB::table('schedules')
            ->select('start','end')
            ->where('schedule_no',$scheduleFlag)
            ->where('dataset_name',$dataset)
            ->where('type',$type)
            ->distinct()
            ->get();
        $finishTimes = [];
        foreach ($times as $time){
            $end = Carbon::parse($time->end);
            $start = Carbon::parse($time->start);
            $diff = $end->diffInMinutes($start);
            $finishTimes[] = [
                'time'=> $diff,
            ];
        }
        $overall = 0;
        foreach ($finishTimes as $time){
            $overall += $time['time'];
        }
        return $overall;
    }

    public function energyRecharged(String $dataset,String $name,String $scheduleFlag)
    {
        $energies = DB::table('schedules')
            ->select('energy_before','energy_after')
            ->where('schedule_no',$scheduleFlag)
            ->where('dataset_name',$dataset)
            ->where('type','CHARGER')
            ->distinct()
            ->get();
        $finishEnergies = [];
        foreach ($energies as $energy){
            $diff = $energy->energy_after - $energy->energy_before;
            $finishEnergies[] = [
                'energy'=> $diff,
            ];
        }
        $overall = 0;
        foreach ($finishEnergies as $energy){
            $overall += $energy['energy'];
        }
        return $overall;
    }
    public function energySpent(String $dataset,String $name,String $scheduleFlag)
    {
        $energies = DB::table('schedules')
            ->select('energy_before','energy_after')
            ->where('schedule_no',$scheduleFlag)
            ->where('dataset_name',$dataset)
            ->where('type','TRIP')
            ->distinct()
            ->get();
        $finishEnergies = [];
        foreach ($energies as $energy){
            $diff = $energy->energy_before - $energy->energy_after;
            $finishEnergies[] = [
                'energy'=> $diff,
            ];
        }
        $overall = 0;
        foreach ($finishEnergies as $energy){
            $overall += $energy['energy'];
        }
        return $overall;
    }
}
