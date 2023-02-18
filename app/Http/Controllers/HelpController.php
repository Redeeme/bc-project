<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HelpController extends Controller
{
    public function getDatasets()
    {
        $dataset = DB::table('helpers')
            ->select('dataset_name')
            ->distinct()
            ->get();
        $dataset->sortBy('dataset_name');
        return view('ganttSelection', [
            'dataset_name' => $dataset,
        ]);
    }
    public function getDataset(Request $request)
    {
        $dataset = $request->dataset;
        $tableName = DB::table('helpers')
            ->select('dataset_table')
            ->where('dataset_name',$dataset)
            ->distinct()
            ->get();
        return match ($tableName[0]->dataset_table) {
            'charger_tasks' => redirect()->route('select-chargers',['dataset' => $dataset]),
            'schedules' => redirect()->route('select-schedules',['dataset' => $dataset]),
            'tasks' => redirect()->route('select-tours',['dataset' => $dataset]),
            default => redirect()->route('welcome-page'),
        };
    }
    public function getSchedulesDatasets()
    {
        $dataset = DB::table('helpers')
            ->select('dataset_name')
            ->where('dataset_table','schedules')
            ->distinct()
            ->get();
        $dataset->sortBy('dataset_name');
        return view('scheduleSelectionGraph', [
            'dataset_name' => $dataset,
        ]);
    }
    public function getSchedulesDataset(Request $request)
    {
        $dataset = $request->dataset;
        return redirect()->route('select-schedules-graph',['dataset' => $dataset]);
    }
}
