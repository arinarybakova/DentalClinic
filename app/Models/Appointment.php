<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $fillable = ['fk_patient', 'fk_dentist', 'time_from', 'time_to', 'fk_status', 'reminder_sent'];
}
