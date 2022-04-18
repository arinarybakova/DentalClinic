<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller {
    public function index()
    {
        return view('user.appointments');
    }

    public function appointments(Request $request)
    {
        if ($request->get('page') !== null && Auth::hasUser()) {
            $limit = $request->get('limit') ?? 10;
            $appointments = Appointment::select('appointments.*',
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

}