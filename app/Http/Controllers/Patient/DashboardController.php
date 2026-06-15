<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /** Tableau de bord du patient */
    public function index(Request $request)
    {
        $user = $request->user();

        // Prochain rendez-vous à venir
        $nextAppointment = Appointment::where('patient_id', $user->id)
            ->where('date_rdv', '>=', today())
            ->whereNotIn('statut', ['annule'])
            ->with('doctor.user')
            ->orderBy('date_rdv')
            ->orderBy('heure_rdv')
            ->first();

        // Statistiques personnelles
        $stats = [
            'total'    => Appointment::where('patient_id', $user->id)->count(),
            'annule'   => Appointment::where('patient_id', $user->id)->where('statut', 'annule')->count(),
            'a_venir'  => Appointment::where('patient_id', $user->id)->where('date_rdv', '>=', today())->whereNotIn('statut', ['annule'])->count(),
        ];

        // 5 derniers rendez-vous
        $recentAppointments = Appointment::where('patient_id', $user->id)
            ->with('doctor.user')
            ->orderByDesc('date_rdv')
            ->take(5)
            ->get();

        return view('patient.dashboard', compact('nextAppointment', 'stats', 'recentAppointments'));
    }
}
