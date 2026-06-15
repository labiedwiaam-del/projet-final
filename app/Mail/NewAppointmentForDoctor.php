<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewAppointmentForDoctor extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Appointment $appointment) {}

    public function build(): static
    {
        $patientName = $this->appointment->patient->full_name ?? $this->appointment->patient->name;
        
        return $this->subject('Nouveau rendez-vous réservé — Patient : ' . $patientName)
            ->view('emails.new-appointment-doctor');
    }
}
