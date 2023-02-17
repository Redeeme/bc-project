<?php

namespace App\Http\Controllers;

use App\Models\DiagramTime;
use App\Models\Schedule;
use App\Models\Station;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class GrafikonController extends Controller
{

    public function getScheduleeGrafikon(){
        $schedules = DB::table('schedules')
            ->select('schedule_no')
            ->distinct()
            ->get();
        $schedules->sortBy('schedules');


        $data = [$schedules->count()];

        $stations = Station::select('station_id')->pluck('station_id');

        for ($i = 0; $i <= $schedules->count() - 1; $i++) {
            $length = Schedule::select('location_start')->where('schedule_no', $schedules[$i]->schedule_no)->count();
            $schedulesALL = DB::table('schedules')->select('*')->where('schedule_no', $schedules[$i]->schedule_no)->get();
            $dataa =[];
            for ($j = 0; $j <= $schedulesALL->count() - 1; $j++) {
                if ($schedulesALL[$j]->schedule_no == $schedules[$i]->schedule_no){
                    $loc_start = 0;
                    for ($m = 0; $m <= $stations->count() - 1; $m++) {
                        if ($stations[$m] == $schedulesALL[$j]->location_start){
                            $loc_start = $m;//premapovanie $loc_start
                        }
                    }
                    $dataa[] = [
                        'x'     => $schedulesALL[$j]->start,
                        'y'     => $loc_start

                    ];
                }
            }
            $data[$i] = $dataa;
        }

        //return response()->json(['data' => $data]);
        return view('grafikonSchedules',compact('data'));
    }
    public function getScheduleGrafikon(){
        $schedules = DB::table('schedules')
            ->select('schedule_no')
            ->distinct()
            ->get();
        $schedules->sortBy('schedules');


        $data = [$schedules->count()];
        $tasks = DB::table('tasks')->select('*')->get();

        for ($i = 0; $i <= $schedules->count() - 1; $i++) {

            $schedulesALL = DB::table('schedules')->select('*')
                ->where('schedule_no', $schedules[$i]->schedule_no)
                ->where('type', 'TRIP')
                ->get();

            $dataa =[];

            for ($j = 0; $j <= $schedulesALL->count() - 1; $j++) {

                    $linka = 0;

                    for ($m = 0; $m <= $tasks->count() - 1; $m++) {
                        if ($tasks[$m]->task_id == $schedulesALL[$j]->schedule_index){
                            $linka = $tasks[$m]->linka;//premapovanie $loc_start
                            break;
                        }
                    }
                    $dataa[] = [
                        'x'     => $schedulesALL[$j]->start,
                        'y'     => $linka
                    ];
                }
            $data[$i] = $dataa;
            }



        //return response()->json(['data' => $data]);
        return view('grafikonSchedules',compact('data'));
    }
}
