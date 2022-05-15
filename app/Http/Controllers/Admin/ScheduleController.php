<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    /**
     * @todo add schedule remove functionality
     */
    public function index()
    {
        return view('admin.schedule');
    }

    public function schedules(Request $request)
    {
        if (isset($request->start)) {
            $dateFrom = date('Y-m-d', strtotime($request->start . " monday this week"));
            $dateTo = date('Y-m-d', strtotime($request->start . " wednesday next week"));
        } else {
            $dateFrom = date('Y-m-d', strtotime('monday this week'));
            $dateTo = date('Y-m-d', strtotime('wednesday next week'));
        }
        $query = DB::table('schedule')
            ->join('users', 'users.id', '=', 'schedule.fk_dentist')
            ->select(
                'schedule.*',
                DB::raw('UNIX_TIMESTAMP(schedule.work_time_from) as time_from'),
                DB::raw('UNIX_TIMESTAMP(schedule.work_time_to) as time_to'),
                DB::raw('CONCAT(users.firstname, " ", users.lastname) AS doctor')
            )
            ->where('schedule.work_time_from', '>=', $dateFrom)
            ->where('schedule.work_time_to', '<=', $dateTo);

        if ($this->isDentist()) {
            $query->where('users.id', '=', Auth::user()->id);
        }

        if (isset($request->doctors)) {
            $doctors = explode(",", $request->doctors);
            foreach ($doctors as $key => $doctor) {
                if ($doctor === '') {
                    unset($doctors[$key]);
                }
            }
            $query->whereIn('fk_dentist', $doctors);
        }

        $schedules = $query->get();
        return [
            'schedules' => $schedules,
            'isDentist' => $this->isDentist(),
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $schedule = Schedule::create($this->parseData($request->post()));
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json([
                'success'   => false,
                'event' => []
            ]);
        }
        return response()->json([
            'success'   => true,
            'event' => $schedule
        ]);
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(int $id, Request $request)
    {
        try {
            $schedule = Schedule::find($id);
            $schedule->fill($this->parseData($request->post()))->save();
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json([
                'success'   => false,
                'event' => []
            ]);
        }
        return response()->json([
            'success'   => true,
            'event' => $schedule
        ]);
    }
}
