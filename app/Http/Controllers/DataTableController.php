<?php

namespace App\Http\Controllers;

use App\DataTables\ChargerTaskDataTable;
use App\DataTables\ChargerTaskDataTableUnit;
use App\DataTables\ScheduleDataTable;
use App\DataTables\TaskDataTable;
use App\Models\ChargerTask;
use App\Models\TableName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class DataTableController extends Controller
{
    public function index()
    {
        return view('tableSelection');
    }

    public function getTableNames(){
        $tableNames = TableName::all();
        return view('tableSelection',[
            'tableNames' => $tableNames,
        ]);
    }

    public function getData(Request $request){
        if ($request->data != null){
            //return response()->json(['id' => $request->data,'dataset' => $request->dataset,'name' => $request->name,'type' => $request->type]);
            return match ($request->name) {
                'charger_tasks' => redirect()->route('page-data-table-charger-task-unit',['id' => $request->data,'dataset' => $request->dataset,'name' => $request->name]),
                'schedules' => redirect()->route('page-data-table-schedule-unit',['id' => $request->data,'dataset' => $request->dataset,'name' => $request->name,'type' => $request->type]),
                'tasks' => redirect()->route('page-data-table-task-unit',['id' => $request->data,'dataset' => $request->dataset,'name' => $request->name]),
                default => redirect()->route('welcome-page'),
            };
        }else{
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
