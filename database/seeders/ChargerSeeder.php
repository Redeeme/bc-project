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
        $filename = storage_path("app\csv\chargers.txt");
        Log::debug($filename);
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
                $data[] = [
                    'charger_index' => $row[0],
                    'location' => $row[1],
                    'cost' => $row[2],
                    'speed' => $row[3],
                ];
            }
            fclose($handle);
            Charger::insert($data);
        }
    }
}
