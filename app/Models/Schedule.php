<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'schedule';
    
    protected $fillable = [
        'work_days',
        'work_time_from',
        'work_time_to',
        'fk_dentist'
    ];
}
