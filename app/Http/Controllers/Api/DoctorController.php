<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    /** Liste des médecins actifs */
    public function index(Request $request): JsonResponse
    {
        $doctors = Doctor::where('is_active', true)
            ->with('user')
            ->when($request->search, function ($q) use ($request) {
                $q->where(function ($inner) use ($request) {
                    $inner->whereHas('user', fn($u) => $u->where('name', 'like', "%{$request->search}%"))
                          ->orWhere('specialite', 'like', "%{$request->search}%");
                });
            })
            ->get()
            ->map(fn($d) => [
                'id'                 => $d->id,
                'name'               => $d->user->full_name,
                'specialite'         => $d->specialite,
                'bio'                => $d->bio,
                'tarif'              => $d->tarif,
                'duree_consultation' => $d->duree_consultation,
                'photo'              => $d->photo ? asset('storage/' . $d->photo) : null,
            ]);

        return response()->json(['success' => true, 'doctors' => $doctors]);
    }

    /** Détail d'un médecin */
    public function show($id): JsonResponse
    {
        $doctor = Doctor::with('user', 'schedules')
            ->where('is_active', true)
            ->findOrFail($id);

        return response()->json(['success' => true, 'doctor' => $doctor]);
    }

    /** Créneaux disponibles pour une date donnée */
    public function availableSlots(Request $request, $id): JsonResponse
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
        ]);

        $doctor = Doctor::findOrFail($id);
        $slots  = $doctor->availableSlots($request->date);

        return response()->json(['success' => true, 'slots' => $slots]);
    }
}
