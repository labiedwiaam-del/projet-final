<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $table = 'plannings';

    protected $fillable = [
        'medecin_id',
        'jour_semaine',
        'heure_debut',
        'heure_fin',
        'slot_duration',
        'actif',
    ];

    protected $casts = [
        'actif'         => 'boolean',
        'slot_duration' => 'integer',
    ];

    /** Relation : médecin propriétaire de ce planning */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'medecin_id');
    }
}
