<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index()
    {
        return view('tourSelection');
    }


    public function getTour($dataset)
    {
        $validatedData = Validator::make(
            [
                'dataset' => $dataset
            ],
            [
                'dataset' => 'required'
            ]
        )->validate();
        $tour = DB::table('tasks')
            ->select('linka AS id')
            ->where('dataset_name', $dataset)
            ->distinct()
            ->get();
        $tour->sortBy('id');
        return view('ganttSelection', [
            'tour' => $tour,
            'dataset' => $dataset,
        ]);
    }

    public function tourStats(Request $request)
    {
        $validatedData = $request->validate([
            'dataset' => 'required',
            'name' => 'required',
            'data' => 'required'
        ]);

        $dataset = $validatedData['dataset'];
        $name = $validatedData['name'];
        $tourflag = $validatedData['data'];

        return view('ganttStats', [
            'tourFlag' => $tourflag,
            'dataset' => $dataset,
            'name' => $name,
        ]);
    }
}
