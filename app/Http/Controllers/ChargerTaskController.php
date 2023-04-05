<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ChargerTaskController extends Controller
{
    public function index()
    {
        return view('chargerSelection');
    }

    public function getCharger($dataset)
    {
        $validatedData = Validator::make(
            [
                'dataset' => $dataset,
            ],
            [
                'dataset' => 'required',
            ]
        )->validate();
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
        $validatedData = $request->validate([
            'dataset' => 'required',
            'name' => 'required',
            'data' => 'required',
        ]);
        $dataset = $validatedData->dataset;
        $name = $validatedData->name;
        $chargerFlag = $validatedData->data;
        return view('ganttStats', [
            'chargerFlag' => $chargerFlag,
            'dataset' => $dataset,
            'name' => $name,
        ]);
    }
}
