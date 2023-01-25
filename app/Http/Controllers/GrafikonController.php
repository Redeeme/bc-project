<?php

namespace App\Http\Controllers;

use App\Models\DiagramTime;
use App\Models\Schedule;
use App\Models\Station;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GrafikonController extends Controller
{
    //

    public function getTaskGrafikon(){
        $tours = DB::table('tasks')
            ->select('linka')
            ->distinct()
            ->get();
        $tours->sortBy('linka');
        $tasks = DB::table('tasks')->select('*')->get();

        $data = [$tours->count()];
        $stations = Station::select('station_id')->pluck('station_id');
        for ($i = 0; $i <= $tours->count() - 1; $i++) {
            $length = Task::select('loc_start')->where('linka', $tours[$i]->linka)->count();
            $tasks = DB::table('tasks')->select('*')->where('linka', $tours[$i]->linka)->get();
            $dataa =[];
            for ($j = 0; $j <= $tasks->count() - 1; $j++) {
                if ($tasks[$j]->linka == $tours[$i]->linka){
                    $loc_start = 0;
                    for ($m = 0; $m <= $stations->count() - 1; $m++) {
                        if ($stations[$m] == $tasks[$j]->loc_start){
                            $loc_start = $m;//premapovanie $loc_start
                        }
                    }
                    $dataa[] = [
                        'x'     => $tasks[$j]->start,
                        'y'     => $loc_start

                    ];
                }
            }
            $data[$i] = $dataa;
        }

        //return response()->json(['data' => $data, 'time1' => $time1,'stations'=>$stations,'proces4'=>$proces4]);
        //return response()->json(['categories' => $categories, 'stations' => $stations,'processes4'=>$processes4,'processes14'=>$processes14,'processes1'=>$processes1]);
        //return view('grafikon',['categories' => $categories, 'stations' => $stations,'processes4'=>$processes4,'processes14'=>$processes14,'processes1'=>$processes1]);
        //return view('grafikon',['proces14' => $proces14, 'time1' => $time1,'stations'=>$stations,'proces4'=>$proces4]);
        return view('grafikon',compact('data'));
    }

    public function getScheduleGrafikon(){
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
        //return response()->json(['categories' => $categories, 'stations' => $stations,'processes4'=>$processes4,'processes14'=>$processes14,'processes1'=>$processes1]);
        //return view('grafikon',['categories' => $categories, 'stations' => $stations,'processes4'=>$processes4,'processes14'=>$processes14,'processes1'=>$processes1]);
        //return view('grafikon',['proces14' => $proces14, 'time1' => $time1,'stations'=>$stations,'proces4'=>$proces4]);
        return view('grafikonSchedules',compact('data'));
    }
}
