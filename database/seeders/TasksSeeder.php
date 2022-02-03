<?php

namespace Database\Seeders;

use App\Models\Task;
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
        if (($handle = fopen($filename, 'r')) !== FALSE)
        {
            while (($row = fgetcsv($handle, 1000, ';')) !== FALSE)
            {
                if(!$header)
                    $header = $row;
                else
                    $data[] = [
                    'index' => $row[0],
                    'spoj_id' => $row[1],
                    'spoj' => $row[2],
                    'linka' => $row[3],
                    'zastavka_start' => $row[4],
                    'zastavka_finish' => $row[5],
                    'cas_start' => $row[6],
                    'cas_finish' => $row[7],
                    'vzdialenost' => $row[8],
                    'spotreba' => $row[9],
                    ];
            }
            fclose($handle);
            Task::insert($data);
        }
    }
}
