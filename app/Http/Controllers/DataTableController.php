<?php

namespace App\Http\Controllers;

use App\DataTables\ChargerTaskDataTable;
use App\DataTables\ScheduleDataTable;
use App\DataTables\TaskDataTable;
use App\Models\TableName;
use Illuminate\Http\Request;

class DataTableController extends Controller
{
    public function index()
    {
        return view('tableSelection');
    }

    public function getTableNames()
    {
        $tableNames = TableName::all();
        return view('tableSelection', [
            'tableNames' => $tableNames,
        ]);
    }

    public function getData(Request $request)
    {
        if ($request->data != null) {
            $validatedData = $request->validate([
                'dataset' => 'required',
                'data' => 'required',
                'name' => 'required|in:tasks,charger_tasks,schedules',
            ]);
            $id = $validatedData['data'];
            $dataset = $validatedData['dataset'];
            $name = $validatedData['name'];
            //return response()->json(['id' => $request->data,'dataset' => $request->dataset,'name' => $request->name,'type' => $request->type]);
            return match ($name) {
                'charger_tasks' => redirect()->route('page-data-table-charger-task-unit', ['id' => $id, 'dataset' => $dataset, 'name' => $name]),
                'schedules' => redirect()->route('page-data-table-schedule-unit', ['id' => $id, 'dataset' => $dataset, 'name' => $name, 'type' => $request->type]),
                'tasks' => redirect()->route('page-data-table-task-unit', ['id' => $id, 'dataset' => $dataset, 'name' => $name]),
                default => redirect()->route('welcome-page'),
            };
        } else {
            return match ($request->name) {
                'charger_tasks' => redirect()->route('page-data-table-charger-task'),
                'schedules' => redirect()->route('page-data-table-schedule'),
                'tasks' => redirect()->route('page-data-table-task'),
                default => redirect()->route('welcome-page'),
            };
        }
        return redirect()->route('welcome-page');
    }

    public function getChargerTaskDataTable(ChargerTaskDataTable $dataTable)
    {
        return $dataTable->render('dataTableView');
    }

    public function getScheduleDataTable(ScheduleDataTable $dataTable)
    {
        return $dataTable->render('dataTableView');
    }

    public function getTaskDataTable(TaskDataTable $dataTable)
    {
        return $dataTable->render('dataTableView');
    }
}
