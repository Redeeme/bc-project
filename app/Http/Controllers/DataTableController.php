<?php

namespace App\Http\Controllers;

use App\DataTables\ChargerTaskDataTable;
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
        return match ($request->name) {
            'charger_tasks' => redirect()->route('page-data-table-chargertask'),
            'schedules' => redirect()->route('page-data-table-schedule'),
            'tasks' => redirect()->route('page-data-table-task'),
            default => redirect()->route('welcome-page'),
        };
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
