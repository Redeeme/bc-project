<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    use HasFactory;
    protected $primaryKey = 'station_id';

    public function charger()
    {
        return $this->belongsTo(Charger::class,'foreign_key');
    }

    public function stations()
    {
        return $this->belongsToMany(Schedule::class,'schedule_stations','station_id','schedule_id');
    }

}
