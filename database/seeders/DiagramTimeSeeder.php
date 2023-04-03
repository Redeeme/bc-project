<?php

namespace Database\Seeders;

use App\Models\Task;
use Carbon\Carbon;
use App\Models\DiagramTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class DiagramTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        for ($i = 4; $i <= 24; $i++) {
            if ($i == 4) {
                $data[] = [
                    'start' => Carbon::createFromTime($i),
                    'end' => Carbon::createFromTime(23, 59, 59),
                    'label' => 'čas',
                ];
            } else {
                $data[] = [
                    'start' => Carbon::createFromTime($i - 1,),
                    'end' => Carbon::createFromTime($i - 1, 59, 59),
                    'label' => $i - 1,
                ];
            }
        }
        DiagramTime::insert($data);
    }
}
