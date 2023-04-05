<?php

namespace App\Http\Controllers;

use App\Models\ChargerTask;
use App\Models\Helper;
use App\Models\TableName;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportFileController extends Controller
{
    public function index()
    {
        $tableNames = TableName::all();
        return view('import', [
            'tableNames' => $tableNames,
        ]);
    }

    public function importData(Request $request)
    {
        $validatedData = $request->validate([
            'table_name' => 'required',
            'uploaded_file' => 'required|file|mimes:csv,txt|max:10240', // 10MB maximum size
        ]);
        $table_name = $validatedData['table_name'];


        $datasets = DB::table('helpers')
            ->select('dataset_name')
            ->distinct()
            ->get();
        // return response()->json(array('$data' => $request->file('uploaded_file')->getClientOriginalName()));
        $file_name = $request->file('uploaded_file')->getClientOriginalName();
        if (!$datasets->contains('dataset_name', $file_name)) {
            //return response()->json(['comment' => $request->comment, 'file' => $request->file('uploaded_file')->getClientOriginalName(), 'table_name' => $request->table_name]);

            $the_file = $request->file('uploaded_file');
            if ($table_name == 'tasks') {
                try {
                    $spreadsheet = IOFactory::load($the_file->getRealPath());
                    $sheet = $spreadsheet->getActiveSheet();
                    $row_limit = $sheet->getHighestDataRow();
                    $column_limit = $sheet->getHighestDataColumn();
                    $row_range = range(3, $row_limit);
                    $column_range = range('F', $column_limit);
                    $startcount = 2;
                    $data = array();
                    $task_id = Task::max('task_id');;

                    $hours_start = 0;
                    $minute_start = 0;
                    $hours_end = 0;
                    $minute_end = 0;
                    foreach ($row_range as $row) {
                        $task_id++;
                        $hours_start = (int)($sheet->getCell('G' . $row)->getValue() / 60);
                        $minute_start = $sheet->getCell('G' . $row)->getValue() % 60;
                        $hours_end = (int)($sheet->getCell('H' . $row)->getValue() / 60);
                        $minute_end = $sheet->getCell('H' . $row)->getValue() % 60;
                        $time_start = Carbon::createFromTime(round($hours_start), $minute_start);
                        $time_end = Carbon::createFromTime(round($hours_end), $minute_end);
                        $data[] = [
                            'task_id' => $sheet->getCell('A' . $row)->getValue(),
                            'processid' => $sheet->getCell('B' . $row)->getValue(),
                            'start' => $time_start,
                            'end' => $time_end,
                            'loc_start' => $sheet->getCell('E' . $row)->getValue(),
                            'loc_end' => $sheet->getCell('F' . $row)->getValue(),
                            'distance' => $sheet->getCell('J' . $row)->getValue(),
                            'consumption' => $sheet->getCell('K' . $row)->getValue(),
                            'linka' => $sheet->getCell('D' . $row)->getValue(),
                            'dataset_name' => $file_name,
                        ];
                        $startcount++;

                    }
                    $helper[] = [
                        'dataset_name' => $file_name,
                        'dataset_table' => 'tasks',
                        'dataset_comment' => 'default',
                        'row_count' => count($data)
                    ];
                    Helper::insert($helper);
                    //return response()->json(array('$data' => $data));
                    DB::table('tasks')->insert($data);
                } catch (Exception $e) {
                    $error_code = $e->errorInfo[1];
                    return back()->withErrors('There was a problem uploading the data!');
                }
                return back()->withSuccess('Great! Data has been successfully uploaded.');
            } elseif ($table_name == 'schedules') {
                try {

                    $spreadsheet = IOFactory::load($the_file->getRealPath());
                    $sheet = $spreadsheet->getActiveSheet();
                    $row_limit = $sheet->getHighestDataRow();
                    $column_limit = $sheet->getHighestDataColumn();
                    $row_range = range(1, $row_limit);
                    $column_range = range('F', $column_limit);
                    $schedule = NULL;
                    $charger = "";
                    $hours_start = 0;
                    $minute_start = 0;
                    $hours_end = 0;
                    $minute_end = 0;
                    $startcount = 2;
                    $data = array();
                    foreach ($row_range as $row) {
                        $firststring = $sheet->getCell('A' . $row);
                        if (str_starts_with($firststring, "Schedule")) {
                            $schedule = $firststring;
                        } elseif ($sheet->getCell('A' . $row)->getValue() === NULL ||
                            $sheet->getCell('A' . $row)->getValue() === '') {
                        } elseif ($firststring == "Index") {

                        } else {
                            $hours_start = (int)($sheet->getCell('B' . $row)->getValue() / 60);
                            $minute_start = $sheet->getCell('B' . $row)->getValue() % 60;
                            $hours_end = (int)($sheet->getCell('C' . $row)->getValue() / 60);
                            $minute_end = $sheet->getCell('C' . $row)->getValue() % 60;
                            $time_start = Carbon::createFromTime(round($hours_start), $minute_start);
                            $time_end = Carbon::createFromTime(round($hours_end), $minute_end);
                            if (str_contains($sheet->getCell('A' . $row), "_")) {
                                $charger = explode("_", $sheet->getCell('A' . $row));
                                $data[] = [
                                    'schedule_index' => $charger[1],
                                    'charger_index' => $charger[0],
                                    'start' => $time_start,
                                    'end' => $time_end,
                                    'energy_before' => (float)$sheet->getCell('D' . $row)->getValue(),
                                    'energy_after' => (float)$sheet->getCell('E' . $row)->getValue(),
                                    'consumption' => (float)$sheet->getCell('F' . $row)->getValue(),
                                    'location_start' => (int)$sheet->getCell('G' . $row)->getValue(),
                                    'location_finish' => (int)$sheet->getCell('H' . $row)->getValue(),
                                    'type' => (string)$sheet->getCell('I' . $row)->getValue(),
                                    'schedule_no' => $schedule,
                                    'dataset_name' => $file_name,
                                ];
                            } else {
                                $charger = NULL;
                                $data[] = [
                                    'schedule_index' => (int)$sheet->getCell('A' . $row)->getValue(),
                                    'charger_index' => $charger,
                                    'start' => $time_start,
                                    'end' => $time_end,
                                    'energy_before' => (float)$sheet->getCell('D' . $row)->getValue(),
                                    'energy_after' => (float)$sheet->getCell('E' . $row)->getValue(),
                                    'consumption' => (float)$sheet->getCell('F' . $row)->getValue(),
                                    'location_start' => (int)$sheet->getCell('G' . $row)->getValue(),
                                    'location_finish' => (int)$sheet->getCell('H' . $row)->getValue(),
                                    'type' => (string)$sheet->getCell('I' . $row)->getValue(),
                                    'schedule_no' => $schedule,
                                    'dataset_name' => $file_name,
                                ];
                            }
                        }

                        $startcount++;
                    }
                    $helper[] = [
                        'dataset_name' => $file_name,
                        'dataset_table' => 'schedules',
                        'dataset_comment' => 'default',
                        'row_count' => count($data)
                    ];
                    Helper::insert($helper);
                    //return response()->json(array('$data' => $data));
                    DB::table('schedules')->insert($data);
                } catch (Exception $e) {
                    $error_code = $e->errorInfo[1];
                    return back()->withErrors('There was a problem uploading the data!');
                }
                return back()->withSuccess('Great! Data has been successfully uploaded.');
            } elseif ($table_name == 'charger_tasks') {
                try {
                    $spreadsheet = IOFactory::load($the_file->getRealPath());
                    $sheet = $spreadsheet->getActiveSheet();
                    $row_limit = $sheet->getHighestDataRow();
                    $column_limit = $sheet->getHighestDataColumn();
                    $row_range = range(2, $row_limit);
                    $column_range = range('F', $column_limit);
                    $startcount = 2;
                    $data = array();
                    foreach ($row_range as $row) {
                        $hours_start = (int)($sheet->getCell('C' . $row)->getValue() / 60);
                        $minute_start = $sheet->getCell('C' . $row)->getValue() % 60;
                        $hours_end = (int)($sheet->getCell('D' . $row)->getValue() / 60);
                        $minute_end = $sheet->getCell('D' . $row)->getValue() % 60;
                        $hours_duration = (int)($sheet->getCell('E' . $row)->getValue() / 60);
                        $minute_duration = $sheet->getCell('E' . $row)->getValue() % 60;
                        $time_start = Carbon::createFromTime(round($hours_start), $minute_start);
                        $time_end = Carbon::createFromTime(round($hours_end), $minute_end);
                        $time_duration = Carbon::createFromTime(round($hours_duration), $minute_duration);
                        $data[] = [
                            'charger_id' => $sheet->getCell('A' . $row)->getValue(),
                            'process_id' => $sheet->getCell('B' . $row)->getValue(),
                            'start' => $time_start,
                            'end' => $time_end,
                            'duration' => $time_duration,
                            'speed' => $sheet->getCell('G' . $row)->getValue(),
                            'loc' => $sheet->getCell('F' . $row)->getValue(),
                            'dataset_name' => $file_name,
                        ];
                        $startcount++;
                    }
                    $helper[] = [
                        'dataset_name' => $file_name,
                        'dataset_table' => 'charger_tasks',
                        'dataset_comment' => 'default',
                        'row_count' => count($data)
                    ];
                    Helper::insert($helper);
                    foreach (array_chunk($data, 1000) as $t) {
                        ChargerTask::insert($t);
                    }
                } catch (Exception $e) {
                    $error_code = $e->errorInfo[1];
                    return back()->withErrors('There was a problem uploading the data!');
                }
                return back()->withSuccess('Great! Data has been successfully uploaded.');
            } else {
                return back()->withErrors('There was a problem uploading the data!');
            }
        }
        return redirect()->route('welcome-page');
    }
}
