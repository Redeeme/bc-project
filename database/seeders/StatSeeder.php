<?php

namespace Database\Seeders;

use App\Models\Stat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        $data[] = [
            'name' => 'Vyťaženie nabíjačiek',
            'comment' => 'Pre každú nabíjačku pomer času nabíjania k celkovému dostupnému času',
            'table' => 'charger_tasks',
            'type' => 'chargers-stat-utilization',
            'x_label' => 'Indexy nabíjačiek',
            'y_label' => 'Využitie nabíjačiek v % (percentách)',
        ];
        $data[] = [
            'name' => 'Počet pripnutí na nabíjačku',
            'comment' => 'Počet pripnutí na nabíjačku',
            'table' => 'schedules',
            'type' => 'schedules-stat-clip',
            'x_label' => 'Indexy vozidiel',
            'y_label' => 'Počet pripnutí na nabíjačku',
        ];
        $data[] = [
            'name' => 'Čas strávený nabíjaním',
            'comment' => 'Čas strávený nabíjaním',
            'table' => 'schedules',
            'type' => 'schedules-stat-charging',
            'x_label' => 'Indexy vozidiel',
            'y_label' => 'Čas v minútach',
        ];
        $data[] = [
            'name' => 'Pomer času nabíjania k času na spojoch',
            'comment' => 'Pomer času nabíjania k času na spojoch',
            'table' => 'schedules',
            'type' => 'schedules-stat-utilization',
            'x_label' => 'Indexy vozidiel',
            'y_label' => 'Čas v minútach',
        ];
        $data[] = [
            'name' => 'Počet obslúžených spojov',
            'comment' => 'Počet obslúžených spojov',
            'table' => 'schedules',
            'type' => 'schedules-stat-trips',
            'x_label' => 'Indexy vozidiel',
            'y_label' => 'počet obslúžených spojov',
        ];
        $data[] = [
            'name' => 'Stav batérie podľa vozidla',
            'comment' => 'Stav batérie podľa vozidla',
            'table' => 'schedules',
            'type' => 'schedules-stat-batery',
            'x_label' => 'Čas',
            'y_label' => 'Stav batérie',
        ];
        $data[] = [
            'name' => 'Počet nabitých vozidiel',
            'comment' => 'Možnosť určiť dĺžku časových intervalov alebo zadefinovať časové intervaly pre ranné, obedné, večerné a nočné hodiny',
            'table' => 'schedules',
            'type' => 'chargers-stat-interval-count-Selection',
            'x_label' => 'Indexy nabíjačiek',
            'y_label' => 'Nabité vozidlá',
        ];
        $data[] = [
            'name' => 'Dĺžka nabíjania',
            'comment' => 'Možnosť určiť dĺžku časových intervalov alebo zadefinovať časové intervaly pre ranné, obedové, večerné a nočné hodiny',
            'table' => 'charger_tasks',
            'type' => 'chargers-stat-interval-length-Selection',
            'x_label' => 'Indexy nabíjačiek',
            'y_label' => 'Čas v minútach',
        ];
        Stat::insert($data);
    }
}
