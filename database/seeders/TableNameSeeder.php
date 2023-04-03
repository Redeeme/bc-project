<?php

namespace Database\Seeders;

use App\Models\TableName;
use Illuminate\Database\Seeder;

class TableNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data[] = ['name' => "charger_tasks"];
        $data[] = ['name' => "schedules"];
        $data[] = ['name' => "tasks"];
        TableName::insert($data);
    }
}
