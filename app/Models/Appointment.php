<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'rendez_vous';

    public $timestamps = false;

    protected $fillable = [
        'patient_id',
        'medecin_id',
        'date_rdv',
        'heure_rdv',
        'duree',
        'statut',
        'motif',
        'notes',
        'reminder_sent',
        'date_creation',
    ];

    protected $casts = [
        'date_rdv'      => 'date',
        'heure_rdv'     => 'string',
        'date_creation' => 'datetime',
        'reminder_sent' => 'boolean',
    ];

    /** Relation : patient (utilisateur) */
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    /** Relation : médecin */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'medecin_id');
    }

    /** Vérifie si le statut est "programmé" (en attente) */
    public function isPending(): bool
    {
        return $this->statut === 'programme';
    }

    /** Vérifie si le statut est "confirmé" */
    public function isConfirmed(): bool
    {
        return $this->statut === 'confirme';
    }

    /** Vérifie si le statut est "annulé" */
    public function isCancelled(): bool
    {
        return $this->statut === 'annule';
    }

    /** Vérifie si le rendez-vous est à venir */
    public function isUpcoming(): bool
    {
        return $this->date_rdv->isFuture() && !$this->isCancelled();
    }

    /**
     * Retourne le libellé du statut en français avec la couleur Tailwind correspondante.
     * Ex: ['label' => 'Programmé', 'color' => 'yellow']
     */
    public function getStatusBadge(): array
    {
        return match ($this->statut) {
            'programme' => ['label' => 'Programmé',   'color' => 'yellow'],
            'confirme'  => ['label' => 'Confirmé',    'color' => 'green'],
            'annule'    => ['label' => 'Annulé',      'color' => 'red'],
            'termine'   => ['label' => 'Terminé',     'color' => 'blue'],
            default     => ['label' => ucfirst($this->statut), 'color' => 'gray'],
        };
    }
}
