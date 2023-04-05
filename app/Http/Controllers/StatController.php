<?php

namespace App\Http\Controllers;

use App\Models\Stat;
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
        if (!isset($table) || !isset($type)) {
            return redirect()->back()->withErrors(['error' => 'Please enter right values :)']);
        }
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
        return view('statsDatasetSelection', [
            'dataset' => $dataset,
            'table' => $table,
            'type' => $type,
        ]);
    }

    public function getStat($type, $table, Request $request)
    {
        if (!isset($table) || !isset($type)) {
            return redirect()->back()->withErrors(['error' => 'Please enter right values :)']);
        }
        $validatedData = $request->validate([
            'data' => 'required',
        ]);
        $dataset = $validatedData['data'];
        return match ($type) {
            'chargers-stat-utilization' => redirect()->route('chargers-stat-utilization', ['type' => $type, 'dataset' => $dataset, 'table' => $table]),
            'schedules-stat-clip' => redirect()->route('schedules-stat-clip', ['type' => $type, 'dataset' => $dataset, 'table' => $table]),
            'schedules-stat-charging' => redirect()->route('schedules-stat-charging', ['type' => $type, 'dataset' => $dataset, 'table' => $table]),
            'schedules-stat-utilization' => redirect()->route('schedules-stat-utilization', ['type' => $type, 'dataset' => $dataset, 'table' => $table]),
            'schedules-stat-trips' => redirect()->route('schedules-stat-trips', ['type' => $type, 'dataset' => $dataset, 'table' => $table]),
            'chargers-stat-interval-length-Selection' => redirect()->route('chargers-stat-interval-length-Selection', ['type' => $type, 'dataset' => $dataset, 'table' => $table]),
            'chargers-stat-interval-count-Selection' => redirect()->route('chargers-stat-interval-count-Selection', ['type' => $type, 'dataset' => $dataset, 'table' => $table]),
            default => redirect()->route('welcome-page'),
        };
    }

    public function chargersStatUtil($table, $type, $dataset)
    {
        if (!isset($table) || !isset($type) || !isset($dataset)) {
            return redirect()->back()->withErrors(['error' => 'Please enter right values :)']);
        }
        $chargersIndexes = DB::table($table)
            ->select('charger_id as x')
            ->where('dataset_name', $dataset)
            ->distinct()
            ->get();
        $data = [];
        foreach ($chargersIndexes as $index) {
            $chargerTasks = DB::table($table)
                ->select('*')
                ->where('dataset_name', $dataset)
                ->where('charger_id', $index->x)
                ->distinct()
                ->get();
            $duration = 0;

            foreach ($chargerTasks as $task) {
                $parts = explode(':', $task->duration);
                $totalMinutes = ($parts[0] * 60) + $parts[1];
                $duration += $totalMinutes;
            }
            $util = $duration / 1440;
            $percentage = round($util * 100, 2);
            $data[] = [
                'y' => $percentage,
            ];
        }
        $x = $chargersIndexes;
        $y = $data;
        $label = DB::table('stats')
            ->select('x_label')
            ->where('type', $type)
            ->get();
        $x_label = $label[0]->x_label;
        $label = DB::table('stats')
            ->select('y_label')
            ->where('type', $type)
            ->get();
        $y_label = $label[0]->y_label;
        $label = DB::table('stats')
            ->select('name')
            ->where('type', $type)
            ->get();
        $name = $label[0]->name;
        return view('statsHistogram', compact('y', 'x', 'type','x_label','y_label','name'));
    }

    public function schedulesStatClip($table, $type, $dataset)
    {
        if (!isset($table) || !isset($type) || !isset($dataset)) {
            return redirect()->back()->withErrors(['error' => 'Please enter right values :)']);
        }
        $schedulesIndexes = DB::table($table)
            ->select('schedule_no as x')
            ->where('dataset_name', $dataset)
            ->distinct()
            ->get();
        $data = [];
        foreach ($schedulesIndexes as $index) {
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
        $label = DB::table('stats')
            ->select('x_label')
            ->where('type', $type)
            ->get();
        $x_label = $label[0]->x_label;
        $label = DB::table('stats')
            ->select('y_label')
            ->where('type', $type)
            ->get();
        $y_label = $label[0]->y_label;
        $label = DB::table('stats')
            ->select('name')
            ->where('type', $type)
            ->get();
        $name = $label[0]->name;
        return view('statsHistogram', compact('y', 'x', 'type','x_label','y_label','name'));
    }

    public function schedulesStatCharging($table, $type, $dataset)
    {
        if (!isset($table) || !isset($type) || !isset($dataset)) {
            return redirect()->back()->withErrors(['error' => 'Please enter right values :)']);
        }
        $schedulesIndexes = DB::table($table)
            ->select('schedule_no as x')
            ->where('dataset_name', $dataset)
            ->distinct()
            ->get();
        $data = [];
        foreach ($schedulesIndexes as $index) {
            $schedulesTasks = DB::table($table)
                ->select('*')
                ->where('dataset_name', $dataset)
                ->where('schedule_no', $index->x)
                ->whereNotNull('charger_index')
                ->get();
            $duration = 0;

            foreach ($schedulesTasks as $task) {
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
        $label = DB::table('stats')
            ->select('x_label')
            ->where('type', $type)
            ->get();
        $x_label = $label[0]->x_label;
        $label = DB::table('stats')
            ->select('y_label')
            ->where('type', $type)
            ->get();
        $y_label = $label[0]->y_label;
        $label = DB::table('stats')
            ->select('name')
            ->where('type', $type)
            ->get();
        $name = $label[0]->name;
        return view('statsHistogram', compact('y', 'x', 'type','x_label','y_label','name'));
    }

    public function schedulesStatUtil($table, $type, $dataset)
    {
        if (!isset($table) || !isset($type) || !isset($dataset)) {
            return redirect()->back()->withErrors(['error' => 'Please enter right values :)']);
        }
        $schedulesIndexes = DB::table($table)
            ->select('schedule_no as x')
            ->where('dataset_name', $dataset)
            ->distinct()
            ->get();
        $data1 = [];
        $data2 = [];
        foreach ($schedulesIndexes as $index) {
            $schedulesTasks = DB::table($table)
                ->select('*')
                ->where('dataset_name', $dataset)
                ->where('schedule_no', $index->x)
                ->distinct()
                ->get();
            $durationCharging = 0;
            $durationTrip = 0;

            foreach ($schedulesTasks as $task) {
                if ($task->charger_index != null) {
                    $start = DateTime::createFromFormat('H:i:s', $task->start);
                    $end = DateTime::createFromFormat('H:i:s', $task->end);
                    if ($end < $start) {
                        $end->modify('+1 day');
                    }
                    $interval = $start->diff($end);
                    $minutes = $interval->h * 60 + $interval->i;
                    $durationCharging += $minutes;
                } else {
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

        $label = DB::table('stats')
            ->select('x_label')
            ->where('type', $type)
            ->get();
        $x_label = $label[0]->x_label;
        $label = DB::table('stats')
            ->select('y_label')
            ->where('type', $type)
            ->get();
        $y_label = $label[0]->y_label;
        $label = DB::table('stats')
            ->select('name')
            ->where('type', $type)
            ->get();
        $name = $label[0]->name;
        return view('statsDoubleHistogram', compact('y', 'x','yy', 'type','x_label','y_label','name'));
    }

    public function schedulesStatTrips($table, $type, $dataset)
    {
        if (!isset($table) || !isset($type) || !isset($dataset)) {
            return redirect()->back()->withErrors(['error' => 'Please enter right values :)']);
        }
        $schedulesIndexes = DB::table($table)
            ->select('schedule_no as x')
            ->where('dataset_name', $dataset)
            ->distinct()
            ->get();
        $data = [];
        foreach ($schedulesIndexes as $index) {
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
        $label = DB::table('stats')
            ->select('x_label')
            ->where('type', $type)
            ->get();
        $x_label = $label[0]->x_label;
        $label = DB::table('stats')
            ->select('y_label')
            ->where('type', $type)
            ->get();
        $y_label = $label[0]->y_label;
        $label = DB::table('stats')
            ->select('name')
            ->where('type', $type)
            ->get();
        $name = $label[0]->name;
        return view('statsHistogram', compact('y', 'x', 'type','x_label','y_label','name'));
    }

    public function chargersStatIntLengthSelection($table, $type, $dataset)
    {
        if (!isset($table) || !isset($type) || !isset($dataset)) {
            return redirect()->back()->withErrors(['error' => 'Please enter right values :)']);
        }
        $type = 'chargers-stat-interval-length';
        return view('statsIntervalSelection', compact('table', 'type', 'dataset'));
    }

    public function chargersStatIntCountSelection($table, $type, $dataset)
    {
        if (!isset($table) || !isset($type) || !isset($dataset)) {
            return redirect()->back()->withErrors(['error' => 'Please enter a name.']);
        }
        $type = 'chargers-stat-interval-count';
        return view('statsIntervalSelection', compact('table', 'type', 'dataset'));
    }

    public function chargersStatIntLength($table, $type, $dataset, Request $request)
    {
        if (!isset($table) || !isset($type) || !isset($dataset)) {
            return redirect()->back()->withErrors(['error' => 'Please enter a name.']);
        }

        $validatedData = $request->validate([
            'interval1' => 'required',
            'interval2' => 'required',
            'interval3' => 'required',
            'interval4' => 'required',
            'interval5' => 'required',
            'interval6' => 'required',
            'interval7' => 'required',
            'interval8' => 'required',
        ]);
        $chargersIndexes = DB::table($table)
            ->select('charger_id as x')
            ->where('dataset_name', $dataset)
            ->distinct()
            ->get();

        $data1 = $validatedData['interval1'];
        $data2 = $validatedData['interval5'];
        $start_time1 = strtotime($data1);
        $end_time1 = strtotime($data2);
        $start_minutes1 = date('i', $start_time1) + date('G', $start_time1) * 60;
        $end_minutes1 = date('i', $end_time1) + date('G', $end_time1) * 60;

        $data3 =$validatedData['interval2'];
        $data4 = $validatedData['interval6'];
        $start_time2 = strtotime($data3);
        $end_time2 = strtotime($data4);
        $start_minutes2 = date('i', $start_time2) + date('G', $start_time2) * 60;
        $end_minutes2 = date('i', $end_time2) + date('G', $end_time2) * 60;

        $data5 = $validatedData['interval3'];
        $data6 = $validatedData['interval7'];
        $start_time3 = strtotime($data5);
        $end_time3 = strtotime($data6);
        $start_minutes3 = date('i', $start_time3) + date('G', $start_time3) * 60;
        $end_minutes3 = date('i', $end_time3) + date('G', $end_time3) * 60;

        $data7 = $validatedData['interval4'];
        $data8 = $validatedData['interval8'];
        $start_time4 = strtotime($data7);
        $end_time4 = strtotime($data8);
        $start_minutes4 = date('i', $start_time4) + date('G', $start_time4) * 60;
        $end_minutes4 = date('i', $end_time4) + date('G', $end_time4) * 60;

        $durations1 = DB::table($table)
            ->select('charger_id', 'duration')
            ->where('dataset_name', $dataset)
            ->whereRaw("SUBSTRING(`start`, 1, 2) * 60 + SUBSTRING(`start`, 4, 2) > ?", [$start_minutes1])
            ->whereRaw("SUBSTRING(`end`, 1, 2) * 60 + SUBSTRING(`end`, 4, 2) < ?", [$end_minutes1])
            ->get();
        $durations2 = DB::table($table)
            ->select('charger_id', 'duration')
            ->where('dataset_name', $dataset)
            ->whereRaw("SUBSTRING(`start`, 1, 2) * 60 + SUBSTRING(`start`, 4, 2) > ?", [$start_minutes2])
            ->whereRaw("SUBSTRING(`end`, 1, 2) * 60 + SUBSTRING(`end`, 4, 2) < ?", [$end_minutes2])
            ->get();
        $durations3 = DB::table($table)
            ->select('charger_id', 'duration')
            ->where('dataset_name', $dataset)
            ->whereRaw("SUBSTRING(`start`, 1, 2) * 60 + SUBSTRING(`start`, 4, 2) > ?", [$start_minutes3])
            ->whereRaw("SUBSTRING(`end`, 1, 2) * 60 + SUBSTRING(`end`, 4, 2) < ?", [$end_minutes3])
            ->get();
        $durations4 = DB::table($table)
            ->select('charger_id', 'duration')
            ->where('dataset_name', $dataset)
            ->whereRaw("SUBSTRING(`start`, 1, 2) * 60 + SUBSTRING(`start`, 4, 2) > ?", [$start_minutes4])
            ->whereRaw("SUBSTRING(`end`, 1, 2) * 60 + SUBSTRING(`end`, 4, 2) < ?", [$end_minutes4])
            ->get();


        $data11 = [];
        $data22 = [];
        $data33 = [];
        $data44 = [];

        for ($i = 0; $i < 4; $i++) {
            foreach ($chargersIndexes as $chargerIndex) {
                if ($i == 0) {
                    $charger_index_durations = $durations1->where('charger_id', $chargerIndex->x);
                    $totalDuration = 0;
                    foreach ($charger_index_durations as $task) {
                        $parts = explode(':', $task->duration);
                        $totalMinutes = ($parts[0] * 60) + $parts[1];
                        $totalDuration += $totalMinutes;
                    }
                    $data11[] = [
                        'y' => $totalDuration,
                    ];
                } elseif ($i == 1) {
                    $charger_index_durations = $durations2->where('charger_id', $chargerIndex->x);
                    $totalDuration = 0;
                    foreach ($charger_index_durations as $task) {
                        $parts = explode(':', $task->duration);
                        $totalMinutes = ($parts[0] * 60) + $parts[1];
                        $totalDuration += $totalMinutes;
                    }
                    $data22[] = [
                        'y' => $totalDuration,
                    ];
                } elseif ($i == 2) {
                    $charger_index_durations = $durations3->where('charger_id', $chargerIndex->x);
                    $totalDuration = 0;
                    foreach ($charger_index_durations as $task) {
                        $parts = explode(':', $task->duration);
                        $totalMinutes = ($parts[0] * 60) + $parts[1];
                        $totalDuration += $totalMinutes;
                    }
                    $data33[] = [
                        'y' => $totalDuration,
                    ];
                } elseif ($i == 3) {
                    $charger_index_durations = $durations4->where('charger_id', $chargerIndex->x);
                    $totalDuration = 0;
                    foreach ($charger_index_durations as $task) {
                        $parts = explode(':', $task->duration);
                        $totalMinutes = ($parts[0] * 60) + $parts[1];
                        $totalDuration += $totalMinutes;
                    }
                    $data44[] = [
                        'y' => $totalDuration,
                    ];
                }
            }
        }

        $x = $chargersIndexes;
        $y1 = $data11;
        $y2 = $data22;
        $y3 = $data33;
        $y4 = $data44;
        $label = DB::table('stats')
            ->select('x_label')
            ->where('type', 'chargers-stat-interval-length-Selection')
            ->get();
        $x_label = $label[0]->x_label;
        $label = DB::table('stats')
            ->select('y_label')
            ->where('type', 'chargers-stat-interval-length-Selection')
            ->get();
        $y_label = $label[0]->y_label;
        $label = DB::table('stats')
            ->select('name')
            ->where('type', 'chargers-stat-interval-length-Selection')
            ->get();
        $name = $label[0]->name;
        return view('statsQuadrupleHistogram', compact('y1', 'y2', 'y3', 'y4', 'x', 'type','x_label','y_label','name'));
    }

    public function chargersStatIntCount($table, $type, $dataset, Request $request)
    {
        if (!isset($table) || !isset($type) || !isset($dataset)) {
            return redirect()->back()->withErrors(['error' => 'Please enter right values :)']);
        }
        $validatedData = $request->validate([
            'interval1' => 'required',
            'interval2' => 'required',
            'interval3' => 'required',
            'interval4' => 'required',
            'interval5' => 'required',
            'interval6' => 'required',
            'interval7' => 'required',
            'interval8' => 'required',
        ]);
        $chargersIndexes = DB::table('charger_tasks')
            ->select('charger_id as x')
            ->where('dataset_name', 'ChEvents_DS10_1.csv')
            ->distinct()
            ->get();

        $data1 = $validatedData['interval1'];
        $data2 = $validatedData['interval5'];
        $start_time1 = strtotime($data1);
        $end_time1 = strtotime($data2);
        $start_minutes1 = date('i', $start_time1) + date('G', $start_time1) * 60;
        $end_minutes1 = date('i', $end_time1) + date('G', $end_time1) * 60;

        $data3 = $validatedData['interval2'];
        $data4 = $validatedData['interval6'];
        $start_time2 = strtotime($data3);
        $end_time2 = strtotime($data4);
        $start_minutes2 = date('i', $start_time2) + date('G', $start_time2) * 60;
        $end_minutes2 = date('i', $end_time2) + date('G', $end_time2) * 60;

        $data5 = $validatedData['interval3'];
        $data6 = $validatedData['interval7'];
        $start_time3 = strtotime($data5);
        $end_time3 = strtotime($data6);
        $start_minutes3 = date('i', $start_time3) + date('G', $start_time3) * 60;
        $end_minutes3 = date('i', $end_time3) + date('G', $end_time3) * 60;

        $data7 = $validatedData['interval4'];
        $data8 = $validatedData['interval8'];
        $start_time4 = strtotime($data7);
        $end_time4 = strtotime($data8);
        $start_minutes4 = date('i', $start_time4) + date('G', $start_time4) * 60;
        $end_minutes4 = date('i', $end_time4) + date('G', $end_time4) * 60;

        $schedules1 = DB::table($table)
            ->select('schedule_no', 'charger_index')
            ->where('dataset_name', $dataset)
            ->whereNotNull('charger_index')
            ->whereRaw("SUBSTRING(`start`, 1, 2) * 60 + SUBSTRING(`start`, 4, 2) > ?", [$start_minutes1])
            ->whereRaw("SUBSTRING(`end`, 1, 2) * 60 + SUBSTRING(`end`, 4, 2) < ?", [$end_minutes1])
            ->groupBy('charger_index', 'schedule_no')
            ->get();
        $schedules2 = DB::table($table)
            ->select('schedule_no', 'charger_index')
            ->where('dataset_name', $dataset)
            ->whereNotNull('charger_index')
            ->whereRaw("SUBSTRING(`start`, 1, 2) * 60 + SUBSTRING(`start`, 4, 2) > ?", [$start_minutes2])
            ->whereRaw("SUBSTRING(`end`, 1, 2) * 60 + SUBSTRING(`end`, 4, 2) < ?", [$end_minutes2])
            ->groupBy('charger_index', 'schedule_no')
            ->get();
        $schedules3 = DB::table($table)
            ->select('schedule_no', 'charger_index')
            ->where('dataset_name', $dataset)
            ->whereNotNull('charger_index')
            ->whereRaw("SUBSTRING(`start`, 1, 2) * 60 + SUBSTRING(`start`, 4, 2) > ?", [$start_minutes3])
            ->whereRaw("SUBSTRING(`end`, 1, 2) * 60 + SUBSTRING(`end`, 4, 2) < ?", [$end_minutes3])
            ->groupBy('charger_index', 'schedule_no')
            ->get();
        $schedules4 = DB::table($table)
            ->select('schedule_no', 'charger_index')
            ->where('dataset_name', $dataset)
            ->whereNotNull('charger_index')
            ->whereRaw("SUBSTRING(`start`, 1, 2) * 60 + SUBSTRING(`start`, 4, 2) > ?", [$start_minutes4])
            ->whereRaw("SUBSTRING(`end`, 1, 2) * 60 + SUBSTRING(`end`, 4, 2) < ?", [$end_minutes4])
            ->groupBy('charger_index', 'schedule_no')
            ->get();


        $data11 = [];
        $data22 = [];
        $data33 = [];
        $data44 = [];

        for ($i = 0; $i < 4; $i++) {
            foreach ($chargersIndexes as $chargerIndex) {
                if ($i == 0) {
                    $schedules_with_charger_index = $schedules1->where('charger_index', $chargerIndex->x);
                    $count = $schedules_with_charger_index->count();
                    $data11[] = [
                        'y' => $count,
                    ];
                } elseif ($i == 1) {
                    $schedules_with_charger_index = $schedules2->where('charger_index', $chargerIndex->x);
                    $count = $schedules_with_charger_index->count();
                    $data22[] = [
                        'y' => $count,
                    ];
                } elseif ($i == 2) {
                    $schedules_with_charger_index = $schedules3->where('charger_index', $chargerIndex->x);
                    $count = $schedules_with_charger_index->count();
                    $data33[] = [
                        'y' => $count,
                    ];
                } elseif ($i == 3) {
                    $schedules_with_charger_index = $schedules4->where('charger_index', $chargerIndex->x);
                    $count = $schedules_with_charger_index->count();
                    $data44[] = [
                        'y' => $count,
                    ];
                }
            }
        }
        $x = $chargersIndexes;
        $y1 = $data11;
        $y2 = $data22;
        $y3 = $data33;
        $y4 = $data44;
        $label = DB::table('stats')
            ->select('x_label')
            ->where('type', 'chargers-stat-interval-count-Selection')
            ->get();
//                return response()->json([
//            '$schedules1' => $type,
//        ]);
        $x_label = $label[0]->x_label;
        $label = DB::table('stats')
            ->select('y_label')
            ->where('type', 'chargers-stat-interval-count-Selection')
            ->get();
        $y_label = $label[0]->y_label;
        $label = DB::table('stats')
            ->select('name')
            ->where('type', 'chargers-stat-interval-count-Selection')
            ->get();
        $name = $label[0]->name;
        return view('statsQuadrupleHistogram', compact('y1', 'y2', 'y3', 'y4', 'x', 'type','x_label','y_label','name'));
//        return response()->json([
//            '$schedules1' => $schedules1->count(),
//            '$schedules2' => $schedules2->count(),
//            '$schedules3' => $schedules3->count(),
//            '$schedules4' => $schedules4->count(),
//            '$data11' => $data11,
//            '$data22' => $data22,
//            '$data33' => $data33,
//            '$data44' => $data44,
//            'table' => $table,
//            'dataset' => $dataset,
//            'data1' => $start_minutes1,
//            'data2' => $end_minutes1,
//        ]);
    }


}
