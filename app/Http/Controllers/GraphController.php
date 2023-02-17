<?php

namespace App\Http\Controllers;

use App\Models\DiagramTime;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GraphController extends Controller
{
    public function index()
    {
        return view('chargerSelection');
    }

    public function schedulesGraph(Request $request){

        $schedul = $request->schedule;

        $type = $request->type;

        $data = [sizeof($schedul)];
        for ($j = 0;$j<=sizeof($schedul)-1;$j++){
            if ($type == "CHARGER"){
                $schedule = Schedule::select('*')->where('schedule_no', $schedul[$j])->where('type', $type)->get();
            }elseif ($type == "TRIP"){
                $schedule = Schedule::select('*')->where('schedule_no', $schedul[$j])->where('type', $type)->get();
            }else{
                $schedule = Schedule::select('*')->where('schedule_no', $schedul[$j])->get();
            }
            $dataa = [$schedule->count()];
            for ($i = 0; $i <= $schedule->count() - 1; $i++) {
                $dataa[] = [
                    'x'     => $schedule[$i]->start,
                    'y'     => $schedule[$i]->energy_after
                ];
            }
            $data[$j] = $dataa;
        }

        //return response()->json(['data' => $data]);
        return view('scheduleLineGraph',compact('data','schedul'));
    }

}
