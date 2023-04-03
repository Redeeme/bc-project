<?php

namespace App\Http\Controllers;

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
            ->where('dataset_name', $dataset)
            ->distinct()
            ->get();
        $charger->sortBy('id');
        return view('ganttSelection', [
            'charger' => $charger,
            'dataset' => $dataset,
        ]);
    }

    public function chargerStats(Request $request)
    {
        $dataset = $request->dataset;
        $name = $request->name;
        $chargerFlag = $request->data;
        return view('ganttStats', [
            'chargerFlag' => $chargerFlag,
            'dataset' => $dataset,
            'name' => $name,
        ]);
    }
}
