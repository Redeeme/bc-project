<?php

namespace Database\Seeders;

use App\Models\Charger;
use App\Models\Station;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class ChargerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filename = storage_path("app\csv\chargers_DS10_1.csv");
        if (!file_exists($filename) || !is_readable($filename))
            return;
        if (($handle = fopen($filename, 'r')) !== FALSE)
        {
            fgetcsv($handle);
            while (($row = fgetcsv($handle, 1000, ';')) !== FALSE)
            {
                error_log($row[0]);
                error_log($row[1]);
                error_log($row[2]);
                error_log($row[3]);
                error_log($row[4]);
                error_log($row[5]);
                $data[] = [
                    'charger_index' => $row[0],
                    'location' => $row[1],
                    'speed' => $row[2],
                    'cost' => $row[3],
                    'lat' => $row[4],
                    'long' => $row[5],
                ];
            }
            fclose($handle);
            Charger::insert($data);
        }
    }
}
