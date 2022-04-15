<?php

namespace App\Http\Controllers\Dentist;
use App\Http\Controllers\Controller;
use App\Models\Schedule;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * @todo add schedule remove functionality
     */
    public function index()
    {
        return view('dentist.schedule');
    }

    public function schedules(Request $request)
    {
        if(isset($request->start)) {
            $dateFrom = date('Y-m-d', strtotime($request->start . " monday this week"));
            $dateTo = date('Y-m-d', strtotime($request->start . " sunday this week"));
        } else {
            $dateFrom = date('Y-m-d', strtotime('monday this week'));
            $dateTo = date('Y-m-d', strtotime('sunday this week'));
        }
        $schedules = DB::table('schedule')
            ->join('users', 'users.id', '=', 'schedule.fk_dentist')
            ->select(
                'schedule.*', 
                DB::raw('UNIX_TIMESTAMP(schedule.work_time_from) as time_from'),
                DB::raw('UNIX_TIMESTAMP(schedule.work_time_to) as time_to'),
                DB::raw('CONCAT(users.firstname, " ", users.lastname) AS doctor')
                )
            ->where('schedule.work_time_from', '>=', $dateFrom)
            ->where('schedule.work_time_to', '<=', $dateTo)
            ->get();
        return $schedules;
    }
    
    protected function parseData(array $post) 
    {
        return [
            'work_days' => '',
            'work_time_from' => new DateTime($post['date'] . " " . $post['timeFrom']),
            'work_time_to' => new DateTime($post['date'] . " " . $post['timeTo']),
            'fk_dentist' => $post['fk_dentist']
        ];
    }
}
