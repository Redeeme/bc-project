<?php

namespace App\Http\Controllers;

use App\Models\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
        $validatedData = $request->validate([
            'dataset' => 'required',
        ]);
        $dataset = $validatedData['dataset'];

        $tableName = DB::table('helpers')
            ->select('dataset_table')
            ->where('dataset_name', $dataset)
            ->distinct()
            ->get();
        return match ($tableName[0]->dataset_table) {
            'charger_tasks' => redirect()->route('select-chargers', ['dataset' => $dataset]),
            'schedules' => redirect()->route('select-schedules', ['dataset' => $dataset]),
            'tasks' => redirect()->route('select-tours', ['dataset' => $dataset]),
            default => redirect()->route('welcome-page'),
        };
    }

    public function getSchedulesDatasets()
    {
        $dataset = DB::table('helpers')
            ->select('dataset_name')
            ->where('dataset_table', 'schedules')
            ->distinct()
            ->get();
        $dataset->sortBy('dataset_name');
        return view('scheduleSelectionGraph', [
            'dataset_name' => $dataset,
        ]);
    }

    public function getSchedulesDataset(Request $request)
    {
        $validatedData = $request->validate([
            'dataset' => 'required',
        ]);
        $dataset = $validatedData['dataset'];
        return redirect()->route('select-schedules-graph', ['dataset' => $dataset]);
    }

    public function indexDataset()
    {
        $dataset = DB::table('helpers')
            ->select('*')
            ->distinct()
            ->get();
        return view('datasetsOverview', [
            'datasets' => $dataset,
        ]);
    }

    public function deleteDataset($id, $table)
    {
        $validatedData = Validator::make(
            [
                'id' => $id,
                'table' => $table,
            ],
            [
                'id' => 'required',
                'table' => 'required',
            ]
        )->validate();
        if (!isset($id) || !isset($table)) {
            return redirect()->back()->withErrors(['error' => 'Please enter right values :)']);
        }
        $dataset = Helper::find($id);

        if (!$dataset) {
            return redirect()->back()->with('error', 'Dataset not found');
        }
        $name = DB::table('helpers')
            ->select('dataset_name')
            ->where('id', '=', $id)
            ->get();
        DB::table($table)
            ->where('dataset_name', '=', $name[0]->dataset_name)
            ->delete();

        $dataset->delete();

        return redirect()->back()->with('success', 'Dataset deleted successfully');
    }

    public function refreshDatasets()
    {
        Artisan::call('migrate:fresh');
        Artisan::call('db:seed');
        return redirect()->back()->with('success', 'Dataset deleted successfully');
    }
}
