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

    public function appointment(Request $request)
    {
        $appointments = Appointment::orderBy('date')->get();
        return $appointments->toArray();
    }
}