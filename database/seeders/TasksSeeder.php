<?php

namespace Database\Seeders;

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
        $filename = storage_path("app\csv\spoje_id_busesAll_Z.csv");
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
                    $hours_start = (int)$row[6] / 60;
                    $minute_start = (int)$row[6] % 60;
                    $hours_end = (int)$row[7] / 60;
                    $minute_end = (int)$row[7] % 60;
                    $time_start = Carbon::createFromTime(round($hours_start), $minute_start);
                    $time_end = Carbon::createFromTime(round($hours_end), $minute_end);
                    $data[] = [
                        'task_id' => $row[0],
                        'processid' => $row[1],
                        'start' => $time_start,
                        'end' => $time_end,
                        'label' => $row[4] . ' ' .
                            $row[5] . ' ' .
                            $time_start . ' ' .
                            $time_end . ' ' .
                            $row[8] . ' ' .
                            $row[9],
                        'linka' => $row[3],
                    ];
                }

            }
            fclose($handle);
            Task::insert($data);
        }
    }
}
