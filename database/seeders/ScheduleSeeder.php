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
        if (($handle = fopen($filename, 'r')) !== FALSE) {
            while (($row = fgetcsv($handle, 1000, ';')) !== FALSE) {
                if (substr($row[0], 0, 8) == "Schedule") {
                    $schedule = $row[0];
                } elseif ($row[0] == null) {

                } elseif (substr($row[0], 0, 5) == "Index"){

                } else {
                    if (str_contains($row[0], "_")) {
                        $charger = explode("_", $row[0]);
                        $data[] = [
                            'schedule_index' => $charger[1],
                            'charger_index' => $charger[0],
                            'start' => $row[1],
                            'finish' => $row[2],
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
                            'start' => $row[1],
                            'finish' => $row[2],
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
