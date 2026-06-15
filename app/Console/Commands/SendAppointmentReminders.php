<?php

namespace App\Console\Commands;

use App\Mail\AppointmentReminder;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendAppointmentReminders extends Command
{
    protected $signature   = 'appointments:send-reminders';
    protected $description = 'Envoie des rappels par email 24h avant chaque rendez-vous confirmé.';

    public function handle(): void
    {
        $tomorrow = Carbon::tomorrow()->toDateString();

        $appointments = Appointment::where('date_rdv', $tomorrow)
            ->where('statut', 'confirme')
            ->where('reminder_sent', false)
            ->with('patient', 'doctor.user')
            ->get();

        foreach ($appointments as $appointment) {
            try {
                Mail::to($appointment->patient->email)
                    ->send(new AppointmentReminder($appointment));

                $appointment->update(['reminder_sent' => true]);
                $this->info("Rappel envoyé à : {$appointment->patient->email}");
            } catch (\Exception $e) {
                $this->error("Erreur pour {$appointment->patient->email} : {$e->getMessage()}");
            }
        }

        $this->info("Total rappels envoyés : {$appointments->count()}");
    }
}
