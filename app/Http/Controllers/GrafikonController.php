<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class GrafikonController extends Controller
{

    public function getScheduleGrafikon()
    {
        $schedules = DB::table('schedules')
            ->select('schedule_no')
            ->where('dataset_name', 'DS10_1_res_GGA_.txt')
            ->distinct()
            ->get();
        $schedules->sortBy('schedules');

        $data = [$schedules->count()];
        $tasks = DB::table('tasks')->select('*')->where('dataset_name', 'spoje_id_DS10_1.csv')->get();

        for ($i = 0; $i <= $schedules->count() - 1; $i++) {

            $schedulesALL = DB::table('schedules')->select('*')
                ->where('schedule_no', $schedules[$i]->schedule_no)
                ->where('type', 'TRIP')
                ->where('dataset_name', 'DS10_1_res_GGA_.txt')
                ->get();

            $dataa = [];

            for ($j = 0; $j <= $schedulesALL->count() - 1; $j++) {
                if ($schedulesALL[$j]->schedule_index != 928) {
                    $linka = 0;

                    for ($m = 0; $m <= $tasks->count() - 1; $m++) {
                        if ($tasks[$m]->task_id == $schedulesALL[$j]->schedule_index) {
                            $linka = $tasks[$m]->linka;//premapovanie $loc_start
                            break;
                        }
                    }
                    $dataa[] = [
                        'x' => $schedulesALL[$j]->start,
                        'y' => $linka
                    ];
                    $dataa[] = [
                        'x' => $schedulesALL[$j]->end,
                        'y' => $linka
                    ];
                }

            }
            $data[$i] = $dataa;
        }


        //return response()->json(['data' => $data]);
        return view('grafikonSchedules', compact('data'));
    }

    public function getScheduleStationsGrafikon()
    {
        $schedules = DB::table('schedules')
            ->select('schedule_no')
            ->where('dataset_name', 'DS10_1_res_GGA_.txt')
            ->distinct()
            ->get();
        $schedules->sortBy('schedules');

        $data = [$schedules->count()];
        $tasks = DB::table('tasks')->select('*')->where('dataset_name', 'spoje_id_DS10_1.csv')->get();

        for ($i = 0; $i <= $schedules->count() - 1; $i++) {

            $schedulesALL = DB::table('schedules')->select('*')
                ->where('schedule_no', $schedules[$i]->schedule_no)
                ->where('type', 'TRIP')
                ->where('dataset_name', 'DS10_1_res_GGA_.txt')
                ->get();

            $dataa = [];

            for ($j = 0; $j <= $schedulesALL->count() - 1; $j++) {
                if ($schedulesALL[$j]->schedule_index != 928) {
                    $locStart = 0;
                    $locEnd = 0;

                    for ($m = 0; $m <= $tasks->count() - 1; $m++) {
                        if ($tasks[$m]->task_id == $schedulesALL[$j]->schedule_index) {
                            //$linka = $tasks[$m]->linka;//premapovanie $loc_start
                            $locStart = $tasks[$m]->loc_start;
                            $locEnd = $tasks[$m]->loc_end;
                            break;
                        }
                    }
                    $locationStart = DB::table('stations')
                        ->select('location')
                        ->where('station_id', $locStart)
                        ->first();
                    $locationEnd = DB::table('stations')
                        ->select('location')
                        ->where('station_id', $locEnd)
                        ->first();

                    $dataa[] = [
                        'x' => $schedulesALL[$j]->start,
                        'y' => $locationStart->location
                    ];
                    $dataa[] = [
                        'x' => $schedulesALL[$j]->end,
                        'y' => $locationEnd->location
                    ];
                }

            }
            $data[$i] = $dataa;
        }
        $stations = DB::table('stations')
            ->select('location')
            ->get();

        //return response()->json(['data' => $stations]);
        return view('grafikonSchedulesStations', compact('data', 'stations'));
    }
}
