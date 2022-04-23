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

    public function appointmentEvents(Request $request)
    {
        if(isset($request->start)) {
            $dateFrom = date('Y-m-d', strtotime($request->start . " monday this week"));
            $dateTo = date('Y-m-d', strtotime($request->start . " sunday this week"));
        } else {
            $dateFrom = date('Y-m-d', strtotime('monday this week'));
            $dateTo = date('Y-m-d', strtotime('sunday this week'));
        }
        $query = DB::table('appointments')
            ->join('users as d', 'd.id', '=', 'appointments.fk_dentist')
            ->join('users as p', 'p.id', '=', 'appointments.fk_patient')
            ->select(
                'appointments.*', 
                DB::raw('UNIX_TIMESTAMP(appointments.time_from) as time_from'),
                DB::raw('UNIX_TIMESTAMP(appointments.time_to) as time_to'),
                DB::raw('CONCAT(d.firstname, " ", d.lastname) AS doctor'),
                DB::raw('CONCAT(p.firstname, " ", p.lastname) AS patient')
                )
            ->where('appointments.time_from', '>=', $dateFrom)
            ->where('appointments.time_to', '<=', $dateTo);

        if(isset($request->doctors)) {
            $doctors = explode(",", $request->doctors);
            foreach($doctors as $key => $doctor) {
                if($doctor === '') {
                    unset($doctors[$key]);
                }
            }
            $query->whereIn('fk_dentist', $doctors);
        }

        $appointments = $query->get();
        return $appointments;
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