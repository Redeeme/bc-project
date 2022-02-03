<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GanttTask extends Model
{
    use HasFactory;
    protected $fillable = ['processid', 'start', 'end','label'];
}
