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
use function PHPUnit\Framework\isNull;

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
    public function tourGantt(Request $request)
    {
        $tour = $request->data;
        $dataset = $request->dataset;
        $processes = Task::select('processid AS label', 'processid AS id')->where('linka', $tour)->where('dataset_name', $dataset)->get();
        $data = Task::select('*')->where('linka', $tour)->where('dataset_name', $dataset)->get();
        $task = [];
        foreach ($data as $row){
            $task[] = [
                'taskid' => $row->processid,
                'start' => $row->start,
                'end' => $row->end,
                'loc_start'=> $row->loc_start,
                'loc_end'=> $row->loc_end,
                 'distance'=> $row->distance,
                 'consumption'=> $row->consumption,
                'linka' => $row->linka,
            ];
        }

        $categories = DiagramTime::select('start','end','label')->where('id','!=','1')->get();
        $category = DiagramTime::select('start','end','label')->where('id','=','1')->get();
//return response()->json(['processes' => $processes, 'task' => $task,'categories'=>$categories,'category'=>$category]);
        return view('gantt', ['processes' => $processes, 'task' => $task,'categories'=>$categories,'category'=>$category,'tour'=>$tour,'tourFlag'=>$tour,'dataset'=>$dataset,'name'=>'tasks']);

    }

    public function chargerGantt(Request $request)
    {
        $tour = $request->data;
        $dataset = $request->dataset;
        $processes = ChargerTask::select('process_id AS label', 'process_id AS id')->where('charger_id', $tour)->where('dataset_name', $dataset)->get();
        $task = ChargerTask::select('*')->where('charger_id', $tour)->where('dataset_name', $dataset)->get();
        $categories = DiagramTime::select('start','end','label')->where('id','!=','1')->get();
        $category = DiagramTime::select('start','end','label')->where('id','=','1')->get();
        //return response()->json(array('processes' => $processes, 'task' => $task,'categories'=>$categories,'category'=>$category,'tour'=>$tour));
        return view('gantt', ['processes' => $processes, 'task' => $task,'categories'=>$categories,'category'=>$category,'tour'=>$tour,'chargerFlag'=>$tour,'dataset'=>$dataset,'name'=>'charger_tasks']);
    }

    public function scheduleGantt(Request $request)
    {

        $schedule = $request->data;
        $type = $request->type;
        $dataset = $request->dataset;
        if ($type == "CHARGER" && $type != null){
            $processes = Schedule::select('schedule_index AS label', 'schedule_index AS id',)->where('schedule_no', $schedule)->where('type', $type)->where('dataset_name', $dataset)->get();
            $task = Schedule::select('*')->where('schedule_no', $schedule)->where('type', $type)->where('dataset_name', $dataset)->get();
        }elseif ($type == "TRIP" && $type != null){
            $processes = Schedule::select('schedule_index AS label', 'schedule_index AS id',)->where('schedule_no', $schedule)->where('dataset_name', $dataset)->where('type', $type)->get();
            $task = Schedule::select('*')->where('schedule_no', $schedule)->where('type', $type)->where('dataset_name', $dataset)->get();
        }else{
            $processes = Schedule::select('schedule_index AS label', 'schedule_index AS id',)->where('schedule_no', $schedule)->where('dataset_name', $dataset)->get();
            $taskk = Schedule::select('*')->where('schedule_no', $schedule)->get();
            $task = [];
            foreach ($taskk as $item) {
                $tmp = Schedule::select('*')->where('schedule_no', $schedule)->where('schedule_index', $item->schedule_index)->where('dataset_name', $dataset)->get();
                if ($tmp[0]->type == "CHARGER"){
                    $task[] = [
                        'schedule_index'=> $item->schedule_index,
                        'start' => $item->start,
                        'end'=> $item->end,
                        'consumption'=> $item->consumption,
                        'energy_before'=> $item->energy_before,
                        'energy_after'=> $item->energy_after,
                        'color'=> "#f16575"
                    ];
                }else{
                    $task[] = [
                        'schedule_index'=> $item->schedule_index,
                        'start' => $item->start,
                        'end'=> $item->end,
                        'consumption'=> $item->consumption,
                        'energy_before'=> $item->energy_before,
                        'energy_after'=> $item->energy_after,
                        'color'=> "#008ee4"
                    ];
                }

            }
        }
        $categories = DiagramTime::select('start','end','label')->where('id','!=','1')->get();
        $category = DiagramTime::select('start','end','label')->where('id','=','1')->get();
        //return response()->json(array('task' => $task, 'processes' => $processes));


        return view('gantt', ['processes' => $processes, 'task' => $task,'categories'=>$categories,'category'=>$category,'tour'=>$schedule,'scheduleFlag'=>$schedule,'type'=>$type,'dataset'=>$dataset,'name'=>'schedules']);
    }
}
