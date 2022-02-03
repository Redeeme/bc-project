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

    public function getTasks(){
        $tasks = Task::all();
        return view('tourSelection',[
            'tasks' => $tasks,
        ]);
    }

    public function getTours()
    {
        $tours = DB::table('tasks')
            ->select('linka')
            ->distinct()
            ->get();
        $tours->sortBy('linka');
        return view('tourSelection', [
            'tours' => $tours,
        ]);
    }
}
