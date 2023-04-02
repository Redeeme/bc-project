<?php

namespace App\Http\Controllers;

use App\Models\Stat;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatController extends Controller
{
    public function indexSelection()
    {
        $stats = Stat::select('*')->get();
        return view('statsSelection', compact('stats'));
    }

    public function indexDatasetSelection($type, $table)
    {

        if ($table == 'schedules-stat-batery') {
            return redirect()->route('select-schedules-graph-datasets');
        }
        if ($type == 'schedules') {
            $dataset = DB::table('helpers')
                ->select('dataset_name')
                ->where('dataset_table', $type)
                ->distinct()
                ->get();

        }
        if ($type == 'charger_tasks') {
            $dataset = DB::table('helpers')
                ->select('dataset_name')
                ->where('dataset_table', $type)
                ->distinct()
                ->get();

        }
//        return response()->json([
//            'type' => $type,
//            'table' => $table,
//            'dataset' => $dataset,
//        ]);
        return view('statsDatasetSelection', [
            'dataset' => $dataset,
            'table' => $table,
            'type' => $type,
        ]);
    }

    public function getStat($type, $table, Request $request)
    {

        return match ($type) {
            'chargers-stat-utilization' => redirect()->route('chargers-stat-utilization', ['type' => $type, 'dataset' => $request->data, 'table' => $table]),
            'schedules-stat-clip' => redirect()->route('schedules-stat-clip', ['type' => $type, 'dataset' => $request->data, 'table' => $table]),
            'schedules-stat-charging' => redirect()->route('schedules-stat-charging', ['type' => $type, 'dataset' => $request->data, 'table' => $table]),
            'schedules-stat-utilization' => redirect()->route('schedules-stat-utilization', ['type' => $type, 'dataset' => $request->data, 'table' => $table]),
            'schedules-stat-trips' => redirect()->route('schedules-stat-trips', ['type' => $type, 'dataset' => $request->data, 'table' => $table]),
            'chargers-stat-interval-length-Selection' => redirect()->route('chargers-stat-interval-length-Selection', ['type' => $type, 'dataset' => $request->data, 'table' => $table]),
            'chargers-stat-interval-count-Selection' => redirect()->route('chargers-stat-interval-count-Selection', ['type' => $type, 'dataset' => $request->data, 'table' => $table]),
            default => redirect()->route('welcome-page'),
        };
    }

    public function chargersStatUtil($table, $type, $dataset)
    {
        $chargersIndexes = DB::table($table)
            ->select('charger_id as x')
            ->where('dataset_name', $dataset)
            ->distinct()
            ->get();
        $data = [];
        foreach ($chargersIndexes as $index){
            $chargerTasks = DB::table($table)
                ->select('*')
                ->where('dataset_name', $dataset)
                ->where('charger_id', $index->x)
                ->distinct()
                ->get();
            $duration = 0;

            foreach ($chargerTasks as $task){
                $parts = explode(':', $task->duration);
                $totalMinutes = ($parts[0] * 60) + $parts[1];
                $duration += $totalMinutes;
            }
            $util = $duration/1440;
            $percentage = round($util * 100, 2);
            $data[] = [
                'y' => $percentage,
            ];
        }
        $x = $chargersIndexes;
        $y = $data;
        return view('statsHistogram',compact('y','x','type'));
    }

    public function schedulesStatClip($table, $type, $dataset)
    {
        $schedulesIndexes = DB::table($table)
            ->select('schedule_no as x')
            ->where('dataset_name', $dataset)
            ->distinct()
            ->get();
        $data = [];
        foreach ($schedulesIndexes as $index){
            $schedulesTasks = DB::table($table)
                ->select('*')
                ->where('dataset_name', $dataset)
                ->where('schedule_no', $index->x)
                ->whereNotNull('charger_index')
                ->distinct()
                ->get();
            $rowCount = $schedulesTasks->count();
            $data[] = [
                'y' => $rowCount,
            ];
        }
        $x = $schedulesIndexes;
        $y = $data;
        return view('statsHistogram',compact('y','x','type'));
    }

    public function schedulesStatCharging($table, $type, $dataset)
    {
        $schedulesIndexes = DB::table($table)
            ->select('schedule_no as x')
            ->where('dataset_name', $dataset)
            ->distinct()
            ->get();
        $data = [];
        foreach ($schedulesIndexes as $index){
            $schedulesTasks = DB::table($table)
                ->select('*')
                ->where('dataset_name', $dataset)
                ->where('schedule_no', $index->x)
                ->whereNotNull('charger_index')
                ->get();
            $duration = 0;

            foreach ($schedulesTasks as $task){
                $start = DateTime::createFromFormat('H:i:s', $task->start);
                $end = DateTime::createFromFormat('H:i:s', $task->end);
                if ($end < $start) {
                    $end->modify('+1 day');
                }
                $interval = $start->diff($end);
                $minutes = $interval->h * 60 + $interval->i;
                $duration += $minutes;
            }
            $data[] = [
                'y' => $duration,
            ];
        }
        $x = $schedulesIndexes;
        $y = $data;
        return view('statsHistogram',compact('y','x','type'));
    }

    public function schedulesStatUtil($table, $type, $dataset)
    {
        $schedulesIndexes = DB::table($table)
            ->select('schedule_no as x')
            ->where('dataset_name', $dataset)
            ->distinct()
            ->get();
        $data1 = [];
        $data2 = [];
        foreach ($schedulesIndexes as $index){
            $schedulesTasks = DB::table($table)
                ->select('*')
                ->where('dataset_name', $dataset)
                ->where('schedule_no', $index->x)
                ->distinct()
                ->get();
            $durationCharging = 0;
            $durationTrip = 0;

            foreach ($schedulesTasks as $task){
                if ($task->charger_index != null){
                    $start = DateTime::createFromFormat('H:i:s', $task->start);
                    $end = DateTime::createFromFormat('H:i:s', $task->end);
                    if ($end < $start) {
                        $end->modify('+1 day');
                    }
                    $interval = $start->diff($end);
                    $minutes = $interval->h * 60 + $interval->i;
                    $durationCharging += $minutes;
                }else{
                    $start = DateTime::createFromFormat('H:i:s', $task->start);
                    $end = DateTime::createFromFormat('H:i:s', $task->end);
                    if ($end < $start) {
                        $end->modify('+1 day');
                    }
                    $interval = $start->diff($end);
                    $minutes = $interval->h * 60 + $interval->i;
                    $durationTrip += $minutes;
                }
            }
            $data1[] = [
                'y' => $durationTrip,
            ];
            $data2[] = [
                'y' => $durationCharging,
            ];
        }
        $x = $schedulesIndexes;
        $y = $data1;
        $yy = $data2;
        return view('statsDoubleHistogram',compact('y','x','yy','type'));
    }

    public function schedulesStatTrips($table, $type, $dataset)
    {
        $schedulesIndexes = DB::table($table)
            ->select('schedule_no as x')
            ->where('dataset_name', $dataset)
            ->distinct()
            ->get();
        $data = [];
        foreach ($schedulesIndexes as $index){
            $schedulesTasks = DB::table($table)
                ->select('*')
                ->where('dataset_name', $dataset)
                ->where('schedule_no', $index->x)
                ->whereNull('charger_index')
                ->distinct()
                ->get();
            $rowCount = $schedulesTasks->count();
            $data[] = [
                'y' => $rowCount,
            ];
        }
        $x = $schedulesIndexes;
        $y = $data;
        return view('statsHistogram',compact('y','x','type'));
    }
    public function chargersStatIntLengthSelection($table, $type, $dataset)
    {
        $type = 'chargers-stat-interval-length';
        return view('statsIntervalSelection',compact('table','type','dataset'));
    }
    public function chargersStatIntCountSelection($table, $type, $dataset)
    {
        $type = 'chargers-stat-interval-count';
        return view('statsIntervalSelection',compact('table','type','dataset'));
    }
    public function chargersStatIntLength($table, $type, $dataset,Request $request)
    {
                return response()->json([
            'type' => $type,
            'table' => $table,
            'dataset' => $dataset,
        ]);
    }
    public function chargersStatIntCount($table, $type, $dataset,Request $request)
    {
        $chargersIndexes = DB::table($table)
            ->select('charger_id as x')
            ->where('dataset_name', $dataset)
            ->distinct()
            ->get();

        return view('statsHistogram',compact('y','x','type'));




        $data1 = $request->interval1;
        $data2 = $request->interval2;
        return response()->json([
            'type' => $type,
            'table' => $table,
            'dataset' => $dataset,
            'data1' => $data1,
            'data2' => $data2,
        ]);
    }


}
