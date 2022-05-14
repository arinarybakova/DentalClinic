<?php

namespace App\Http\Controllers\Admin;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Jobs\SendAppointmentCancelledEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentCancelledMail;

class AppointmentController extends Controller
{
    public function index()
    {
        return view('admin.appointments');
    }

    public function appointments(Request $request)
    {
        if ($request->get('page') !== null) {
            $limit = $request->get('limit') ?? 10;
            $appointments = Appointment::select(
                'appointments.*',
                'appointment_status.status',
                DB::raw('DATE(appointments.time_from) as date'),
                DB::raw('TIME_FORMAT(TIME(appointments.time_from), "%H:%i") as time'),
                DB::raw('CONCAT(patient.firstname, " ", patient.lastname) as patient'),
                DB::raw('CONCAT(dentist.firstname, " ", dentist.lastname) as dentist')
            )
                ->join('appointment_status', 'appointment_status.id', 'appointments.fk_status')
                ->join('users as patient', 'patient.id', '=', 'appointments.fk_patient')
                ->join('users as dentist', 'dentist.id', '=', 'appointments.fk_dentist');

            if ($this->isDentist()) {
                $appointments->where('fk_dentist', '=', Auth::user()->id);
            }

            /** @todo fix filter where clauses when user is dentist */
            if ($request->get('filter') !== null) {
                $appointments->where(DB::raw('CONCAT(dentist.firstname, " ", dentist.lastname)'), 'LIKE', '%' . $this->escape_like($request->get('filter')) .  '%')
                    ->orWhere(DB::raw('CONCAT(patient.firstname, " ", patient.lastname)'), 'LIKE', '%' . $this->escape_like($request->get('filter')) .  '%')
                    ->orWhere('time_from', 'LIKE', '%' . $this->escape_like($request->get('filter')) .  '%')
                    ->orderBy('fk_status');
            } else {
                $appointments->orderBy('fk_status', 'ASC');
            }
            $pagination = $appointments->paginate($limit)->toArray();
            $appointments = $pagination['data'];
            $total = $pagination['total'];
        } else {
            $appointments = [];
            $total = 0;
        }
        return [
            'appointments' => $appointments,
            'total' => $total,
            'isDentist' => $this->isDentist(),
        ];
    }

    public function appointmentEvents(Request $request)
    {
        if (isset($request->start)) {
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

        if ($this->isDentist()) {
            $query->where('d.id', '=', Auth::user()->id);
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

        if (isset($request->approved)) {
            $query->where('fk_status', '=', config('app.approved_status_id'));
        }

        $appointments = $query->get();
        return $appointments;
    }

    public function approve(int $id)
    {
        try {
            $appointment = Appointment::find($id);
            $appointment->fk_status = config('app.approved_status_id');
            $appointment->save();
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
    public function cancel($id)
    {
        try {
            $appointment = Appointment::find($id);
            $appointment->fk_status = config('app.canceled_status_id');
            $appointment->save();

            $appointment = Appointment::select('appointments.time_from', 'd.firstname', 'd.lastname', 'p.email')
                ->join('users as d', 'd.id', 'appointments.fk_dentist')
                ->join('users as p', 'p.id', 'appointments.fk_patient')
                ->where('appointments.id', '=', $id)
                ->first();

            Mail::to($appointment['email'])->queue(new AppointmentCancelledMail($appointment));
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
