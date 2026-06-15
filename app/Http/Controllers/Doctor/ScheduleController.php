<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /** Affiche le planning hebdomadaire du médecin */
    public function index(Request $request)
    {
        $doctor    = $request->user()->doctor;
        $jours     = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'];

        // Charge les plannings existants, indexés par jour
        $schedules = Schedule::where('medecin_id', $doctor->id)
            ->get()
            ->keyBy('jour_semaine');

        return view('doctor.schedules.index', compact('schedules', 'jours'));
    }

    /**
     * Enregistre ou met à jour les plannings hebdomadaires.
     * Le formulaire envoie un tableau "schedules[lundi][heure_debut]", etc.
     */
    public function store(Request $request)
    {
        // Pas de validation stricte sur le format — on nettoie directement
        $doctor = $request->user()->doctor;
        $jours  = ['lundi','mardi','mercredi','jeudi','vendredi','samedi','dimanche'];

        foreach ($jours as $jour) {
            $data   = $request->input("schedules.{$jour}", []);
            $actif  = isset($data['actif']);

            // Valeurs par défaut si le champ est absent ou vide
            $debut    = !empty($data['heure_debut'])   ? $data['heure_debut']   : '09:00';
            $fin      = !empty($data['heure_fin'])      ? $data['heure_fin']      : '17:00';
            $duration = !empty($data['slot_duration'])  ? (int)$data['slot_duration'] : 30;

            // Normaliser au format H:i (supprimer les secondes si présentes ex: 09:00:00)
            $debut = substr($debut, 0, 5);
            $fin   = substr($fin,   0, 5);

            Schedule::updateOrCreate(
                ['medecin_id' => $doctor->id, 'jour_semaine' => $jour],
                [
                    'heure_debut'   => $debut,
                    'heure_fin'     => $fin,
                    'slot_duration' => $duration,
                    'actif'         => $actif,
                ]
            );
        }

        return back()->with('success', 'Planning mis à jour avec succès.');
    }
}
