<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Mail\AppointmentConfirmed;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class DashboardController extends Controller
{
    /** Tableau de bord du médecin */
    public function index(Request $request)
    {
        $doctor = $request->user()->doctor;

        $todayAppointments = Appointment::with('patient')
            ->where('medecin_id', $doctor->id)
            ->whereDate('date_rdv', today())
            ->orderBy('heure_rdv')
            ->get();

        $upcomingCount = Appointment::where('medecin_id', $doctor->id)
            ->where('date_rdv', '>', today())
            ->whereNotIn('statut', ['annule'])
            ->count();

        $nextPatient = $todayAppointments
            ->where('statut', '!=', 'annule')
            ->first();

        return view('doctor.dashboard', compact('doctor', 'todayAppointments', 'upcomingCount', 'nextPatient'));
    }

    /** Liste des rendez-vous du médecin avec filtres */
    public function appointments(Request $request)
    {
        $doctor = $request->user()->doctor;

        $appointments = Appointment::with('patient')
            ->where('medecin_id', $doctor->id)
            ->when($request->statut, fn($q) => $q->where('statut', $request->statut))
            ->when($request->date, fn($q) => $q->whereDate('date_rdv', $request->date))
            ->orderByDesc('date_rdv')
            ->paginate(15);

        return view('doctor.appointments.index', compact('appointments'));
    }

    /** Met à jour le statut d'un rendez-vous */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'statut' => 'required|in:confirme,annule,termine',
        ]);

        $doctor      = $request->user()->doctor;
        $appointment = Appointment::where('id', $id)
            ->where('medecin_id', $doctor->id)
            ->firstOrFail();

        $appointment->update(['statut' => $request->statut]);

        // Si le médecin confirme le rendez-vous, envoyer un email au patient
        if ($request->statut === 'confirme') {
            try {
                $appointment->load('doctor.user', 'patient');
                Mail::to($appointment->patient->email)
                    ->send(new AppointmentConfirmed($appointment));
            } catch (\Exception $e) {
                // Ne bloque pas si le mail échoue
            }
        }

        return back()->with('success', 'Statut mis à jour.');
    }
}
