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
            'comment' => 'pre každú nabíjačku pomer času nabíjania k celkovému dostupnému času',
            'table' => 'charger_tasks',
            'type' => 'chargers-stat-utilization',
        ];
        $data[] = [
            'name' => 'Počet pripnutí na nabíjačku',
            'comment' => 'Počet pripnutí na nabíjačku',
            'table' => 'schedules',
            'type' => 'schedules-stat-clip',
        ];
        $data[] = [
            'name' => 'Čas strávený nabíjaním',
            'comment' => 'Čas strávený nabíjaním',
            'table' => 'schedules',
            'type' => 'schedules-stat-charging',
        ];
        $data[] = [
            'name' => 'Pomer času nabíjania k času na spojoch',
            'comment' => 'Pomer času nabíjania k času na spojoch',
            'table' => 'schedules',
            'type' => 'schedules-stat-utilization',
        ];
        $data[] = [
            'name' => 'Počet obslúžených spojov',
            'comment' => 'Počet obslúžených spojov',
            'table' => 'schedules',
            'type' => 'schedules-stat-trips',
        ];
        $data[] = [
            'name' => 'Stav beterie podla vozidla',
            'comment' => 'Stav beterie podla vozidla',
            'table' => 'schedules',
            'type' => 'schedules-stat-batery',
        ];
        $data[] = [
            'name' => 'Pocet nabitych vozidel',
            'comment' => 'možnosť určiť dĺžku časových intervalov/zadefinovať časové intervaly pre ráno, obed, večer a noc',
            'table' => 'charger_tasks',
            'type' => 'chargers-stat-interval-count-Selection',
        ];
        $data[] = [
            'name' => 'Dlzka nabijania',
            'comment' => 'možnosť určiť dĺžku časových intervalov/zadefinovať časové intervaly pre ráno, obed, večer a noc',
            'table' => 'charger_tasks',
            'type' => 'chargers-stat-interval-length-Selection',
        ];
        Stat::insert($data);
    }
}
