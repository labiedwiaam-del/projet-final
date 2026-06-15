<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Appointment $appointment) {}

    public function build(): static
    {
        $doctorName = $this->appointment->doctor->user->full_name ?? $this->appointment->doctor->user->name;

        return $this->subject('Rendez-vous confirmé ! — Dr. ' . $doctorName)
            ->view('emails.appointment-confirmed');
    }
}
