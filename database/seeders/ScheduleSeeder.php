<?php

namespace Database\Seeders;

use App\Models\Schedule;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filename = storage_path("app\csv\schedules.txt");
        Log::debug($filename);
        if (!file_exists($filename) || !is_readable($filename))
            return;

        $schedule = NULL;
        $data = [];
        $charger = "";
        $hours_start = 0;
        $minute_start = 0;
        $hours_end = 0;
        $minute_end = 0;
        if (($handle = fopen($filename, 'r')) !== FALSE) {
            while (($row = fgetcsv($handle, 1000, ';')) !== FALSE) {
                if (substr($row[0], 0, 8) == "Schedule") {
                    $schedule = $row[0];
                } elseif ($row[0] == null) {

                } elseif (substr($row[0], 0, 5) == "Index"){

                } else {
                    $hours_start = (int)($row[1] / 60);
                    $minute_start = $row[1] % 60;
                    $hours_end = (int)($row[2] / 60);
                    $minute_end = $row[2] % 60;
                    $time_start = Carbon::createFromTime(round($hours_start), $minute_start);
                    $time_end = Carbon::createFromTime(round($hours_end), $minute_end);
                    if (str_contains($row[0], "_")) {
                        $charger = explode("_", $row[0]);
                        $data[] = [
                            'schedule_index' => $charger[1],
                            'charger_index' => $charger[0],
                            'start' => $time_start,
                            'end' => $time_end,
                            'energy_before' => $row[3],
                            'energy_after' => $row[4],
                            'consumption' => $row[5],
                            'location_start' => $row[6],
                            'location_finish' => $row[7],
                            'type' => $row[8],
                            'schedule_no' => $schedule,
                        ];
                    } else {
                        $charger = NULL;
                        $data[] = [
                            'schedule_index' => $row[0],
                            'charger_index' => $charger,
                            'start' => $time_start,
                            'end' => $time_end,
                            'energy_before' => $row[3],
                            'energy_after' => $row[4],
                            'consumption' => $row[5],
                            'location_start' => $row[6],
                            'location_finish' => $row[7],
                            'type' => $row[8],
                            'schedule_no' => $schedule,
                        ];
                    }

                }

            }
            fclose($handle);
            Schedule::insert($data);
        }
    }
}
