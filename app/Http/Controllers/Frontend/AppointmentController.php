<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AppointmentController extends Controller {
    public function index()
    {
        return view('user.appointments');
    }

    public function appointments(Request $request)
    {
        if ($request->get('page') !== null) {
            $limit = $request->get('limit') ?? 10;
            if ($request->get('filter') !== null) {
                $appointments = Appointment::where('dentist', 'LIKE', '%' . $this->escape_like($request->get('filter')) .  '%')
                    ->orWhere('date', 'LIKE', '%' . $this->escape_like($request->get('filter')) .  '%')
                    ->orWhere('time', 'LIKE', '%' . $this->escape_like($request->get('filter')) .  '%')
                    ->orderBy('status');
            } else {
                $appointments = Appointment::orderBy('date');
            }
            $pagination = $appointments->paginate($limit)->toArray();
            $appointments = $pagination['data'];
            $total_pages = $pagination['to'];
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