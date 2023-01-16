<?php

namespace Database\Seeders;

use App\Models\Charger;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            TasksSeeder::class,
            ChargerSeeder::class,
            StationSeeder::class,
            ScheduleSeeder::class,
            ChargerTaskSeeder::class,
            TableNameSeeder::class,
            DiagramTimeSeeder::class
        ]);
    }
}
