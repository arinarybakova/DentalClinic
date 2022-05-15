<?php

namespace App\Jobs;

use Illuminate\Support\Carbon;
use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentReminderMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendAppointmentReminders implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $appointments = Appointment::select('appointments.id', 'appointments.time_from', 'd.firstname', 'd.lastname', 'p.email')
            ->join('users as d', 'appointments.fk_dentist', 'd.id')
            ->join('users as p', 'appointments.fk_patient', 'p.id')
            ->where('reminder_sent', false)
            ->whereDate('time_from', '<=', Carbon::make('+1 day'))
            ->whereDate('time_from', '>=', Carbon::make('now'))
            ->get();

        foreach($appointments as $appointment) {
            Mail::to($appointment['email'])->queue(new AppointmentReminderMail($appointment));
        }
    }
}
