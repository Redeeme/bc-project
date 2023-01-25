<?php

namespace App\Http\Controllers;

use App\Models\ChargerTask;
use App\Models\DiagramTime;
use App\Models\GanttProcess;
use App\Models\GanttTask;
use App\Models\Schedule;
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
    public function toursGantt(Request $request)
    {
        $tour = $request->linka;
        $processes = Task::select('processid AS label', 'processid AS id')->where('linka', $tour)->get();
        $data = Task::select('*')->where('linka', $tour)->get();
        $task = [];
        foreach ($data as $row){
            $task[] = [
                'processid' => $row->processid,
                'start' => $row->start,
                'end' => $row->end,
                'label' => 'ZastavkaStart' . '-' . $row->loc_start . ' ' .
                    'ZastavkaFinish' . '-' . $row->loc_end . ' ' .
                    'Vzdialenost' . '-' . $row->distance . ' ' .
                    'Spotreba' . '-' . $row->consumption,
                'linka' => $row->linka,
            ];
        }


        $categories = DiagramTime::select('start','end','label')->where('id','!=','1')->get();
        $category = DiagramTime::select('start','end','label')->where('id','=','1')->get();

        return view('gantt', ['processes' => $processes, 'task' => $task,'categories'=>$categories,'category'=>$category,'tour'=>$tour]);
        //return response()->json(['processes' => $processes, 'task' => $task,'categories'=>$categories,'category'=>$category]);
    }

    public function chargersGantt(Request $request)
    {
        $tour = $request->charger;

        $processes = ChargerTask::select('process_id AS label', 'process_id AS id')->where('charger_id', $tour)->get();
        $task = ChargerTask::select('process_id', 'start', 'end', 'label')->where('charger_id', $tour)->get();
        $categories = DiagramTime::select('start','end','label')->where('id','!=','1')->get();
        $category = DiagramTime::select('start','end','label')->where('id','=','1')->get();
        //return response()->json(array('processes' => $processes, 'task' => $task,'categories'=>$categories,'category'=>$category,'tour'=>$tour));
        return view('gantt', ['processes' => $processes, 'task' => $task,'categories'=>$categories,'category'=>$category,'tour'=>$tour]);
    }

    public function schedulesGantt(Request $request)
    {

        $schedule = $request->schedule;
        $type = $request->type;
        if ($type == "CHARGER"){
            $processes = Schedule::select('schedule_index AS label', 'schedule_index AS id')->where('schedule_no', $schedule)->where('type', $type)->get();
            $task = Schedule::select('schedule_index', 'start', 'end', 'consumption')->where('schedule_no', $schedule)->where('type', $type)->get();
        }elseif ($type == "TRIP"){
            $processes = Schedule::select('schedule_index AS label', 'schedule_index AS id')->where('schedule_no', $schedule)->where('type', $type)->get();
            $task = Schedule::select('schedule_index', 'start', 'end', 'consumption')->where('schedule_no', $schedule)->where('type', $type)->get();
        }else{
            $processes = Schedule::select('schedule_index AS label', 'schedule_index AS id')->where('schedule_no', $schedule)->get();
            $task = Schedule::select('schedule_index', 'start', 'end', 'consumption')->where('schedule_no', $schedule)->get();
        }
        $categories = DiagramTime::select('start','end','label')->where('id','!=','1')->get();
        $category = DiagramTime::select('start','end','label')->where('id','=','1')->get();
        //return response()->json(array('processes' => $type, 'task' => $schedule));
        return view('gantt', ['processes' => $processes, 'task' => $task,'categories'=>$categories,'category'=>$category,'tour'=>$schedule]);
    }
}
