<?php

namespace Database\Seeders;

use App\Models\Helper;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class TasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filename = storage_path("app\csv\spoje_id_DS10_J.csv");
        Log::debug($filename);
        if(!file_exists($filename) || !is_readable($filename))
            return;

        $header = NULL;
        $data = [];
        $hours_start = 0;
        $minute_start = 0;
        $hours_end = 0;
        $minute_end = 0;
        if (($handle = fopen($filename, 'r')) !== FALSE)
        {
            while (($row = fgetcsv($handle, 1000, ';')) !== FALSE)
            {
                if(!$header) {
                    $header = $row;
                }else{
                    $hours_start = (int)($row[6] / 60);
                    $minute_start = $row[6] % 60;
                    $hours_end = (int)($row[7] / 60);
                    $minute_end = $row[7] % 60;
                    $time_start = Carbon::createFromTime(round($hours_start), $minute_start);
                    $time_end = Carbon::createFromTime(round($hours_end), $minute_end);
                    $data[] = [
                        'task_id' => $row[0],
                        'processid' => $row[1],
                        'start' => $time_start,
                        'end' => $time_end,
                        'loc_start' => $row[4],
                        'loc_end' => $row[5],
                        'distance' => $row[8],
                        'consumption' => $row[9],
                        'linka' => $row[3],
                        'dataset_name' => 'spoje_id_DS10_J.csv',
                    ];
                }

            }
            fclose($handle);
            Task::insert($data);
            $helper[] = [
                'dataset_name' => 'spoje_id_DS10_J.csv',
                'dataset_table' => 'tasks',
                'dataset_comment' => 'default',
            ];
            Helper::insert($helper);
        }
    }
}
