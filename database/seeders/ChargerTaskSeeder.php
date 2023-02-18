<?php

namespace Database\Seeders;

use App\Models\ChargerTask;
use App\Models\Helper;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class ChargerTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filename = storage_path("app\csv\ChEvents_DS10_J.csv");
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
                    $hours_start = (int)($row[2] / 60);
                    $minute_start = $row[2] % 60;
                    $hours_end = (int)($row[3] / 60);
                    $minute_end = $row[3] % 60;
                    $time_start = Carbon::createFromTime(round($hours_start), $minute_start);
                    $time_end = Carbon::createFromTime(round($hours_end), $minute_end);
                    $data[] = [
                        'charger_id' => $row[0],
                        'process_id' => $row[1],
                        'start' => $time_start,
                        'end' => $time_end,
                        'speed' => $row[6],
                        'loc' => $row[5],
                        'dataset_name' => 'ChEvents_DS10_J',
                    ];
                }

            }
            fclose($handle);
            foreach (array_chunk($data,1000) as $t)
            {
                ChargerTask::insert($t);
            }
            $helper[] = [
                'dataset_name' => 'ChEvents_DS10_J',
                'dataset_table' => 'charger_tasks',
            ];
            Helper::insert($helper);
        }
    }
}
