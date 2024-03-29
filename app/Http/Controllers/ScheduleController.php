<?php

namespace App\Http\Controllers;

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
        if (!isset($dataset)) {
            return redirect()->back()->withErrors(['error' => 'Please enter right values :)']);
        }
        $schedule = DB::table('schedules')
            ->select('schedule_no AS id')
            ->where('dataset_name', $dataset)
            ->distinct()
            ->get();
        $schedule->sortBy('id');
        $categories = DB::table('schedules')
            ->select('type')
            ->distinct()
            ->get();
        return view('ganttSelection', ['schedule' => $schedule, 'categories' => $categories, 'dataset' => $dataset]);
    }

    public function schedulesSelectGraph($dataset)
    {
        if (!isset($dataset)) {
            return redirect()->back()->withErrors(['error' => 'Please enter right values :)']);
        }
        $schedules = DB::table('schedules')
            ->select('schedule_no')
            ->where('dataset_name', $dataset)
            ->distinct()
            ->get();
        $schedules->sortBy('schedule_no');
        $categories = DB::table('schedules')
            ->select('type')
            ->where('dataset_name', $dataset)
            ->distinct()
            ->get();
        return view('scheduleSelectionGraph', ['schedules' => $schedules, 'categories' => $categories, 'dataset' => $dataset]);
    }

    public function getScheduleTable()
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
        return view('ganttSelection', ['schedule' => $schedule, 'categories' => $categories]);
    }

    public function getScheduleGantt()
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
        return view('ganttSelection', ['schedule' => $schedule, 'categories' => $categories]);
    }

    public function getScheduleStats()
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
        return view('ganttSelection', ['schedule' => $schedule, 'categories' => $categories]);
    }

    public function scheduleStats(Request $request)
    {
        $validatedData = $request->validate([
            'dataset' => 'required',
            'name' => 'required',
            'type' => 'required',
            'data' => 'required'
        ]);

        $dataset = $validatedData['dataset'];
        $name = $validatedData['name'];
        $scheduleFlag = $validatedData['data'];
        $type = $validatedData['type'];

        $chargingTime = $this->timeSpent('CHARGER', $dataset, $name, $scheduleFlag);
        $tripTime = $this->timeSpent('TRIP', $dataset, $name, $scheduleFlag);
        $overallTime = $chargingTime + $tripTime;
        $energyRecharged = $this->energyRecharged($dataset, $name, $scheduleFlag);
        $energySpent = $this->energySpent($dataset, $name, $scheduleFlag);


        $stats = [];
        $stats[] = [
            'name' => 'Doba nabíjania',
            'stat' => $chargingTime." minút",
        ];
        $stats[] = [
            'name' => 'Čas na spojoch',
            'stat' => $tripTime." minút",
        ];
        $stats[] = [
            'name' => 'Celkový čas',
            'stat' => $overallTime." minút",
        ];
        $stats[] = [
            'name' => 'Nabité množstvo energie',
            'stat' => $energyRecharged." Kilowatthodin",
        ];
        $stats[] = [
            'name' => 'Spotrebované množstvo energie',
            'stat' => $energySpent." Kilowatthodin",
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

    public function timeSpent(string $type, string $dataset, string $name, string $scheduleFlag)
    {
        if (!isset($scheduleFlag) || !isset($name) || !isset($dataset)|| !isset($type)) {
            return redirect()->back()->withErrors(['error' => 'Please enter right values :)']);
        }
        $times = DB::table('schedules')
            ->select('start', 'end')
            ->where('schedule_no', $scheduleFlag)
            ->where('dataset_name', $dataset)
            ->where('type', $type)
            ->distinct()
            ->get();
        $finishTimes = [];
        foreach ($times as $time) {
            $end = Carbon::parse($time->end);
            $start = Carbon::parse($time->start);
            $diff = $end->diffInMinutes($start);
            $finishTimes[] = [
                'time' => $diff,
            ];
        }
        $overall = 0;
        foreach ($finishTimes as $time) {
            $overall += $time['time'];
        }
        return $overall;
    }

    public function energyRecharged(string $dataset, string $name, string $scheduleFlag)
    {
        if (!isset($scheduleFlag) || !isset($name) || !isset($dataset)) {
            return redirect()->back()->withErrors(['error' => 'Please enter right values :)']);
        }
        $energies = DB::table('schedules')
            ->select('energy_before', 'energy_after')
            ->where('schedule_no', $scheduleFlag)
            ->where('dataset_name', $dataset)
            ->where('type', 'CHARGER')
            ->distinct()
            ->get();
        $finishEnergies = [];
        foreach ($energies as $energy) {
            $diff = $energy->energy_after - $energy->energy_before;
            $finishEnergies[] = [
                'energy' => $diff,
            ];
        }
        $overall = 0;
        foreach ($finishEnergies as $energy) {
            $overall += $energy['energy'];
        }
        return $overall;
    }

    public function energySpent(string $dataset, string $name, string $scheduleFlag)
    {
        if (!isset($scheduleFlag) || !isset($name) || !isset($dataset)) {
            return redirect()->back()->withErrors(['error' => 'Please enter right values :)']);
        }
        $energies = DB::table('schedules')
            ->select('energy_before', 'energy_after')
            ->where('schedule_no', $scheduleFlag)
            ->where('dataset_name', $dataset)
            ->where('type', 'TRIP')
            ->distinct()
            ->get();
        $finishEnergies = [];
        foreach ($energies as $energy) {
            $diff = $energy->energy_before - $energy->energy_after;
            $finishEnergies[] = [
                'energy' => $diff,
            ];
        }
        $overall = 0;
        foreach ($finishEnergies as $energy) {
            $overall += $energy['energy'];
        }
        return $overall;
    }
}
