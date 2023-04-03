<?php

namespace Database\Seeders;

use App\Models\Schedule;
use App\Models\Station;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class StationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filename = storage_path("app\csv\stations.txt");
        Log::debug($filename);
        if (!file_exists($filename) || !is_readable($filename))
            return;
        if (($handle = fopen($filename, 'r')) !== FALSE) {
            fgetcsv($handle);
            while (($row = fgetcsv($handle, 1000, ';')) !== FALSE) {
                error_log($row[0]);
                $data[] = [
                    'station_id' => $row[0],
                    'location' => $row[1],
                ];
            }
            fclose($handle);
            Station::insert($data);
        }
    }
}
