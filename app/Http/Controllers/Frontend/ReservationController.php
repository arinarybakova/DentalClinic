<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Schedule;
use DateTime;
use Illuminate\Support\Facades\Date;
use Symfony\Component\HttpFoundation\Request;

class ReservationController extends Controller
{
    public function index()
    {
        return view('user.reservation');
    }

    public function availableTimes(Request $request)
    {
        if ($request->get('doctor') !== null 
            && $request->get('dateFrom') !== null
            && $request->get('dateTo') !== null) {
            $schedules = Schedule::where('fk_dentist', '=', $request->get('doctor'))
                ->where('work_time_from', '>=', $request->get('dateFrom'))
                ->where('work_time_from', '>=', date('Y-m-d'))
                ->where('work_time_from', '<=', $request->get('dateTo'))->get();
            $times = [];

            foreach ($schedules as $schedule) {
                $scheduleData = $schedule->toArray();
                $date = new DateTime($scheduleData['work_time_from']);
                $times[$date->format('Y-m-d')] = $this->getTimesFromSchedule($scheduleData);
            }

            $appointments = Appointment::select('time_from', 'time_to')
                ->where('fk_dentist', '=', $request->get('doctor'))
                ->where('time_from', '>=', $request->get('dateFrom'))
                ->where('time_from', '>=', date('Y-m-d'))
                ->where('time_from', '<=', $request->get('dateTo'))
                ->get()->toArray();
            $times = $this->calculateExcludedTimes($times, $appointments);

            return $times;
        }
    }

    protected function calculateExcludedTimes(array $times, array $appointments): array
    {
        /** @var Appointment $appointment */
        foreach ($appointments as $appointment) {
            $exploded = explode(" ", $appointment['time_from']);
            if (!isset($exploded[1])) {
                continue;
            }
            $date = $exploded[0];
            $timeExploded = explode(":", $exploded[1]);
            if (!isset($timeExploded[0]) || !isset($timeExploded[1])) {
                continue;
            }
            $time = sprintf('%s:%s', $timeExploded[0], $timeExploded[1]);
            $key = array_search($time, $times[$date]);
            if ($key) {
                unset($times[$date][$key]);
            }
        }
        return $times;
    }

    protected function getTimesFromSchedule(array $schedule)
    {
        $from = new DateTime($schedule['work_time_from']);
        $to = new DateTime($schedule['work_time_to']);
        $diff = date_diff($to, $from)->h;

        $result = [];
        $result[] = $from->format('H:i');
        for ($i = 1; $i < $diff; $i++) {
            $result[] = $from->modify('+1 hour')->format('H:i');
        }
        return $result;
    }
}
