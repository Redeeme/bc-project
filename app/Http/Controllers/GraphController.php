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
        if ($type == "CHARGER"){
            $schedules = Schedule::select('schedule_index AS label', 'schedule_index AS id')->where('schedule_no', $schedul)->where('type', $type)->get();
        }elseif ($type == "TRIP"){
            $schedules = Schedule::select('schedule_index AS label', 'schedule_index AS id')->where('schedule_no', $schedul)->where('type', $type)->get();
        }else{
            $schedules = Schedule::select('schedule_index AS label', 'schedule_index AS id')->where('schedule_no', $schedul)->get();
        }

        $data = [$schedules->count()];

        for ($i = 0; $i <= $schedules->count() - 1; $i++) {
            $dataa[] = [
                'x'     => $schedules[$i]->start,
                'y'     => $schedules[$i]->energy_after
            ];
        }
        return view('grafikonSchedules',compact('data'));
    }

}
