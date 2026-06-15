<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /** Liste tous les rendez-vous avec filtres */
    public function index(Request $request)
    {
        $appointments = Appointment::with('patient', 'doctor.user')
            ->when($request->statut, fn($q) => $q->where('statut', $request->statut))
            ->when($request->doctor_id, fn($q) => $q->where('medecin_id', $request->doctor_id))
            ->when($request->date_from, fn($q) => $q->where('date_rdv', '>=', $request->date_from))
            ->when($request->date_to, fn($q) => $q->where('date_rdv', '<=', $request->date_to))
            ->orderByDesc('date_rdv')
            ->paginate(20);

        $doctors = Doctor::with('user')->where('is_active', true)->get();

        return view('admin.appointments.index', compact('appointments', 'doctors'));
    }

    /** Mise à jour du statut d'un rendez-vous */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'statut' => 'required|in:programme,confirme,annule,termine',
        ]);

        $appointment = Appointment::findOrFail($id);
        $appointment->update(['statut' => $request->statut]);

        // Si le statut passe à confirmé, envoyer un email au patient
        if ($request->statut === 'confirme') {
            try {
                $appointment->load('doctor.user', 'patient');
                \Illuminate\Support\Facades\Mail::to($appointment->patient->email)
                    ->send(new \App\Mail\AppointmentConfirmed($appointment));
            } catch (\Exception $e) {
                // Ne bloque pas si le mail échoue
            }
        }

        return back()->with('success', 'Statut mis à jour.');
    }

    /** Supprime un rendez-vous */
    public function destroy($id)
    {
        Appointment::findOrFail($id)->delete();
        return back()->with('success', 'Rendez-vous supprimé.');
    }
}
