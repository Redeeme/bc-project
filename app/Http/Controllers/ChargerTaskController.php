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

    public function getChargerTasks(){
        $chargerTasks = ChargerTask::all();
        return view('chargerSelection',[
            'chargerTasks' => $chargerTasks,
        ]);
    }

    public function getChargers()
    {
        $chargers = DB::table('charger_tasks')
            ->select('charger_id')
            ->distinct()
            ->get();
        $chargers->sortBy('process_id');
        return view('chargerSelection', [
            'chargers' => $chargers,
        ]);
    }
}
