<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\SendAppointmentReminderJob;
use App\Mail\AppointmentConfirmation;
use App\Models\Appointment;
use App\Models\Doctor;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AppointmentController extends Controller
{
    /** Liste des rendez-vous du patient connecté */
    public function index(Request $request): JsonResponse
    {
        $appointments = Appointment::where('patient_id', $request->user()->id)
            ->with('doctor.user')
            ->orderByDesc('date_rdv')
            ->get();

        return response()->json(['success' => true, 'appointments' => $appointments]);
    }

    /** Réservation d'un rendez-vous */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'doctor_id' => 'required|exists:medecins,id',
            'date_rdv'  => 'required|date|after_or_equal:today',
            'heure_rdv' => 'required|date_format:H:i',
            'motif'     => 'nullable|string|max:500',
        ]);

        // Vérification double booking
        $exists = Appointment::where('medecin_id', $request->doctor_id)
            ->where('date_rdv', $request->date_rdv)
            ->where('heure_rdv', $request->heure_rdv)
            ->whereNotIn('statut', ['annule'])
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Ce créneau est déjà réservé. Veuillez choisir un autre horaire.',
            ], 409);
        }

        $doctor      = Doctor::findOrFail($request->doctor_id);
        $appointment = Appointment::create([
            'patient_id'    => $request->user()->id,
            'medecin_id'    => $doctor->id,
            'date_rdv'      => $request->date_rdv,
            'heure_rdv'     => $request->heure_rdv,
            'duree'         => $doctor->duree_consultation ?? 30,
            'statut'        => 'programme',
            'motif'         => $request->motif,
            'date_creation' => now(),
        ]);

        try {
            Mail::to($request->user()->email)
                ->send(new AppointmentConfirmation($appointment->load('doctor.user', 'patient')));
        } catch (\Exception $e) {
            // Ne bloque pas si le mail échoue
        }

        // Planifie le rappel 24h avant (via queue)
        $reminderAt = Carbon::parse($request->date_rdv . ' ' . $request->heure_rdv)->subDay();
        if ($reminderAt->isFuture()) {
            SendAppointmentReminderJob::dispatch($appointment)->delay($reminderAt);
        }

        return response()->json([
            'success'     => true,
            'message'     => 'Rendez-vous créé avec succès.',
            'appointment' => $appointment->load('doctor.user'),
        ], 201);
    }

    /** Mise à jour d'un rendez-vous */
    public function update(Request $request, $id): JsonResponse
    {
        $appointment = Appointment::where('id', $id)
            ->where('patient_id', $request->user()->id)
            ->firstOrFail();

        $request->validate([
            'date_rdv'  => 'sometimes|date|after_or_equal:today',
            'heure_rdv' => 'sometimes|date_format:H:i',
            'motif'     => 'nullable|string|max:500',
        ]);

        $appointment->update($request->only('date_rdv', 'heure_rdv', 'motif'));

        return response()->json(['success' => true, 'appointment' => $appointment]);
    }

    /** Annulation d'un rendez-vous */
    public function cancel($id): JsonResponse
    {
        $appointment = Appointment::where('id', $id)
            ->where('patient_id', request()->user()->id)
            ->firstOrFail();

        $appointment->update(['statut' => 'annule']);

        return response()->json(['success' => true, 'message' => 'Rendez-vous annulé.']);
    }
}
