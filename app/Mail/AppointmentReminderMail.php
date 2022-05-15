<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;

class AppointmentReminderMail extends Mailable implements ShouldQueue
{
    use Queueable;

    private $appointment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($appointment)
    {
        $this->appointment = $appointment;
        $this->build();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data['visitDate'] = $this->appointment['time_from'] ?? '';
        $data['visitDentist'] = sprintf("%s %s", ($this->appointment['firstname'] ?? ''), ($this->appointment['lastname'] ?? ''));

        $appointmentEntity = Appointment::find($this->appointment['id']);
        $appointmentEntity->reminder_sent = true;
        $appointmentEntity->save();

        return $this->markdown('emails.appointment-reminder', $data);
    }
}
