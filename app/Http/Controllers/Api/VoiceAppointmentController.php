<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class VoiceAppointmentController extends Controller
{
    /**
     * Reçoit les données de l'assistant vocal ElevenLabs et crée le rendez-vous.
     * Webhook URL: POST /api/voice/save-appointment
     */
    public function save(Request $request): JsonResponse
    {
        $data = $request->validate([
            'first_name'   => 'required|string|max:100',
            'last_name'    => 'required|string|max:100',
            'phone'        => 'required|string|max:20',
            'email'        => 'required|email',
            'date_rdv'     => 'required|date|after_or_equal:today',
            'heure_rdv'    => 'required',
            'doctor_id'    => 'required|exists:medecins,id',
        ]);

        // Crée le patient si c'est sa première fois
        $user = User::firstOrCreate(
            ['email' => $data['email']],
            [
                'prenom'    => $data['first_name'],
                'nom'       => $data['last_name'],
                'telephone' => $data['phone'],
                'password'  => Hash::make(Str::random(16)),
                'role'      => 'patient',
            ]
        );

        // Vérifie le double booking
        $exists = Appointment::where('medecin_id', $data['doctor_id'])
            ->where('date_rdv', $data['date_rdv'])
            ->where('heure_rdv', $data['heure_rdv'])
            ->whereNotIn('statut', ['annule'])
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Ce créneau est déjà réservé.',
            ], 409);
        }

        $appointment = Appointment::create([
            'patient_id'    => $user->id,
            'medecin_id'    => $data['doctor_id'],
            'date_rdv'      => $data['date_rdv'],
            'heure_rdv'     => $data['heure_rdv'],
            'duree'         => 30,
            'statut'        => 'programme',
            'date_creation' => now(),
        ]);

        return response()->json([
            'success'     => true,
            'message'     => 'Rendez-vous enregistré par l\'assistant vocal.',
            'appointment' => $appointment,
            'patient'     => $user,
        ], 201);
    }
}
