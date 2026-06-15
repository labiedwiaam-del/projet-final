<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $table = 'medecins';

    protected $fillable = [
        'user_id',
        'specialite',
        'bio',
        'photo',
        'is_active',
        'numero_licence',
        'duree_consultation',
        'tarif',
    ];

    protected $casts = [
        'is_active'         => 'boolean',
        'duree_consultation' => 'integer',
        'tarif'             => 'decimal:2',
    ];

    /** Relation : profil utilisateur du médecin */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** Relation : rendez-vous du médecin */
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'medecin_id');
    }

    /** Relation : plannings hebdomadaires */
    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'medecin_id');
    }

    /**
     * Génère les créneaux disponibles pour une date donnée.
     * Retourne un tableau de ['time' => 'HH:MM', 'available' => bool]
     */
    public function availableSlots(string $date): array
    {
        // Convertit la date en nom de jour (lundi, mardi, etc.)
        $jourMap = [
            'Monday'    => 'lundi',
            'Tuesday'   => 'mardi',
            'Wednesday' => 'mercredi',
            'Thursday'  => 'jeudi',
            'Friday'    => 'vendredi',
            'Saturday'  => 'samedi',
            'Sunday'    => 'dimanche',
        ];

        $dayEnglish = Carbon::parse($date)->format('l');
        $jourFr     = $jourMap[$dayEnglish] ?? strtolower($dayEnglish);

        $schedule = $this->schedules()
            ->where('jour_semaine', $jourFr)
            ->where('actif', true)
            ->first();

        if (!$schedule) {
            return [];
        }

        $slots      = [];
        $slotMinutes = $schedule->slot_duration ?? 30;
        $current    = Carbon::parse($date . ' ' . $schedule->heure_debut);
        $end        = Carbon::parse($date . ' ' . $schedule->heure_fin);

        while ($current->lt($end)) {
            $time = $current->format('H:i');

            // Vérifie si ce créneau est déjà réservé
            $booked = $this->appointments()
                ->where('date_rdv', $date)
                ->where('heure_rdv', $time)
                ->whereNotIn('statut', ['annule'])
                ->exists();

            $slots[] = [
                'time'      => $time,
                'available' => !$booked,
            ];

            $current->addMinutes($slotMinutes);
        }

        return $slots;
    }
}
