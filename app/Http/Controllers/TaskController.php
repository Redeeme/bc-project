<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function index()
    {
        return view('tourSelection');
    }


    public function getTour($dataset)
    {
        $tour = DB::table('tasks')
            ->select('linka AS id')
            ->where('dataset_name',$dataset)
            ->distinct()
            ->get();
        $tour->sortBy('id');
        return view('ganttSelection', [
            'tour' => $tour,
            'dataset' => $dataset,
        ]);
    }
}
