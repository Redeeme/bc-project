<?php

namespace App\Http\Controllers;

use App\Models\DiagramTime;
use App\Models\GanttProcess;
use App\Models\GanttTask;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GanttController extends Controller
{
//task:
//spoj_id -> processid
//cas_start -> start
//cas_finish -> end
//zastavka_start + " " + zastavka_finish + " " + cas_start + " " + cas_finish + " " + vzdialenost + " " + spotreba ->label
//
//processes:
//spoj_id -> label
//spoj_id -> processid
    public function index(Request $request)
    {
        $tour = $request->linka;
        $tasks = DB::table('tasks')
            ->where('linka', $tour)
            ->get();

        $processes = Task::select('processid AS label', 'processid AS id')->where('linka', $tour)->get();
        $task = Task::select('processid', 'start', 'end', 'label')->where('linka', $tour)->get();
        $categories = DiagramTime::select('start','end','label')->where('id','!=','1')->get();
        $category = DiagramTime::select('start','end','label')->where('id','=','1')->get();

        return view('gantt', ['processes' => $processes, 'task' => $task,'categories'=>$categories,'category'=>$category,'tour'=>$tour]);
        //return response()->json(['processes' => $processes, 'task' => $task,'categories'=>$categories,'category'=>$category]);
    }
}
