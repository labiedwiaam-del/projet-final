<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Jobs\SendAppointmentReminderJob;
use App\Mail\AppointmentConfirmation;
use App\Models\Appointment;
use App\Models\Doctor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AppointmentController extends Controller
{
    /** Liste des rendez-vous du patient */
    public function index(Request $request)
    {
        $appointments = Appointment::where('patient_id', $request->user()->id)
            ->with('doctor.user')
            ->when($request->filter, function ($q) use ($request) {
                match ($request->filter) {
                    'upcoming'  => $q->where('date_rdv', '>=', today())->whereNotIn('statut', ['annule']),
                    'past'      => $q->where('date_rdv', '<', today()),
                    'cancelled' => $q->where('statut', 'annule'),
                    default     => null,
                };
            })
            ->orderByDesc('date_rdv')
            ->paginate(10);

        return view('patient.appointments.index', compact('appointments'));
    }

    /** Formulaire de prise de rendez-vous (étape 1 : choisir un médecin) */
    public function create(Request $request)
    {
        $doctors = Doctor::where('is_active', true)
            ->with('user')
            ->when($request->search, fn($q) => $q->whereHas('user',
                fn($u) => $u->where('name', 'like', "%{$request->search}%"))
                ->orWhere('specialite', 'like', "%{$request->search}%"))
            ->get();

        $selectedDoctor = $request->doctor_id
            ? Doctor::with('user')->find($request->doctor_id)
            : null;

        return view('patient.appointments.create', compact('doctors', 'selectedDoctor'));
    }

    /** Retourne les créneaux disponibles (AJAX ou redirect) */
    public function slots(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:medecins,id',
            'date'      => 'required|date|after_or_equal:today',
        ]);

        $doctor = Doctor::findOrFail($request->doctor_id);
        $slots  = $doctor->availableSlots($request->date);

        return response()->json(['slots' => $slots]);
    }

    /** Enregistre le rendez-vous */
    public function store(Request $request)
    {
        $request->validate([
            'doctor_id'   => 'required|exists:medecins,id',
            'date_rdv'    => 'required|date|after_or_equal:today',
            'heure_rdv'   => 'required|date_format:H:i',
            'motif'       => 'nullable|string|max:500',
        ]);

        $doctor = Doctor::findOrFail($request->doctor_id);

        // Vérification du double booking
        $exists = Appointment::where('medecin_id', $doctor->id)
            ->where('date_rdv', $request->date_rdv)
            ->where('heure_rdv', $request->heure_rdv)
            ->whereNotIn('statut', ['annule'])
            ->exists();

        if ($exists) {
            return back()->withErrors([
                'heure_rdv' => 'Ce créneau est déjà réservé. Veuillez choisir un autre horaire.',
            ])->withInput();
        }

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

        // Envoi de l'email de confirmation immédiat au patient
        try {
            Mail::to($request->user()->email)
                ->send(new AppointmentConfirmation($appointment->load('doctor.user', 'patient')));
        } catch (\Exception $e) {
            // Ne bloque pas si le mail échoue en dev
        }

        // Envoi de l'email de notification au médecin
        try {
            Mail::to($doctor->user->email)
                ->send(new \App\Mail\NewAppointmentForDoctor($appointment));
        } catch (\Exception $e) {
            // Ne bloque pas si le mail échoue en dev
        }

        // Planifie le rappel automatique 24h avant le rendez-vous
        $reminderAt = Carbon::parse(
            $request->date_rdv . ' ' . $request->heure_rdv
        )->subDay(); // = J-1 à la même heure

        // Ne planifie le rappel que si la date de rappel est dans le futur
        if ($reminderAt->isFuture()) {
            SendAppointmentReminderJob::dispatch($appointment)->delay($reminderAt);
        }

        return redirect()->route('patient.appointments.index')
            ->with('success', 'Rendez-vous réservé avec succès ! Un email de confirmation vous a été envoyé. Vous recevrez un rappel 24h avant.');
    }

    /** Annule un rendez-vous */
    public function cancel(Request $request, $id)
    {
        $appointment = Appointment::where('id', $id)
            ->where('patient_id', $request->user()->id)
            ->firstOrFail();

        if (!$appointment->isPending() && !$appointment->isConfirmed()) {
            return back()->withErrors(['error' => 'Ce rendez-vous ne peut plus être annulé.']);
        }

        $appointment->update(['statut' => 'annule']);

        return back()->with('success', 'Rendez-vous annulé avec succès.');
    }
}
