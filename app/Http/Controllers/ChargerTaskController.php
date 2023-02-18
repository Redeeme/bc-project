<?php

namespace App\Http\Controllers;

use App\Models\ChargerTask;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChargerTaskController extends Controller
{
    public function index()
    {
        return view('chargerSelection');
    }


    public function getCharger($dataset)
    {
        $charger = DB::table('charger_tasks')
            ->select('charger_id AS id')
            ->where('dataset_name',$dataset)
            ->distinct()
            ->get();
        $charger->sortBy('id');
        return view('ganttSelection', [
            'charger' => $charger,
            'dataset' => $dataset,
        ]);
    }
}
