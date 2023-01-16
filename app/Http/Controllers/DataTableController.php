<?php

namespace App\Http\Controllers;

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

    public function getDataTable(Request $request)
    {
        $tableName = $request->name;
        return view('dataTableView', ['tableName' => $tableName]);
    }

    public function getChargerTasks()
    {
        $chargerTask = ChargerTask::all();
        return DataTables::of($chargerTask)->make(true);
    }
}
