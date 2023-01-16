<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    protected $primaryKey = 'schedule_id';

    public function stations()
    {
        return $this->belongsToMany(Station::class,'schedule_stations','schedule_id','station_id');
    }
}
