<?php

namespace App\Http\Controllers\Frontend;

use DateTime;
use DateInterval;
use DateTimeZone;
use App\Models\Schedule;
use App\Models\Appointment;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Request;

class ReservationController extends Controller
{
    public function index()
    {
        return view('user.reservation');
    }

    public function availableTimes(Request $request)
    {
        if (
            $request->get('doctor') !== null
            && $request->get('dateFrom') !== null
            && $request->get('dateTo') !== null
        ) {
            $dateTo = new DateTime($request->get('dateTo'));
            if ($dateTo !== null) {
                $dateTo->modify('+1 day');

                $schedules = Schedule::where('fk_dentist', '=', $request->get('doctor'))
                    ->where('work_time_from', '>=', $request->get('dateFrom'))
                    ->where('work_time_from', '>=', date('Y-m-d'))
                    ->where('work_time_from', '<=', $dateTo)->get();
                $times = [];

                foreach ($schedules as $schedule) {
                    $scheduleData = $schedule->toArray();
                    $date = new DateTime($scheduleData['work_time_from']);
                    $times[$date->format('Y-m-d')] = $this->getTimesFromSchedule($scheduleData);
                }

                $appointments = Appointment::select('time_from', 'time_to')
                    ->where('fk_status', '!=', config('app.canceled_status_id'))
                    ->where('fk_dentist', '=', $request->get('doctor'))
                    ->where('time_from', '>=', $request->get('dateFrom'))
                    ->where('time_from', '>=', date('Y-m-d'))
                    ->where('time_from', '<=', $request->get('dateTo'))
                    ->get()->toArray();
                $times = $this->calculateExcludedTimes($times, $appointments);

                return $times;
            }
        }

        return [];
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
            if ($key !== false) {
                unset($times[$date][$key]);
            }
        }
        return $times;
    }

    protected function getTimesFromSchedule(array $schedule)
    {
        $from = new DateTime($schedule['work_time_from'], new DateTimeZone(config('app.timezone')));
        $to = new DateTime($schedule['work_time_to'], new DateTimeZone(config('app.timezone')));
        $diff = date_diff($to, $from)->h;

        $result = [];
        if ($from->format('Y-m-d H:i:s') > date('Y-m-d H:i:s')) {
            $result[] = $from->format('H:i');
        }
        for ($i = 1; $i < $diff; $i++) {
            $from->modify('+1 hour');
            if ($from->format('Y-m-d H:i:s') > date('Y-m-d H:i:s')) {
                $result[] = $from->format('H:i');
            }
        }
        return $result;
    }
}
