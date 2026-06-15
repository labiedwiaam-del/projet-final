<?php

namespace App\Jobs;

use App\Mail\AppointmentReminder;
use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

/**
 * Job déclenché après chaque réservation.
 * S'exécute automatiquement 24h avant le rendez-vous.
 * En production : utiliser un queue worker (php artisan queue:work).
 * En développement : QUEUE_CONNECTION=sync dans .env pour exécution immédiate.
 */
class SendAppointmentReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Nombre de tentatives max si le job échoue.
     */
    public int $tries = 3;

    /**
     * @param Appointment $appointment Le rendez-vous concerné
     */
    public function __construct(public Appointment $appointment) {}

    /**
     * Exécute le job : envoie l'email de rappel et marque reminder_sent = true.
     */
    public function handle(): void
    {
        // Recharger depuis la DB pour avoir les données fraîches
        $appointment = $this->appointment->fresh(['patient', 'doctor.user']);

        // Ne pas envoyer si le RDV a été annulé entre-temps
        if (!$appointment || $appointment->isCancelled()) {
            return;
        }

        // Ne pas renvoyer si déjà envoyé
        if ($appointment->reminder_sent) {
            return;
        }

        Mail::to($appointment->patient->email)
            ->send(new AppointmentReminder($appointment));

        $appointment->update(['reminder_sent' => true]);
    }
}
