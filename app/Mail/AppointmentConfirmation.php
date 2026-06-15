<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Appointment $appointment) {}

    public function build(): static
    {
        return $this->subject('Demande de rendez-vous enregistrée — ' . config('app.name'))
            ->view('emails.appointment-confirmation');
    }
}
