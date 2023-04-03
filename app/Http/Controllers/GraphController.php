<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class GraphController extends Controller
{

    public function schedulesGraph(Request $request)
    {

        $schedul = $request->schedule;
        $dataset = $request->dataset;
        $type = $request->type;

        $data = [sizeof($schedul)];
        for ($j = 0; $j <= sizeof($schedul) - 1; $j++) {
            if ($type == "CHARGER") {
                $schedule = Schedule::select('*')->where('schedule_no', $schedul[$j])->where('type', $type)->where('dataset_name', $dataset)->get();
            } elseif ($type == "TRIP") {
                $schedule = Schedule::select('*')->where('schedule_no', $schedul[$j])->where('type', $type)->where('dataset_name', $dataset)->get();
            } else {
                $schedule = Schedule::select('*')->where('schedule_no', $schedul[$j])->where('dataset_name', $dataset)->get();
            }
            $dataa = [$schedule->count()];
            for ($i = 0; $i <= $schedule->count() - 1; $i++) {
                $dataa[] = [
                    'x' => $schedule[$i]->start,
                    'y' => $schedule[$i]->energy_after
                ];
            }
            $data[$j] = $dataa;
        }

        //return response()->json(['data' => $data]);
        return view('scheduleLineGraph', compact('data', 'schedul'));
    }

}
