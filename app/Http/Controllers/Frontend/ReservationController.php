<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use DateTime;
use Illuminate\Support\Facades\Date;
use Symfony\Component\HttpFoundation\Request;

class ReservationController extends Controller {
    public function index()
    {
        return view('user.reservation');
    }

    public function availableTimes(Request $request)
    {
        if ($request->get('doctor') !== null) {
            $schedules = Schedule::where('fk_dentist', '=', $request->get('doctor'))->get();
            $times = [];
            
            foreach($schedules as $schedule) {
                $scheduleData = $schedule->toArray();
                $date = new DateTime($scheduleData['work_time_from']);
                $times[$date->format('Y-m-d')] = $this->getTimesFromSchedule($scheduleData);
            }
            
            return $times;
        }
    }

    protected function getTimesFromSchedule(array $schedule) {
        $from = new DateTime($schedule['work_time_from']);
        $to = new DateTime($schedule['work_time_to']);
        $diff = date_diff($to, $from)->h;
        
        $result = [];
        $result[] = $from->format('H:i');
        for($i = 1; $i < $diff; $i++) {
            $result[] = $from->modify('+1 hour')->format('H:i');
        }
        return $result;
    }
}