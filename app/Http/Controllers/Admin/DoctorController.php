<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DoctorController extends Controller
{
    /** Liste des médecins */
    public function index(Request $request)
    {
        $doctors = Doctor::with('user')
            ->withCount('appointments')
            ->when($request->search, fn($q) => $q->whereHas('user',
                fn($u) => $u->where('name', 'like', "%{$request->search}%"))
                ->orWhere('specialite', 'like', "%{$request->search}%"))
            ->paginate(15);

        return view('admin.doctors.index', compact('doctors'));
    }

    /** Formulaire de création d'un médecin */
    public function create()
    {
        return view('admin.doctors.create');
    }

    /** Enregistre un nouveau médecin + son compte utilisateur */
    public function store(Request $request)
    {
        $request->validate([
            'prenom'             => 'required|string|max:100',
            'nom'                => 'required|string|max:100',
            'email'              => 'required|email|unique:users',
            'telephone'          => 'nullable|string|max:20',
            'password'           => 'required|min:8|confirmed',
            'specialite'         => 'required|string|max:100',
            'bio'                => 'nullable|string|max:1000',
            'numero_licence'     => 'required|string|max:50',
            'duree_consultation' => 'required|integer|min:10|max:120',
            'tarif'              => 'required|numeric|min:0',
            'photo'              => 'nullable|image|max:2048',
        ]);

        $user = User::create([
            'prenom'    => $request->prenom,
            'nom'       => $request->nom,
            'email'     => $request->email,
            'telephone' => $request->telephone,
            'role'      => 'medecin',
            'password'  => Hash::make($request->password),
        ]);

        $photoPath = $request->hasFile('photo')
            ? $request->file('photo')->store('doctors', 'public')
            : null;

        Doctor::create([
            'user_id'            => $user->id,
            'specialite'         => $request->specialite,
            'bio'                => $request->bio,
            'numero_licence'     => $request->numero_licence,
            'duree_consultation' => $request->duree_consultation,
            'tarif'              => $request->tarif,
            'photo'              => $photoPath,
            'is_active'          => true,
        ]);

        return redirect()->route('admin.doctors.index')->with('success', 'Médecin créé avec succès.');
    }

    public function show(Doctor $doctor)
    {
        $doctor->load('user', 'schedules', 'appointments');
        return view('admin.doctors.show', compact('doctor'));
    }

    public function edit(Doctor $doctor)
    {
        $doctor->load('user');
        return view('admin.doctors.edit', compact('doctor'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'specialite'         => 'required|string|max:100',
            'bio'                => 'nullable|string|max:1000',
            'numero_licence'     => 'required|string|max:50',
            'duree_consultation' => 'required|integer|min:10|max:120',
            'tarif'              => 'required|numeric|min:0',
            'is_active'          => 'sometimes|boolean',
            'photo'              => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($doctor->photo) {
                Storage::disk('public')->delete($doctor->photo);
            }
            $doctor->photo = $request->file('photo')->store('doctors', 'public');
        }

        $doctor->update([
            'specialite'         => $request->specialite,
            'bio'                => $request->bio,
            'numero_licence'     => $request->numero_licence,
            'duree_consultation' => $request->duree_consultation,
            'tarif'              => $request->tarif,
            'is_active'          => $request->has('is_active'),
            'photo'              => $doctor->photo,
        ]);

        return redirect()->route('admin.doctors.index')->with('success', 'Médecin mis à jour.');
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->user->delete(); // supprime aussi le médecin en cascade
        return redirect()->route('admin.doctors.index')->with('success', 'Médecin supprimé.');
    }
}
