<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        return view('admin.schedule');
    }

    public function schedules()
    {
        $schedules = DB::table('schedule')
            ->join('users', 'users.id', '=', 'schedule.fk_dentist')
            ->select(
                'schedule.*', 
                DB::raw('UNIX_TIMESTAMP(schedule.work_time_from) as time_from'),
                DB::raw('UNIX_TIMESTAMP(schedule.work_time_to) as time_to'),
                DB::raw('CONCAT(users.firstname, " ", users.lastname) AS doctor')
                )
            ->get();
        return $schedules;
    }
}
