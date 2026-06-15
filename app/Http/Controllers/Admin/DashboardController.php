<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\User;

class DashboardController extends Controller
{
    /** Tableau de bord principal de l'admin */
    public function index()
    {
        // Statistiques globales
        $stats = [
            'totalPatients'        => User::where('role', 'patient')->count(),
            'totalDoctors'         => User::where('role', 'medecin')->count(),
            'appointmentsMonth'    => Appointment::whereMonth('date_rdv', now()->month)->count(),
            'pendingAppointments'  => Appointment::where('statut', 'programme')->count(),
        ];

        // Graphique mensuel (12 derniers mois)
        $monthly = Appointment::selectRaw('MONTH(date_rdv) as month, COUNT(*) as total')
            ->whereYear('date_rdv', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        // 10 derniers rendez-vous
        $recentAppointments = Appointment::with('patient', 'doctor.user')
            ->orderByDesc('date_creation')
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'monthly', 'recentAppointments'));
    }

    /** Page statistiques détaillées */
    public function statistics()
    {
        $monthly = Appointment::selectRaw('MONTH(date_rdv) as month, COUNT(*) as total')
            ->whereYear('date_rdv', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $byStatus = Appointment::selectRaw('statut, COUNT(*) as total')
            ->groupBy('statut')
            ->pluck('total', 'statut');

        $topDoctors = \App\Models\Doctor::withCount('appointments')
            ->orderByDesc('appointments_count')
            ->take(5)
            ->with('user')
            ->get();

        return view('admin.statistics', compact('monthly', 'byStatus', 'topDoctors'));
    }
}
