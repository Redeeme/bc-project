<?php

namespace App\Http\Controllers;

use App\Models\DiagramTime;
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
        for ($i = 0; $i <= $tours->count() - 1; $i++) {
            $length = Task::select('loc_start')->where('linka', $tours[$i]->linka)->count();
            $tasks = DB::table('tasks')->select('*')->where('linka', $tours[$i]->linka)->get();
            $dataa =[];
            for ($j = 0; $j <= $tasks->count() - 1; $j++) {
                if ($tasks[$j]->linka == $tours[$i]->linka){
                    $dataa[] = [
                        'x'      => $tasks[$j]->start,
                        'y'     => $tasks[$j]->loc_start

                    ];
                }
            }
            $data[$i] = $dataa;
        }

        $processes4 = Task::select('loc_end')->where('linka', 4)->get();
        $processes14 = Task::select('loc_end')->where('linka', 14)->get();
        $proces = Task::select('loc_start')->where('linka', 14)->pluck('loc_start');
        $proces14 = Task::select('loc_start')->where('linka', 14)->pluck('loc_start');
        $proces4 = Task::select('loc_start')->where('linka', 4)->pluck('loc_start');
        $time1 = Task::select('start')->where('linka', 14)->pluck('start');
        $categories = DiagramTime::select('start','end','label')->where('id','!=','1')->get();
        $stations = Station::select('station_id')->pluck('station_id');
        $stations = $stations->shuffle();

        //return response()->json(['data' => $data, 'time1' => $time1,'stations'=>$stations,'proces4'=>$proces4]);
        //return response()->json(['categories' => $categories, 'stations' => $stations,'processes4'=>$processes4,'processes14'=>$processes14,'processes1'=>$processes1]);
        //return view('grafikon',['categories' => $categories, 'stations' => $stations,'processes4'=>$processes4,'processes14'=>$processes14,'processes1'=>$processes1]);
        //return view('grafikon',['proces14' => $proces14, 'time1' => $time1,'stations'=>$stations,'proces4'=>$proces4]);
        return view('grafikon',compact('proces14','time1','stations','proces4','data'));
    }

}
