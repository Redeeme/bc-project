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
        if (!isset($dataset)) {
            return redirect()->back()->withErrors(['error' => 'Please enter right values :)']);
        }
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
