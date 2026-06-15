<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    /** Liste des médecins disponibles pour les patients */
    public function index(Request $request)
    {
        $doctors = Doctor::where('is_active', true)
            ->with('user')
            ->when($request->search, function ($q) use ($request) {
                // Search within the constraint so it doesn't escape the is_active scope
                $q->where(function ($inner) use ($request) {
                    $inner->whereHas('user', fn($u) => $u->where('name', 'like', "%{$request->search}%"))
                          ->orWhere('specialite', 'like', "%{$request->search}%");
                });
            })
            ->get();

        return view('patient.doctors.index', compact('doctors'));
    }
}
