<?php

namespace App\Http\Controllers\Admin;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller {
    public function index()
    {
        return view('admin.appointments');
    }

    public function appointments(Request $request)
    {
        if ($request->get('page') !== null) {
            $limit = $request->get('limit') ?? 10;
            $appointments = Appointment::select('appointments.*',
                    DB::raw('DATE(appointments.time_from) as date'),
                    DB::raw('TIME_FORMAT(TIME(appointments.time_from), "%H:%i") as time'),
                    DB::raw('CONCAT(patient.firstname, " ", patient.lastname) as patient'),
                    DB::raw('CONCAT(dentist.firstname, " ", dentist.lastname) as dentist')
                )
                ->join('users as patient', 'patient.id', '=', 'appointments.fk_patient')
                ->join('users as dentist', 'dentist.id', '=', 'appointments.fk_dentist');

            if ($request->get('filter') !== null) {
                $appointments->where(DB::raw('CONCAT(dentist.firstname, " ", dentist.lastname)'), 'LIKE', '%' . $this->escape_like($request->get('filter')) .  '%')
                    ->orWhere(DB::raw('CONCAT(patient.firstname, " ", patient.lastname)'), 'LIKE', '%' . $this->escape_like($request->get('filter')) .  '%')
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