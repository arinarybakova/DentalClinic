<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index()
    {
        return view('user.appointments');
    }

    public function appointments(Request $request)
    {
        if ($request->get('page') !== null && Auth::hasUser()) {
            $limit = $request->get('limit') ?? 10;
            $appointments = Appointment::select(
                'appointments.*',
                DB::raw('DATE(appointments.time_from) as date'),
                DB::raw('CONCAT(TIME_FORMAT(TIME(appointments.time_from), "%H:%i"), " - ", 
                    TIME_FORMAT(TIME(appointments.time_to), "%H:%i")) as time'),
                DB::raw('CONCAT(dentist.firstname, " ", dentist.lastname) as dentist')
            )
                ->join('users as dentist', 'dentist.id', '=', 'appointments.fk_dentist')
                ->where('fk_patient', '=', Auth::user()->id);

            if ($request->get('filter') !== null) {
                $appointments->where('CONCAT(dentist.firstname, " ", dentist.lastname)', 'LIKE', '%' . $this->escape_like($request->get('filter')) .  '%')
                    ->orWhere('time_from', 'LIKE', '%' . $this->escape_like($request->get('filter')) .  '%')
                    ->orderBy('status');
            } else {
                $appointments->orderBy('time_from');
            }
            $pagination = $appointments->paginate($limit)->toArray();
            $appointments = $pagination['data'];
            $total = $pagination['total'];
        } else {
            $appointments = [];
            $total = 0;
        }
        return ['appointments' => $appointments, 'total' => $total];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Appointment $appointment)
    {
        return response()->json($appointment);
    }

    public function store(Request $request)
    {
        if (!$this->validateStore($request->post())) {
            return response()->json([
                'success'   => false,
                'appointment' => []
            ]);
        }
        try {
            $appointment = Appointment::create($this->parseStore($request->post()));
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json([
                'success'   => false,
                'appointment' => []
            ]);
        }
        return response()->json([
            'success'   => true,
            'appointment' => $appointment
        ]);
    }

    protected function parseStore($post): array
    {
        return [
            'fk_patient' => Auth::user()->id,
            'fk_dentist' => $post['doctor'],
            'time_from' => $post['date'] . " " . $post['time'],
            'time_to' => $post['date'] . " " . $this->getTimeTo($post['time']),
            'status' => ''
        ];
    }

    protected function getTimeTo($time): string {
        $timeExploded = explode(":", $time);
        return ((int)$timeExploded[0] !== 23 ? (int)$timeExploded[0] + 1 : 0) . ":" . $timeExploded[1];
    }

    /** @todo add validation with other appointments */
    protected function validateStore($post): bool
    {
        $requiredKeys = ['doctor', 'date', 'time'];
        if (count(array_diff_key($post, $requiredKeys)) !== count($requiredKeys) 
            || !Auth::hasUser()) {
            return false;
        }

        $dateTime = $post['date'] . " " . $post['time'];
        $timeTo = $this->getTimeTo($post['time']);
        $dateTimeTo = $post['date'] . " " . $timeTo;

        $scheduleCount = Schedule::where('fk_dentist', '=', $post['doctor'])
            ->where('work_time_from', "<=", $dateTime)
            ->where('work_time_to', ">=", $dateTimeTo)
            ->count();

        return $scheduleCount > 0;
    }
}
