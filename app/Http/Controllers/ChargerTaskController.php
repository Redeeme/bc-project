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


    public function getCharger()
    {
        $charger = DB::table('charger_tasks')
            ->select('charger_id AS id')
            ->distinct()
            ->get();
        $charger->sortBy('id');
        $dataset = DB::table('charger_tasks')
            ->select('dataset')
            ->distinct()
            ->get();
        $dataset->sortBy('dataset');
        return view('ganttSelection', [
            'charger' => $charger,
            'dataset' => $dataset,
        ]);
    }
}
