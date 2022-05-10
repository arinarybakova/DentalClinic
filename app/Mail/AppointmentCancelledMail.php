<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentCancelledMail extends Mailable
{
    use Queueable, SerializesModels;

    /** @var Appointment */
    private $appointment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Appointment $appointment)
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
        
        return $this->markdown('emails.appointment-cancelled', $data);
    }
}
